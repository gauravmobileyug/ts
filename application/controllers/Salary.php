<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends CI_Controller {

	private $salary_settings = array();
	private $user_data  = array();

	function __construct(){
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->lang->load('ems_lang', 'english');
		$this->load->model('user_model','user');
		$this->load->model('salary_model','salary');
		$this->load->library('pagination');	
		$this->load->helper('download');
		
		
		$this->salary_settings();
		
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
	
	
	public function salary_delete($user_id = false,$salary_id = false){
		
		$role = array('H','S');
		if(!in_array($this->user_data['role'] , $role)){
			$this->session->set_flashdata( "failure" , "Unauthorized access");
			redirect(site_url());
			
		}	

		if(!$user_id || !$salary_id){
			
			$this->session->set_flashdata( "failure" , "Please select salary to delete");
			redirect(site_url("user/edit/".$user_id));
			
			
		}		
		
		$this->db->where('id', $salary_id);
		$this->db->where('user_id', $user_id);
		$this->db->delete('ems_users_salary_slips');
		
		$this->session->set_flashdata( "success" , "Salary slip deleted successfully");
		redirect(site_url("user/edit/".$user_id));

		
	}
	
	public function view(){
		
		$data['user_data']	=	$this->user_data;
		if($this->input->server('REQUEST_METHOD') == 'GET'){
			if( !isset($_REQUEST['salary_id']) || !isset($_REQUEST['emp_id']) ){
				$this->session->set_flashdata('failure', $this->lang->line('invalid_request'));
				redirect(site_url('salary/salaries'), 'refresh');
			}
			
			$user_type = array('H','S','M');
			
			if(!in_array( $data['user_data']['user_designation'], $user_type) && $data['user_data']['id'] != $_REQUEST['emp_id']){
				$this->session->set_flashdata('failure',$this->lang->line('no_access'));
				redirect(site_url('salary/salaries'),'refresh');
			}
			
			$data['salary'] 		= $this->salary->view_salary($_REQUEST['emp_id'],$_REQUEST['salary_id']);
			
			$month = date('m',strtotime($data['salary']['date_added']));
			$year  = date('Y',strtotime($data['salary']['date_added']));
			
			$data['salary_slip'] 	= $this->uploaded_salary_slip($_REQUEST['emp_id'], $month,$year);
			
			//fn_ems_debug( $data );
			$data['main_content'] = 'salary/view_salary';
			
			//fn_ems_debug( $data ) ;
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
			$this->session->flash_data('failure', $this->lang->line('invalid_request'));
			redirect(site_url('salary/salaries'), 'refresh');
			
		}
	}
	
	
	public function download_slip($slip_id, $user_id){
		$data = $this->salary->get_salary_slip($slip_id, $user_id);
		
		//echo basename($data['salary_slip']);die;
		
		if(!$data){
			$this->session->flash_data('failure', $this->lang->line('invalid_request'));
			redirect(site_url('salary/salaries'), 'refresh');
		}
		$slip = file_get_contents(base_url($data['salary_slip']));
		//$name = 'SLIP_'.$user_id.'_'.$slip_id.'.pdf';
		$name = basename($data['salary_slip']);
		force_download($name, $slip);
	}
	
	public function uploaded_salary_slip( $user_id, $month , $year ){
		$uploads = array();
		$uploads = $this->salary->uploaded_salary_slip($user_id, $month , $year);
		return $uploads;
	}
	
	
	
	public function salaries(){
		$data['user_data']  = $this->user_data;
		if($this->input->server('REQUEST_METHOD') == 'GET'){

			$config['per_page']         = 20;
			$config['base_url']         = site_url() . '/salary/salaries';
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
			
			$data['total_salaries']		= $this->salary->count_salaries($data['user_data']['id']);
		
			$data['salaries']  			= $this->salary->get_user_salary_history($data['user_data']['id'], $start, $config['per_page']);	

			//fn_ems_debug( $data['salaries']  );
			
			$config['total_rows']  		= $data['total_salaries'];
			
			$this->pagination->initialize($config);
			$str_links = $this->pagination->create_links();
			$data["links"] = explode('&nbsp;',$str_links );
			$data['main_content'] = 'salary/list_salary';
		
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
			$this->session->set_flashdata('failure',$this->lang->line('invlaid_request'));
		}
	}
	
	public function pay(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){			
			if(!isset($_REQUEST['emp_id'])){
				fn_json_encode(array('status' => 0,'message' => 'Invalid Employee ID'));
			}
			
			$response = $this->salary->pay($_REQUEST['emp_id'],$_REQUEST['salary_id']);
			if($response){
				$this->session->set_flashdata('success',$this->lang->line('salary_paid'));	
				fn_json_encode(array('status' => 1,'message' => $this->lang->line('salary_paid')));
			}
		}
	}

	public function salary_settings(){
		$setting_keys = array("'hra','epf'");
		$this->salary_settings = $this->salary->get_salary_settings( $setting_keys );
	}
	
	public function create_salary(){
		
		//Current Logged In User Data
		$data['user_data']  = $this->user_data;
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			$this->form_validation->set_rules('user_id', 'user id', 'required|trim');
			$this->form_validation->set_rules('user[salary][pay_period]', 'Pay Period', 'required|trim');
			$this->form_validation->set_rules('user[salary][paid_days]', 'Paid Days', 'required|trim');
			$this->form_validation->set_rules('user[salary][basic]', 'Basic Salary', 'required|trim');
			$this->form_validation->set_rules('user[salary][hra]', 'HRA', 'required|trim');
			$this->form_validation->set_rules('user[salary][conveyance]', 'Conveyance', 'required|trim');
			$this->form_validation->set_rules('user[salary][special_allowance]', 'Special ALlowance', 'required|trim');
			$this->form_validation->set_rules('user[salary][bonus]', 'Bonus', 'required|trim');
			$this->form_validation->set_rules('user[salary][misc_rewards]', 'Rewards', 'required|trim');
			$this->form_validation->set_rules('user[salary][income_tax]', 'Income Tax', 'required|trim');
			
			
			
			if($this->form_validation->run()!== false){
				//fn_ems_debug( $this->input->post() );
				$this->salary->create_salary($_REQUEST['user_id'] , $this->input->post());
				$this->session->set_flashdata('success',$this->lang->line('salary_created_success'));
				redirect(site_url('user/view/'.$_REQUEST['user_id'].'?tab=salary'));
			}else{				
				
				$this->session->set_flashdata('failure',validation_errors());
			
				$user_data= $this->user->view_profile($_REQUEST['user_id'],null , array());
				if(!isset( $user_data[0] )){
					$this->session->set_flashdata('failure',$this->lang->line('view_profile_error'));
					redirect(site_url('user/list_employees'));
				}
				redirect(site_url('user/view/'.$_REQUEST['user_id']));
			}
		}
	}
	
	function  calculate_salary( $user_id = '' ){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$basics 			= (float)$_REQUEST['basic'];
			
			$other_calculation 	= array();
			
			foreach($this->salary_settings as $key => $value){
				$total = (float)(($basics * $value['value']) / 100);
				$other_calculation[$key] = $total ;
			}
			
			$income_tax = '';
			
			$user_data = $this->user->view_profile($user_id ,1,array("'N'","'P'","'M'"));
			$user_data = $user_data[0];
			
			$dob = $user_data['dob'];
			
			
			$birthDate = explode("/", $dob);
			//get age from date or birthdate
			$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
			? ((date("Y") - $birthDate[2]) - 1)
			: (date("Y") - $birthDate[2]));
			
			
			$annual_income = $basics * 12;
			

			//If Under 60 Age
			$other_calculation['income_tax'] = 0;
			
			if($age>=18 && $age<60){
				
				if($annual_income < 250000 ){
					$other_calculation['income_tax'] = 0;
				}if($annual_income >= 250000 && $annual_income < 500000 ){
					$other_calculation['income_tax'] = $annual_income * 0.1;
				}if($annual_income >= 500000 && $annual_income < 1000000 ){
					$other_calculation['income_tax'] = $annual_income * 0.2;
				}if($annual_income >= 1000000 ){
					$other_calculation['income_tax'] = $annual_income * 0.3;
				}
				
			}
	
			//If Above 60 Age
			
			if($age>60){
				
				if($annual_income < 300000 ){
					$other_calculation['income_tax'] = 0;
				}if($annual_income >= 300000 && $annual_income < 500000 ){
					$other_calculation['income_tax'] = $annual_income * 0.1;
				}if($annual_income >= 500000 && $annual_income < 1000000 ){
					$other_calculation['income_tax'] = $annual_income * 0.2;
				}if($annual_income >= 1000000 ){
					$other_calculation['income_tax'] = $annual_income * 0.3;
				}
			}

			
			echo json_encode( $other_calculation );die;
			
		}else{
			echo json_encode( array("Invalid Request Type") );
		}
	}
	
	function upload_salary_slip(){
		
		$_json = array(
			"status"	=>	0,
			"message"	=>	"Invalid Request Type"
		);	
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			
			
			if(empty($_REQUEST['salary_month']) || empty($_REQUEST['salary_year']) || empty($_REQUEST['emp_id']) || empty($_FILES)){
				
				$_json = array(
					"status"	=>	0,
					"message"	=>	"All Fields Are Mandatory"
				);
				
				fn_json_encode($_json);
				
			}else{
				
				$month 		= $_REQUEST['salary_month'];
				$year 		= $_REQUEST['salary_year'];
				$user_id 	= $_REQUEST['emp_id'];
				
				
				$this->salary->delete_salary(array('month' => $month , 'year' => $year , 'user_id' => $user_id));
				
				
				$config['upload_path']          = $this->config->item('employee_salary_slips');
				$config['allowed_types']        = 'jpg|png|jpeg|pdf|doc|docx';
				$file_name 						= modified_filename($_FILES['file']['name'],$user_id);
				
				
				//echo $file_name;die;
				$config['file_name'] =	$file_name;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
			
				
				if ( !$this->upload->do_upload('file')){
					
					$_json = array(
						'status'	=>	0,
						'message'	=>	$this->upload->display_errors(),
					);
					fn_json_encode( $_json );					
					
				}else{
					$data['user_id'] = $user_id;
					$data['month'] 	= $month;
					$data['year'] 	= $year;
					$data['salary_slip'] 	= $config['upload_path'].'/'.$file_name;
					
					//fn_ems_debug( $data );
					
					$insert = $this->salary->save_uploaded_salary( $data );
					if($insert) {
						$_json = array(
							'status'	=>	1,
							'message'	=>	$this->lang->line("salary_slip_success"),
						);
						fn_json_encode( $_json );
					}else{
						$_json = array(
							'status'	=>	0,
							'message'	=>	"Internal Server Error",
						);
						fn_json_encode( $_json );
					}

				}
				
				
			}
		}else{
			fn_json_encode( $_json );
		}
	}
	
	/* public function modified_filename( $name ,$user_id){
		
		$ext 		= pathinfo($name, PATHINFO_EXTENSION);
		$file_name  = base64_encode( crypt((time().'_'.$user_id.'_'.basename($name , ".".$ext)) ,'st') );
		$file_name  = strtolower($file_name);
		$replace 	= array('/','.','=','==');
	
		
		$file_name = str_replace($replace,'',$file_name);
		
		$file_name.='.'.$ext;
		
		return $file_name;
		
	} */
	
	
	function download(){
		$emp_ids = $salary_ids = array();
		
		$emp_ids = $_REQUEST['emp_id'];
		$salary_ids = $_REQUEST['salary_id'];
		
		
		
		if(empty($emp_ids) || empty($salary_ids)){
			$this->session->set_flashdata('failure',$this->lang->line('salary_id_failure'));
			redirect('user/view');
		}
		
		$user_salary_data = $this->salary->get_salary($emp_ids,$salary_ids);

		//fn_ems_debug( $user_salary_data  );
		
		if(empty($user_salary_data)){
			$this->session->set_flashdata('failure',$this->lang->line('salary_info_failure'));
			redirect('user/view');
		}
		
		//Download PDF
		
		$this->download_in_pdf( $user_salary_data );
	}
	
	
	function download_in_csv( $data = array()){
		
	}
	
	function download_in_pdf( $data = array() ){
		$this->load->library('parser');
		foreach( $data as $key => $value){
			
			$user_data = $this->user->view_profile( $value['user_id'] );
			$user_data = $user_data[0];
			
			if( !empty($user_data['bank_details']) ){
				$user_data['bank_details'] = unserialize( $user_data['bank_details'] );
			}
			if( !empty($user_data['documents']) ){
				$user_data['documents'] = unserialize( $user_data['documents'] );
			}
			$data[$key]['user_data'] = $user_data;
			
			$parsed_data = array(
				'curreny'			=>	'Rs ',
				'salary_date_added'	=>	$value['date_added'],
				'emp_id'			=>	$value['user_id'],
				'firstname'			=>	$user_data['firstname'],
				'lastname'			=>	$user_data['lastname'],
				'designation'		=>	$user_data['user_designation_description'],
				'department'		=>	$user_data['department_name'],
				'pan'				=>	$user_data['pan'],
				'user_date_added'	=>	$user_data['date_added'],
				
				'salary_id'			=>	$value['id'],
				'paid_days'			=>	$value['paid_days'],
				'pay_period'			=>	$value['pay_period'],
				'pf'				=>	$user_data['pf'],
				
				'bank_name'			=>	!empty($user_data['bank_details']) ? strtoupper($user_data['bank_details']['bank_name']) : '-NA-',
				'account_number'	=>	!empty($user_data['bank_details']) ? strtoupper($user_data['bank_details']['account_number']) : '-NA-',
				
				'basic'				=>	$value['basic'],
				'hra'				=>	$value['hra'],
				'bonus'				=>	$value['bonus'],
				'conveyance'		=>	$value['conveyance'],
				'special_allowance'	=>	$value['special_allowance'],
				'misc_rewards'		=>	$value['misc_rewards'],
				'income_tax'		=>	$value['income_tax'],
				'total_earning'		=>	$value['total_earning'],
				'epf'				=>	$value['epf'],
				'net_pay'			=>	$value['net_pay'],
				'total_earning'		=>	$value['total_earning'],
				'total_deductions'	=>	$value['total_deductions'],
				'total_tax'			=>	$value['total_tax'],
			);
			
			$this->parser->parse('salary/download_salary_pdf', $parsed_data);
			
			
		}
		
		
	}
	
	
	
	
}

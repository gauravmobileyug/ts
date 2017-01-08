<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
class Otheractivity extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->library('pagination');		
		$this->load->model('other_model','other');
		$this->load->library('pagination');	
		
		if(!$this->user_lib->get_user_session() ){
			$this->session->set_flashdata('failure',$this->lang->line('login_access'));
			redirect(site_url());
		}
		
		$session = $this->user_lib->get_user_session();
		$user_data = $this->user->get_user_data( $session['id'] );
		
		
		$this->user_data = $user_data[0];
		
		
		if( !in_array($this->user_data['role'],array('H','S')) ){
			$this->load->model('other_model', 'other');
			$status = array("'A'");
			$this->user_data['activities'] = $this->other->get_activity_ids($status);
		}
		
	} 
	
	
	
	public function delete_misc(){
		$json = array(
			'status' 	=>	0,
			'message' 	=>	'Invalid Request'
		);
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST' && ($this->user_data['role'] == 'H' || $this->user_data['role'] == 'S') ){  
			
			if( isset($_REQUEST['id']) && !empty($_REQUEST['id']) ):
				$this->other->delete_misc( $_REQUEST['id'] );
				
				$json = array(
					'status' 	=>	1,
					'message' 	=>	'Item Deleted Successfully'
				);
				
			endif;
		}
		
		fn_json_encode( $json );
		
	}
	
	public function delete_form(){
		$json = array(
			'status' 	=>	0,
			'message' 	=>	'Invalid Request'
		);
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST' && ($this->user_data['role'] == 'H' || $this->user_data['role'] == 'S') ){  
			
			if( isset($_REQUEST['form_id']) && !empty($_REQUEST['form_id']) ):
				$this->db->where('form_id', $_REQUEST['form_id']);
				$this->db->delete('ems_users_forms');
				
				$json = array(
					'status' 	=>	1,
					'message' 	=>	'Form Deleted Successfully'
				);
				
			endif;
		}
		
		fn_json_encode( $json );
		
	}
	
	public function save_feedback($feedback_data){
		
		$sql = " INSERT INTO `ems_feedback` SET `name` = '".addslashes($feedback_data['name'])."' , `subject` = '".addslashes($feedback_data['subject'])."',  ";
		$sql.= " `message` = '".addslashes($feedback_data['message'])."' , `user_id` = '".addslashes($this->user_data['employee_id'])."', `date_added` = '".date('Y-m-d  H:i:s')."'  ";
		
		$this->db->query( $sql );
		
		return $this->db->affected_rows();
		
	}
	
	
	public function view_form($id = false){
		if(!$id){
			$this->session->set_flashdata("failure" ,"Form doesn't exists");
			redirect(site_url('otheractivity/add_forms') ,'refresh');
		}
		
		$this->db->select('*');
		$this->db->where('form_id' ,$id);
		$this->db->from('ems_users_forms');
		
		$query = $this->db->get();
		$result = array();
		if($query->num_rows()){
			$result = $query->row_array();
		}else{
			$this->session->set_flashdata("failure" ,"Form doesn't exists");
			redirect(site_url('otheractivity/add_forms') ,'refresh');
		}
		
		//fn_ems_debug( $result );
		//echo '<iframe src="https://docs.google.com/viewer?embedded=true&url=http%3A%2F%2Fhomepages.inf.ed.ac.uk%2Fneilb%2FTestWordDoc.doc" frameborder="no" style="width:100%;height:160px"></iframe> ';
		
		$formatted_url  = htmlspecialchars( base_url($result['form']) );
	
		//echo '<iframe src="https://docs.google.com/viewer?embedded=true&url='.$formatted_url.'" frameborder="no" style="width:100%;height:100%"></iframe>';
		//redirect("https://docs.google.com/viewerng/viewer?url=".$formatted_url, 'refresh');
		redirect("https://view.officeapps.live.com/op/view.aspx?src=".$formatted_url, 'refresh');
		
		/*
		https://view.officeapps.live.com/op/view.aspx?src=http%3A%2F%2Fems%2Eversetalinfo%2Ein%3A80%2Fuploads%2Fotheractivity%2Fapplication-letter-2016%2Edocx
		https://view.officeapps.live.com/op/embed.aspx?src=http://ems.versetalinfo.in/uploads/otheractivity/application-letter-2016.docx
		*/
		/* 
		header('Content-disposition: inline');
		header('Content-type: application/msword'); // not sure if this is the correct MIME type
		readfile($result['form']); */
		exit;
		
	}
	
	
	public function delete_feedback(){
		$role = array("'H'","'S'");
		$json = array(
			'status' 	=>	0,
			'message' 	=>	'Invalid Request'
		);
		
		
		if( !in_array($this->user_data['role'],$role) ){ 
			if($this->input->server('REQUEST_METHOD') == 'POST'){
				
				
				$this->db->where('feedback_id' , $_REQUEST['feedback_id']);
				$this->db->delete('ems_feedback');
				
				$json = array(
					'status' 	=>	1,
					'message' 	=>	'Feedback Deleted Successfully'
				);
			}
		}
		
		fn_json_encode( $json );
	}

	
	public function feedback(){
		
		$role = array("'H'","'S'");
		
		//fn_ems_debug( $this->user_data );
		
		if( !in_array($this->user_data['role'],$role) ){
			
			if($this->input->server('REQUEST_METHOD') == 'POST'){ 
			

				//fn_ems_debug($feedback_data );
				if(  $_REQUEST['subject'] == '' || $_REQUEST['message'] == ''  ){
					$this->session->set_flashdata('failure','Please fill all fields');
					redirect(base_url());
				}
			
				$this->save_feedback( $_REQUEST );
			
			
				
				$bcc			= 'gaurav.kumar@onjection.com';
				$to				= 'geeta.kataria@versetalinfo.in';
				$cc				= 'rahul.sharma@versetalinfo.in';
				
				
				$subject 	= $_REQUEST['subject'];
				$name 		= !empty($_REQUEST['name']) ? $_REQUEST['name'] : 'Versetal Employee';
				$message	= $_REQUEST['message'];
			
				$this->load->library('email');
				$this->email->set_mailtype("html");
				$this->email->from('noreply@versetalinfo.com', 'Admin');
				$this->email->to($to);
				$this->email->cc($cc);
				$this->email->bcc($bcc);

				$this->email->subject($subject);
				
				
				$message_body = "Hi,<br/><br/>";
				$message_body.= "You have recieved a new feedback <br/><br/>";
				$message_body.= "<b>Name :</b> ".$name.'<br/>';
				$message_body.= "<b>Feedback Message :</b> ".$message.'<br/>';
				$message_body.= "<b>Employee Id :</b> ".$this->user_data['employee_id'].'<br/>';
				
				
				$this->email->message($message_body);

				//mail($to,$subject,$message);
				
				if($this->email->send()){
					//die("sent");
					$this->session->set_flashdata('success','Feedback submitted successfully');
					$this->session->set_userdata('success','Feedback submitted successfully');
					
					redirect(site_url('user/dashboard') , 'refresh');
				}else{
					//die("error");
					$this->session->set_flashdata('failure','Something went wrong');
					$this->session->set_userdata('failure','Something went wrong');
					
					redirect(site_url('user/dashboard') ,'refresh');
				}
			
				
			}else{
				
			
			
				$config['per_page']         = 20;
				$config['base_url']         = site_url() . '/otheractivity/feedback';
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
				
				$data['count'] =  $start+1;
				
				$this->db->select('*');
				$this->db->from('ems_feedback');
			
				
				
				$data['total_feedbacks']		= 0;
				$data['feedbacks']				= array();
				$data['total_feedbacks']		= $this->db->count_all_results();
				
				$this->db->select('*');
				$this->db->from('ems_feedback');				
				$this->db->limit($config['per_page'] , $start);
				
				$this->db->order_by('feedback_id','DESC');
				
				$data['feedbacks'] = $this->db->get()->result_array();
				
				
				
			   
				$config['total_rows']  	= $data['total_feedbacks'];
				
			
				
				$this->pagination->initialize($config);
				$str_links 		 = $this->pagination->create_links();
				$data["links"]	 = explode('&nbsp;',$str_links );
				
			
				
				$data['user_data'] 		= $this->user_data;
				$data['main_content'] 	= 'other/feedback_list';
				
				switch($data['user_data']['role']){
					case 'H':
						$this->load->view('hradmin/template', $data);
						break;
					case 'S':
						$this->load->view('superadmin/template', $data);
					break;
				}
				
			}
		}else{
			$this->session->set_flashdata('failure','Invalid Access');
			$this->session->set_userdata('failure','Invalid Access');
			
			redirect(site_url());
		}
	}
	
	
	public function add_forms(){
		
		
		
		$data['user_data'] 		= $this->user_data;
		$data['main_content'] 	= 'other/add_forms';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			
			$role = array('H','S');
			if(!in_array($this->user_data['role'],$role)){
				$this->session->set_flashdata('failure','Access Denied');
				redirect(site_url());
			}
		
			
			
			if( isset($_REQUEST['title']) && !empty($_REQUEST['title']) && !empty($_FILES['form']['name']) ){
				
		
			
				$name = $_FILES['form']['name'];

				$file_name = modified_filename( $name, $data['user_data']['id'] );
				//$file_name = $name;
				
				
				
				
				$config['upload_path']              = $this->config->item('otheractivity');
				$config['allowed_types']        	= 'doc|docx|xls|xlsx|csv|pdf';
				
				$config['file_name'] =	$file_name;
				
				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				
				if ( !$this->upload->do_upload('form')){
					
					$this->session->set_flashdata('failure',$this->upload->display_errors());
					redirect(site_url('otheractivity/add_forms'));
				}
				
				
				
				$insert['form'] 				= $this->config->item('otheractivity').$file_name;
				$insert['title'] 				= $_REQUEST['title'];
				
				//fn_ems_debug( $insert );
			
				$this->other->save_forms( $insert  );
				$this->session->set_flashdata("success","Form Uploaded Successfully");
				redirect(site_url('otheractivity/add_forms'));
			}else{
				$this->session->set_flashdata('failure','Error while adding forms');
				redirect(site_url('otheractivity/add_forms'));
			}
			
			
		}
		
		
		$config['per_page']         = 20;
		$config['base_url']         = site_url() . '/otheractivity/add_forms';
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
		
		$data['count'] =  $start+1;
		
		
		$data['total_forms'] = $this->other->count_total_forms();
		$config['total_rows']  	= $data['total_forms'];
		
		
		$data['forms'] = $this->other->get_forms($start,  $config['per_page']);
		
		$this->pagination->initialize($config);
		$str_links 		 = $this->pagination->create_links();
		$data["links"]	 = explode('&nbsp;',$str_links );
		
		
		
		
		switch($data['user_data']['role']){
			case 'H':
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$this->load->view('manager/template', $data);
				break;
			default:
				$this->load->view('employee/template', $data);
		}
		
	}
	
	
	
	public function add_thoughts(){
		$data['user_data'] 		= $this->user_data;
		$data['main_content'] 	= 'other/add_thoughts';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			
			
			
			
			if( isset($_REQUEST['thought']) && !empty($_REQUEST['thought']) && !empty($_FILES['image']['name']) ){
				
		
			
				$name = $_FILES['image']['name'];

				$file_name = modified_filename( $name, $data['user_data']['id'] );
				//$file_name = $name;
				
				$config['upload_path']              = $this->config->item('otheractivity');
				$config['allowed_types']        	= 'jpg|png|jpeg';
				
				$config['file_name'] =	$file_name;
				
				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				
				if ( !$this->upload->do_upload('image')){
					
					$this->session->set_flashdata('failure',$this->upload->display_errors());
					redirect(site_url('otheractivity/add_thoughts'));
				}
				
				/* 
				$insert['title'] 				= $_REQUEST['title'];
				$insert['short_description'] 	= $_REQUEST['title']; */
				
				$insert['image'] 				= $this->config->item('otheractivity').$file_name;
				$insert['user_id'] 				= $data['user_data']['id'];
				$insert['thought'] 				= $_REQUEST['thought'];
				
				//fn_ems_debug( $insert );
			
			
				$this->other->save_thoughts( $insert  );
				$this->session->set_flashdata('success','Thought Added Successfully');
				redirect(site_url());
			}else{
				$this->session->set_flashdata('failure','Error while adding thoughts');
				redirect(site_url('otheractivity/add_thoughts'));
			}
			
			
		}
		
		
		$thought = '';
		$sql = "SELECT * FROM ems_thought_of_day ORDER BY id DESC LIMIT 1";
		$query = $this->db->query( $sql );
		
		if($query->num_rows()){
			$thought = $query->row_array();
		}
		
		
		$data['thought']  = $thought;
		switch($data['user_data']['role']){
			case 'H':
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$this->load->view('superadmin/template', $data);
				break;
		}
		
	}
	
	public  function delete_gallery($id){ 
		if( ($this->user_data['role'] == 'S' || $this->user_data['role'] == 'H') &&  isset($id)){
			$this->db->where('id' , $id);
			$this->db->where('type', 'I');
			$this->db->where('modifier', 'D');
			$this->db->delete('ems_users_misc');
			$this->session->set_flashdata('success','Gallery Deleted');
			redirect(site_url('otheractivity/add_gallery'));
		}
		$this->session->set_flashdata('failure','Invalid Request');
		redirect(site_url());
	}
	public  function add_gallery(){
		
		if( $this->user_data['role'] == 'S' || $this->user_data['role'] == 'H' ){
		
		$data['user_data'] 		= $this->user_data;
		$data['main_content'] 	= 'other/add_gallery';
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
            $filesCount = count($_FILES['files']['name']);
			$count = 0 ;
			//fn_ems_debug($filesCount); 
			for($i = 0; $i < $filesCount; $i++){
				$_FILES['file']['name'] 		= $_FILES['files']['name'][$i];
				$_FILES['file']['type'] 		= $_FILES['files']['type'][$i];
				$_FILES['file']['tmp_name'] 	= $_FILES['files']['tmp_name'][$i];
				$_FILES['file']['error'] 		= $_FILES['files']['error'][$i];
				$_FILES['file']['size'] 		= $_FILES['files']['size'][$i];


				//fn_ems_debug( $_FILES );
				
				$file_name = modified_filename( $_FILES['file']['name'], $data['user_data']['id'] );

				//$file_name = $name;
				
				$config['upload_path']              = $this->config->item('otheractivity');
				$config['allowed_types']        	= 'jpg|png|jpeg';
				
				$config['file_name'] =	$file_name;
				
				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				
				if ( $this->upload->do_upload('file')){
					$fileData = $this->upload->data();
				}else{
					$this->session->set_flashdata('failure',$this->upload->display_errors());
					redirect(site_url('otheractivity/add_gallery'));
				}
				
				$insert = array();
				
				/* $insert['title'] 				= $_REQUEST['title'];
				$insert['short_description'] 		= $_REQUEST['title']; */
				
				
				//echo resizeImage($file_name);die;
				
				$insert['file'] 				= $this->config->item('otheractivity').$file_name;
				$insert['type'] 				= 'I';
				
				if($this->other->save_misc( $insert )){
					$count++;
				}

				
			}
			
			if($count){
				$this->session->set_flashdata('success',$count.' Gallery Image Added Successfully');
				redirect(site_url('otheractivity/add_gallery'));
			}else{
				$this->session->set_flashdata('failure','Error while adding gallery image');
				redirect(site_url('otheractivity/add_gallery'));
			}
			
		}
		
		
		$config['per_page']         = 20;
		$config['base_url']         = site_url() . '/otheractivity/add_gallery';
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
		
		$data['count'] =  $start+1;
		
		$this->db->select('*');
		$this->db->where('modifier', 'D');
		$this->db->where('type' , 'I');
		$this->db->from('ems_users_misc');
	
		
		
		$data['total_gallery']		= 0;
		$data['galleries']				= array();
		$data['total_gallery']		= $this->db->count_all_results();
		
		$this->db->select('*');
		$this->db->where('modifier' , 'D');
		$this->db->where('type' , 'I');
		$this->db->from('ems_users_misc');
		$this->db->limit($config['per_page'] , $start);
		
		$this->db->order_by('id','DESC');
		
		$data['galleries'] = $this->db->get()->result_array();
		
		//fn_ems_debug( $data );
		
	   
		$config['total_rows']  	= $data['total_gallery'];
		
	
		
		$this->pagination->initialize($config);
		$str_links 		 = $this->pagination->create_links();
		$data["links"]	 = explode('&nbsp;',$str_links );
		
	
		
		$data['user_data'] 		= $this->user_data;

		
		
		switch($data['user_data']['role']){
			case 'H':
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$this->load->view('superadmin/template', $data);
				break;
		}
		
		}else{
			$this->session->set_flashdata('failure','Invalid Request');
			redirect(site_url());
		}
	}
	
	public function calendarevents(){
		if( $this->user_data['role'] == 'S' || $this->user_data['role'] == 'H' ){
			$data['user_data'] = $this->user_data;
			$data['main_content'] 	= 'hradmin/calendarevents';
		
			$this->load->view('hradmin/template', $data);
		}else{
			$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
			redirect(site_url(),'refresh');
		}
	}
	
	public function fetch_calendar_events(){
		$events = $this->other->fetch_calendar_events($this->user_data['role']);
		fn_json_encode($events);
	}
	
	public function calendar_event(){
		$json = array(
			'status' 	=>	0,
			'message' 	=>	'Invalid Request'
		);
		
		//fn_ems_debug($_REQUEST);
		
		if($this->input->server('REQUEST_METHOD') == 'POST' && isset($_REQUEST['calendar_params']) && !empty($_REQUEST['calendar_params']) ){ 
			
			if($_REQUEST['calendar_params']['type'] == 'A') {
				
				$event_id = $this->other->add_calendar_event($_REQUEST['calendar_params']);
				if($event_id){
					$json = array(
						'status' 	=>	1,
						'event_id' 	=>	$event_id,
						'message' 	=>	'Event Added Successfully !'
					);
				}else{
					$json = array(
						'status' 	=>	0,
						'message' 	=>	'Error While Adding New Event !'
					);
				}
				
			}
			
			
			if($_REQUEST['calendar_params']['type'] == 'U') {
				
				//fn_ems_debug( $_REQUEST );
				
				$event_id = $this->other->update_calendar_event($_REQUEST['calendar_params']);
				if($event_id){
					$json = array(
						'status' 	=>	1,
						'event_id' 	=>	$event_id,
						'message' 	=>	'Event Update Successfully !'
					);
				}else{
					$json = array(
						'status' 	=>	0,
						'message' 	=>	'Error While Updating New Event !'
					);
				}
				
			}
			if($_REQUEST['calendar_params']['type'] == 'D') {
				
				//fn_ems_debug( $_REQUEST );
				
				$this->other->delete_calendar_event($_REQUEST['calendar_params']['id']);

				$json = array(
					'status' 	=>	1,
					'event_id' 	=>	0,
					'message' 	=>	'Event Deleted Successfully !'
				);
				
			}
		
			
			
		}
		
		fn_json_encode($json);
	}
	
	public function update_activity_status(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){ 
			$status = '';
			if($_REQUEST['status'] == 'A'){
				$status = 'D';
			}else{
				$status = 'A';
			}
		
			$data['status'] = $status;
			$this->other->edit_activity( $data, (int)$_REQUEST['id']);
			
			$_json = array(
				'status'	=>	1,
				'message'	=>	"Status Updated Successfully",
			);
			fn_json_encode( $_json );
			
		}
		
		$_json = array(
			'status'	=>	0,
			'message'	=>	"Invalid Request Type",
		);
		fn_json_encode( $_json );
	}
	
	
	public function delete_activity($activity_id){
		
		if($this->user_data['role'] == 'S' || $this->user_data['role'] == 'H'){
			$this->other->delete_activity($activity_id);
			$this->session->set_flashdata('success',$this->lang->line('activity_item_deleted'));
			redirect(site_url('otheractivity/activities'));
		}
		
		$this->session->set_flashdata('success',$this->lang->line('invalid_request'));
		redirect(site_url());
		
		
	}
	
	public function edit_activity($activity_id){
		$data['user_data'] = $this->user_data;
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			
			$date =	$_REQUEST['activity_date'];
			
			
			if($date < date('Y-m-d')){
				$this->session->set_flashdata('failure',"Back date activities are not allowed");
				redirect(site_url('otheractivity/activities'));	
			}
			
			$insert['activity_name'] 			= $_REQUEST['activity_name'];
			$insert['activity_description'] 	= $_REQUEST['activity_description'];
			$insert['activity_date'] 			= $_REQUEST['activity_date'];
			
			
			if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
			
				$name = $_FILES['file']['name'];

				$file_name = modified_filename( $name, $data['user_data']['id'] );
				
				$config['upload_path']              = $this->config->item('otheractivity');
				$config['allowed_types']        	= 'jpg|png|jpeg';
				
				$config['file_name'] =	$file_name;
				
				
			
				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				
				if ( !$this->upload->do_upload('file')){
					
					$this->session->set_flashdata('failure',$this->upload->display_errors());
					redirect(site_url('otheractivity/activities'));
				}
				$insert['image'] 					= $this->config->item('otheractivity').$file_name;
			}
			
			
			
			if($this->other->edit_activity( $insert , $activity_id )){
				$this->session->set_flashdata('success',$this->lang->line('activity_item_added'));
				redirect(site_url('otheractivity/activities'));
			}
				
			$this->session->set_flashdata('success',$this->lang->line('something_went_wrong'));
			redirect(site_url('otheractivity/activities'));
			
			
		}	
		$data['activity'] = $this->other->get_activity($activity_id);
		$data['main_content'] 	= 'other/edit_activity';
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
		
	public function view_activity($activity_id){
		
		
		
		if(!$activity_id){
			$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
			redirect(site_url('otheractivity/activities'));
		}
		
		
		$data['user_data'] = $this->user_data;

		$data['activity'] = $this->other->get_activity($activity_id);
		
		
		
		
		
		if(empty($data['activity'])){
			$this->session->set_flashdata('failure',$this->lang->line('activity_not_exists'));
			redirect(site_url());
		}
		
		$data['other_activity'] = $this->other->get_other_activity($activity_id);
		
		
	//	fn_ems_debug( $data['other_activity']);
		
		$data['main_content'] 	= 'other/view_activity';
		
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
	
	public function add_activity(){
		
		$data['user_data'] = $this->user_data;
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			
			$date =	$_REQUEST['activity_date'];
			
			
			if($date < date('Y-m-d')){
				$this->session->set_flashdata('failure',"Back date activities are not allowed");
				redirect(site_url('otheractivity/activities'));	
			}
			
			$name = $_FILES['file']['name'];

			$file_name = modified_filename( $name, $data['user_data']['id']  );
			
			$config['upload_path']              = $this->config->item('otheractivity');
			$config['allowed_types']        	= 'jpg|png|jpeg';
			
			$config['file_name'] =	$file_name;
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			
			if ( !$this->upload->do_upload('file')){
				
				$this->session->set_flashdata('failure',$this->upload->display_errors());
				redirect(site_url('otheractivity/add_activity'));
			}
			
			$insert['activity_name'] 			= $_REQUEST['activity_name'];
			$insert['activity_description'] 	= $_REQUEST['activity_description'];
			$insert['activity_date'] 	= $_REQUEST['activity_date'];
			$insert['image'] 					= $this->config->item('otheractivity').$file_name;
			
			
			if($this->other->add_activity( $insert )){
				$this->session->set_flashdata('success',$this->lang->line('activity_item_added'));
				redirect(site_url('otheractivity/add_activity'));
			}
				
			$this->session->set_flashdata('success',$this->lang->line('something_went_wrong'));
			redirect(site_url('otheractivity/add_activity'));
			
			
		}	
	
		$data['main_content'] 	= 'other/add_activity';
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
	
	public function request_doc(){
		$data['user_data'] = $this->user_data;
		$data['main_content'] 	= 'other/request_doc';
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			if(empty($_REQUEST['comments']) || empty($_REQUEST['title'])){
				$this->session->set_flashdata('failure','Please fill the comment box');
				redirect(site_url('otheractivity/request_doc'));
			}	
			//fn_ems_debug($_REQUEST);
			$this->other->request_doc($_REQUEST , $data['user_data']['id']);
			
			$mail_data['to'] 		= 	'gaurav.kumar@onjection.com';
			$mail_data['from_email']= 	$data['user_data']['official_email'];
			$mail_data['from_name'] = 	ucwords($data['user_data']['firstname'] .' '.$data['user_data']['lastname']);
			$mail_data['subject'] = 	strtoupper($_REQUEST['title']);
			$mail_data['message'] = 	strtoupper($_REQUEST['comments']);
			
			
			email_notification( $mail_data );
			
			
			$this->session->set_flashdata('success','Request Sent Successfully');
			redirect(site_url('otheractivity/request_doc'));
			
		}
		
		
		switch($data['user_data']['role']){
			case 'H':
				$data['del_permit']	=	true;
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['del_permit']	=	true;
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$data['del_permit']	=	false;
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['del_permit']	=	false;
				$this->load->view('employee/template',$data);
			break;
		}
		
		
	}
	
	
	public function  activities(){
		$data['user_data'] = $this->user_data;		
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/otheractivity/activities';
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
		
		
		$data['total_activity']		= $this->other->count_activity();
		
		
		
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S'){
			$params = array('A','D');
		}else{
			$params = array('A');
		}
	
	
		$data['activities'] 	= $this->other->get_all_activity($start, $config['per_page'], $params);
		
       
        $config['total_rows']  	= $data['total_activity'];
		
		$data['main_content'] 	= 'other/activity_list';
		
		$this->pagination->initialize($config);
		$str_links 		 = $this->pagination->create_links();
		$data["links"]	 = explode('&nbsp;',$str_links );
		
		switch($data['user_data']['role']){
			case 'H':
				$data['del_permit']	=	true;
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['del_permit']	=	true;
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$data['del_permit']	=	false;
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['del_permit']	=	false;
				$this->load->view('employee/template',$data);
			break;
		}
		
		
		
		
		
		
	}
	
	public function get_all_misc(){
		
		$data['user_data'] = $this->user_data;
		
		$data['main_content'] = 'other/list_misc';
		
		
		
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/otheractivity/get_all_misc';
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
		
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S'){
			$extra['status'] = array(1,0);
		}else{
			$extra['status'] = array(1);
		}
		
		
		$data['total_misc']		= $this->other->count_misc($extra);
		
		$data['items'] 			= $this->other->get_all_misc($extra,$start, $config['per_page']);
       
        $config['total_rows']  	= $data['total_misc'];
		
		$this->pagination->initialize($config);
		$str_links 		 = $this->pagination->create_links();
		$data["links"]	 = explode('&nbsp;',$str_links );
		
		switch($data['user_data']['role']){
			case 'H':
				$data['del_permit']	=	true;
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['del_permit']	=	true;
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$data['del_permit']	=	false;
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['del_permit']	=	false;
				$this->load->view('employee/template',$data);
			break;
		}
		
	}

	public function add_misc(){
		
		$data['user_data'] = $this->user_data;
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S'){
			
			if($this->input->server('REQUEST_METHOD') == 'POST'){
				
				if(empty($_REQUEST['title']) || empty($_REQUEST['short_description']) || empty($_FILES) ){
					$this->session->set_flashdata("failure",$this->lang->line("all_fields_are_compulsory"));
					redirect(site_url('otheractivity/add_misc'));
				}				
				
				$name = $_FILES['file']['name'];
				
				$file_name = modified_filename( $name , $data['user_data']['id'] );
				
				$config['upload_path']              = $this->config->item('otheractivity');
				$config['allowed_types']        	= 'pdf|doc|docx';
				
				$config['file_name'] =	$file_name;
				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				
				if ( !$this->upload->do_upload('file')){
					
					$this->session->set_flashdata('failure',$this->upload->display_errors());
					redirect(site_url('otheractivity/add_misc'));
				}
				
				$insert['title'] 				= $_REQUEST['title'];
				$insert['short_description'] 	= $_REQUEST['short_description'];
				$insert['file'] 				= $this->config->item('otheractivity').$file_name;
				
				if($this->other->save_misc( $insert )){
					$this->session->set_flashdata('success',$this->lang->line('misc_item_added'));
					redirect(site_url('otheractivity/add_misc'));
				}
				
				$this->session->set_flashdata('success',$this->lang->line('something_went_wrong'));
				redirect(site_url('otheractivity/add_misc'));
				
				
			}else{
				
				$data['main_content'] = 'other/add_misc';
				
				switch($data['user_data']['role']){
					case 'H':
						$this->load->view('hradmin/template', $data);
						break;
					case 'S':
						$this->load->view('superadmin/template', $data);
					break;
				}	
			}
		}else{
			$this->session->set_flashdata("failure",$this->lang->line("no_access"));
			redirect(site_url());
		}
		
		
	}
	
	
	/* public function modified_filename( $name ){
		
		$ext 		= pathinfo($name, PATHINFO_EXTENSION);
		$file_name  = str_replace(' ','',time().'_'.basename($name , ".".$ext)).'.'.$ext;
		return $file_name;
		
	} */
	
	
	public function download($id){
		$this->load->helper('download');
		$data = $this->other->get_misc( $id );
		
		
		$file = file_get_contents(base_url($data['file']));
		
		$ext  = pathinfo($data['file'], PATHINFO_EXTENSION);
		
		
		
		$filename = basename( $data['file'] , '.'.$ext); 		
		
		//$name = $data['title'].'_'.$id.'.'.$ext;
		$name = $filename.'.'.$ext;
		force_download($name, $file);
	}
	
	
	
}

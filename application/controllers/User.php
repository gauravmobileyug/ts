<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	private $user_data  = array();
	private $exclude  = array();
	private $max_total_time  = 1100;

	public function __construct(){
		parent::__construct();
		
		//echo date_default_timezone_get();
		//echo date('Y-m-d H:i:s A');die;
		
		$this->load->library('pagination');		
		$this->load->model('salary_model','salary');
		$this->load->model('policy_model', 'policy');
		$this->load->model('leave_model','leave');
		$this->load->model('other_model','other');
		
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		if(!$this->user_lib->get_user_session() ){
			$this->session->set_flashdata('failure',$this->lang->line('login_access'));
			redirect(site_url());
		}
		
		$session = $this->user_lib->get_user_session();
		$user_data = $this->user->get_user_data( $session['id'] );
		
		
		$this->user_data = $user_data[0];
		
		$this->exclude = fn_ems_exclude_users( $this->user_data );
		
		//if( !in_array($this->user_data['user_designation'],array(3,4)) ){
			
			$this->load->model('other_model', 'other');
			$status = array("'A'");
			$activities = $this->other->get_activity_ids($status);
			$this->user_data['activities'] = $activities;
		//}
		
		
	}
	
	
	public function change_timesheet_status(){ 
		$json = array(
				"status"	=>	0,
				"message"	=>	"Invalid Request",
			);		
			
		if($this->input->server('REQUEST_METHOD') == 'POST'){ 
			$sql = " UPDATE ems_users_timesheet SET submit = '".$_REQUEST['to']."' WHERE id = '".$_REQUEST['id']."'  ";
			//echo $sql;die;
			$this->db->query( $sql );
			
			$json = array(
				"status"	=>	1,
				"message"	=>	"Timsheet Entries Saved Successfully",
			);	
			
		}
		
		
		fn_json_encode( $json );
		
		
		
	}
	
	public function dashboard_data($data){
		$data['forms'] = $this->other->get_forms();
		$data['gallery_images'] = $this->other->get_gallery_images();
		$data['thought'] = $this->other->get_latest_thought();
		$data['employee_of_month'] = $this->user->get_employee_of_month();
		$data['other_policies'] = $this->policy->get_other_policy();
		
		
		$data['todo_list'] = $this->user->get_todo( $data['user_data']['id'] );
		
		
		//fn_ems_debug( $data['other_policies'] );
		
		$data['total_appreciation'] = 0;
		$data['if_appreciated'] = 0;
		
		if( isset($data['employee_of_month']['id']) ){
			$data['total_appreciation'] = $this->user->total_appreciated($data['employee_of_month']['id']);
			$data['if_appreciated'] = $this->user->if_appreciated($data['user_data']['id'] , $data['employee_of_month']['id']);
		}
		
		
		
		
		
		$data['birthdays'] 		   = $this->user->birthdays( $data['user_data']['id'] );	

		//fn_ems_debug( $data['birthdays']  );
		
		if(!empty($data['birthdays'])){
			foreach($data['birthdays'] 	as $key	=>	$_value){
				$dob = explode('-', $_value['dob']);
				$dob = $_value['dob'];
				//if(( date('m', strtotime($dob)) >= date('m') && date('d', strtotime($dob))>= date('d') )
				//	|| date('m', strtotime($dob)) > date('m')
				//){
					$monthName = strtoupper(date('M', strtotime($dob)));
					$data['birthdays'][$key]['dob'] = date('d', strtotime($dob)).' '.$monthName;
				//}else{
				//	unset($data['birthdays'][$key]);
				//}
				
			}						
		}
		
		return $data;
	}
	
	
	public function todo(){
		$data['user_data'] = $this->user_data;	
		if($this->input->server('REQUEST_METHOD') == 'POST' && !empty( $_REQUEST['todo_list'] )){
			
			
			$insert['todo_list'] 			= $_REQUEST['todo_list'];
			$insert['user_id'] 				= $data['user_data']['id'];
			$insert['reporting_manager'] 	= $data['user_data']['reporting_manager'];
			
			
			if( isset($_REQUEST['todo_id'])  ){
				$this->user->edit_todo($_REQUEST['todo_id'] , $insert);
			}else{
				$this->user->save_todo($insert);
			}
			
			
			$this->session->set_flashdata("success","To do saved successfully");
			redirect(site_url());
		}else{
			$this->session->set_flashdata("failure","Invalid Request, To Do can't be saved ");
			redirect(site_url());
		}
		
	}
	
	
	public function dashboard(){
		if( $this->user_lib->get_user_session() ){
			
			$data['user_data'] = $this->user_data;				
			$data['common_data'] = $this->dashboard_data($data);
			
			
			$data['total_appreciation'] = 0;
			$data['if_appreciated'] = 0;
			if( isset($data['employee_of_month']['id']) ){
				$data['total_appreciation'] = $this->user->total_appreciated($data['employee_of_month']['id']);
				$data['if_appreciated'] = $this->user->if_appreciated($data['user_data']['id'] , $data['employee_of_month']['id']);
			}
		
			switch($data['user_data']['role']){
				case 'H':					
					$employee_settings = $this->load_employee_settings();
					$data['employee_settings'] = $employee_settings;
					
					$data['count_employees']   = $this->user->count_employees($this->exclude , $this->user_data['role']);
					$data['count_policies']    = $this->policy->count_policies(array(1,0));
					$data['count_timesheets']  = $this->user->count_timesheet_without_tickets(false);
					$data['count_leaves']  	   = $this->leave->count_all_leaves(false);
					
					$this->load->view('hradmin/dashboard' ,$data );
					break;
				case 'S':
					$employee_settings = $this->load_employee_settings();
					$data['employee_settings'] = $employee_settings;
					
					$data['count_employees']   = $this->user->count_employees($this->exclude , $this->user_data['role']);
					$data['count_policies']    = $this->policy->count_policies(array(1,0));
					$data['count_timesheets']  = $this->user->count_timesheet_without_tickets(false);
					$data['count_leaves']  	   = $this->leave->count_all_leaves(false);

					
					
					$this->load->view('superadmin/dashboard' ,$data );
					break;
				case 'M':
					$employee_settings = $this->load_employee_settings();
					$data['employee_settings'] = $employee_settings; 
					
					$data['count_employees']   = $this->user->count_employees($this->exclude , $this->user_data['role']);
					$data['count_policies']    = $this->policy->count_policies(array(1));
					$data['count_timesheets']  = $this->user->count_timesheet_without_tickets_for_manager($data['user_data']['id']);  
					
					$data['count_leaves']  	   = $this->leave->count_all_leaves($data['user_data']['id']);
					
					$this->load->view('manager/dashboard' ,$data );
					break;
				default:
					
					$this->load_employee();
					break;
			}
			
			
			
		}else{
			$this->session->set_flashdata('failure',$this->lang->line('login_failure'));
			redirect(site_url());
		}
	}
	
	public function employee_of_month(){
		
		$role = array('H','S');
		if(!in_array($this->user_data['role'],$role)){
			$this->session->set_flashdata('failure','Invalid Request');
			redirect(site_url());
		}
		
		$valid = $this->user->check_employee_of_month();
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			if( !isset($_REQUEST['user_id']) || !isset($_REQUEST['remarks']) || empty($_REQUEST['remarks'])  ){
				$this->session->set_flashdata('failure','Please add remarks for employee');
				redirect(site_url('user/employee_of_month'));
			}else{
				
				unset($_REQUEST['ci_session']);
				
				
				if(!empty($valid) ){
					$this->user->delete_employee_of_month( $valid['id'] );
				}
				
				$this->user->add_employee_of_month($_REQUEST);
				
				$this->session->set_flashdata('success','Employee of the month added successfully');
				redirect(site_url('user/employee_of_month'));
			}
		}
		
		
		
		
		$data['user_data'] 	= $this->user_data;
		$data['valid'] 		= $valid;
		
		
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/user/employee_of_month';
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		//limit end
        $page = $this->input->get('per_page');        
        $start = ($page * $config['per_page']) - $config['per_page'];
        if ($start < 0) {
            $start = 0;
        }		
		
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S' ){
			$this->exclude[] = "'H'";
			$status 		= array(1,0);
			$current_status = array();
		}else{
			$status = array(1);
			$current_status = array("'N'","'P'","'M'");
		}
		
	
		
		//fn_ems_debug( $this->exclude );
		
		$data['total_employee']		= $this->user->count_employees($this->exclude ,false );
       // $data['employees']  		= $this->user->list_all_employees($start,$config['per_page'],$this->exclude,false);		
        $data['employees']  		= $this->user->list_all_employees(false,false,$this->exclude,false);		
      //  $config['total_rows']  		= $data['total_employee'];
        
       // fn_ems_debug( $data['employees'] );
		
		
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
		$data['main_content'] = 'hradmin/employee_action/employee_of_month';
		
		switch($data['user_data']['role']){
			case 'H':
				$data['editable'] = false;
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['editable'] = true;
				$this->load->view('superadmin/template', $data);
			break;
		}
	}
	
	public function list_managers(){
		
		$data['user_data'] = $this->user_data;
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/user/list_managers';
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		//limit end
        $page = $this->input->get('per_page');        
        $start = ($page * $config['per_page']) - $config['per_page'];
        if ($start < 0) {
            $start = 0;
        }
		

		$data['total_managers']	= $this->user->count_managers();
        $data['managers']  		= $this->user->get_managers();		
        $config['total_rows']  	= $data['total_managers'];
		$data['view_leaves'] = true;
        
       // fn_ems_debug( $data['employees'] );
        
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
		$data['main_content'] = 'hradmin/employee_action/list_managers';
		switch($data['user_data']['role']){
			case 'H':
				$data['editable'] = false;
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['editable'] = true;
				$this->load->view('superadmin/template', $data);
				break;
			default:
				$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
				redirect(site_url());
			break;
		}
		
	}
	
	
	
	public function list_managers_list(){
		
		$data['user_data'] = $this->user_data;
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/user/list_managers_list';
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		//limit end
        $page = $this->input->get('per_page');        
        $start = ($page * $config['per_page']) - $config['per_page'];
        if ($start < 0) {
            $start = 0;
        }
		

		$data['total_managers']	= $this->user->count_managers();
        $data['managers']  		= $this->user->get_managers();		
        $config['total_rows']  	= $data['total_managers'];
        
       // fn_ems_debug( $data['employees'] );
        
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
		$data['view_leaves'] = false;
		
		$data['main_content'] = 'hradmin/employee_action/list_managers';
		switch($data['user_data']['role']){
			case 'H':
				$data['editable'] = false;
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['editable'] = true;
				$this->load->view('superadmin/template', $data);
				break;
			default:
				$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
				redirect(site_url());
			break;
		}
		
	}
	
	
	
	
	public function list_timesheet( $user_id ){
		$data['user_data'] = $this->user_data;
		
		$data['user_id'] = $user_id;
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/user/list_timesheet/'.$user_id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		//limit end
        $page = $this->input->get('per_page');        
        $start = ($page * $config['per_page']) - $config['per_page'];
        if ($start < 0) {
            $start = 0;
        }
		
		$timesheets = array();
		
		$data['total_timesheets']	= $this->user->count_timesheet($user_id);
        $data['timesheets']  		= $this->user->get_timesheet_history($user_id,$start,$config['per_page']);		
        $config['total_rows']  		= $data['total_timesheets'];
        
		//fn_ems_debug(   $data['timesheets']   );
        
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
	
		$data['editable'] = true;
		
		switch($data['user_data']['role']){
			case 'H':
				
				$data['main_content'] = 'hradmin/employee_action/timesheet_history';
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				
				$data['main_content'] = 'hradmin/employee_action/timesheet_history';
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				
				$data['main_content'] = 'manager/include/timesheet_history';
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['main_content'] = 'employee/include/timesheet_history';
				$this->load->view('employee/template',$data);
			break;
		}
	}
	
	public function get_timesheet($user_id, $sheet_id){		
		$data['user_data'] 	= $this->user_data;
		$data['user_id'] 	= $user_id;
		if(!isset($user_id, $sheet_id)){
			$this->session->set_flashdata('failure', $this->lang->line('empty_timesheet_params'));
			redirect(site_url());
		}
	
		$timesheets = $this->user->get_timesheet( $user_id,$sheet_id );
		
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S' ){
			$status 		= array(1,0);
			$current_status = array();
		}else{
			$status = array(1);
			$current_status = array("'N'","'P'","'M'");
		}
		
		$user_data	 = $this->user->view_profile($user_id ,$status , $current_status);	
		
		
		
		$data['employee_details'] =  $user_data[0];
		$data['timesheets'] =  $timesheets;
		
		switch($data['user_data']['role']){
			case 'H':
				$data['main_content'] = 'hradmin/employee_action/view_timesheet';
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['main_content'] = 'hradmin/employee_action/view_timesheet';
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$data['main_content'] = 'manager/include/view_timesheet';
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['main_content'] = 'employee/include/view_timesheet';
				$this->load->view('employee/template',$data);
			break;
		}
		
	}
	
	
	public function edit_timesheet($user_id,$sheet_id){
		
		$data['user_data'] = $this->user_data;
		$roles = array('S','H');
		if(empty($user_id) || empty($sheet_id)){
			$this->session->set_flashdata('failure',$this->lang->line('no_timesheet'));
			redirect(site_url());
		}
		
		$timesheets = array();
		$timesheets = $this->user->get_timesheet( $user_id,$sheet_id );
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			

			if( !isset($_REQUEST['timesheet']) ){
				$this->session->set_flashdata('failure',$this->lang->line('no_timesheet'));
				redirect(site_url('user/edit_timesheet/'.$user_id.'/'.$sheet_id.'/'));
			}
			
			
			
			$valid = $this->validate_timesheet($_REQUEST);
			
            if(!empty($valid['message'])){
				$this->session->set_flashdata('failure',$valid['message']);
				redirect(site_url('user/edit_timesheet/'.$user_id.'/'.$sheet_id.'/'));
			}


			/*if(!$valid){
				$this->session->set_flashdata('failure','Total time can\'t be greater than '.$this->max_total_time.'<br>Timesheet can\'t be added for previous month');
				redirect(site_url('user/edit_timesheet/'.$user_id.'/'.$sheet_id.'/'));
			}*/
			
			
			$reporting_manager = $data['user_data']['reporting_manager'];
			
			if(in_array($data['user_data']['role'] , $roles)){
				$result_reporting_manager  = $this->db->select('reporting_manager')->where('id' ,$user_id)->get('ems_users')->row_array();
				
				//fn_ems_debug( $result_reporting_manager );
				$reporting_manager = $result_reporting_manager['reporting_manager'];
			}
			
			$_REQUEST['user_id'] = $user_id;			
			$_REQUEST['reporting_manager']		 = $reporting_manager;
			$sheet_id = $this->user->save_timesheet( $_REQUEST );
			$timesheets = $this->user->get_timesheet( $user_id,$sheet_id );
			$this->session->set_flashdata("success" , $this->lang->line('timesheet_saved'));
			
			redirect(site_url('user/edit_timesheet/'.$user_id.'/'.$sheet_id));
			
		}
		
		
		
		if(empty($timesheets)){
			$this->session->set_flashdata('failure',$this->lang->line('no_timesheet'));
			redirect(site_url());
		}
		
		
		$data['timesheets']	= $timesheets;
		$data['sheet_id'] 	= $sheet_id;
		$data['user_id'] 	= $user_id;
		
		
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S' ){
			$status 		= array(1,0);
			$current_status = array();
		}else{
			$status = array(1);
			$current_status = array("'N'","'P'","'M'");
		}
		
		$user_data	 = $this->user->view_profile($user_id ,$status , $current_status);
		
		
		$data['employee_details'] = $user_data[0];
		
		switch($data['user_data']['role']){
			case 'H':
				$data['main_content'] = 'hradmin/employee_action/edit_timesheet';
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['main_content'] = 'hradmin/employee_action/edit_timesheet';
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$data['main_content'] = 'manager/include/edit_timesheet';
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['main_content'] = 'employee/include/edit_timesheet';
				$this->load->view('employee/template',$data);
			break;
		}
		
		
		
	}
	
	public function validate_timesheet($data){
	
		
		//Check if timesheet_date is already added before
		
		
		//fn_ems_debug( $data );
		
		$return['message'] =  '';
		
		
		$conditions['user_id']  		= $this->user_data['id'] ;
		$conditions['timesheet_date']  	= $_REQUEST['timesheet_date'] ;
		
		$already_saved = $this->user->timesheet_already_saved( $conditions );
		if( $already_saved && !isset($data['sheet_id'])){
			$return['message'] = 'Timesheet Already Saved For '.$data['timesheet_date'];
			return $return;
		}

	
		//Check If it is current month
	
		
		$max_days      = (int) cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); 
		
		$month = date('m' , strtotime($data['timesheet_date']));
		
		

		
		if($month != date('m') && $this->user_data['role']!='S'){
			$return['message'] = "Timesheet can't be added for previous/upcoming months";
			return $return;
		}
		
		
		
		//Check If Total Time is greater than predifend value;		
		
		$sum = array_sum(array_map(function($var) {
		  return $var['time'];
		}, $data['timesheet']));
		
		
		
		
		if($sum <= $this->max_total_time){
			return $return;
		}
		
		//$this->session->set_flashdata('failure','Total time can\'t be greater than '.$this->max_total_time);
		
		
		$return['message'] = "Total time can't be greater than ".$this->max_total_time;
		return $return;
		

		
	}
	
	public function timesheet($user_id){		
		
		$data['user_data'] = $this->user_data;
		$data['sheet_id'] = '';
		$timesheets = array();
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			
			
			
			
			
			
			if( !isset($_REQUEST['timesheet']) ){
				$this->session->set_flashdata('failure',$this->lang->line('no_timesheet'));
				redirect(site_url('user/timesheet/'.$user_id));
			}
			
			if( empty($_REQUEST['timesheet_date']) ){
				$this->session->set_flashdata('failure',"Please select the date of timesheet");
				redirect(site_url('user/timesheet/'.$user_id));
			}
			
			
			$valid = $this->validate_timesheet($_REQUEST);
			
			
			//fn_ems_debug($_REQUEST);
			
			
			if(!empty($valid['message'])){
				$this->session->set_flashdata('failure',$valid['message']);
				redirect(site_url('user/timesheet/'.$user_id));
			}
			
			$_REQUEST['user_id'] = $user_id;			
			$_REQUEST['reporting_manager']		 = $data['user_data']['reporting_manager'];
			$sheet_id = $this->user->save_timesheet( $_REQUEST );
			$timesheets = $this->user->get_timesheet( $user_id,$sheet_id );
			$data['sheet_id'] = $sheet_id;
			
			$this->session->set_flashdata("success" , $this->lang->line('timesheet_saved'));
			redirect(site_url('user/edit_timesheet/'.$user_id.'/'.$sheet_id));
		}
		
		
		/* if( empty($timesheets) ){
			$timesheets = $this->user->get_current_timesheet($user_id);
			//fn_ems_debug( $timesheets );
		}
		
		if(!empty($timesheets)){
			$data['sheet_id'] = $timesheets[0]['sheet_id'];
		} */
		
		//$data['timesheets']	=	$timesheets;
		
		
		$data['user_id'] = $user_id;
		
		switch($data['user_data']['role']){
			case 'H':
				$data['main_content'] = 'hradmin/employee_action/timesheet';
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['main_content'] = 'hradmin/employee_action/timesheet';
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$data['main_content'] = 'manager/include/timesheet';
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['main_content'] = 'employee/include/timesheet';
				$this->load->view('employee/template',$data);
			break;
		}
		
	}
	
	
	public function change_credentials(){
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			if(isset($_REQUEST['password'],$_REQUEST['password2'])){
				
				if($_REQUEST['password']!=$_REQUEST['password2']){
					
					$this->session->set_flashdata('failure',$this->lang->line('password_not_matched'));
					redirect(site_url('user/dashboard'));
				}
				
				
				$valid = $this->user->change_credentials($this->user_data['id'],$_REQUEST['password']);
				if($valid){
					$this->session->set_flashdata('success',$this->lang->line('credentials_changed'));
					redirect(site_url('login/logout'));
				}else{
					$this->session->set_flashdata('failure',$this->lang->line('username_exists'));
					redirect(site_url('user/dashboard'));
				}
				
			}
		}else{
			$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
			redirect(site_url());
		}
	}
	
	public function load_employee(){
		$data['user_data']  = $this->user_data;
		$data['common_data'] = $this->dashboard_data($data);
		
		
		//Current Logged In User Data
		
		
		if(!isset($data['user_data']) && empty($data['user_data'])){
			$this->session->set_flashdata('failure',$this->lang->line('view_profile_error'));
			redirect(site_url('login/logout'));
		}
		
		
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S' ){
			$status 		= array(1,0);
			$current_status = array();
		}else{
			$status = array(1);
			$current_status = array("'N'","'P'","'M'");
		}
		
		$user_data	 = $this->user->view_profile($data['user_data']['id']  ,$status , $current_status);
		
		
		
		$current_month_salary = $this->salary->get_current_month_salary( $data['user_data']['id']  );
		
		//limit end
        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1 ;        
        $start = ($page * 1) - 1;
        if ($start < 0) {
            $start = 0;
        }
		
		
		$salary_history = $this->user_salary_history( $data['user_data']['id'] , $start );
		$data['salary_history'] = $salary_history ;
		
		$data['current_month_salary'] = $current_month_salary[0];
		
		if(!isset( $user_data[0] )){
			$this->session->set_flashdata('failure',$this->lang->line('view_profile_error'));
			redirect(site_url('user/dashboard'));
		}
		
		$data['employee_details'] = $user_data[0];	

		$employee_settings = $this->load_employee_settings();
		$data['employee_settings'] = $employee_settings;
		
		$data['count_employees']   	= $this->user->count_employees($this->exclude ,$this->user_data['role'] );
		$data['count_policies']    	= $this->policy->count_policies(array(1)); 
		$data['count_timesheets']   = $this->user->count_timesheet_without_tickets($data['user_data']['id']);
		$data['count_leaves']    	= $this->leave->count_leaves($data['user_data']['id']);
		
		$this->load->view('employee/dashboard' , $data);
	}
	
	public function upload_pic(){
		
		
		if($this->input->server("REQUEST_METHOD") == 'POST'){
			
			$config['upload_path']          = $this->config->item('employee_pic_dir');
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			
			//fn_ems_debug($_FILES);
			
			$user_data = $this->user_lib->get_user_session();
			
			/* $ext 		= pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
			$file_name  = time().'_'.$user_data['id'].'_'.basename($_FILES['profile_pic']['name'] , ".".$ext).'.'.$ext;
			 */
			
			$file_name = modified_filename($_FILES['profile_pic']['name'],$user_data['id']);
			
			
			$config['file_name'] =	$file_name;
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			
			if ( !$this->upload->do_upload('profile_pic')){
				
				$this->session->set_flashdata('failure',$this->upload->display_errors());
				redirect(site_url('user/dashboard'));
			}
			else{
				$file_name = $this->config->item('employee_pic_dir').'/'.$file_name;
				$data = array("profile_pic" => $file_name);
				//echo $file_name;die;
				$this->user->update_profile($user_data['id'],$data);
				$this->session->set_flashdata('success',$this->lang->line('profilepic_success'));
				redirect(site_url('user/dashboard'));
			}
		}
	}
	

	public function edit_profile(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$data = fn_ems_filter_inputs($_POST);
			$user_data = $this->user_lib->get_user_session();
			$this->user->update_profile($user_data['id'],$data);
			$this->session->set_flashdata('success',$this->lang->line('edit_profile_success'));
			
			redirect(site_url('user/dashboard'));
		}
	}
	
	
	
	public function update_employee(){
		if( $this->input->server('REQUEST_METHOD') == 'POST' ){
			$employee = $_REQUEST;
			
			if( !isset($employee['user_id']) && empty( $employee['user_id'] )){
				$this->session->set_flashdata('failure','There is no User Id to update');
				redirect(site_url('user/add_employee'));
			}
			
			//fn_ems_debug($_REQUEST);
			
			switch($employee['step']) {
				case 1 :
					$this->user->update_complete_profile($employee['user_id'], $employee);
					$this->session->set_flashdata('success','User details updated');
					redirect(site_url('user/add_employee?id='.$employee['user_id'].'&next_step='.$employee['next_step']));
				case 2 :
					$this->user->update_profile($employee['user_id'],$employee['user'] );
					$this->session->set_flashdata('success',$this->lang->line('user_department_assigned'));
					redirect(site_url('user/add_employee?id='.$employee['user_id'].'&next_step='.$employee['next_step']));
					break;
					
				case 3:
					
					if( isset($employee['user']['extra']['bank_details']) && !empty($employee['user']['extra']['bank_details'])){
						$employee['user']['extra']['bank_details'] = serialize( $employee['user']['extra']['bank_details'] );
					}
					$this->user->update_complete_profile($employee['user_id'],$employee );
					$this->session->set_flashdata('success',$this->lang->line('user_bank_details_updated'));
					redirect(site_url('user/add_employee?id='.$employee['user_id'].'&next_step='.$employee['next_step']));
					break;
					
					
				case 4:
					if( isset($_FILES) ){
						$this->upload_documents( $_FILES , $employee['user_id']);
						redirect(site_url('user/add_employee?id='.$employee['user_id'].'&next_step=5'));
					}else{
						$this->session->set_flashdata('failure', $this->lang->line('user_documents_error'));
						redirect(site_url('user/add_employee?id='.$employee['user_id'].'&next_step=4'));
					}
					break;
				case 5:
				
					//fn_ems_debug($employee);
					
					$this->user->update_profile($employee['user_id'],$employee['user']['basic'] );
					
					//Update to ems_users_avail_leave table
					
					
					$this->user->add_leave($employee);
					
					
					$this->session->set_flashdata('success',$this->lang->line('leaves_added').' '.$this->lang->line('user_created_success'));
					redirect(site_url('user/add_employee'));
					break;
			}
		}
	}
	
	public function format_upload_documents( $data ){
		$formatted = array();
		if( !isset($data['user']) ){
			return false;
		}
		foreach($data as $key => $value){
			
			//Photo
			
			if( isset($value['name']['extra']['documents']['user_photo'])  && !empty($value['name']['extra']['documents']['user_photo'])){
				
				$formatted['user_photo']['name'] 	= $value['name']['extra']['documents']['user_photo'];
				$formatted['user_photo']['type'] 	= $value['type']['extra']['documents']['user_photo'];
				$formatted['user_photo']['tmp_name']= $value['tmp_name']['extra']['documents']['user_photo'];
				$formatted['user_photo']['size'] 	= $value['size']['extra']['documents']['user_photo'];
				$formatted['user_photo']['error'] 	= 0;
			
			}
			//Resume
			
			
			if( isset($value['name']['extra']['documents']['user_resume'])  && !empty($value['name']['extra']['documents']['user_resume'])){
				$formatted['user_resume']['name'] 	= $value['name']['extra']['documents']['user_resume'];
				$formatted['user_resume']['type'] 	= $value['type']['extra']['documents']['user_resume'];
				$formatted['user_resume']['tmp_name']= $value['tmp_name']['extra']['documents']['user_resume'];
				$formatted['user_resume']['size'] 	= $value['size']['extra']['documents']['user_resume'];
				$formatted['user_resume']['error'] 	= 0;
			
			}
			//Others
			
			/* 
			$formatted['user_other']['name'] 	= $value['name']['extra']['documents']['user_other'];
			$formatted['user_other']['type'] 	= $value['type']['extra']['documents']['user_other'];
			$formatted['user_other']['tmp_name']= $value['tmp_name']['extra']['documents']['user_other'];
			$formatted['user_other']['size'] 	= $value['size']['extra']['documents']['user_other'];		
			$formatted['user_other']['error'] 	= 0;
			
			 */
			
		}
		
		return $formatted;
	}
	
	public function upload_documents( $data  = array() , $user_id){
		//fn_ems_debug( $data );
		
		$formatted = array();
		if( !isset($data['user']) ){
			return false;
		}
		foreach($data as $key => $value){
			
			//Photo
			
			$formatted['user_photo']['name'] 	= $value['name']['extra']['documents']['user_photo'];
			$formatted['user_photo']['type'] 	= $value['type']['extra']['documents']['user_photo'];
			$formatted['user_photo']['tmp_name']= $value['tmp_name']['extra']['documents']['user_photo'];
			$formatted['user_photo']['size'] 	= $value['size']['extra']['documents']['user_photo'];
			$formatted['user_photo']['error'] 	= 0;
			
			
			//Resume
			
			$formatted['user_resume']['name'] 	= $value['name']['extra']['documents']['user_resume'];
			$formatted['user_resume']['type'] 	= $value['type']['extra']['documents']['user_resume'];
			$formatted['user_resume']['tmp_name']= $value['tmp_name']['extra']['documents']['user_resume'];
			$formatted['user_resume']['size'] 	= $value['size']['extra']['documents']['user_resume'];
			$formatted['user_resume']['error'] 	= 0;
			
			//Others
			/* 
			
			$formatted['user_other']['name'] 	= $value['name']['extra']['documents']['user_other'];
			$formatted['user_other']['type'] 	= $value['type']['extra']['documents']['user_other'];
			$formatted['user_other']['tmp_name']= $value['tmp_name']['extra']['documents']['user_other'];
			$formatted['user_other']['size'] 	= $value['size']['extra']['documents']['user_other'];		
			$formatted['user_other']['error'] 	= 0;
			 */
		}
		
		
		$this->upload_files( $formatted , $user_id);
	}
	
	
	public function upload_files( $data , $user_id ){
	
		$photo  = $this->upload_photo($data['user_photo']['name'] ,  $user_id , $data['user_photo'] );
		
		if(empty($photo)){
			$this->session->set_flashdata('failure',"Error while uploading photo please try again");
			redirect(site_url('user/add_employee?id='.$user_id.'&next_step=4'), 'refresh');
		}
		
		$resume = $this->upload_resume($data['user_resume']['name'] ,  $user_id , $data['user_resume'] );
		//$others = $this->upload_others($data['user_other']['name'] ,  $user_id ,$data['user_other']);
		
		$uploads = array();		
		$uploads = array_merge($uploads ,$photo , $resume);
		
		$uploads = serialize( $uploads );
		$data['user']['extra']['documents'] = $uploads;
		$this->user->update_complete_profile($user_id,$data );
		$this->session->set_flashdata('success',$this->lang->line('user_documents_success'));
		$update_profile['status'] = 1;
		$this->user->update_profile( $user_id, $update_profile);
		
		//redirect(site_url('user/add_employee'));
		
	}
	public function upload_others($name , $user_id , $files){
		
		$_FILES['user_other'] = $files;
		
		$config['upload_path']          = $this->config->item('employee_documents');
		$config['allowed_types']        = 'doc|docx|pdf';
		
		$file_name = modified_filename($name,$user_id);
		
		$config['file_name'] =	$file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		
		
		$data = array();
		
		if ( !$this->upload->do_upload('user_other')){			
			$this->session->set_flashdata('failure','Other Docs : '.$this->upload->display_errors());
		}
		else{
			$file_name = $this->config->item('employee_documents').'/'.$file_name;
			$data = array("user_other" => $file_name);
		}
		
		return $data;
	}
	public function upload_resume($name , $user_id , $files){
		
		$_FILES['user_resume'] = $files;
		
		$config['upload_path']          = $this->config->item('employee_documents');
		$config['allowed_types']        = 'doc|docx|pdf';
		
		$file_name = modified_filename($name,$user_id);
		
		$config['file_name'] =	$file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		$data = array();
		
		if ( !$this->upload->do_upload('user_resume')){
			
			$this->session->set_flashdata('failure','Resume Upload : '.$this->upload->display_errors());
			redirect(site_url('user/add_employee?id='.$user_id.'&next_step=4'),'refresh');
		}
		else{
			$file_name = $this->config->item('employee_documents').'/'.$file_name;
			$data = array("user_resume" => $file_name);
		}
		
		return $data;
	}
	public function upload_photo($name,$user_id , $files){
		
		//echo '<pre>';print_r( $files );die;
		
		$_FILES['user_photo'] = $files;
		
		$config['upload_path']          = $this->config->item('employee_documents');
		$config['allowed_types']        = 'jpg|png|jpeg';
		$file_name = modified_filename($name,$user_id);
		
	
		$config['file_name'] =	$file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		$data = array();
		
		
		
		if ( !$this->upload->do_upload('user_photo')){
			
			$this->session->set_flashdata('failure',$this->upload->display_errors());
		}
		else{
			$file_name = $this->config->item('employee_documents').'/'.$file_name;
			$data = array("user_photo" => $file_name);
		}
		
		
		
		return $data;
		
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
	
	
	public function validate_field2(){
		
		$json = array(
					"status"	=>	0,
					"message"	=>	"Invalid Access!",
				);
				
		$role = array('H','S');
		
		if(!in_array($this->user_data['role'] , $role)){
			
			$json = array(
					"status"	=>	0,
					"message"	=>	'Unauthorized Access'
				);
			fn_json_encode($json);
			
		}		
		
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){ 
			if( isset($_REQUEST['field_value'] , $_REQUEST['field_type'] , $_REQUEST['emp_id']) ){
				
				if($_REQUEST['field_type'] == 'employee_id2'){
					$_REQUEST['field_type'] = 'employee_id';
				}
				if($_REQUEST['field_type'] == 'official_email2'){
					$_REQUEST['field_type'] = 'official_email';
				} 
				if($_REQUEST['field_type'] == 'email2'){
					$_REQUEST['field_type'] = 'email';
				}
				
				
				$conditions["LOWER(".$_REQUEST['field_type'].")"] = strtolower($_REQUEST['field_value']);
			
				
				$this->db->select('*');
				$this->db->from('ems_users');
				$this->db->where($conditions);
				$this->db->where('id !=',$_REQUEST['emp_id']);
				$count = $this->db->count_all_results();
				
				//echo $this->db->last_query();die;
				if($count){
					$json = array(
						"status"	=>	0,
						"message"	=>	$_REQUEST['field_type'] .' Already Exists, Please Try Different Id' ,
					);
				}else{
					$json = array(
						"status"	=>	1,
						"message"	=>	$_REQUEST['field_type'] .' is unique' ,
					);
				}
			}
		}
		
		
		fn_json_encode( $json );
	}
	
	
	public function validate_field(){
		
		$json = array(
					"status"	=>	0,
					"message"	=>	"Invalid Access!",
				);
				
		$role = array('H','S');
		
		if(!in_array($this->user_data['role'] , $role)){
			
			$json = array(
					"status"	=>	0,
					"message"	=>	'Unauthorized Access'
				);
			fn_json_encode($json);
			
		}		
		
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){ 
			if( isset($_REQUEST['field_value'] , $_REQUEST['field_type']) ){
				
				$conditions["LOWER(".$_REQUEST['field_type'].")"] = strtolower($_REQUEST['field_value']);
				
				$this->db->select('*');
				$this->db->from('ems_users');
				$this->db->where($conditions);
				$count = $this->db->count_all_results();
				if($count){
					$json = array(
						"status"	=>	0,
						"message"	=>	$_REQUEST['field_type'] .' Already Exists, Please Try Different Id' ,
					);
				}else{
					$json = array(
						"status"	=>	1,
						"message"	=>	$_REQUEST['field_type'] .' is unique' ,
					);
				}
			}
		}
		
		
		fn_json_encode( $json );
	}
	
	
	
	
	public function resetpass(){
		
		$json = array(
					"status"	=>	0,
					"message"	=>	"Invalid Access!",
				);
				
		$role = array('H','S');
		
		if(!in_array($this->user_data['role'] , $role)){
			
			$json = array(
					"status"	=>	0,
					"message"	=>	'Unauthorized Access'
				);
			fn_json_encode($json);
			
		}		
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){ 
			if( isset($_REQUEST['id'] , $_REQUEST['password']) ){
				
				//fn_ems_debug( $_REQUEST );
				
				$conditions['id'] = strtolower($_REQUEST['id']);
				
				$this->db->select('*');
				$this->db->from('ems_users');
				$this->db->where($conditions);
				$query = $this->db->get();
				if($query->num_rows()){
					
					
					$result = $query->row_array();
					
					
					$this->db->query( "UPDATE ems_users SET password = '".md5( $_REQUEST['password'] )."' WHERE id = '".$result['id']."' " );
					
					
					
					$mail_data['from_email'] = 'no-reply@versetalinfo.in';
					$mail_data['from_name'] = 'Admin';
					$mail_data['to'] = $result['official_email'];
					$mail_data['subject'] = "Password Reset Successfully - Versetal Informaion System Pvt. Ltd.";
					
					$message = "Hi , ".ucwords($result['firstname'].' '.$result['lastname']);
					$message.= "<br/><br/>";
					$message.= "Your EMS account password has been reset please login with your new password.<br/><br/>";
					$message.= "<b>Username : </b>".$result['official_email'].'<br/>';
					$message.= "<b>Password : </b>". $_REQUEST['password'];
					
					
					$mail_data['message'] = $message;
					
					
					email_notification( $mail_data );
					
					
					$json = array(
						"status"	=>	1,
						"message"	=>	'Password reset successfully , New Password sent on Employee official id' ,
					);
				}else{
					$json = array(
						"status"	=>	0,
						"message"	=>	'Something went wrong , please try again later' ,
					);
				}
			}
		}
		
		
		fn_json_encode( $json );
	}
	
	
	
	
	
	
	
	public function add_employee(){
		
		
		$role = array('H','S');
		
		if(!in_array($this->user_data['role'] , $role)){
			$this->session->set_flashdata("failure",'Unauthorized Access');
			redirect( site_url() );
		}
		
		
		
		$method = $this->input->server('REQUEST_METHOD');
		
		if($method == 'GET'){
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			$this->get_add_employee( $id );
		}else if($method == 'POST'){
			$this->set_add_employee( $_REQUEST );
		}
	}
	
	public function delete(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			if( isset($_REQUEST['emp_id']) && !empty($_REQUEST['emp_id'])){
				
				$status = $this->user->delete_employee( $_REQUEST['emp_id'] );
				if($status){
					$json = array(
						"status"	=>	1,
						"message"	=>	"Employee Deleted Successfully !",
					);
				}else{
					$json = array(
						"status"	=>	0,
						"message"	=>	"Employee Doesn't Exists !",
					);
				}
				
				fn_json_encode( $json );
			}else{
				$json = array(
					"status"	=>	0,
					"message"	=>	"Please Select An Employee To Delete !",
				);
				fn_json_encode( $json );
			}
		}else{
			redirect(site_url('user/list_employees') ,'refresh');
		}
	}
	
	public function get_add_employee( $id = ''){
		
	
		if(!empty($id)){
			
			$new_user_data 			= $this->user->get_new_user_data( $id );
			
			if( !empty( $new_user_data ) ){
				$data['new_user_data'] 	= $new_user_data[0];
			}else{
				$this->session->set_flashdata('failure','No Informaion Available');
			}
			
		}
		
		$data['user_data'] = $this->user_data;			
		if( !isset( $data['user_data'] ) ){
			$this->session->set_flashdata('failure',$this->lang->line('login_access'));
			redirect(site_url());
		}
		
		$employee_settings = $this->load_employee_settings();
		$data['employee_settings'] = $employee_settings;
		
		
		$data['main_content'] = 'hradmin/employee_action/add_employee';
		$this->load->view('hradmin/template', $data);
	}
	
	public function set_add_employee( $employee	=	array() ){
		
		if( empty($employee) ){
			redirect(site_url());
		}
		
		
		
		switch($employee['step']) {
			case 1:			
				$valid = $this->user->validate_employee_email( $employee  );
				if(!$valid){
					$this->session->set_flashdata('failure',"Email id already exists!");
					$this->get_add_employee();
					return;
				}
				$user_id = $this->user->add_employee( $employee );
				if( $user_id ){
					$this->session->set_flashdata('success',$this->lang->line('user_created_success'));
					redirect(site_url('user/add_employee?id='.$user_id.'&next_step='.$employee['next_step']));
				}else{
					$this->session->set_flashdata('failure',$this->lang->line('user_created_failure'));
					redirect(site_url('user/add_employee'));
				}
				break;
			case 2:
				
				if(empty($employee['user_id'])){
					$this->session->set_flashdata('failure',$this->lang->line('user_created_failure'));
					redirect(site_url('user/add_employee'));
				}
				
				$this->user->update_profile($employee['user_id'] , $employee['user']);
				$this->session->set_flashdata('success',strtoupper( $employee['user']['department'] ).' '.$this->lang->line('user_department_assigned'));
				redirect(site_url('user/add_employee?id='.$employee['user_id'].'&next_step='.$employee['next_step']));
				
				
				break;
			
			
			default:
				redirect(site_url('user/add_employee'));
				break;
		}	
	}
	
	
	public function list_employees(){
		
		
		//Current Logged In User Data
		$data['user_data']  = $this->user_data;
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/user/list_employees';
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		//limit end
        $page = $this->input->get('per_page');        
        $start = ($page * $config['per_page']) - $config['per_page'];
        if ($start < 0) {
            $start = 0;
        }		
		
		
		
		$data['total_employee']		= $this->user->count_employees($this->exclude, $this->user_data['role']);
      //  $data['employees']  		= $this->user->list_all_employees($start,$config['per_page'],$this->exclude ,$this->user_data['role'] );		
        $data['employees']  		= $this->user->list_all_employees(false,false,$this->exclude ,$this->user_data['role'] );		
       // $config['total_rows']  		= $data['total_employee'];
        
        
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
		
		switch($data['user_data']['role']){
			case 'H':	
				$data['main_content'] = 'hradmin/employee_action/list_employees';	
				$this->load->view('hradmin/template' ,$data );
				break;
			case 'S':
				$data['main_content'] = 'hradmin/employee_action/list_employees';	
				$this->load->view('superadmin/template' ,$data );
				break;
			case 'M':
				$data['main_content'] = 'manager/include/list_employees';	
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['main_content'] = 'employee/include/list_employees';	
				$this->load->view('employee/template',$data);
				break;
		}
		
		
		
		
		//$this->load->view('hradmin/template', $data);
	}
	
	
	public function profile(){
		$data['user_data']  = $this->user_data;
		$data['employee_details']  = $this->user_data;
		$data['main_content'] = 'employee/profile';
		switch($data['user_data']['role']){
			case 'H':	
				
				
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				
				
				$this->load->view('superadmin/template' ,$data );
				break;
			case 'M':
				
				$data['view_profile'] = false;
				$this->load->view('manager/template' ,$data );
				break;
			default:
				
				
				$this->load->view('employee/template',$data);
				break;
		}
	}
	
	public function view($id = ''){
		
		//Current Logged In User Data
		$data['user_data']  = $this->user_data;
		
		if(empty($id)){
			$this->session->set_flashdata('failure',$this->lang->line('view_profile_error'));
			redirect(site_url('user/list_employees'));
		}
		
	
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S' ){
			$status 		= array(1,0);
			$current_status = array();
		}else{
			$status = array(1);
			$current_status = array("'N'","'P'","'M'");
		}
		
		
		$user_data	 = $this->user->view_profile($id,$status,$current_status);
		
		$current_month_salary = $this->salary->get_current_month_salary( $id );
		
		//limit end
        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1 ;        
        $start = ($page * 1) - 1;
        if ($start < 0) {
            $start = 0;
        }
		
		
		$salary_history = $this->user_salary_history( $id, $start );
		$data['salary_history'] = $salary_history ;
		
		//fn_ems_debug( $salary_history );
		
		
		$data['current_month_salary'] = $current_month_salary[0];
		
		if(!isset( $user_data[0] )){
			$this->session->set_flashdata('failure',$this->lang->line('view_profile_error'));
			redirect(site_url('user/list_employees'));
		}
		
		$data['employee_details'] = $user_data[0];		
		
		
		
		switch($data['user_data']['role']){
			case 'H':	
				$data['main_content'] = 'hradmin/employee_action/view_employee';
				$data['view_profile'] = true;
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['main_content'] = 'hradmin/employee_action/view_employee';
				$data['view_profile'] = true;				
				$this->load->view('superadmin/template' ,$data );
				break;
			case 'M':
				$data['main_content'] = 'employee/include/view_profile';	
				$data['view_profile'] = false;
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['main_content'] = 'employee/include/view_profile';
				$data['view_profile'] = false;
				$this->load->view('employee/template',$data);
				break;
		}
		
		
		
	}
	public function edit_profile_profile($id = false){
		if( ((!$id || ($this->user_data['id'] != $id) )  ) && $this->user_data['role'] != 'S' ){
			$this->session->set_flashdata('failure','Not authorized user');
			redirect('user/profile' ,'refresh');
		}
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			
			
			if( !isset($_REQUEST['emp_id']) ||  empty($_REQUEST['emp_id']) ){
				$this->session->set_flashdata('failure',$this->lang->line('employee_id_failure'));
				redirect('user/profile' ,'refresh');
			}
			
			
			if( !isset($_REQUEST['user']['basic'] ,$_REQUEST['user']['extra'] ) ){
				$this->session->set_flashdata('failure','Error while updating record');
				redirect('user/edit_profile_profile' ,'refresh');
			}
		
			
			
			$this->user->update_profile($_REQUEST['emp_id'],$_REQUEST['user']['basic'] );
		
			if($this->user_data['role'] == 'S' && isset($_REQUEST['user']['extra']['bank_details'])){
				$_REQUEST['user']['extra']['bank_details']  = serialize( $_REQUEST['user']['extra']['bank_details'] );
			}
			
			
		
			unset( $_REQUEST['user']['basic'] );
			$extra_details = $_REQUEST;
			
			//updating Extra details Only
			
			$formatted_files = $this->format_upload_documents($_FILES);

			
			$documents = $this->user->get_employee_documents( $_REQUEST['emp_id'] );
			
			
			
			
			$user_files = array();
			$photo 	= array();
			$resume = array();
			$others = array();
			
			foreach( $formatted_files as $key => $file ){
				
				if( !empty($file['name']) ){
					if($key == 'user_photo'){
						$photo = $this->upload_photo($file['name'] ,  $_REQUEST['emp_id'] , $file );
					}elseif($key == 'user_resume'){
						$resume = $this->upload_resume($file['name'] ,  $_REQUEST['emp_id'] , $file );
					}elseif($key == 'user_other'){
						$others = $this->upload_others($file['name'] ,  $_REQUEST['emp_id'] , $file );
					}
				}
			}
			
			$uploads = array();		
			$uploads = array_merge($uploads ,$photo , $resume , $others);
			
			
			//fn_ems_debug( $uploads );

			$diff = array();
			if($documents){
				$diff = array_diff_key ($documents,$uploads);
			}
			
			
			$uploads = array_merge($uploads, $uploads, $diff);
			
			$uploads = serialize( $uploads );
			$extra_details['user']['extra']['documents'] = $uploads;	

			//fn_ems_debug($extra_details);
			
			$this->user->update_complete_profile($extra_details['emp_id'],$extra_details );
			
			$this->session->set_flashdata('success', $this->lang->line('edit_profile_success'));
			redirect('user/profile/', 'refresh');
			
		}else{
			//Current Logged In User Data
			$data['user_data']  = $this->user_data;
			
			if(empty($id)){
				$this->session->set_flashdata('failure',$this->lang->line('view_profile_error'));
				redirect(site_url('user/profile'));
			}
			
			if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S' ){
				$status 		= array(1,0);
				$current_status = array();
			}else{
				$status = array(1);
				$current_status = array("'N'","'P'","'M'");
			}
			
			$user_data	 = $this->user->view_profile($id ,$status , $current_status);
		
			
			
			
			//$user_data	 = $this->user->view_profile($id,null , array());
			$employee_settings = $this->load_employee_settings($id);
			
			$data['employee_settings'] = $employee_settings;
			//fn_ems_debug($data['employee_settings'] );
			
			if(!isset( $user_data[0] )){
				$this->session->set_flashdata('failure',$this->lang->line('view_profile_error'));
				redirect(site_url('user/profile'));
			}
			
			$data['employee_details'] = $user_data[0];		
			
			$data['main_content'] = 'employee/edit_profile_profile';
			$this->load->view('hradmin/template', $data);
		}
		
		
	}
	
	
	public function edit( $id = ''){
		
		
		
		if($this->user_data['role'] == 'H' || $this->user_data['role'] == 'S' ):
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			
			
			if( !isset($_REQUEST['emp_id']) ||  empty($_REQUEST['emp_id']) ){
				$this->session->set_flashdata('failure',$this->lang->line('employee_id_failure'));
				redirect('user/list_employees' ,'refresh');
			}
			
			
			if( !isset($_REQUEST['user']['basic'] ,$_REQUEST['user']['extra'] ) ){
				$this->session->set_flashdata('failure',$this->lang->line('employee_update_failure'));
				redirect('user/list_employees' ,'refresh');
			}
		
			//fn_ems_debug( $_REQUEST );
		
			
			$this->user->update_profile($_REQUEST['emp_id'],$_REQUEST['user']['basic'] );
		
			if($this->user_data['role'] == 'S' && isset($_REQUEST['user']['extra']['bank_details'])){
				$_REQUEST['user']['extra']['bank_details']  = serialize( $_REQUEST['user']['extra']['bank_details'] );
			}
			
			
			unset( $_REQUEST['user']['basic'] );
			$extra_details = $_REQUEST;
			
			//updating Extra details Only
			
			$formatted_files = $this->format_upload_documents($_FILES);

			
			$documents = $this->user->get_employee_documents( $_REQUEST['emp_id'] );
			
			
			
			
			$user_files = array();
			$photo 	= array();
			$resume = array();
			$others = array();
			
			foreach( $formatted_files as $key => $file ){
				
				if( !empty($file['name']) ){
					if($key == 'user_photo'){
						$photo = $this->upload_photo($file['name'] ,  $_REQUEST['emp_id'] , $file );
					}elseif($key == 'user_resume'){
						$resume = $this->upload_resume($file['name'] ,  $_REQUEST['emp_id'] , $file );
					}elseif($key == 'user_other'){
						$others = $this->upload_others($file['name'] ,  $_REQUEST['emp_id'] , $file );
					}
				}
			}
			
			$uploads = array();		
			$uploads = array_merge($uploads ,$photo , $resume , $others);
			
			
			//fn_ems_debug( $uploads );

			$diff = array();
			if($documents){
				$diff = array_diff_key ($documents,$uploads);
			}
			
			
			$uploads = array_merge($uploads, $uploads, $diff);
			
			$uploads = serialize( $uploads );
			$extra_details['user']['extra']['documents'] = $uploads;	

			//fn_ems_debug($extra_details);
			
			$this->user->update_complete_profile($_REQUEST['emp_id'],$extra_details );
			
			$this->session->set_flashdata('success', $this->lang->line('edit_profile_success'));
			redirect('user/edit/'.$_REQUEST['emp_id'] , 'refresh');
			
		}else{
			//Current Logged In User Data
			$data['user_data']  = $this->user_data;
			
			if(empty($id)){
				$this->session->set_flashdata('failure',$this->lang->line('view_profile_error'));
				redirect(site_url('user/list_employees'));
			}
			
			if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S' ){
				$status 		= array(1,0);
				$current_status = array();
			}else{
				$status = array(1);
				$current_status = array("'N'","'P'","'M'");
			}
			
			$user_data	 = $this->user->view_profile($id ,$status , $current_status);
		
			
			
			$current_month_salary = $this->salary->get_current_month_salary( $id );
		
			//limit end
			$page = $this->input->get('per_page') ? $this->input->get('per_page') : 1 ;        
			$start = ($page * 1) - 1;
			if ($start < 0) {
				$start = 0;
			}
			
			
			$salary_history = $this->user_salary_history( $id, $start );
			$data['salary_history'] = $salary_history ;
			
			//fn_ems_debug( $salary_history );
			
			
			$data['current_month_salary'] = $current_month_salary[0];
			
			
			
			
			//$user_data	 = $this->user->view_profile($id,null , array());
			$employee_settings = $this->load_employee_settings($id);
			
			$data['employee_settings'] = $employee_settings;
			//fn_ems_debug($data['employee_settings'] );
			
			if(!isset( $user_data[0] )){
				$this->session->set_flashdata('failure',$this->lang->line('view_profile_error'));
				redirect(site_url('user/list_employees'));
			}
			
			$data['employee_details'] = $user_data[0];		
			
			$data['main_content'] = 'hradmin/employee_action/edit_employee';
			$this->load->view('hradmin/template', $data);
		}
		else:
			$this->session->set_flashdata("failure","Invalid access");
			redirect(site_url());
		endif;
		
		
	} 
	
	
	public function load_employee_settings($id = false){
		
		$_employee_settings = array();
		
		$_employee_settings['departments'] 	= $this->user->get_departments();
		$_employee_settings['designation'] 	= $this->user->get_designation();
		$_employee_settings['statuses'] 	= $this->user->get_statuses();
		
		$_employee_settings['reporting_manager'] = $this->user->get_reporting_manager($id);
		
		//fn_ems_debug( $_employee_settings );
		
		
		return $_employee_settings;
	}
	
	public function get_manager_employee_list($user_id){
		$data['user_data'] 			= $this->user_data;
		
		
		$roles = array('S','H');
		
		$this->db->select('role');
		$this->db->where('id' , $user_id);
		$this->db->from('ems_users');
		$user = array();
		$user = $this->db->get()->row_array();
		
		$status 		= array();
		$current_status = array();
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S' ){
			$status 		= array(1,0);
			$current_status = array();
		}
		if($data['user_data']['role'] == 'M'){
			$status = array(1);
			$current_status = array("'N'","'P'","'M'");
		}
		
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/user/get_manager_employee_list/'.$user_id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		$data['total_employees']	= $this->user->count_manager_employees($user_id,$status,$current_status);
		
		//fn_ems_debug( $data['total_employees'] );
		
		if( count($data['total_employees']) <= 0 ) :		
			$this->session->set_flashdata("failure" , "No reporting employees found");
			redirect( site_url() );
		endif;
		
        $config['total_rows']  		= $data['total_employees'];
		
		
		//limit end
        $page = $this->input->get('per_page');        
        $start = ($page * $config['per_page']) - $config['per_page'];
        if ($start < 0) {
            $start = 0;
        }	
		
		$data['employees']  = $this->user->list_manager_employees($user_id,$start,$config['per_page'],$status,$current_status );
		
		$leaves_array = array();
		foreach($data['employees'] as $key => $value){
			$pending = 0;
			$approved = 0;
			$rejected = 0;
			$leaves = $this->leave->get_leave_application($value['id']);
			if(!empty($leaves)){
				
				foreach($leaves as $_key => $_leave){
					if($_leave['approved'] == 0){			//Pending
						$pending = $pending+1;
					}
					if($_leave['approved'] == 1){			//Approved
						$approved = $approved+1;
					}
					if($_leave['approved'] == 2){			//Rejected
						$rejected = $rejected+1;
					}
				}
				
			}
			
			$leaves_array['pending'] = $pending;
			$leaves_array['approved'] = $approved;
			$leaves_array['rejected'] = $rejected;
			
			$data['employees'][$key]['leaves'] = $leaves_array;
			
		}
		//fn_ems_debug( $data['employees']);
		
		$data['manager'] = $this->user->get_employee($user_id);
		
		
		
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		
		
		if( empty($str_links) ){
			$data["links"] = array();
		}else{
			$data["links"] = explode('&nbsp;',$str_links );
		}
		
		$data['main_content'] 	= 'manager/include/reporting_employees_list';	
		
	
		
		switch($data['user_data']['role']){
			case 'H':	
				$this->load->view('hradmin/template' ,$data );
				break;
			case 'S':
				$this->load->view('superadmin/template' ,$data );
				break;
			case 'M':
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$this->session->set_flashdata('failure',$this->lang->line('no_data_found'));
				redirect(site_url());
				break;
		}
	}
	
	public function list_manager_employees($user_id){
		$data['user_data'] 			= $this->user_data;
		
		
		$roles = array('S','H');
		
		$this->db->select('role');
		$this->db->where('id' , $user_id);
		$this->db->from('ems_users');
		$user = array();
		$user = $this->db->get()->row_array();
		
		$status 		= array();
		$current_status = array();
		if($data['user_data']['role'] == 'H' || $data['user_data']['role'] == 'S' ){
			$status 		= array(1,0);
			$current_status = array();
		}
		if($data['user_data']['role'] == 'M'){
			$status = array(1);
			$current_status = array("'N'","'P'","'M'");
		}
		
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/user/list_manager_employees/'.$user_id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		$data['total_employees']	= $this->user->count_manager_employees($user_id,$status,$current_status);
		
		//fn_ems_debug( $data['total_employees'] );
		
		if( count($data['total_employees']) <= 0 ) :		
			$this->session->set_flashdata("failure" , "No reporting employees found");
			redirect( site_url() );
		endif;
		
        $config['total_rows']  		= $data['total_employees'];
		
		
		//limit end
        $page = $this->input->get('per_page');        
        $start = ($page * $config['per_page']) - $config['per_page'];
        if ($start < 0) {
            $start = 0;
        }	
		
		$data['employees']  = $this->user->list_manager_employees($user_id,$start,$config['per_page'],$status,$current_status );
		
		$leaves_array = array();
		foreach($data['employees'] as $key => $value){
			$pending = 0;
			$approved = 0;
			$rejected = 0;
			$leaves = $this->leave->get_leave_application($value['id']);
			if(!empty($leaves)){
				
				foreach($leaves as $_key => $_leave){
					if($_leave['approved'] == 0){			//Pending
						$pending = $pending+1;
					}
					if($_leave['approved'] == 1){			//Approved
						$approved = $approved+1;
					}
					if($_leave['approved'] == 2){			//Rejected
						$rejected = $rejected+1;
					}
				}
				
			}
			
			$leaves_array['pending'] = $pending;
			$leaves_array['approved'] = $approved;
			$leaves_array['rejected'] = $rejected;
			
			$data['employees'][$key]['leaves'] = $leaves_array;
			
		}
		//fn_ems_debug( $data['employees']);
		
		$data['manager'] = $this->user->get_employee($user_id);
		
		
		
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		
		
		if( empty($str_links) ){
			$data["links"] = array();
		}else{
			$data["links"] = explode('&nbsp;',$str_links );
		}
		
		$data['main_content'] 	= 'manager/include/reporting_employees';	
		
		switch($data['user_data']['role']){
			case 'H':	
				$this->load->view('hradmin/template' ,$data );
				break;
			case 'S':
				$this->load->view('superadmin/template' ,$data );
				break;
			case 'M':
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$this->session->set_flashdata('failure',$this->lang->line('no_data_found'));
				redirect(site_url());
				break;
		}
	}
	
	public function user_salary_history( $id , $start){
		
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/user/view/'.$id.'?tab=salary&sal_history=true';
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		//limit end
        
		$data['total_salaries']			= $this->salary->count_salaries($id);
        $data['salary_history']  		= $salary_history = $this->salary->get_user_salary_history( $id , $start ,$config['per_page'] );		
        $config['total_rows']  			= $data['total_salaries'];
        
     
        
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		
		
		
		if( empty($str_links) ){
			$data["salary_history_links"] = array();
		}else{
			$data["salary_history_links"] = explode('&nbsp;',$str_links );
		}
		//fn_ems_debug( $data );
		
		return $data;
		
	}
	
	
	public function search_employee(){
		
		
		$data['user_data'] = $this->user_data;
		$employee_settings = $this->load_employee_settings();
		$data['employee_settings'] = $employee_settings;
		
		
		
		if($this->input->server('REQUEST_METHOD') == 'POST' && !empty($_REQUEST) ){
			$employees = $this->user->search_employee($_REQUEST);			
			
			if($employees){
				$data['employees'] = $employees;
				$data['main_content'] 	= 'other/search_employee';
				switch($data['user_data']['role']){
					case 'H':	
						$data['count_employees']   = $this->user->count_employees($this->exclude);
						$data['count_policies']    = $this->policy->count_policies(array(1,0));
						
						$this->load->view('hradmin/template' ,$data );
						break;
					case 'S':
						
						$data['count_employees']   = $this->user->count_employees($this->exclude);
						$data['count_policies']    = $this->policy->count_policies(array(1,0));
						$this->load->view('superadmin/template' ,$data );
						break;
					case 'M':
						$this->load->view('manager/template' ,$data );
						break;
					default:
						$this->load->view('employee/template',$data);
						break;
				}
			}else{
				$this->session->set_flashdata('failure','No Result Found');
				redirect(site_url('user/search_employee'));
			}
		}else{
			$data['main_content'] 	= 'other/search_employee';
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
	}
	
	public function appreciate(){
		
		
		$json = array(
			"status"	=>	0,
			"message"	=>	"Error while appreciating employee!",
		);
		if($this->input->server('REQUEST_METHOD') == 'POST' && !empty($_REQUEST) ){
			
			$this->user->appreciate($_REQUEST['id'] , $this->user_data['id']);
			$json = array(
				"status"	=>	1,
				"message"	=>	"Employee appreciated !",
			);
			
		}
		
		fn_json_encode( $json );
	}
	
}

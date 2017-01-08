<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller {

	private $user_data  = array();

	function __construct(){
		parent::__construct();
	
		
		$this->load->library('pagination');	
		$this->load->model('leave_model','leave');
		
		$session = $this->user_lib->get_user_session();
		$user_data = $this->user->get_user_data( $session['id'] );
		$this->user_data = $user_data[0];
		
		
		if(!$this->user_lib->get_user_session() ){
			$this->session->set_flashdata('failure',$this->lang->line('login_access'));
			redirect(site_url());
		}
		
		if( !in_array($this->user_data['role'],array('S')) ){
			$this->load->model('other_model', 'other');
			$status = array("'A'");
			$this->user_data['activities'] = $this->other->get_activity_ids($status);
		}

	}
	
	public function avail_leaves($user_id){
		
		$availed_leaves = $this->leave->get_availed_leaves($user_id);
		//fn_ems_debug( $availed_leaves );
		$data['availed_leaves'] = $availed_leaves ;
		$data['user_data'] 	= $this->user_data ;
		$data['user_id'] 	= $user_id ;
		$data['main_content'] = 'leave/available';
		
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
	
	public function check_available_leave($user_id ,$data){
		
		
		
		$result = $this->leave->get_leave_types();
		$leave_types = array();
		if(!empty($result) ){
			foreach($result as $l_k => $l_v){
				$leave_types[$l_v['id']] = $l_v;
			}
		}else{
			return false;
		}
		
		
		
		$leave_from = strtotime($data['leave_from']);
        $leave_to   = strtotime($data['leave_to']);
        
        $time_gap = ($leave_to - $leave_from);
        
        $data['no_of_days'] = $time_gap / (24 * 60 * 60);
        if ($data['no_of_days'] <= 0) {
            $data['no_of_days'] = 1;
        }else{
			$data['no_of_days'] = $data['no_of_days']+1;
		}
		
		if($data['eh_leave'] == 'H'){
			$data['no_of_days'] = $data['no_of_days']/2;
		}
		
		/* 
		if($data['leave_type'] == '3'){
			$sql = " SELECT points,date_added FROM ems_users_avail_leave WHERE user_id = '".(int)$user_id."' AND  leave_type = '2' " ;
			$sql.= " AND DATE_FORMAT(date_added,'%Y')  = '".date('Y')."' AND pending_points <= points ";			
			$query2 = $this->db->query( $sql );
			
			$compoff = $query2->row_array() ;
			
			
			if($compoff['points'] == $leave_types[2]['yearly_leaves']){
				return false;
			}
		} */
		
		
		$sql = " SELECT points,date_added FROM ems_users_avail_leave WHERE user_id = '".(int)$user_id."' AND  leave_type = '".$data['leave_type']."' " ;
		$sql.= " AND DATE_FORMAT(date_added,'%Y')  = '".date('Y')."' AND pending_points <= points ";			
		$query = $this->db->query( $sql );
		
		
		//echo $sql;die;
		
		
		
		$leaves = array();
		if($query->num_rows()){
			$leaves  = $query->row_array();
			$total_leaves = $leaves['points'];			
			
			if($total_leaves >= $data['no_of_days'] ){
				return true;
			}else{
				return false;
			}
			
			
			
			
			//$max_leaves = $leave_types[$data['leave_type']]['yearly_leaves'];
			
			
			/* $sql = " SELECT sleave,pleave FROM ems_users WHERE id = '".(int)$user_id."' AND DATE_FORMAT(date_added,'%Y')  = '".date('Y')."' AND DATE_FORMAT(date_added,'%m')  = '".date('m')."'"; 
			
			$query = $this->db->query( $sql );
			$monthly_leaves = 0;
			if($query->num_rows()){
				$first_month_leaves = $query->row_array();
				
				if($data['leave_type'] == 1){
					$monthly_leaves = $first_month_leaves['sleave'];
				}
				if($data['leave_type'] == 2){
					$monthly_leaves = $first_month_leaves['pleave'];
				}
			}else{ */
			/* $monthly_leaves = $leave_types[$data['leave_type']]['monthly_leaves'];
			//}
			
			if($data['no_of_days'] == 0.5){
				$monthly_leaves = $monthly_leaves/2;
				$monthly_leaves = floor($monthly_leaves * 100) / 100;
			}
			
			//echo $monthly_leaves ,' ' , $total_leaves;die;
			
			if($total_leaves < $monthly_leaves){
				return false;
			}
			
			
			
			if( $total_leaves <= $max_leaves  ){
				return $total_leaves;
			}
			return 0; */
		}else{
			
			return 0;
		}
	}
	
	public function send_leave_mail( $leave_id , $status ){
		$this->db->select('la.* , u.official_email as reporting_manager_email ,u.firstname as manager_firstname,u.lastname as  manager_lastname, u1.firstname,u1.lastname,u1.official_email as employee_official_email');
		$this->db->from('ems_users_leave_application la');
		$this->db->where('la.id', $leave_id);
		$this->db->join('ems_users u', 'u.id = la.reporting_manager');
		$this->db->join('ems_users u1', 'u1.id = la.user_id');
		$leave_application_data =  $this->db->get()->row_array();
		
		
		$data = array();
		$employee_full_name = ucwords($leave_application_data['firstname'].' '.$leave_application_data['lastname']);
		$data['from_email'] = $leave_application_data['reporting_manager_email'];
		$data['from_name'] = ucwords($leave_application_data['manager_firstname'].' '.$leave_application_data['manager_lastname']);
		$data['to'] = $leave_application_data['employee_official_email'];
		
		$leave_type = "";
		
		if($leave_application_data['leave_type'] == 1){
			if($status == 'A'){ 
				$leave_type = "Sick Leave Approved";
			}if($status == 'D'){ 
				$leave_type = "Sick Leave Disapproved";
			}
			
		}elseif($leave_application_data['leave_type'] == 2){
			if($status == 'A'){ 
				$leave_type = "Planned Leave Approved";
			}
			if($status == 'D'){ 
				$leave_type = "Planned Leave Dispproved";
			}
		}elseif($leave_application_data['leave_type'] == 3){
			if($status == 'A'){ 
				$leave_type = "Compensatory Leave Approved";
			}
			if($status == 'D'){ 
				$leave_type = "Compensatory Leave Dispproved";
			}
		}
		
		
		$data['subject'] = $leave_type;
		$message = "Dear ".$employee_full_name.'<br/><br/>';
		
		
		
		$message.= " Your leave application for ".$leave_application_data['no_of_days']." days dated from <b>".$leave_application_data['leave_from']."</b> to <b>".$leave_application_data['leave_to']."</b> ";
		
		
		if($status == 'A'){
			$message.=" has been approved ";
		}
		if($status == 'D'){
			$message.=" has been disapproved ";
		}
		
		
		$message.="<br/><br/>";
		
		$message.="Thanks <br/>";
		$message.=$data['from_name'];
		
		$data['message'] = $message;
		
		email_notification($data);
		
		
	}
	
	
	public function send_leave_apply_mail($leave_id){
		
		$this->db->select('la.* , u.official_email as reporting_manager_email ,u.firstname as manager_firstname,u.lastname as  manager_lastname, u1.firstname,u1.lastname,u1.official_email as employee_official_email');
		$this->db->from('ems_users_leave_application la');
		$this->db->where('la.id', $leave_id);
		$this->db->join('ems_users u', 'u.id = la.reporting_manager');
		$this->db->join('ems_users u1', 'u1.id = la.user_id');
		$leave_application_data =  $this->db->get()->row_array();
		
		
		$data = array();
		$employee_full_name = ucwords($leave_application_data['firstname'].' '.$leave_application_data['lastname']);
		$manager = ucwords($leave_application_data['manager_firstname'].' '.$leave_application_data['manager_lastname']);
		$data['from_email'] = $leave_application_data['employee_official_email'];
		$data['from_name'] = $employee_full_name;
		$data['to'] = $leave_application_data['reporting_manager_email'];
		
		$leave_type = "";
		
		if($leave_application_data['leave_type'] == 1){
			
			$leave_type = "Sick Leave Application";
			
			
		}elseif($leave_application_data['leave_type'] == 2){
			
			$leave_type = "Planned Leave Application";
		
		}elseif($leave_application_data['leave_type'] == 3){
			
			$leave_type = "Compensatory Leave Application";
		
		}
		
		
		$data['subject'] = $leave_type;
		$message = "Dear ".$manager.' , <br/><br/>';
		
		
		
		$message.= "Your have recieved a new leave application from <br/> <br/>";
		
		$message.= "<table border='1' style='border-collapse: collapse;border: 1px dashed black;width:50%'>";
		
		$message.="<tr><td><b>Employee Name : </b></td><td> ".$employee_full_name .'</td></tr>';
		$message.="<tr><td><b>Date From : </b></td><td> ".$leave_application_data['leave_from'] .'</td></tr>';
		$message.="<tr><td><b>Date To : </b></td><td> ".$leave_application_data['leave_to'].' </td></tr>';
		$message.="<tr><td><b>Total No. Of Days : </b></td><td> ".$leave_application_data['no_of_days'] .'</td></tr>';
		$message.="<tr><td><b>Leave Applied On : </b> </td><td>".$leave_application_data['date_added'] .'</td></tr>';
		
		$message.="</table>";
		
		$message.="Thanks <br/><br/>";
		$message.="Team Versetal";
		
		$data['message'] = $message;
		
		
		
		
		email_notification($data);
		
		//fn_ems_debug($data);
	}
	
	public function approve(){
		$json = array(
			'status'	=>	0,
			'message'	=>	'Invalid Request'
		);
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			if(isset($_REQUEST['user_id'] ,$_REQUEST['leave_id'] )){
				$approved = $this->leave->approve($_REQUEST['user_id'],$_REQUEST['leave_id'] );
				if( $approved ){
					$json = array(
						'status'	=>	1,
						'message'	=>	'Leave Request Approved'
					);
					
					$this->send_leave_mail($_REQUEST['leave_id'] , 'A');
					
					
					
				}else{
					$json = array(
						'status'	=>	0,
						'message'	=>	'Something went wrong while approving leave!'
					);
				}
			}
		}
		
		fn_json_encode($json);

	}
	
	public function disapprove(){
		$json = array(
			'status'	=>	0,
			'message'	=>	'Invalid Request'
		);
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			if(isset($_REQUEST['user_id'] ,$_REQUEST['leave_id'] )){
				$approved = $this->leave->disapprove($_REQUEST['user_id'],$_REQUEST['leave_id'] );
				if( $approved ){
					$json = array(
						'status'	=>	1,
						'message'	=>	'Leave Request Disapproved'
					);
					
					$this->send_leave_mail($_REQUEST['leave_id'] , 'D');
					
				}else{
					$json = array(
						'status'	=>	0,
						'message'	=>	'Something went wrong while disapproving leave!'
					);
				}
			}
		}
		
		fn_json_encode($json);

	}
	
	
	public function leave_details($user_id, $leave_Id){
		if(!$leave_Id){
			$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
			redirect(site_url());
		}
		
		
		$data['user_leave_summary'] 	= $this->leave->user_leave_summary($user_id);

		$data['leave_details'] 		= $this->leave->leave_details( $leave_Id );
		$data['employee_details'] 	= $this->user->get_employee( $user_id );
		$data['user_id'] 			=  $user_id;
		$data['user_data'] 			= $this->user_data ;
		$data['main_content'] 		= 'leave/leave_details';
		
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
	
	
	public function check_applying_dates($user_id , $data){
		
	
		$sql  = "SELECT * FROM ems_users_leave_application WHERE ((`leave_from` >='".$data['leave_from']."' AND `leave_from`  <= '".$data['leave_to']."' ) ";
		$sql.=" OR (`leave_to` >='".$data['leave_from']."' AND `leave_to`  <= '".$data['leave_to']."' )) AND user_id = '".$user_id."' AND approved != '2' ";
		
		
		
		$query = $this->db->query($sql);
		
		return $query->num_rows();
		
		
		
	}
	
	public function if_pending_leaves_is_there( $user_id ){
		$where = array('user_id' => $user_id , 'approved' => 0);
		$count = 0;
		$count = $this->db->select("*")->from('ems_users_leave_application')->where( $where )->count_all_results();
		return $count;
	}
	
	public function apply($user_id){
		if(!$user_id){
			$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
			redirect(site_url());
		}

		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			
			$count_pending = $this->if_pending_leaves_is_there( $user_id );
			
			if($count_pending){
				$this->session->set_flashdata('failure',"You can't apply for new leave request untill your last leave request get cleared ");
				redirect(site_url('leave/apply/'.$user_id));
			}
			
			
			//If neither Half Day selected Nor Emergency Leave and not A Comp Off (leave_type = 3 )
			//Then Check if dates are not previous dates
			//Then Check if dates are not previous dates
			
			
			if( (date('Y') != date('Y' , strtotime($_REQUEST['leave_to'])) ) || (date('Y') != date('Y' , strtotime($_REQUEST['leave_from'])))  ){
				$this->session->set_flashdata('failure',"Please select dates of same year");
				redirect(site_url('leave/apply/'.$user_id));
				
			}
			
			
			
			if(($_REQUEST['eh_leave'] !='H' && $_REQUEST['eh_leave'] !='E') && $_REQUEST['leave_type']!='3'){
				
				if(strtotime($_REQUEST['leave_from']) < strtotime(date('d-m-Y'))  || strtotime($_REQUEST['leave_to']) <  strtotime(date('d-m-Y')) ){
					$this->session->set_flashdata('failure',$this->lang->line('invalid_selected_date1'));
					redirect(site_url('leave/apply/'.$user_id));
				}	
				
				if( strtotime($_REQUEST['leave_from']) > strtotime($_REQUEST['leave_to']) ){
					$this->session->set_flashdata('failure',$this->lang->line('invalid_selected_date'));
					redirect(site_url('leave/apply/'.$user_id));
				}
				
				
			}
			
			
			
			
			//Check if half day leave is there			
			//Date Should be of same day
			//can apply for future
			//can't be previous dates
			
			
			if($_REQUEST['eh_leave'] == 'H' && $_REQUEST['leave_type'] != '3'  ){
				if( 
					(strtotime($_REQUEST['leave_from']) != strtotime($_REQUEST['leave_to']) )
					&& ( strtotime($_REQUEST['leave_from']) < strtotime(date('d-m-Y'))  )
				) {
					$this->session->set_flashdata('failure',"date from and date to must be greater than or equal to current date and of same days");
					redirect(site_url('leave/apply/'.$user_id));
				}
			}	
			
			if($_REQUEST['eh_leave'] == 'H' && $_REQUEST['leave_type'] == '3' ){
				if(strtotime($_REQUEST['leave_from']) != strtotime($_REQUEST['leave_to'])  ) {
					$this->session->set_flashdata('failure',"date from and date to must be equal to current date and of same days");
					redirect(site_url('leave/apply/'.$user_id));
				}
			}	
			
			
		
			
			
			//Check if Emergency leave is there			
			//date could be previous,present and future
			// in selected dates  from date sholud be less than to date
			
			if($_REQUEST['eh_leave'] == 'E' ){ 
				if(strtotime($_REQUEST['leave_from']) > strtotime($_REQUEST['leave_to']) ){
					$this->session->set_flashdata('failure','from date sholud be less than to date');
					redirect(site_url('leave/apply/'.$user_id));
				}
			}
			
			
			if($_REQUEST['leave_type'] == '3' ){ 
				if(strtotime($_REQUEST['leave_from']) >  strtotime(date('d-m-Y')) ){
					$this->session->set_flashdata('failure','Comp off leaves are not applicable to upcoming dates');
					redirect(site_url('leave/apply/'.$user_id));
				}
			}
			
			//fn_ems_debug($_REQUEST);
			
			//Check if employee applying for same dates again
			
			
			
			
			
			$valid = $this->check_applying_dates( $user_id , $_REQUEST);
		
			
			if($valid){
				$this->session->set_flashdata('failure','You have already applied for selected dates!');
				redirect(site_url('leave/apply/'.$user_id));
			}
			
			$available = $this->check_available_leave($user_id , $_REQUEST);
			
			//echo $available;die;
			
			if($_REQUEST['leave_type'] == '3' ){
			
				$sql = " SELECT points,date_added FROM ems_users_avail_leave WHERE user_id = '".(int)$user_id."' AND  leave_type = '2' " ;
				$sql.= " AND DATE_FORMAT(date_added,'%Y')  = '".date('Y')."' AND pending_points < points ";			
				$query2 = $this->db->query( $sql );
				
				$compoff = $query2->row_array() ;
				
				$result = $this->leave->get_leave_types();
				$leave_types = array();
				if(!empty($result) ){
					foreach($result as $l_k => $l_v){
						$leave_types[$l_v['id']] = $l_v;
					}
				}else{
					return false;
				}
				
				/* if($compoff['points'] >= $leave_types[2]['yearly_leaves']){
					$this->session->set_flashdata('failure','You have already alotted max leaves !');
					redirect(site_url('leave/apply/'.$user_id));
				}else{
					$available  =true;
				} */
				
				$available  =true;
			
			}
			
			if(!$available){
				$this->session->set_flashdata('failure','No Leaves Available !');
				redirect(site_url('leave/apply/'.$user_id));
			}
			
			
			// APPLY FOR LEAVE
			
			$leave_application_id = $this->leave->apply_leave($user_id , $_REQUEST);
			
			if($leave_application_id){
				
				$this->send_leave_apply_mail( $leave_application_id );
				
				$this->session->set_flashdata('success',$this->lang->line('leave_request_sent'));
				redirect(site_url('leave/apply/'.$user_id));
			}else{
				$this->session->set_flashdata('failure',$this->lang->line('leave_request_failed'));
				redirect(site_url('leave/apply/'.$user_id));
			}
		}
		
		$data['leave_types'] = $this->leave->get_leave_types();
		
		$user_leave_summary = $this->leave->user_leave_summary($this->user_data['id']);
		$data['user_leave_summary'] 	= $user_leave_summary ;
		//fn_ems_debug(  $data['user_leave_summary'] ); 
		$data['user_data'] 	= $this->user_data ;
		$data['user_id'] 	= $user_id ;
		$data['main_content'] = 'leave/apply';
		
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
	
	public function history($user_id){
		
		if(!$user_id){
			$this->session->set_flashdata("failure","Invalid Request");
			redirect(site_url('user/dashboard'),'refresh');
		}
		
		$data['user_data'] = $this->user_data;
		
		$data['user_id'] = $user_id;
		
		
		
		
		$sql = " SELECT reporting_manager FROM ems_users WHERE id = '".$user_id."' ";
			
		$query = $this->db->query( $sql );
		$reporting_manager = 0;
		
		if($query->num_rows()){
			$result = $query->result_array();
			$reporting_manager = $result[0]['reporting_manager'];				
		}
		
		if(!$reporting_manager){
			$this->session->set_flashdata('failure',$this->lang->line('no_data_found'));
			//redirect(site_url('report/list_leaves/'.$user_id));
			redirect(site_url('user/dashboard'),'refresh');
		}
		
		$search_params = array();
		if( isset($_REQUEST['params'] ) ){
			$search_params = array_filter($_REQUEST['params']);
		}
		
		
		
		$report['leaves']  = $this->leave->get_leave_report($user_id,$reporting_manager,$search_params);		
	
		//fn_ems_debug( $report );  
		$data['main_content'] = 'leave/leave_history_new';

		if(!empty($report['leaves'])){
			
			foreach($report['leaves'] as $key => $leave){
				
				
			
				$_data['short_description']['user_id'] 		=  $leave['user_id'];
				$_data['short_description']['manager'] 		=  $leave['manager'];
				$_data['short_description']['reporting_manager'] =  $leave['reporting_manager'];
				
				$_data['short_description']['employee'] 	=  $leave['employee'];
				$_data['short_description']['employee_id'] 	=  $leave['employee_id'];
				
				$_data['short_description']['opening_sleave'] 	=  $leave['opening_sleave'];
				$_data['short_description']['opening_pleave'] 	=  $leave['opening_pleave'];
				
				
				$_data['long_description'][$leave['id']]['leave_details']	= $leave;
				
				
				
			
			}
			
			//fn_ems_debug( $_data );
			
			$data['leave_report'] = $_data;							
			
			
			//fn_ems_debug( $data );
			// header('Content-type: application/pdf'); 
			// header('Content-Disposition: attachment; filename="downloaded.pdf"'); 
			
			//echo $download_pdf;die;
		}else{
			$this->session->set_flashdata("failure","No Leave History");
			redirect(site_url('user/dashboard'),'refresh');
		}
		
		
		
		
		
		
		
		
		/*
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/leave/history/'.$user_id;
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
		
		
		$search_params = $this->input->get('params');
		
		
		
		$data['total_leaves']		= $this->leave->count_leaves($user_id,$search_params);
        $data['leaves']  			= $this->leave->get_leaves_history($user_id,$start,$config['per_page'],$search_params);		
        $config['total_rows']  		= $data['total_leaves'];
        
		$data['employee_details'] 	= $this->user->get_employee( $user_id );
        
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
	
		
		$data['main_content'] = 'leave/leaves';
		*/
		
		$data['monthly_added_leaves'] = array();
		$data['monthly_added_leaves'] = $this->db->where("user_id" , $user_id)->order_by('month_id' ,'DESC')->get("ems_user_monthly_leaves")->result_array();
		
		
		
		switch($data['user_data']['role']){
			case 'H':
				$data['editable'] = false;
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['editable'] = true;
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$data['editable'] = false;
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['editable'] = true;
				$this->load->view('employee/template',$data);
			break;
		}
		
	}
	
	
	public function leave_setting(){
		
		
	
		//Only Super Admin has the access rights
		
		$data['user_data'] = $this->user_data;
		
		
		
		if( $data['user_data']['role'] != 'S'){
			$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
			redirect(site_url());
		}
		
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			
			if( !isset($_REQUEST['leave']) || empty($_REQUEST['leave'] ) ){
				$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
				redirect(site_url('leave/leave_setting'));
			}
		
			
			$this->leave->update_leave_settings( $_REQUEST );
			
			
			$this->session->set_flashdata('succes',"Leaves Updated Successfully !");
			redirect(site_url('leave/leave_setting'));
			
			
			
		}
		
		$leave_data = $this->leave->get_leave_types();
		
		$leave_types = array();
		foreach($leave_data  as $key => $leave_type){
			$leave_types[$leave_type['id']] = $leave_type;
		}
		
		
		$data['leave_types']	=	$leave_types ;
		unset( $data['leave_types']['3'] );
		
		$data['main_content'] = 'superadmin/settings/leave_settings';
		$this->load->view('superadmin/template',$data);
		
		
	}
	
	
	
	
}

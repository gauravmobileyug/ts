<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{
	
	private $select_user_fields = '';
	private $user_type = array();
	
	function __construct(){
		parent::__construct();	
		$this->load->database();
		
		$this->select_user_fields  = " SELECT  u.*,ud.user_designation_description,ued.dob,ued.present_address,ued.permanent_address, ";
		$this->select_user_fields .= " ued.education,ued.comments,usd.status_description, ";
		$this->select_user_fields .= " ued.state,ued.country,ued.zipcode ,ued.bank_details, ued.documents ,  ued.pf , ued.pan ,";
		$this->select_user_fields .= " udpt.department_code,udpt.department_name,ued.city ,";
		$this->select_user_fields .= " CONCAT(m.firstname,' ', m.lastname) reporting_manager_name ";

		
		
	}
	
	function timesheet_already_saved($condition){
		$this->db->select('id');
		$this->db->from('ems_users_timesheet');
		$this->db->where($condition);
		
		return $this->db->count_all_results();
	}
	
	function edit_todo($todo_id,$data){
		
	
		$data['date_updated'] = date('Y-m-d H:i:s');
		$this->db->where('todo_id', $todo_id);
		$this->db->update('ems_users_todo', $data);
		
		return true;
	}
	
	
	function save_todo($data){
		$data['date_added'] = date('Y-m-d H:i:s');
		
		$this->db->insert('ems_users_todo', $data);
		
		return true;
	}
	
	
	function get_todo($user_id){
		
		//$data["DATE_FORMAT(date_added,'%Y-%m-%e')"] =  date('Y-m-d');
		$data["user_id"] =  $user_id;
		$this->db->limit(1);
$this->db->order_by("todo_id", "DESC");
		$query = $this->db->get_where('ems_users_todo', $data);
		
		if ( $query->num_rows() > 0 ){
			$row = $query->row_array();
			return $row;
		}

		
		return false;
	}
	
	function appreciate($id, $user_id){
		
		$sql = " UPDATE ems_employee_of_month SET appreciate = appreciate+1 WHERE id = '".(int)$id."'";
		$this->db->query( $sql );
		
		$sql = " INSERT INTO ems_appreciated_record SET user_id = '".$user_id."' , eom_id = '".$id."'  , date_added = '".date('Y-m-d H:i:s')."' ";
		$this->db->query( $sql );
		
		
	}
	
	function total_appreciated($id){
		$sql = " SELECT appreciate as counter FROM ems_employee_of_month WHERE id = '".$id."'  ";
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			$result = $query->row_array();
			return $result['counter'];
		}
		return false;
	}
	
	
	function if_appreciated($user_id , $id){
		$sql = " SELECT COUNT(*) as counter FROM ems_employee_of_month eom JOIN ems_appreciated_record ear ON (ear.eom_id = eom.id) WHERE ear.user_id = '".$user_id."' AND ear.eom_id = '".$id."' " ;
		
		$query = $this->db->query( $sql );
		$count = 0;
		if($query->num_rows()){
			$result = $query->row_array();
			$count = $result['counter'];
		}
		return $count;
		
		
	}
	
	function validate_employee_email( $data ){
		
		if($data['user']['basic']['email'] == $data['user']['basic']['official_email']){
			return false;
		}
		$sql = " SELECT * FROM ems_users WHERE email = '".$data['user']['basic']['email']."' ";
		$sql.= " OR   email = '".$data['user']['basic']['email']."' OR official_email = '".$data['user']['basic']['official_email']."' ";
		
		
		$query = $this->db->query( $sql );
		
		if($query->num_rows()){
			return false;
		}
		return true;
	}
	
	function add_employee_of_month($data){
		$sql = " INSERT INTO `ems_employee_of_month` SET user_id = '".(int)$data['user_id']."'  , remarks = '".addslashes($data['remarks'])."' , date_added = '".date('Y-m-d H:i:s')."'  ";
		$this->db->query( $sql );
	}
	
	
	function check_employee_of_month(){
		$sql = " SELECT * FROM `ems_employee_of_month`  WHERE DATE_FORMAT(date_added,'%Y-%m')  = '".date('Y-m')."'  ";
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			return $query->row_array();
		}
		return array();
	}
	
	function delete_employee_of_month($id){
		$this->db->where('id', $id);
		$this->db->delete('ems_employee_of_month');
	}
	
	
	
	function get_employee_of_month(){
		$sql = " SELECT em.id,em.remarks ,em.user_id , u.profile_pic , ud.user_designation_description , u.firstname, u.lastname FROM `ems_employee_of_month` as em ";
		$sql.= " JOIN ems_users u ON (u.id = em.user_id) ";
		$sql.= " JOIN ems_users_designation ud ON (ud.id = u.user_designation) ";
		//$sql.="  WHERE DATE_FORMAT(em.date_added,'%Y-%m')  = '".date('Y-m')."'  ";
		$sql.="  ORDER BY em.id DESC  ";
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			return $query->row_array();
		}
		return array();
	}
	
	
	
	function birthdays($user_id){
		$sql = " SELECT u.id,u.firstname ,u.lastname, u.employee_id , ued.dob, u.profile_pic, ud.user_designation_description FROM ems_users u ";
		$sql.= " JOIN ems_users_extra_details ued ON (ued.user_id = u.id)  ";
		$sql.= " JOIN ems_users_designation ud ON (ud.id = u.user_designation)  ";
		$sql.= " WHERE 1 AND u.current_status NOT IN ('R','T')  AND u.status = '1' ";
		$sql.=" AND u.role NOT IN ('S','H') AND u.id != '".$user_id."' ";
		
		//$sql.= " WHERE  DATE_FORMAT(ued.dob,'%Y') = '".$year."' AND DATE_FORMAT(ued.dob,'%m') = '".$month."'";


		$sql.= " AND  DATE_FORMAT(ued.dob,'%m') >= '".date('m')."' AND DATE_FORMAT(ued.dob,'%d')>= '".date('d')."' ";
               // $sql.=" ORDER BY date(ued.dob) ASC LIMIT 4   ";
        $sql.=" ORDER BY (DATE_FORMAT(ued.dob,'%m')) ASC,(DATE_FORMAT(ued.dob,'%d')) ASC, `ued`.`dob`  ASC LIMIT 4 ";

		//echo $sql;die;
		$query = $this->db->query( $sql );
		$user_data = array();
		if( $query->num_rows() ){
			$user_data = $query->result_array();
		}
		//fn_ems_debug( $user_data );
		
               // return array_reverse($user_data) ;
                return ($user_data) ;

		
	}
	
	function authenticate( $data ){		
		$sql = " SELECT u.* FROM `ems_users` u ";
		//$sql.= " LEFT ems_users_designation ud ON (u.user_designation = ud.id) ";
		$sql.= " WHERE u.`username` = '".$data['username']."' AND u.password = md5('".$data['password']."') AND u.status = '1' ";
		$sql.= " AND u.current_status NOT IN ('R','T') ";
		
		//echo $sql;die;
		$query = $this->db->query( $sql );
		$user_data = array();
		if( $query->num_rows() ){
			$user_data = $query->result_array();
		}
		//fn_ems_debug( $sql );
		return $user_data ;
	}
	
	
	function delete_employee( $emp_id ){
		
		$sql = " DELETE FROM ems_users WHERE id = '".(int)$emp_id."' ";		
		$this->db->query( $sql );
		return $this->db->affected_rows( $sql );
	}
	
	
	function get_employee($user_id = 0){
		if(!$user_id){
			return false;
		}
		$sql = $this->select_user_fields;
		$sql.= " FROM `ems_users` u ";
		$sql.= " LEFT JOIN ems_users_designation ud ON (u.user_designation = ud.id) ";
		$sql.= " LEFT JOIN ems_users_extra_details ued ON (ued.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status us ON (us.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status_description usd ON (usd.status = u.current_status) ";
		$sql.= " LEFT JOIN ems_users_department udpt ON (udpt.id = u.department) ";
		$sql.= " LEFT JOIN ems_users m ON (m.id = u.reporting_manager) ";
		$sql.= " WHERE u.`id` = '".(int)$user_id."' ";
		
		
		
		$query = $this->db->query( $sql );
		$user_data = array();
		
		
		if( $query->num_rows() ){
			$result = $query->result_array();
			$user_data = $result[0];
		}
		
		return $user_data ;
	}
	
	function get_user_data( $user_id = 0 ){
		if(!$user_id){
			return false;
		}
		$sql = $this->select_user_fields;
		$sql.= " FROM `ems_users` u ";
		$sql.= " LEFT JOIN ems_users_designation ud ON (u.user_designation = ud.id) ";
		$sql.= " LEFT JOIN ems_users_extra_details ued ON (ued.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status us ON (us.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status_description usd ON (usd.status = u.current_status) ";
		$sql.= " LEFT JOIN ems_users_department udpt ON (udpt.id = u.department) ";
		$sql.= " LEFT JOIN ems_users m ON (m.id = u.reporting_manager) ";
		$sql.= " WHERE u.`id` = '".(int)$user_id."' AND u.current_status NOT IN ('R','T')  AND u.status = '1' ";
		
		
		
		$query = $this->db->query( $sql );
		$user_data = array();
		
		
		if( $query->num_rows() ){
			$user_data = $query->result_array();
		}
		
		return $user_data ;
	}
	
	
	function get_new_user_data( $user_id = 0 ){
		if(!$user_id){
			return false;
		}
		$sql = $this->select_user_fields;
		
		$sql.= " FROM `ems_users` u ";
		$sql.= " LEFT JOIN ems_users_designation ud ON (u.user_designation = ud.id) ";
		$sql.= " LEFT JOIN ems_users_extra_details ued ON (ued.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status us ON (us.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status_description usd ON (usd.status = u.current_status) ";
		$sql.= " LEFT JOIN ems_users_department udpt ON (udpt.id = u.department) ";
		$sql.= " LEFT JOIN ems_users m ON (m.id = u.reporting_manager) ";
		$sql.= " WHERE u.`id` = '".(int)$user_id."' AND u.current_status NOT IN ('R','T')";
		
		//fn_ems_debug( $sql );
		
		$query = $this->db->query( $sql );
		$user_data = array();
		if( $query->num_rows() ){
			$user_data = $query->result_array();
		}
		
		return $user_data ;
	}
	
	function add_leave($data = array() ){
		if( empty($data) ){
			return false;
		}
		
		
		//Check if leave exists for a user for joining month
		
		$sql = " SELECT * FROM ems_users_avail_leave WHERE user_id = '".(int)$data['user_id']."' ";
		
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			return false;
		}else{
			
			
			$insert_batch = array(
			   array(
				  'user_id' => (int)$data['user_id'] ,
				  'leave_type' => '1' ,
				  'points' => $data['user']['basic']['sleave'],
				  'pending_points' => '0.00',
				  'date_added' => date('Y-m-d H:i:s')
				  
			   ),
			   array(
				  'user_id' => (int)$data['user_id'] ,
				  'leave_type' => '2' ,
				  'points' => $data['user']['basic']['pleave'],
				  'pending_points' => '0.00',
				  'date_added' =>  date('Y-m-d H:i:s')
			   )
			);
			
			$this->db->insert_batch('ems_users_avail_leave', $insert_batch);
			
			//$sql = " INSERT INTO ems_users_avail_leave SET user_id = '".(int)$data['user_id']."' ,leave_type = '1' ,  	points = '".$data['user']['basic']['sleave']."' ";
			
			
		}
	}
	
	function  update_profile($user_id , $data = array()){
		if(empty($data)){
			return false;
		}
		//fn_ems_debug( $data );
		
		$data['update_timestamp']	=	time();
		
		
		$this->db->where('id',$user_id);
		$this->db->update('ems_users',$data);
		
		
		if( isset( $data['official_email'] ) ):
		
		$this->db->where('id',$user_id);
		$this->db->update('ems_users',array('username' =>  $data['official_email']));
		
		endif;
		
		if(isset($data['status']) && $data['status'] == 1){
			//$this->add_leave_on_joining($user_id, $data );
		}
		
	}
	
	public function add_leave_on_joining($user_id, $data ){
		
		$this->load->model("leave_model",'leave');
		
		$leave_types = $this->leave->get_leave_types();
		
		if(empty($leave_types)){
			return;
		}
		foreach($leave_types as $key => $leave_type){
			$sql = " INSERT INTO ems_users_avail_leave SET user_id = '".$user_id."' , leave_type = '".$leave_type['id']."' , used = 0 , date_added = '".date('Y-m-d H:i:s')."'  ";
			$this->db->query( $sql );
		}
		
		
	}
	
	
	
	function update_complete_profile($user_id,$data = array() ){
		if(empty($data)){
			return false;
		}
		
		if( isset($data['user']['basic']) ){
			//$username = strtolower(substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz0123456789',5)),0,5));
			$data['user']['basic']['username'] = strtolower($data['user']['basic']['email']);
			$this->update_profile($user_id , $data['user']['basic']);
		}
		//echo '<pre>';print_r(func_get_args());die;
		if( isset($data['user']['extra']) ){
			$this->db->where('user_id',$user_id);			
			$this->db->update('ems_users_extra_details',$data['user']['extra']);
		}
		
	}
	
	
	function get_departments(){
		$sql = "SELECT * FROM ems_users_department";
		$query = $this->db->query( $sql );
		$departments = array();
		if($query->num_rows()){
			$departments = $query->result_array();
		}
		//fn_ems_debug( $departments );
		return $departments;
	}
	
	function get_reporting_manager($reporting_manager = false){
		$sql = " SELECT id, CONCAT(firstname,' ',lastname) as name FROM ems_users WHERE status = 1 AND role = 'M' ";
		
		if($reporting_manager){
			$sql.= " AND id != '".(int)$reporting_manager."' ";
		}
		
		//echo $sql ;die;
		$query  = $this->db->query( $sql );
		$reporting_manager = array();
		if($query->num_rows()){
			$reporting_manager = $query->result_array();
		}
		return $reporting_manager;
	}
	
	
	function get_designation(){
		$sql = "SELECT * FROM ems_users_designation WHERE user_designation NOT IN ('D') ";
		$query = $this->db->query( $sql );
		$designation = array();
		if($query->num_rows()){
			$designation = $query->result_array();
		}
		//fn_ems_debug( $departments );
		return $designation;
	}
	
	
	function get_statuses(){
		$sql = "SELECT * FROM ems_users_status_description";
		$query = $this->db->query( $sql );
		$statuses = array();
		if($query->num_rows()){
			$statuses = $query->result_array();
		}
		//fn_ems_debug( $departments );
		return $statuses;
	}
	
	
	public function add_employee( $data ){
		
		
		
		$user_id = false;
		$basic_data = $data['user']['basic'];
		
		$basic_data['current_status'] = 'N';
		$basic_data['timestamp'] = time();
		$basic_data['date_added'] = date('Y-m-d h:i:s',time());
		

		//$username = strtolower(substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz0123456789',5)),0,5));
		$basic_data['username'] = strtolower($basic_data['official_email']);
		$basic_data['password'] = md5('vis@123');
		
		
		$basic_data['status'] = 0;
		
		$basic_data['doj'] = date('Y-m-d', strtotime($basic_data['doj']));
		//fn_ems_debug( $basic_data );
		
		$insert_string = $this->db->insert_string('ems_users',$basic_data);
		
		
		//echo $insert_string;die;
		$this->db->query( $insert_string );
		$user_id = $this->db->insert_id();
		
		$this->db->query("DELETE FROM ems_users_extra_details WHERE user_id = '".$user_id."' ");
		$data['user']['extra']['user_id']  = $user_id;
		$insert_string = $this->db->insert_string('ems_users_extra_details',$data['user']['extra']);
		
		$this->db->query( $insert_string );
		
		return $user_id;	
		
	}
	
	
	
	public function list_all_employees($start  = false , $end = false, $exclude=false, $role = false){
		$sql = $this->select_user_fields;
		$sql.= " FROM `ems_users` u ";
		$sql.= " LEFT JOIN ems_users_designation ud ON (u.user_designation = ud.id) ";
		$sql.= " LEFT JOIN ems_users_extra_details ued ON (ued.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status us ON (us.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status_description usd ON (usd.status = u.current_status) ";
		$sql.= " LEFT JOIN ems_users_department udpt ON (udpt.id = u.department) ";
		$sql.= " LEFT JOIN ems_users m ON (m.id = u.reporting_manager) ";
		$sql.= " WHERE 1 ";
		if($exclude){
			$sql.= " AND u.role NOT IN (".implode(',',$exclude).")";
		}
		
		if($role != 'H' && $role != 'S'){
			$sql.=" AND u.status = '1' ";
		}
		
		$sql.= " ORDER BY id DESC ";
		if( $start!=false && $end!=false) {
			$sql.= " LIMIT ".$start." , ".$end;
		}
		
		
		$query = $this->db->query( $sql );
		$user_data = array();
		if( $query->num_rows() ){
			$user_data = $query->result_array();
		}
		
		return $user_data ;
	}

	
	
	public function count_manager_employees($user_id,$status = array(),$current_status = array()){
		$sql = " SELECT COUNT(*) as total ";
		$sql.= " FROM `ems_users` u ";
		$sql.= " LEFT JOIN ems_users_designation ud ON (u.user_designation = ud.id) ";
		$sql.= " LEFT JOIN ems_users_extra_details ued ON (ued.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status us ON (us.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status_description usd ON (usd.status = u.current_status) ";
		$sql.= " LEFT JOIN ems_users_department udpt ON (udpt.id = u.department) ";
		$sql.= " WHERE 1 AND u.reporting_manager = '".(int)$user_id."' ";
		
		if(!empty($current_status)){
			$sql.= "  AND u.current_status IN (".implode(',',$current_status).")  ";
		}
		
		if(!empty($status)){
			$sql.= "  AND u.status IN (".implode(',',$status).")  ";
		}
		
		
		 
		$query = $this->db->query( $sql );
		
		$count = 0;
		if( $query->num_rows() ){
			$result = $query->result_array();
			$count  = $result[0]['total'];
		}
		return $count;
	}
	public function list_manager_employees( $user_id,$start,$end ,$status  = array(),$current_status = array()){
		$sql = $this->select_user_fields;
		$sql.= " FROM `ems_users` u ";
		$sql.= " LEFT JOIN ems_users_designation ud ON (u.user_designation = ud.id) ";
		$sql.= " LEFT JOIN ems_users_extra_details ued ON (ued.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status us ON (us.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status_description usd ON (usd.status = u.current_status) ";
		$sql.= " LEFT JOIN ems_users_department udpt ON (udpt.id = u.department) ";
		$sql.= " LEFT JOIN ems_users m ON (m.id = u.reporting_manager) ";
		$sql.= " WHERE 1 AND u.reporting_manager = '".(int)$user_id."'  ";
		if( !empty($current_status) ){
			$sql.= " AND u.current_status  IN (".implode(',',$current_status).") ";
		}
		if( !empty($status) ){
			$sql.= " AND u.status  IN (".implode(',',$status).") ";
		}
		
		
		$sql.= " ORDER BY id DESC  LIMIT ".$start." , ".$end;
		
		$query = $this->db->query( $sql );
		$user_data = array();
		if( $query->num_rows() ){
			$user_data = $query->result_array();
		}
		
		return $user_data ;
		
	}
	
	public function count_employees($exclude = false , $role = false){
		
		$sql = " SELECT COUNT(*) as total ";
	
		$sql.= " FROM `ems_users` u ";
		$sql.= " LEFT JOIN ems_users_designation ud ON (u.user_designation = ud.id) ";
		$sql.= " LEFT JOIN ems_users_extra_details ued ON (ued.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status us ON (us.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status_description usd ON (usd.status = u.current_status) ";
		$sql.= " LEFT JOIN ems_users_department udpt ON (udpt.id = u.department) ";
		$sql.= " WHERE 1 ";
		
		if($exclude){
			$sql.=" AND u.role NOT IN (".implode(',',$exclude).")";
		}
		
		if($role != 'H' && $role != 'S'){
			$sql.=" AND u.status = '1' ";
		}
		$query = $this->db->query( $sql );
		
		$counts = 0;
		
		if( $query->num_rows() ){
			$counts = 	$query->result_array();
			$counts	=	$counts[0]['total'];
		}
		
		return $counts ;
	}
	
	
	
	public function count_managers(){
		
		$sql = " SELECT COUNT(*) as total FROM ems_users WHERE role = 'M'  AND current_status NOT IN ('R','T') ";
		$counts = 0;
		$query = $this->db->query( $sql );
		if( $query->num_rows() ){
			$result = $query->result_array();
			$counts = $result[0]['total'];
		}
		return $counts ;
	}
	
	
	
	public function get_managers(){
		
		/* 
		$sql = " SELECT u.id, u.firstname , u.lastname , COUNT(u2.id) AS employees FROM ems_users AS u ";
		$sql.= " JOIN ems_users u2 ON (u2.reporting_manager = u.id) ";
		$sql.= " WHERE u.user_designation = '6'  AND u.current_status NOT IN ('R','T') GROUP BY u2.reporting_manager ";
		*/
		
		$sql = " SELECT u.id, u.firstname , u.lastname  FROM ems_users AS u ";	
		$sql.= " WHERE u.role = 'M'  AND u.current_status NOT IN ('R','T') ";
		
		
		
		
		$result = array();
		$query = $this->db->query( $sql );
		if( $query->num_rows() ){
			$managers = $query->result_array();
			
			foreach($managers as $key => $value){
				
				$sql = " SELECT COUNT(u.id) AS employees FROM ems_users AS u WHERE u.reporting_manager = '".(int)$value['id']."' ";
				$q	 = $this->db->query( $sql );
				if( $q->num_rows() ){ 
					$m_employees = $q->row_array();					
					$managers[$key]['employees'] = $m_employees['employees'];
				}else{
					$managers[$key]['employees'] = 0;
					
				}				
			}
			$result = $managers ;
			
		}
		
		
		
		//fn_ems_debug( $result );
		
		return $result ;
	}
	
	
	
	
	
	
	
	public function get_timesheet($user_id,$sheet_id){
		
		$sql  = " SELECT * , t.id as sheet_id FROM `ems_users_timesheet` as t ";
		$sql .= " JOIN `ems_users_timesheet_description` as td ON ( t.id = td.sheet_id ) ";
		$sql .= " WHERE t.user_id = '".(int)$user_id."' AND t.id = '".$sheet_id."' ";
		
		$timesheet = array();
		
		$query = $this->db->query( $sql );
		if( $query->num_rows() ){
			$timesheet = $query->result_array();
		}
		return $timesheet;
	}
	
	
	public function get_current_timesheet($user_id){
		
		$date = date('Y-m-d');
		
		$sql  = " SELECT * FROM `ems_users_timesheet` as t ";
		$sql .= " JOIN `ems_users_timesheet_description` as td ON ( t.id = td.sheet_id ) ";
		$sql .= " WHERE DATE_FORMAT(t.date_added,'%Y-%m-%e') = DATE_FORMAT('".date('Y-m-d')."','%Y-%m-%e') AND t.user_id = '".(int)$user_id."' ";
		
		//echo $sql;die;
		
		$timesheet = array();
		
		$query = $this->db->query( $sql );
		if( $query->num_rows() ){
			$timesheet = $query->result_array();
		}
		return $timesheet;
	}
	
	public function delete_timesheet($sheet_id){
		$sql = " DELETE FROM ems_users_timesheet_description WHERE sheet_id = '".(int)$sheet_id."' ";
		$this->db->query( $sql );
	}
	
	public function count_timesheet($user_id ,  $search_params = array()){
	
		
		$sql = " SELECT t.id ";
		$sql.= " FROM ems_users_timesheet as t "; 	
		$sql.= " JOIN ems_users_timesheet_description td ON ( td.sheet_id = t.id ) AND t.user_id = '".(int)$user_id."' ";
		$sql.= " WHERE t.user_id = '".(int)$user_id."' ";
		
		
		
		if(!empty($search_params) && isset($search_params['from_date'] , $search_params['to_date'])){
			$sql.=" AND DATE( t.date_added ) BETWEEN  '".$search_params['from_date']."' AND  '".$search_params['to_date']."' ";
		}
		
		$query = $this->db->query( $sql );
		return $query->num_rows();
	}
	
	
	public function count_timesheet_without_tickets($user_id){
		$sql = " SELECT t.id ";
		$sql.= " FROM ems_users_timesheet as t "; 	
		$sql.= " JOIN ems_users_timesheet_description td ON ( td.sheet_id = t.id ) ";
		$sql.= " WHERE 1 ";
		if($user_id){
			$sql.= " AND t.user_id = '".(int)$user_id."' ";
		}
		$sql.="  GROUP BY t.id ";
		
		
		$query = $this->db->query( $sql );
		return $query->num_rows();
	}
	
	public function count_timesheet_without_tickets_for_manager($manager){
		$sql = " SELECT t.id ";
		$sql.= " FROM ems_users_timesheet as t "; 	
		$sql.= " JOIN ems_users_timesheet_description td ON ( td.sheet_id = t.id ) ";
		$sql.= " WHERE 1 ";
		if($manager){
			$sql.= " AND t.reporting_manager = '".(int)$manager."' ";
		}
		$sql.="  GROUP BY t.id ";
		
		
		$query = $this->db->query( $sql );
		return $query->num_rows();
	}
	
	
	public function timesheet_reports($params , $start = false , $end = false){
		$sql = " SELECT  t.user_id, u.firstname , u.lastname , SUM(td.time) total_time ";
		$sql.= " FROM ems_users_timesheet as t "; 	
		$sql.= " JOIN ems_users_timesheet_description td ON ( td.sheet_id = t.id ) ";
		$sql.= " JOIN ems_users u ON ( u.id = t.user_id ) ";
		$sql.= " WHERE 1 ";

		
		if( isset($params['from_date']) && !empty($params['to_date']) ){
			$sql.=" AND DATE( t.timesheet_date ) BETWEEN  '".$params['from_date']."' AND  '".$params['to_date']."' ";
		}
		
		if( isset($params['ticket_number']) && !empty($params['ticket_number'])  ){
			$sql.=" AND td.ticket_number = '".$params['ticket_number']."'  ";
		}
		
		if( isset($params['name']) && !empty($params['name']) ){
			
			$name = explode(' ',$params['name']);
			$str = " AND ( ";
			
			$length = count($name);
			$i = 1;
			foreach($name as $chunk){
				$str .= " ( LOWER(u.firstname) LIKE '%".$chunk."%' OR LOWER(u.lastname) LIKE '%".$chunk."%' ) ";				
				
				if($i != $length){
					$str .= " OR ";	
				}
				$i++;
			}
			$str.= " ) ";
			
			$sql.= $str;
			//$sql.=" AND ( LOWER(u.firstname) LIKE '%".strtolower($params['name'])."' OR  LOWER(u.lastname) LIKE '%".strtolower($params['name'])."') ";
		}
		
		$sql.=" GROUP BY t.user_id ";
		
		
		//echo $sql;die;
		if($start && $end ){
			$sql.= " LIMIT ".$start." , ".$end;
		}
		
		$timesheet_reports = array();
		//echo $sql;die;
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			$timesheet_reports = $query->result_array();
		}
		
		return $timesheet_reports;
	}
	
	
	public function get_timesheet_history($user_id , $start = false , $end = false , $search_params = false){
		
		
		$sql = " SELECT t.id as sheet_id ,COUNT(t.id) as total_tickets, SUM( td.time ) AS total_time, t.user_id,t.submit,t.date_added,t.date_updated,t.timesheet_date ";
		$sql.= " FROM ems_users_timesheet as t "; 	
		$sql.= " JOIN ems_users_timesheet_description td ON ( td.sheet_id = t.id ) AND t.user_id = '".(int)$user_id."' ";
		$sql.= " WHERE t.user_id = '".(int)$user_id."' ";
		
		if(!empty($search_params) && isset($search_params['from_date'] , $search_params['to_date'])){
			$sql.=" AND DATE( t.timesheet_date ) BETWEEN  '".$search_params['from_date']."' AND  '".$search_params['to_date']."' ";
		}
		
		
		$sql.= " GROUP BY t.id ORDER BY t.timesheet_date DESC ";
		
		if($start && $end ){
			$sql.= " LIMIT ".$start." , ".$end;
		}
		
		
		//echo $sql;die;
		
		$timesheet_history = array();
		
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			$timesheet_history = $query->result_array();
		}
		
		
		//fn_ems_debug( $timesheet_history );
		return $timesheet_history;
	}
	
	
	public function get_timesheet_report($user_id , $reporting_manager , $search_params = false){
		
		
		$sql = " SELECT t.id as sheet_id ,t.user_id, CONCAT(u.firstname,' ',u.lastname) as manager , CONCAT(u1.firstname,' ',u1.lastname) as employee,";
		$sql.= " u1.employee_id, ";
		$sql.= " t.reporting_manager ,t.submit,t.date_added,t.date_updated, t.timesheet_date ,";
		$sql.= " td.ticket_number , td.client_name , td.time , td.description ";
		$sql.= " FROM ems_users_timesheet as t "; 	
		$sql.= " JOIN ems_users_timesheet_description td ON ( td.sheet_id = t.id ) AND t.user_id = '".(int)$user_id."' ";
		$sql.= " JOIN ems_users u ON ( u.id = t.reporting_manager ) ";
		$sql.= " JOIN ems_users u1 ON ( u1.id = t.user_id ) ";
		$sql.= " WHERE t.user_id = '".(int)$user_id."' AND t.reporting_manager = '".(int)$reporting_manager."' ";
		
		if(!empty($search_params) && isset($search_params['from_date'] , $search_params['to_date'])){
			$sql.=" AND DATE( t.date_added ) BETWEEN  '".$search_params['from_date']."' AND  '".$search_params['to_date']."' ";
		}		
		
		$sql.= " ORDER BY t.timesheet_date DESC ";
		
		//echo $sql;die;	
		
		$timesheet_history = array();
		
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			$timesheet_history = $query->result_array();
		}
		
		return $timesheet_history;
	}
	
	
	
	
	public function save_timesheet($data){
		
		//fn_ems_debug( $data );
		
		if( isset($data['sheet_id']) && !empty($data['sheet_id']) ){
			
			
			$sql 	= " SELECT timesheet_date FROM ems_users_timesheet WHERE id = '".$data['sheet_id']."' ";
			$q = $this->db->query( $sql );
			$result  = $q->result_array();
			
			/* $days = intval((time() - strtotime($result[0]['timesheet_date'])) / (24 *3600)); 
			
			if($days > 7) { 
				return $data['sheet_id'];
			} */
			
			
			
			$sql = " UPDATE `ems_users_timesheet` SET submit = '".(int)$data['submit']."', reporting_manager = '".$data['reporting_manager']."' , date_updated = '".date('Y-m-d H:i:s')."' , timesheet_date = '".$data['timesheet_date']."'  WHERE id = '".$data['sheet_id']."' AND user_id = '".$data['user_id']."' ";
			
			$this->db->query( $sql );
			
			$this->delete_timesheet( $data['sheet_id'] );
			
			
			
			
			foreach($data['timesheet'] as $key => $value){
				$insert_query[] = "('".$value['assigned_by']."','".$data['sheet_id']."','".addslashes(trim($value['ticket_number']))."','".addslashes(trim($value['client_name']))."', '".addslashes(trim($value['time']))."' , '".addslashes(trim($value['description']))."')";		
			}
			
			$sql = " INSERT INTO ems_users_timesheet_description(assigned_by,sheet_id,ticket_number,client_name,time,description) VALUES ";
			$sql.= implode(',',$insert_query);
			
			$this->db->query( $sql );
			
			return $data['sheet_id'];
		}
		
		
		
		
		
		$sql = " INSERT INTO ems_users_timesheet SET user_id = '".addslashes(trim($data['user_id']))."', ";
		$sql.="  reporting_manager = '".$data['reporting_manager']."' , submit = '".(int)$data['submit']."' , date_added = '".date('Y-m-d H:i:s')."' , timesheet_date = '".$data['timesheet_date']."', date_updated = '".date('Y-m-d H:i:s')."'  ";
		
		$this->db->query( $sql );
		
		$sheet_id 	= $this->db->insert_id();
		
		foreach($data['timesheet'] as $key => $value){
			$insert_query[] = "('".$value['assigned_by']."','".$sheet_id."','".addslashes(trim($value['ticket_number']))."','".addslashes(trim($value['client_name']))."', '".addslashes(trim($value['time']))."' , '".addslashes(trim($value['description']))."')";		
		}
		
		$sql = " INSERT INTO ems_users_timesheet_description(assigned_by,sheet_id,ticket_number,client_name,time,description) VALUES ";
		$sql.= implode(',',$insert_query);
		
		
		$this->db->query( $sql );
		
		return $sheet_id;
		
		
		//$this->db->update();
		
		
	}
	
	public function change_credentials($user_id,$password){
		
		/* $sql = " SELECT * FROM ems_users WHERE id = '".addslashes(trim($user_id))."' ";
		$this->db->query( $sql );
		if($this->db->affected_rows()){
			return false;
		} */
		
		$sql = " UPDATE ems_users SET  password = '".md5(addslashes(trim($password)))."' WHERE id = '".(int)$user_id."'  ";
		$this->db->query( $sql );
		return true;
	}
	
	
	function view_profile( $user_id = 0, $status = array() , $current_status = array() ){
		if(!$user_id){
			return false;
		}
		$sql = $this->select_user_fields;
		$sql.= " FROM `ems_users` u ";
		$sql.= " LEFT JOIN ems_users_designation ud ON (u.user_designation = ud.id) ";
		$sql.= " LEFT JOIN ems_users_extra_details ued ON (ued.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status us ON (us.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status_description usd ON (usd.status = u.current_status) ";
		$sql.= " LEFT JOIN ems_users_department udpt ON (udpt.id = u.department) ";
		$sql.= " LEFT JOIN ems_users m ON (m.id = u.reporting_manager) ";
		$sql.= " WHERE u.`id` = '".(int)$user_id."' ";
		
		if( !empty($status) ){
			$sql.= "  AND u.status IN(".implode(',',$status).") ";
		}		
		if( !empty( $current_status ) ){
			$sql.= " AND u.current_status IN (".implode(',',$current_status).") ";
		}
		
		$query = $this->db->query( $sql );
		$user_data = array();
		if( $query->num_rows() ){
			$user_data = $query->result_array();
		}
		
		return $user_data ;
	}
	
	function get_employee_documents( $user_id = '' ){
		if(empty($user_id)){
			return;
		}
		$sql = "SELECT documents FROM ems_users_extra_details WHERE user_id = '".(int)$user_id."'";
		$query = $this->db->query( $sql );
		$documents = array();
		if($query->num_rows()){
			$result    = $query->result_array();
			$documents = unserialize( $result[0]['documents'] );
		}
		return $documents;
	}
	
	
	
	function search_employee($data = array()){
		if(empty($data)){
			return ;
		}
		
		$data['search'] = array_filter( $data['search'] );
		
		
		$result = array();
		$sql = $this->select_user_fields;
		$sql.= " FROM `ems_users` u ";
		
		$sql.= " LEFT JOIN ems_users_designation ud ON (u.user_designation = ud.id) ";
		$sql.= " LEFT JOIN ems_users_extra_details ued ON (ued.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status us ON (us.user_id = u.id) ";
		$sql.= " LEFT JOIN ems_users_status_description usd ON (usd.status = u.current_status) ";
		$sql.= " LEFT JOIN ems_users_department udpt ON (udpt.id = u.department) ";
		$sql.= " LEFT JOIN ems_users m ON (m.id = u.reporting_manager) ";
		
		$sql.= " WHERE 1 AND u.role !='S' ";
		
		if( isset($data['search']['id'])){
			$sql.= " AND u.employee_id = '".$data['search']['id']."' ";
		}
		if( isset($data['search']['phone']) ){
			$sql.= "  AND u.phone = '".$data['search']['phone']."' ";
		}
		if( isset($data['search']['firstname'])){
			//$sql.= " AND u.firstname = '".$data['search']['firstname']."' ";
			
			
			$name = explode(' ',$data['search']['firstname']);
			$str = " AND ( ";
			
			$length = count($name);
			$i = 1;
			foreach($name as $chunk){
				$str .= " ( LOWER(u.firstname) LIKE '%".$chunk."%' OR LOWER(u.lastname) LIKE '%".$chunk."%' ) ";				
				
				if($i != $length){
					$str .= " OR ";	
				}
				$i++;
			}
			$str.= " ) ";
			
			$sql.= $str;
			
			
			
			
		}
		
		if( isset($data['search']['lastname'])){
			//$sql.= " AND u.lastname = '".$data['search']['lastname']."' ";
			
			$name = explode(' ',$data['search']['lastname']);
			$str = " AND ( ";
			
			$length = count($name);
			$i = 1;
			foreach($name as $chunk){
				$str .= " ( LOWER(u.firstname) LIKE '%".$chunk."%' OR LOWER(u.lastname) LIKE '%".$chunk."%' ) ";				
				
				if($i != $length){
					$str .= " OR ";	
				}
				$i++;
			}
			$str.= " ) ";
			
			$sql.= $str;
			
		}
		
		
		if( isset($data['search']['current_status'])){
			$sql.= " AND u.current_status = '".$data['search']['current_status']."' ";
		}
		
		
		if( isset($data['search']['official_email'])){
			$sql.= " AND u.official_email = '".$data['search']['official_email']."' ";
		}
		
		if( isset($data['search']['doj'])){
			$sql.= " AND u.doj = '".$data['search']['doj']."' ";
		}
		
		$query = $this->db->query( $sql );
		
		
		if($query->num_rows()){
			$result =  $query->result_array();
		}
		return $result;
		
	}
}

?>
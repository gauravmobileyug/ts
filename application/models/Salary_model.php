<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_model extends CI_Model{
	
	function __construct(){
		parent::__construct();	
		$this->load->database();
	}
	
	public function get_salary_settings( $keys = array() ){
		if( empty($keys)  ){
			return false;
		}
		
		$settings = array();
		
		$sql = "SELECT * FROM `ems_users_salary_settings` WHERE  `key` IN ( ".implode(',',$keys)." ) "; 
		
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			$settings = $query->result_array();
		}
		
		
		foreach($settings as $key => $value){
			$settings[$value['key']] = $value;
			unset($settings[$key]);
		}
		
		return $settings;
		//echo '<pre>';print_r( $settings );die;
		
	}
	
	public function create_salary($user_id = '' , $data = array()){	
		$data['user']['salary']['salary_type'] = 'monthly';
		
		//calculate total_earning ,total_tax , total_deductions ,net_pay ,paid_days		
		$salary_data = $this->calculate_total_payment( $data['user']['salary'] );
	
		$insert_string = $this->db->insert_string('ems_users_salary_structure',$salary_data);
		
		$this->db->query($insert_string);
		
		if($this->db->affected_rows()){
			return $this->db->insert_id();
		}
		return false;
	}
	
	
	public function get_current_month_salary($id = ''){
		if( empty( $id ) ){
			return false;
		}
		$current_month = date('m/Y');
		$sql = " SELECT * FROM ems_users_salary_structure WHERE user_id = '".(int)$id."' AND DATE_FORMAT(`date_added`,'%m/%Y') = '".$current_month."' LIMIT 1 ";
		
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			return $query->result_array();
		}
		return ;
	}
	
	public function get_user_salary_history($id = '' , $start = 0, $limit =  0){
		if(empty( $id )){
			return;
		}
		
		$salary_history = array();
		
		$sql = " SELECT * FROM ems_users_salary_slips WHERE user_id = '".(int)$id."'  ORDER BY year DESC,  month DESC LIMIT ".$start." , ".$limit;
		$query = $this->db->query( $sql );
		if( $query->num_rows() ){
			$salary_history = $query->result_array();
		}
		
		return $salary_history;
		
	}
	
	public function pay($emp_id,$salary_id){
		$sql = " UPDATE ems_users_salary_structure SET paid = '1' WHERE id = '".(int)$salary_id."' AND user_id = '".(int)$emp_id."' ";
		$query 	= $this->db->query( $sql );
		return $this->db->affected_rows();
	}
	
	public function count_salaries( $id = ''){
		$count  = 0;
		$sql 	= " SELECT COUNT(id) as total FROM ems_users_salary_slips WHERE user_id = '".(int)$id."'";
		$query 	= $this->db->query( $sql );
		$result 	= $query->result_array();
		if( !empty($result) ){
			$count	= $result[0]['total'];
		}
		return $count;
		
	}
	
	
	
	public function calculate_total_payment( $data ){
		
		//Total Tax
		$total_tax = (float)$data['income_tax'];
		
		//Total Earning
		$total_earning = (float)($data['basic'] + $data['hra'] + $data['conveyance'] + $data['special_allowance'] +  $data['misc_rewards'] +  $data['bonus'] );
		
		//Total Deductions		
		$total_deductions = (float)($data['epf']);
		
		$net_pay = (float)($total_earning - ($total_tax + $total_deductions));
		
		$data['total_earning'] 	= $total_earning;
		$data['total_tax'] 		= $total_tax;
		$data['total_deductions'] = $total_deductions;
		$data['net_pay'] 		= 	$net_pay;
		
		$data['month']			=	date('m');
		
		return $data;
	}
	
	
	public function get_salary($user_ids = array() , $salary_ids = array()){
		
		$salary_data = array();
		
		$sql = "SELECT * FROM ems_users_salary_structure WHERE user_id IN (".implode(',' , $user_ids).") AND id IN (".implode(',',$salary_ids).") LIMIT 1 ";
		$query = $this->db->query( $sql );
		
		if($query->num_rows()){
			$salary_data = $query->result_array();
		}
		
		return $salary_data;
		
		
	}
	
	public function uploaded_salary_slip( $user_id, $month , $year  ){
		$sql = " SELECT * FROM ems_users_salary_slips WHERE user_id = '".$user_id."' AND month = '".$month."' AND year = '".$year."' ";
		$query = $this->db->query( $sql );
		$slip = array();
		
		if($query->num_rows()){
			$result = $query->result_array();
			$slip = $result[0];
		}
		
		return $slip;
	}
	
	
	public function get_salary_slip($slip_id,$user_id){
		$sql = " SELECT * FROM ems_users_salary_slips WHERE  id = '".$slip_id."' AND user_id = '".$user_id."'  ";
		$query = $this->db->query( $sql );
		$slip = array();
		
		if($query->num_rows()){
			$result = $query->result_array();
			$slip = $result[0];
		}
		
		return $slip;
	}
	
	
	public function view_salary($emp_id,$salary_id){
		
		$salary = array();
		
		$sql = " SELECT * FROM ems_users_salary_structure WHERE user_id = '".(int)$emp_id."' AND id = '".(int)$salary_id."' ";
		
		$query = $this->db->query( $sql );
		
		if($query->num_rows()){
			$result = $query->result_array();
			$salary = $result[0];
		}
		
		return $salary;
	}
		public function delete_salary($data){				$this->db->query( "DELETE  FROM ems_users_salary_slips WHERE month = '".$data['month']."' AND year = '".$data['year']."' AND user_id = '".$data['user_id']."' " );		}		
	public function save_uploaded_salary($data){
		$insert_string = $this->db->insert_string('ems_users_salary_slips',$data);
		$this->db->query( $insert_string );
		return $this->db->insert_id();
	}
	
	
}

?>
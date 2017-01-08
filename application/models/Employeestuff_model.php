<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeStuff_model extends CI_Model{
	
	
	
	function __construct(){
		parent::__construct();	
		$this->load->database();
	}
	
	
	public function get_departments(){
		$sql = " SELECT * FROM ems_users_department ";
		
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			return $query->result_array();
		}
		
		return array();
	}
	
	public function add_departments( $data ){			
		$insert_string = $this->db->insert_string('ems_users_department',$data['departments']);
		$this->db->query( $insert_string );
		return $this->db->insert_id();
	}
	
	
	
	
	
	
	public function get_designations(){
		$sql = " SELECT * FROM ems_users_designation ";
		
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			return $query->result_array();
		}
		
		return array();
	}
	
	public function add_designations( $data ){
		
		$sql = " SELECT MAX(user_designation) as user_designation FROM ems_users_designation ";
		$query = $this->db->query( $sql );
		
		$user_designation = $query->result_array();
		$user_designation = $user_designation[0]['user_designation'];
		
		
		$ascii = ord($user_designation)+1;
		$data['designations']['user_designation'] = chr($ascii);
		
		$insert_string = $this->db->insert_string('ems_users_designation',$data['designations']);
		$this->db->query( $insert_string );
		return $this->db->insert_id();
	}
	
}

?>
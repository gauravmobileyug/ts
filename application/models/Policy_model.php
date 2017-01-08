<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Policy_model extends CI_Model{
	
	private $select_fields = '';
	
	function __construct(){
		parent::__construct();	
		$this->load->database();
		
		$this->select_fields  = "";
	}
	
	public function get_policies($policy_id = '' , $start = false , $end = false ,$publish = array()){
		
		$sql 		= " SELECT p.* FROM ems_users_policies AS p ";
		$condition 	= " WHERE 1 ";
		$order_by   = " ORDER BY p.id DESC ";
		$limit		= " ";
		if( empty($policy_id) ){
			
			if(!empty($publish)){
				$condition .= " AND publish IN (".implode(",",$publish) .")";	
			}
			if ($start && $end ){
				$limit.= ' LIMIT '.$start.' , '. $end;
			}
			
			$sql  .= $condition.$order_by.$limit;
			
			$query = $this->db->query( $sql );
			
			$policies = array();
			if($query->num_rows()){
				return $query->result_array();
			}
			
			return $policies;
		}else{
			
			$condition .= " AND id = '".(int)$policy_id."'";
			if(!empty($publish)){
				$condition .= " AND publish IN ( ".implode(",",$publish) .") ";	
			}
			
			$sql = $sql.$condition;
			
			//echo $sql;die;
			
			$query = $this->db->query($sql);
			if($query->num_rows()){
				return $query->result_array();
			}
			return false;
		}
	}
	
	public function get_other_policy(){
		$sql =" SELECT  s1.* FROM ( ";
		$sql.="  SELECT  s2.* FROM ems_users_policies s2 WHERE s2.type IN('P' , 'A') AND s2.publish = '1' ORDER BY s2.id DESC ) as s1 GROUP BY s1.type";
		
		//echo $sql;die;
		$query = $this->db->query( $sql );
		if( $query->num_rows() ){
			$result = $query->result_array();
			
			return $result;
		}else{
			return array();
		}
	}
	
	public function count_policies($publish = array()){
		$sql = " SELECT COUNT(*) as total FROM ems_users_policies AS p ";
		$condition = " WHERE 1 ";
		if(!empty($publish)){
			$condition .= " AND publish IN (".implode(",",$publish) .") ";	
		}
		$sql = $sql.$condition;
		
		$query = $this->db->query( $sql );
		
		
		if( $query->num_rows() ){
			$row = $query->result_array();
			
			return $row[0]['total'];
		}else{
			return false;
		}
	}
	
	
	public function save_policy($data){
		
		//fn_ems_debug( $data );
		
		$data['date_added'] = date('Y-m-d H:i:s');
		$data['date_modified'] = date('Y-m-d H:i:s');

		if( isset($data['save_publish']) ){
			$data['save']  =	$data['publish'] 			= 1;
		}elseif( !isset($data['save_publish']) ){
			$data['publish'] 			= 0;
			$data['save'] 				= 1;
		}
		
		
		unset($data['_wysihtml5_mode']);
		unset($data['id']);		
		unset($data['ci_session']);
		unset($data['cvo_sid1']);
		unset($data['cvo_tid1']);
		unset($data['utag_main']);
		unset($data['ci_session']);
		unset($data['save_publish']);
		unset($data['last_five_searches']);
		
		$this->db->insert('ems_users_policies', $data);
		if($this->db->affected_rows()){
			return $this->db->insert_id();
		}
		return false;
		
	}
	
	public function update_policy($data){	

		//fn_ems_debug( $data );
	
		//unset( $data['date_modified'] );
		$policy_id = $data['id'];
		unset($data['_wysihtml5_mode']);
		unset($data['id']);		unset($data['ci_session']);
		
		$data['date_modified'] = date('Y-m-d H:i:s');
		
		if( isset($data['save_publish']) ){
			$data['save']  =	$data['publish'] 			= 1;
		}elseif( !isset($data['save_publish']) ){
			$data['publish'] 			= 0;
			$data['save'] 				= 1;
		}
		
		
		unset($data['_wysihtml5_mode']);
		unset($data['id']);		
		unset($data['ci_session']);
		unset($data['cvo_sid1']);
		unset($data['cvo_tid1']);
		unset($data['utag_main']);
		unset($data['ci_session']);
		unset($data['save_publish']);
		unset($data['last_five_searches']);
		
		$this->db->where('id', $policy_id);
		$this->db->update('ems_users_policies',$data);
		
		return true;
	}
	
	public function save_policy_file($file){
		$data	=	array(
			'file'	=>	$file
		);
		
		unset($data['_wysihtml5_mode']);
		unset($data['id']);		
		unset($data['ci_session']);
		unset($data['cvo_sid1']);
		unset($data['cvo_tid1']);
		unset($data['utag_main']);
		unset($data['last_five_searches']);
		unset($data['ci_session']);  
		
		$this->db->insert('ems_users_policies', $data);
		return $this->db->insert_id();
	}	public function update_policy_file($file , $id){
		$data	=	array(
			'file'	=>	$file
		);				$query = $this->db->query("SELECT file FROM ems_users_policies WHERE id = '".$id."' ");				$result = $query->result_array();						//unlink(base_url($result[0]['file']));		
		$this->db->where('id', $id);		$this->db->update('ems_users_policies', $data);		return $id;		
	}
	
	public function get_policy( $policy_id ){
		$result = array();
		$query = $this->db->query( "SELECT * FROM ems_users_policies WHERE id = '".(int)$policy_id."' LIMIT 1" );
		if($query->num_rows()){
			$result =  $query->result_array();
			return $result[0];
		}
		return false;
	}
	
}

?>
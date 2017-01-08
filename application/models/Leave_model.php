<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_model extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
	
	public function get_leave_application($user_id){
		$sql = " SELECT * FROM ems_users_leave_application WHERE user_id = '".$user_id."' ";
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			return $query->result_array();
		}
		return array();
	}
	
    public function get_leave_types()
    {
        $leave_types = array();
        $sql         = " SELECT * FROM ems_users_leave_types ";
        $query       = $this->db->query($sql);
        if ($query->num_rows()) {
            $leave_types = $query->result_array();
        }
        
        return $leave_types;
    }
	
	public function get_leave_type_by_id($leave_code){
		$sql= " SELECT * FROM ems_users_leave_types WHERE leave_code = '".$leave_code."' ";
		$query = $this->db->query( $sql ); 
		$result = array();
		if($query->num_rows()){
			$result = $query->row_array();
		}
		return $result;
	}
	
    public function update_employee_leaves($user_id, $data)
    {
		
		//fn_ems_debug( $data );die;
		
		
		$result = $this->leave->get_leave_types();
		$leave_types = array();
		if(!empty($result) ){
			foreach($result as $l_k => $l_v){
				$leave_types[$l_v['id']] = $l_v;
			}
		}
		
		if($data['leave_application']['leave_type'] == 1 || $data['leave_application']['leave_type'] == 2) {
            $deduct_point = $data['employee_leaves'][$data['leave_application']['leave_type']]['pending_points'];
            
			//echo $data['leave_application']['no_of_days'];die;
			

			//$leave_point = $leave_types[$data['leave_application']['leave_type']]['monthly_leaves'];
			//}
			
			if($data['leave_application']['half_day'] == 'Y'){
				
				/* $leave_point      	= ($leave_point / 30)/2;
				$leave_point 		= floor($leave_point * 100) / 100; */
				$leave_point = 0.5;
				
				$deduct_point = $leave_point; 
				
			}
			
			
			if($data['leave_application']['half_day'] == 'N'){
				$deduct_point = $data['leave_application']['no_of_days'];
			}
			
			$balance_update_sql = '';
			if( $data['leave_application']['leave_type']  == 1){
				$balance_update_sql = " UPDATE em_users_leave_balance SET sleave = (sleave - ".$deduct_point.")  WHERE  user_id = '" . $user_id . "' AND application_id = '".$data['leave_application']['id']."' ";
				
			}
			
			if( $data['leave_application']['leave_type']  == 2){
				$balance_update_sql = " UPDATE em_users_leave_balance SET pleave = (pleave - ".$deduct_point.")  WHERE  user_id = '" . $user_id . "' AND application_id = '".$data['leave_application']['id']."' ";
				
			}
			
			
			if(!empty($balance_update_sql)){
				$this->db->query($balance_update_sql);	
			}
			
            $sql = " UPDATE ems_users_avail_leave SET points = (points - " . $deduct_point . ") ,";
            $sql .= " pending_points = (pending_points - " . $deduct_point . ") ";
            $sql .= " WHERE user_id = '" . $user_id . "' AND leave_type = '" . $data['leave_application']['leave_type'] . "' ";
            $sql .= " AND DATE_FORMAT(date_added,'%Y')  = '" . date('Y') . "'";
            $this->db->query($sql);
			
        }elseif($data['leave_application']['leave_type'] == 3){
			
			//$add_point = $this->get_leave_type_by_id('PL');
			
			
			//fn_ems_debug( $data );die;
			
			$comp_points = $data['leave_application']['no_of_days'];
			
			
			/*
			//$sql = " SELECT `points` FROM `ems_users_avail_leave` WHERE  user_id = '" . $user_id . "' AND leave_type = '" . $add_point['id'] . "' ";
			$sql = " SELECT `points` FROM `ems_users_avail_leave` WHERE  user_id = '" . $user_id . "' AND leave_type = '2' ";
			$sql .= " AND DATE_FORMAT(date_added,'%Y')  = '" . date('Y') . "'";
			$points_query = $this->db->query($sql);
			
			 if($points_query->num_rows()){
				$res 	= $points_query->row_array();
				$point 	= $res['points']+$add_point['monthly_leaves'];
				if($point >= 18){
					$this->session->set_flashdata('failure','Max leaves assigned to user');
					return ;
				}
			} */
			
			
            
            // $sql = " UPDATE ems_users_avail_leave SET points = (points + " . $add_point['monthly_leaves'] . ") ";
            $sql = " UPDATE ems_users_avail_leave SET points = (points + " . $comp_points . ") ";
          //$sql .= ", pending_points = (pending_points - " . $deduct_point . ") ";
            $sql .= " WHERE user_id = '" . $user_id . "' AND leave_type = '2' ";
            $sql .= " AND DATE_FORMAT(date_added,'%Y')  = '" . date('Y') . "'";
			
			
			
            $this->db->query($sql);
			
			
			$balance_update_sql = '';
			
			$balance_update_sql = " UPDATE em_users_leave_balance SET pleave = (pleave + ".$comp_points.")  WHERE  user_id = '" . $user_id . "' AND application_id = '".$data['leave_application']['id']."' ";
		
			
			
			if(!empty($balance_update_sql)){
				$this->db->query($balance_update_sql);	
			}
			
			
			
		}
		
		
		
		
      /*   if ($data['leave_application']['leave_type'] == 2) {
            $deduct_point =  $data['employee_leaves'][$data['leave_application']['leave_type']]['pending_points'];
           
            $sql = " UPDATE ems_users_avail_leave SET points = (points - " . $deduct_point . ") , ";
            $sql .= " pending_points = (pending_points - " . $deduct_point . ") ";
            $sql .= " WHERE user_id = '" . $user_id . "' AND leave_type = '" . $data['leave_application']['leave_type'] . "' ";
            $sql .= " AND DATE_FORMAT(date_added,'%Y')  = '" . date('Y') . "'";
            $this->db->query($sql);
        } */
    }
    public function reset_employee_leaves($user_id, $data)
    {
		$array = array();
		foreach($data['employee_leaves'] as $key => $value){
			$array[$value['leave_type']] = $value;
		}
		unset( $data['employee_leaves'] );
		$data['employee_leaves'] = $array;
		//fn_ems_debug( $data );
		
		
        if ($data['leave_application']['leave_type'] == 1) {
            $add_point = $data['employee_leaves'][$data['leave_application']['leave_type']]['pending_points'];
            /* if ($data['leave_application']['half_day'] != 'N') {
                $add_point = $add_point / 2;
                $add_point = 0.5;
            } */
            $sql = " UPDATE ems_users_avail_leave SET ";
            $sql .= " pending_points = (pending_points - " . $add_point . ") ";
            $sql .= " WHERE user_id = '" . $user_id . "' AND leave_type = '" . $data['leave_application']['leave_type'] . "' ";
            $sql .= " AND DATE_FORMAT(date_added,'%Y')  = '" . date('Y') . "'";
            $this->db->query($sql);
        }
        if ($data['leave_application']['leave_type'] == 2) {
            $add_point = $data['employee_leaves'][$data['leave_application']['leave_type']]['pending_points'];
            /* if ($data['leave_application']['half_day'] != 'N') {
                $add_point = $add_point / 2;
                $add_point = 0.5;
            } */
            $sql = " UPDATE ems_users_avail_leave SET";
            $sql .= " pending_points = (pending_points - " . $add_point . ") ";
            $sql .= " WHERE user_id = '" . $user_id . "' AND leave_type = '" . $data['leave_application']['leave_type'] . "' ";
            $sql .= " AND DATE_FORMAT(date_added,'%Y')  = '" . date('Y') . "'";
            $this->db->query($sql);
        }
    }
    public function count_leaves($user_id , $params = array(),$reporting_manager = false)
    {
        $sql = " SELECT COUNT(*) as total FROM ems_users_leave_application la WHERE la.user_id = '" . $user_id . "' ";
		
		if(!empty($params)){
			
			$sql.=" AND ( DATE( la.leave_from ) BETWEEN  '".$params['from_date']."' AND  '".$params['to_date']."') ";
			$sql.=" AND ( DATE( la.leave_to ) BETWEEN  '".$params['from_date']."' AND  '".$params['to_date']."') ";
		
		}
		
		if($reporting_manager){
			$sql .= " AND reporting_manager = '".$reporting_manager."' ";
		}
		
        $query = $this->db->query($sql);
        $count = 0;
        if ($query->num_rows()) {
            $result = $query->result_array();
            $count  = $result[0]['total'];
        }
        return $count;
    }
    public function count_leaves_of_employees($reporting_manager)
    {
        $sql   = "SELECT SUM(s.total_leave_app) as total FROM (SELECT u.id as employee_id , COUNT(la.id) as total_leave_app  FROM ems_users as u 				JOIN  ems_users as u2 ON (u2.id = u.reporting_manager)				JOIN  ems_users_leave_application as la ON (u.id = la.user_id) 				WHERE u.reporting_manager = '" . $reporting_manager . "' GROUP BY u.id) as s";
        $query = $this->db->query($sql);
        $count = 0;
        if ($query->num_rows()) {
            $result = $query->result_array();
            $count  = $result[0]['total'];
        }
        return $count;
    }
    public function leave_details($leave_Id)
    {
        $sql = " SELECT la.*, lt.leave_name , al.points , al.date_added AS avail_date ";
        $sql .= " FROM ems_users_leave_application la ";
        $sql .= " JOIN ems_users_leave_types lt ON (lt.id = la.leave_type) ";
        $sql .= " LEFT JOIN ems_users_avail_leave al ON (al.leave_type = la.leave_type) ";
        $sql .= " WHERE la.id = '" . $leave_Id . "' ";
        $query         = $this->db->query($sql);
        $leave_details = array();
        if ($query->num_rows()) {
            $result        = $query->result_array();
            $leave_details = $result[0];
        }
        return $leave_details;
    }
    public function get_leaves_history($user_id, $start, $end, $params = array(),$reporting_manager = false)
    {
        $sql = " SELECT la.*, lt.leave_name ";
        $sql .= " FROM ems_users_leave_application la ";
        $sql .= " JOIN ems_users_leave_types lt ON (lt.id = la.leave_type) ";
        $sql .= " WHERE la.user_id = '" . $user_id . "'  ";
		
		if(!empty($params)){
			
			$sql.=" AND ( DATE( la.leave_from ) BETWEEN  '".$params['from_date']."' AND  '".$params['to_date']."') ";
			$sql.=" AND ( DATE( la.leave_to ) BETWEEN  '".$params['from_date']."' AND  '".$params['to_date']."')  ";
		
		}
		if($reporting_manager){
			$sql .= " AND reporting_manager = '".$reporting_manager."' ";
		}
		$sql.= " ORDER BY la.id DESC " ;
        $sql .= " LIMIT " . $start . " , " . $end;
		
		//echo $sql;die;
		
        $query  = $this->db->query($sql);
        $result = array();
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }
    public function approve($user_id, $leave_id)
    {
        $sql  = " SELECT * FROM ems_users_avail_leave WHERE user_id  = '" . (int) $user_id . "'";
        $qry  = $this->db->query($sql);
      
        if (!$qry->num_rows()) {
            return false;
        }
		$results = $qry->result_array();
		
		$employee_leaves = array();
		foreach($results as $key => $value){
			$employee_leaves[$value['leave_type']]  = $value;
		}
		
        $data['employee_leaves'] = $employee_leaves;
        $sql                     = " SELECT * FROM ems_users_leave_application WHERE id  = '" . (int) $leave_id . "'";
        $qry                     = $this->db->query($sql);
        if (!$qry->num_rows()) {
            return false;
        }
        $rslt                      = $qry->result_array();
        $data['leave_application'] = $rslt[0];
		
		//fn_ems_debug($data);
        $sql = " UPDATE ems_users_leave_application SET approved = '1' , date_approved = '".date('Y-m-d H:i:s')."'  WHERE user_id = '".$user_id."' AND id = '".$leave_id."'  ";
		$this->db->query($sql); 
        $this->update_employee_leaves($user_id, $data);
        return true;
    }
	
	
    public function disapprove($user_id, $leave_id)
    {
        $sql  = " SELECT * FROM ems_users_avail_leave  ";
		$sql.= " WHERE user_id  = '" . (int) $user_id . "' AND DATE_FORMAT(date_added,'%Y') = '" . date('Y') . "' ";
        $qry  = $this->db->query($sql);
        $rslt = $qry->result_array();
        if (!$qry->num_rows()) {
            return false;
        }
        
        $data['employee_leaves'] = $rslt;
        $sql                     = " SELECT * FROM ems_users_leave_application WHERE id  = '" . (int) $leave_id . "'";
        $qry                     = $this->db->query($sql);
        if (!$qry->num_rows()) {
            return false;
        }
        $rslt                      = $qry->result_array();
        $data['leave_application'] = $rslt[0];
        $sql                       = " UPDATE ems_users_leave_application SET approved = '2' , date_approved = '".date('Y-m-d H:i:s')."' WHERE id = '" . (int) $leave_id . "'  ";
        $this->db->query($sql);
        $this->reset_employee_leaves($user_id, $data);
        return true;
    }
	
	
	
	public function leave_reports($params , $start = false , $end = false, $manager = false ){
		
		
		//fn_ems_debug( $params );
		
		
		$sql = " SELECT  la.*,u.employee_id,u.id as user_id, u.firstname,u.lastname,lt.leave_name,CONCAT(u2.firstname , ' ',u2.lastname) as manager ";
		$sql.= " FROM ems_users_leave_application as la "; 	
		$sql.= " JOIN ems_users u ON ( u.id = la.user_id ) ";
		$sql.= " JOIN ems_users_leave_types lt ON ( lt.id = la.leave_type ) ";
		$sql.= " JOIN ems_users u2 ON ( u2.id = la.reporting_manager ) ";
		$sql.= " LEFT JOIN em_users_leave_balance lb ON ( lb.application_id = la.id ) ";
		$sql.= " WHERE 1 ";

		
		if( isset($params['from_date'] ,$params['to_date'] ) && !empty($params['from_date']) && !empty($params['to_date']) ){
			$sql.=" AND ( DATE( la.leave_from ) BETWEEN  '".$params['from_date']."' AND  '".$params['to_date']."') ";
			$sql.=" AND ( DATE( la.leave_to ) BETWEEN  '".$params['from_date']."' AND  '".$params['to_date']."') ";
			//$sql.=" AND ( la.leave_from = '".$params['from_date']."' AND  la.leave_from = '".$params['to_date']."' ) ";
			
		}
		
		
		if($manager){
			$sql.= " AND u2.id = '".$manager."' ";
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
		
		$sql.=" GROUP BY la.user_id ";
		
		
		//echo $sql;die;
		
		
		if($start && $end ){
			$sql.= " LIMIT ".$start." , ".$end;
		}
		
		$leave_reports = array();
		//echo $sql;die;
		$query = $this->db->query( $sql );
		if($query->num_rows()){
			$leave_reports = $query->result_array();
		}
		
		
		return $leave_reports;		
	}
	
    public function user_leave_summary($user_id)
    {
        $sql           = " SELECT * FROM ems_users_avail_leave WHERE `user_id` = '" . $user_id . "' AND  DATE_FORMAT(`date_added`,'%Y')  = '" . date('Y') . "' ";
        $query         = $this->db->query($sql);
        $leave_summary = array();
        if ($query->num_rows()) {
            $avail_leaves    = $query->result_array();
            $total_available = 0;
            $total_pending   = 0;
            foreach ($avail_leaves as $key => $value) {
                $total_available += $value['points'];
                if ($value['leave_type'] == 1) {
                    $leave_summary['SICK'] = $value['points'];
                }
                if ($value['leave_type'] == 2) {
                    $leave_summary['PLANNED'] = $value['points'];
                }
                if ($value['leave_type'] == 2 || $value['leave_type'] == 1) {
                    $total_pending += $value['pending_points'];
                }
            }
            $leave_summary['TOTAL']   = $total_available;
            $leave_summary['PENDING'] = $total_pending;
        }
        return $leave_summary;
    }
    public function get_leave_report($user_id, $reporting_manager, $params = array())
    {
        $sql = " SELECT la.*, CONCAT(u.firstname,' ',u.lastname) as manager , CONCAT(u1.firstname,' ',u1.lastname) as employee, u1.employee_id ,lt.leave_name , ";
        $sql .= " lb.balance_id , lb.sleave as balance_sleave , lb.pleave as balance_pleave , u1.sleave as opening_sleave , u1.pleave as opening_pleave, uml.m_sleave,uml.m_pleave,uml.m_date_added ";
        $sql .= " FROM ems_users_leave_application as la ";
        $sql .= " JOIN ems_users u ON ( u.id = la.reporting_manager ) ";
        $sql .= " JOIN ems_users u1 ON ( u1.id = la.user_id ) ";
        $sql .= " JOIN ems_users_leave_types lt ON ( lt.id = la.leave_type ) ";
        $sql .= " JOIN `em_users_leave_balance`  lb ON ( lb.application_id = la.id ) ";
        $sql .= " LEFT JOIN `ems_user_monthly_leaves`  uml  ON ( uml.user_id = la.user_id ) ";
        $sql .= " WHERE la.user_id = '" . (int) $user_id . "' AND la.reporting_manager = '" . (int) $reporting_manager . "' ORDER BY la.id DESC , uml.m_date_added DESC ";
		
		//echo $sql;die;
        $leave_history = array();
        $query         = $this->db->query($sql);
        if ($query->num_rows()) {
            $leave_history = $query->result_array();
        }
        return $leave_history;
    }
    public function count_all_leaves($reporting_manager)
    {
        $sql = " SELECT id FROM ems_users_leave_application ";
        if ($reporting_manager) {
            $sql .= " WHERE reporting_manager = '" . $reporting_manager . "' ";
        }
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    public function apply_leave($user_id = false, $data = array())
    {
        
        if (empty($data) || !$user_id) {
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
		
		
		
        $sql            = " SELECT * FROM ems_users_leave_types WHERE status = '1' ";
        $qry            = $this->db->query($sql);
        $result         = $qry->result_array();
        
		$employee_leaves  = array();
	   
		foreach( $result as $_key => $_value) {
			$employee_leaves[$_value['id']] = $_value;
		}
	   
		
		
        $data['reporting_manager'] = 0;
        
        $sql = " SELECT reporting_manager FROM ems_users WHERE id = '" . (int) $user_id . "' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $repoting_manager          = $query->result_array();
            $data['reporting_manager'] = $repoting_manager[0]['reporting_manager'];
        }
		
		if($data['reporting_manager'] == 0){
			return false;
		}
        $data['user_id'] = $user_id;
       
        
        unset($data['ci_session']);
		
		$comp_off_leave = 0;
		if($data['leave_type'] == 3){
			$comp_off_leave = $data['leave_type'];
			$data['leave_type'] = 2;
		}
		
		
		$leave_point = $employee_leaves[$data['leave_type']]['monthly_leaves'];
		
		
		
        /* if ($data['leave_type'] == 1) {
            $leave_point = $employee_leaves['sleave'];
        }
        if ($data['leave_type'] == 2) {
            $leave_point = $employee_leaves['pleave'];
        } */
		
		
        if ($data['eh_leave'] == 'H') {
            $data['half_day'] 	= 'Y';
            /* 
			$leave_point      	= ($leave_point / 30)/2;
			$leave_point 		= floor($leave_point * 100) / 100;
			*/
			$leave_point 		= 0.5;
			
        }
        if ($data['eh_leave'] == 'E') {
            $data['emergency_leave'] = 'Y';
        }
		
		unset( $data['eh_leave'] );
		
		if($comp_off_leave){
			$data['leave_type'] = 3;
		}
		
		
		if(!isset($data['half_day'])){
			$leave_point = $data['no_of_days'];
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
		
		$data['date_added'] = date('Y-m-d H:i:s');
		
		
		//echo $leave_point;die;
        $insert_string = $this->db->insert_string('ems_users_leave_application', $data);
		
		
		
		
        $this->db->query($insert_string);
        $application_id = $this->db->insert_id();
		
		
		
		if(!$comp_off_leave) {
			
			$sql  = " UPDATE `ems_users_avail_leave` SET `pending_points` = (`pending_points`+'" . $leave_point . "') ";
			$sql .= " WHERE `user_id` = '" . (int) $user_id . "' AND  `leave_type` = '" . $data['leave_type'] . "' AND DATE_FORMAT(date_added,'%Y')  = '" . date('Y') . "'   ";
			
			$this->db->query($sql);	
		}
		
		$sql = " SELECT * FROM `ems_users_avail_leave` WHERE `user_id` = '".(int)$user_id."' AND DATE_FORMAT(date_added,'%Y')  = '".date('Y')."'  ";	
		
		
		$query = $this->db->query($sql);
		
		$availed_leaves =  $query->result_array();
		
		
		//fn_ems_debug( $avail_leaves );		
		
		$balance_sleave = 0;
		$balance_pleave = 0;
		
		foreach($availed_leaves as $av_key => $av_value){
			if($av_value['leave_type'] == 1){
				$balance_sleave = $av_value['points'];
			}
			if($av_value['leave_type'] == 2){
				$balance_pleave = $av_value['points'];
			}
		}
		
		$sql = " INSERT INTO `em_users_leave_balance`  SET `user_id` = '".(int)$user_id."' , `application_id` = '".(int)$application_id."' ,  ";
		$sql.= "  `sleave` = '".$balance_sleave."' , `pleave` = '".$balance_pleave."' ,  `date_added` = '".date('Y-m-d H:i:s')."' ";
		
		$this->db->query($sql);
		

        return $application_id;
    }
    
    public function get_availed_leaves($user_id)
    {
        
        $availed_leaves = array();
        
        $sql = " SELECT al.user_id,al.used,al.date_added as availed_date,lt.*  FROM ems_users_avail_leave as al ";
        $sql .= " JOIN ems_users_leave_types as lt ON (lt.id = al.leave_type ) ";
        $sql .= " WHERE al.user_id = '" . $user_id . "' ";
        
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result_array();
            
            foreach ($result as $key => $leave) {
                $availed_leaves[$leave['id']] = $leave;
            }
            
        }
        return $availed_leaves;
        
        
    } 
	public function update_leave_settings( $data ){
		foreach($data['leave'] as $key=> $value){
			$sql=" UPDATE ems_users_leave_types SET yearly_leaves = '".$value['yleave']."' , monthly_leaves = '".$value['mleave']."' WHERE leave_code = '".$key."'   ";
			$this->db->query( $sql );
		}
		return true;
	}
    
    
    
}

?>
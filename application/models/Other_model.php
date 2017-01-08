<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
class Other_model extends CI_Model
{
    
    private $select_fields = '';
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function get_activity($activity_id = false)
    {
        $sql    = " SELECT * FROM ems_users_activity WHERE id = '" . $activity_id . "' ";
        $query  = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];
    }
	
	public function delete_activity($activity_id)
    {
        $sql    = " DELETE FROM ems_users_activity WHERE id = '" . $activity_id . "' ";
        $this->db->query($sql);
		return;
        
    }
	
	public function delete_misc($misc_id)
    {
		
        $sql    = " DELETE FROM ems_users_misc WHERE id = '" . $misc_id . "' ";
        $this->db->query($sql);
		return;
        
    }
	
	
	
	public function save_forms($data)
    {
        $sql= " INSERT INTO ems_users_forms SET `title` = '".addslashes($data['title'])."' , `form` = '".$data['form']."' , `date_added` = '".date('Y-m-d H:i:s')."'  ";
        $this->db->query($sql);
		return true;
        
    }
	
	public function get_forms($start=false,$end=false)
    {
        $sql= " SELECT * FROM  ems_users_forms ";
		$sql.=" ORDER BY form_id DESC ";
		
		if($start!==false && $end!==false){
			$sql.=" LIMIT ".$start.','.$end; 
		}
		
		
		
        $query = $this->db->query($sql);
		if($query->num_rows()){
			return $query->result_array();
		}
		return array();
        
    }
	
	
	public function count_total_forms()
    {
        $sql= " SELECT * FROM  ems_users_forms ";
        $query = $this->db->query($sql);
		if($query->num_rows()){
			return $query->num_rows();
		}
		return 0;
        
    }
	
	
	
	
	public function delete_forms($id)
    {
        $sql= " DELETE FROM ems_users_forms WHERE form_id = '".(int)$id."' ";
        $this->db->query($sql);
		return true;
        
    }
	
	
	
	public function save_thoughts($data)
    {
        $sql= " INSERT INTO ems_thought_of_day SET `thought` = '".addslashes($data['thought'])."' , `user_id` = '".$data['user_id']."' , `image` = '".$data['image']."'  ";
        $this->db->query($sql);
		return;
        
    }
	
	public function get_latest_thought()
    {
         $sql = " SELECT t.* , u.firstname , u.lastname FROM ems_thought_of_day  t ";
		 $sql.= " JOIN ems_users u ON (u.id = t.user_id) ";
		 $sql.= " ORDER BY t.id DESC LIMIT 1 ";
        $query  = $this->db->query($sql);
        $result = array();
        if ($query->num_rows()) {
            $result = $query->row_array();
        }
        return $result;
        
    }
	
	
    public function get_other_activity($activity_id = false)
    {
        $sql    = " SELECT * FROM ems_users_activity WHERE id != '" . $activity_id . "' AND  activity_date >= DATE_FORMAT(NOW() , '%y-%m-%d')  ORDER BY id DESC ";
        $query  = $this->db->query($sql);
        $result = array();
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }
	
	public function request_doc($data , $user_id){
		
		$sql = " INSERT INTO ems_misc_request SET user_id = '".$user_id."' , `comments` = '".addslashes( $data['comments'] )."' , `title`= '".addslashes($data['title'])."' ,";
		$sql.= " date_added = '".date('Y-m-d H:i:s')."'  ";
		$this->db->query( $sql );
		return $this->db->affected_rows();
	}
	
	public function get_request_doc($data){
	
	}
	
	
    public function get_activity_ids($status)
    {
        $sql    = " SELECT id,activity_name FROM ems_users_activity WHERE status IN (" . implode(',', $status) . ")  AND activity_date >= DATE_FORMAT(NOW() , '%y-%m-%d')  ORDER BY id DESC ";
        $query  = $this->db->query($sql);
        $result = array();
        if ($query->num_rows()) {
            $result = $query->result_array();
        }
        return $result;
    }
    public function add_activity($data)
    {
        $insert_string = $this->db->insert_string('ems_users_activity', $data);
        $this->db->query($insert_string);
        return $this->db->insert_id();
    }
    public function edit_activity($data, $activity_id)
    {
        $this->db->where('id', $activity_id);
        $this->db->update('ems_users_activity', $data);
        return true;
    }
    public function count_activity($data = array())
    {
        $sql   = "SELECT COUNT(*) as total FROM  ems_users_activity WHERE 1 ";
		$sql.=" AND activity_date >= DATE_FORMAT(NOW() , '%y-%m-%d') ";
        $query = $this->db->query($sql);
        $count = 0;
        if ($query->num_rows()) {
            $count = $query->result_array();
            $count = $count[0]['total'];
        }
        return $count;
    }
    public function get_all_activity($start = false, $end = false, $params = array())
    {
        $sql = " SELECT * FROM ems_users_activity WHERE 1 ";
        if (isset($params['status']) && !empty($params['status'])) {
            $sql .= " AND status IN (" . implode(',', $params['status']) . ")";
        }
		$sql.=" AND activity_date >= DATE_FORMAT(NOW() , '%y-%m-%d') ORDER BY activity_date DESC ";
        $activities = array();
        $query      = $this->db->query($sql);
        if ($query->num_rows()) {
            $activities = $query->result_array();
        }
        return $activities;
    }
    public function save_misc($data)
    {
        //fn_ems_debug( $data );
        
        $insert_string = $this->db->insert_string('ems_users_misc', $data);
        $this->db->query($insert_string);
        return $this->db->insert_id();
    }
    
    public function get_misc($id)
    {
        $sql   = " SELECT * FROM ems_users_misc WHERE id = '" . (int) $id . "' AND type = 'M' ";
        $query = $this->db->query($sql);
        
        if ($query->num_rows()) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }
    public function get_gallery_images(){
		$query = $this->db->query( "SELECT * FROM ems_users_misc WHERE type = 'I' ORDER BY date_added DESC LIMIT 30 " );
		if($query->num_rows()){
			return $query->result_array();
		}
		return array();
	}
    public function count_misc($data = array())
    {
        $sql       = " SELECT * FROM ems_users_misc ";
        $condition = " WHERE 1 AND type = 'M' ";
        if (!empty($data['status'])) {
            $condition .= ' AND status IN (' . implode(',', $data['status']) . ') ';
        }
        $sql .= $condition;
        $query = $this->db->query($sql);
        
        return $query->num_rows();
    }
    public function get_all_misc($data = array(), $start = false, $end = false)
    {
        
        $items = array();
        
        $sql       = " SELECT * FROM ems_users_misc ";
        $condition = " WHERE 1 AND type = 'M' ";
        $limit     = '';
        $order_by  = '';
        
        
        if (!empty($data['status'])) {
            $condition .= ' AND status IN (' . implode(',', $data['status']) . ') ';
        }
        
        if ($start && $end) {
            $limit .= $start . ',' . $end;
        }
        $order_by = ' ORDER BY id DESC ';
        $sql .= $condition . $order_by . $limit;
        $query = $this->db->query($sql);
        
        if ($query->num_rows()) {
            $items = $query->result_array();
        }
        
        
        return $items;
        
    }
	
	public function add_calendar_event( $data ){
		$sql = " INSERT INTO ems_calendar SET title = '".addslashes($data['title'])."' , startdate = '".addslashes($data['date'])."' ,enddate = '".addslashes($data['date'])."',  ";
		$sql.= " backgroundColor = '".addslashes($data['backgroundColor'])."' , borderColor = '".addslashes($data['borderColor'])."'  ";
		
		
		$this->db->query( $sql );
		return $this->db->insert_id();
	}
	
	public function update_calendar_event( $data ){
		
		unset($data['type']);
		$id = $data['id'];
		unset($data['id']);
		
		$this->db->where('id' , $id);
		$this->db->update('ems_calendar' , $data);
		
		
		return $id;
		
	}
	
	public function fetch_calendar_events($role){
		$sql = " SELECT * FROM ems_calendar ";
		$query = $this->db->query( $sql );
		$events = array();
		if($query->num_rows()){
			$result = $query->result_array();
			foreach($result as $key => $fetch){
				$e = array();
				$e['id'] = $fetch['id'];
				$e['title'] = $fetch['title'];
				$e['start'] = $fetch['startdate'];
				$e['end'] = $fetch['enddate'];
				$e['backgroundColor'] = $fetch['backgroundColor'];
				$e['borderColor'] = $fetch['borderColor'];
				$allday = ($fetch['allDay'] == "true") ? true : false;
				//$e['allDay'] = $allday;
				
				if($role == 'H' ||$role == 'S'  ){
					$e['eventStartEditable'] = true;
					$e['eventDurationEditable'] = true;
				}
				
				
				array_push($events, $e);
			}
		}
		return $events;
	}
	
	function delete_calendar_event( $id ){
		$this->db->query( "DELETE FROM ems_calendar WHERE id = '".(int)$id."' " );
	}
    
    
}

?>
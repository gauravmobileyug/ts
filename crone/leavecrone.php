<?php
echo 'Server time : '.date('Y-m-d H:i:s').'<br/>';

echo '<pre>';print_r( $_REQUEST );


date_default_timezone_set('Asia/Kolkata');
echo 'Local time : '.date('Y-m-d H:i:s').'<br/>';

//die;
error_reporting(E_ALL);
ini_set('display_errors' ,1);
class LeaveCrone{  
	private $db = null;
	private $current_status = array("'N'", "'P'", "'M'");  
	private $employees = array();  
	private $leave_types = array(); 
	private $ems_users_leave_types = array(); 
	
	private $pl_max_carry_forward = 10;

	function __construct()    {
		$db_config = include_once('db.php');
		//echo '<pre>';print_r($db_config);
   
		$this->db  = mysqli_connect($db_config['default']['hostname'], $db_config['default']['username'], $db_config['default']['password'], $db_config['default']['database']); 
		if (mysqli_connect_errno()) {  
			echo "Failed to connect to MySQL: " . mysqli_connect_error();   
			die;   
		}  else{
			echo ' connected with db ';
			echo(__DIR__);
		}   
		$this->get_all_employees();
		
		echo '<pre>';print_r( $this->employees );
		
		
		$this->get_all_leaves(); 
	}  

	public function get_all_employees()    { 
	
		//Fetching those employees who are not having same month of joining date
		//Also checking if joining date is greater than the current date
		

	
		$sql = " SELECT id FROM ems_users WHERE current_status IN (" . implode(',', $this->current_status) . ")  AND status = '1' AND role NOT IN ('H' ,'S') "; 
		$sql.= " AND DATE_FORMAT(  `doj` ,  '%m-%Y' ) != DATE_FORMAT( NOW() ,  '%m-%Y' )  ";
		$sql.= " AND  ( DATE_FORMAT(  `doj` ,  '%m-%Y' ) <  DATE_FORMAT( NOW() ,  '%m-%Y' )) "; 
		$result = $this->db->query($sql);     
		if ($result->num_rows > 0) {   
			while ($row = $result->fetch_assoc()) {  
				$this->employees[] = $row['id'];   
			}  
		} 
		return $this->employees;  
	}

	public function get_all_leaves()    { 
		$sql    = " SELECT * FROM ems_users_leave_types WHERE status = '1' ";
		$result = $this->db->query($sql);    
		if ($result->num_rows > 0) {    
			while ($row = $result->fetch_assoc()) {  
				$this->leave_types[$row['id']] = $row;       
			}     
		}   
		return $this->leave_types;   
	}  

	public function save_crone_logs($name = '')    { 
		$sql = " INSERT INTO ems_crone_logs SET name = '" . $name . "' , date_executed = '".date('Y-m-d H:i:s')."'  ";  
		$this->db->query($sql);   
	}  
	
	public function save_user_monthly_leaves($user_id , $month , $year ,$m_sleave  = 'X',$m_pleave = 'X')    { 
	
		$sql = " SELECT * FROM ems_users_avail_leave WHERE user_id = '".(int)$user_id."' AND DATE_FORMAT(`date_added`,'%Y')  = '".$year."' ";
		
		
		$m_total_sleave = 0;
		$m_total_pleave = 0;
		$m_total_leaves = 0;
		
		$result = $this->db->query($sql);    
		
		
		
		if ($result->num_rows > 0) {    
			while ($row = $result->fetch_assoc()) {  
			
				if($row['leave_type'] == 1){
					$m_total_sleave  = $row['points'];
				}
				
				if($row['leave_type'] == 2){
					$m_total_pleave  = $row['points'];
				}				
			}    
			
			$m_total_leaves = $m_total_sleave + $m_total_pleave;
			
		}   
		
	
		$sql = " INSERT INTO ems_user_monthly_leaves SET user_id = '".(int)$user_id."' , month = '".$month."' , year = '".$year."' ,";
		$sql.= " m_sleave = '".$m_sleave."' , m_pleave = '".$m_pleave."' , m_date_added = '".date('Y-m-d H:i:s')."' ,";  
		$sql.= " m_total_sleave = '".$m_total_sleave."' , m_total_pleave = '".$m_total_pleave."' , m_total_leaves = '".$m_total_leaves."' ";  
		
		
		
		$this->db->query($sql);   
	}  
	
	
	

	
	public function run_regular_plan_leave(){
		echo 'Regular PLANNED LEAVE Run ON '.date('Y-m-d H:i:s').': <br/><br/>';
		foreach( $this->employees as $employee ){
			
			$sql = " UPDATE `ems_users_avail_leave` SET `points` = (`points` + '".$this->leave_types[2]['monthly_leaves']."') ";
			$sql.= " WHERE 1 AND `leave_type` = '2' ";
			$sql.= " AND `user_id` = '".(int)$employee."' AND DATE_FORMAT(`date_added`,'%Y')  = DATE_FORMAT(NOW(),'%Y') ";
			
			$this->db->query( $sql );
			
			
			echo $employee .' => '.$sql .'<br/>' ;
			
			$this->save_user_monthly_leaves($employee,date('m'),date('Y') ,'X' ,$this->leave_types[2]['monthly_leaves']);
		}
		
		$this->save_crone_logs("Regular Plan Leave");
		
	}
	
	public function run_regular_sick_leave(){
		
		echo 'Regular SICK LEAVE Run ON '.date('Y-m-d H:i:s').': <br/><br/>';
		
		foreach( $this->employees as $employee ){
			
			$sql = " UPDATE `ems_users_avail_leave` SET `points` = (`points` + '".$this->leave_types[1]['monthly_leaves']."') ";
			$sql.= " WHERE 1 AND `leave_type` = '1' ";
			$sql.= " AND `user_id` = '".(int)$employee."' AND DATE_FORMAT(`date_added`,'%Y')  = DATE_FORMAT(NOW(),'%Y') ";
			
			$this->db->query( $sql );
			
			echo $employee .' => '.$sql .'<br/>' ;
			
			$this->save_user_monthly_leaves($employee,date('m'),date('Y') ,$this->leave_types[1]['monthly_leaves'],'X' );
		}
		$this->save_crone_logs("Regular Sick Leave");
	}

	public function run_newyear_sick_leave(){
		echo 'NEW YEAR Sick Leave Run ON '.date('Y-m-d H:i:s').': <br/><br/>';
		foreach( $this->employees as $employee ){
			
			$sql = " INSERT INTO `ems_users_avail_leave` SET `user_id` = '".(int)$employee."' , `leave_type`  = '1' ,  `points`  = '".$this->leave_types[1]['monthly_leaves']."', ";
			$sql.= " pending_points = '0.00', `date_added` = '".date('Y-m-d H:i:s')."' ";
			
			$this->db->query( $sql );
			
			echo $employee .' => '.$sql .'<br/>' ;
			
			$this->save_user_monthly_leaves($employee,date('m'),date('Y') ,$this->leave_types[1]['monthly_leaves'],'X' );
		}
		
		$this->save_crone_logs("New Year Sick Leave");
	}
	
	
	
	public function run_newyear_sick_leave_bkp(){
		echo 'NEW YEAR Sick Leave Run ON '.date('Y-m-d H:i:s').': <br/><br/>';
		foreach( $this->employees as $employee ){
			
			$sql = " INSERT INTO `ems_users_avail_leave` SET `user_id` = '".(int)$employee."' , `leave_type`  = '1' ,  `points`  = '".$this->leave_types[1]['monthly_leaves']."', ";
			$sql.= " pending_points = '0.00', `date_added` = '".date('Y-m-d H:i:s',mktime(0,0,0,01,1,2017))."' ";
			
			$this->db->query( $sql );
			
			echo $employee .' => '.$sql .'<br/>' ;
			
			$this->save_user_monthly_leaves($employee,'01','2017' ,$this->leave_types[1]['monthly_leaves'],'X' );
		}
		
		$this->save_crone_logs("New Year Sick Leave");
	}
	
	
	public function run_newyear_planned_leave(){
		
		$previous_year = date("Y",strtotime("-1 year"));
		
		echo 'NEW YEAR PLANNED LEAVE Run ON '.date('Y-m-d H:i:s').': <br/><br/>';
		
		foreach( $this->employees as $employee ){
			$sql = " SELECT points FROM `ems_users_avail_leave` WHERE `user_id` = '".(int)$employee."' AND `leave_type`  = '2' ";
			$sql.= " AND DATE_FORMAT(`date_added`,'%Y') = '".$previous_year ."'";
			$result = $this->db->query($sql);  


			$points_left = 0;
			if ($result->num_rows > 0) { 
			
				$points_left_a = $result->fetch_assoc();
				$points_left = $points_left_a['points'];
				
				
				if($points_left >= $this->pl_max_carry_forward){
					
					$sql = " INSERT INTO `ems_users_avail_leave` SET `user_id` = '".(int)$employee."' , `leave_type`  = '2' , ";
					$sql.= " `points`  = '".$this->pl_max_carry_forward."', ";
					$sql.= " pending_points = '0.00', `date_added` = '".date('Y-m-d H:i:s')."' ";
				
					$this->db->query( $sql );
					
					
					echo $employee .' => '.$sql .'<br/>' ;
					
					$this->save_user_monthly_leaves($employee,date('m'),date('Y') ,'X',$this->pl_max_carry_forward );
					
				}else{
					$sql = " INSERT INTO `ems_users_avail_leave` SET `user_id` = '".(int)$employee."' , `leave_type`  = '2' , ";
					$sql.= " `points`  = '".($this->leave_types[2]['monthly_leaves'] + $points_left)."', ";
					$sql.= " pending_points = '0.00', `date_added` = '".date('Y-m-d H:i:s')."' ";
				
					$this->db->query( $sql );
					echo $employee .' => '.$sql .'<br/>' ;
					
					$this->save_user_monthly_leaves($employee,date('m'),date('Y') ,'X',($this->leave_types[2]['monthly_leaves'] + $points_left));
					
				}
				
				
			}   
			
		}
		
		$this->save_crone_logs("New Year Plan Leave");
	}
	
	public function run_newyear_planned_leave_bkp(){
		
		$previous_year = date("Y");
		
		echo 'NEW YEAR PLANNED LEAVE Run ON '.date('Y-m-d H:i:s').': <br/><br/>';
		
		foreach( $this->employees as $employee ){
			$sql = " SELECT points FROM `ems_users_avail_leave` WHERE `user_id` = '".(int)$employee."' AND `leave_type`  = '2' ";
			$sql.= " AND DATE_FORMAT(`date_added`,'%Y') = '".$previous_year ."'";
			$result = $this->db->query($sql);  


			$points_left = 0;
			if ($result->num_rows > 0) { 
			
				$points_left_a = $result->fetch_assoc();
				$points_left = $points_left_a['points'];
				
				
				if($points_left >= $this->pl_max_carry_forward){
					
					$sql = " INSERT INTO `ems_users_avail_leave` SET `user_id` = '".(int)$employee."' , `leave_type`  = '2' , ";
					$sql.= " `points`  = '".$this->pl_max_carry_forward."', ";
					$sql.= " pending_points = '0.00', `date_added` = '".date('Y-m-d H:i:s',mktime(0,0,0,01,1,2017))."' ";
				
					$this->db->query( $sql );
					
					
					echo $employee .' => '.$sql .'<br/>' ;
					
					$this->save_user_monthly_leaves($employee,'01','2017' ,'X',$this->pl_max_carry_forward );
					
				}else{
					$sql = " INSERT INTO `ems_users_avail_leave` SET `user_id` = '".(int)$employee."' , `leave_type`  = '2' , ";
					$sql.= " `points`  = '".($this->leave_types[2]['monthly_leaves'] + $points_left)."', ";
					$sql.= " pending_points = '0.00', `date_added` = '".date('Y-m-d H:i:s',mktime(0,0,0,01,1,2017))."' ";
				
					$this->db->query( $sql );
					echo $employee .' => '.$sql .'<br/>' ;
					
					$this->save_user_monthly_leaves($employee,'01','2017' ,'X',($this->leave_types[2]['monthly_leaves'] + $points_left));
					
				}
				
				
			}   
			
		}
		
		$this->save_crone_logs("New Year Plan Leave");
	}
	
	
	

	public function run_leave_crone()    {    
	
	
	
		if( isset($_REQUEST['test_sleave']) && $_REQUEST['test_sleave'] == 1){
			//die("sleave");
			$this->run_regular_sick_leave();
		}
		if( isset($_REQUEST['test_pleave']) && $_REQUEST['test_pleave'] == 1){
			//die("pleave");
			$this->run_regular_plan_leave();
		}
		
		if( isset($_REQUEST['test_year']) && $_REQUEST['test_year'] == 1){
			$this->run_newyear_sick_leave_bkp();
			$this->run_newyear_planned_leave_bkp();
		}
		
		
		
		
	

		//Add Sick Leaves Points At Begining Of The Month   
		//Add Plan Leaves Points At End Of The Month 
	
	
		## LEAVE RESET CRONE CONCEPT ##
		
		//Check if it is New Year If So
			//Run crone on around 00.01 AM 
			# Then check if PL of employee is greater than or equal predifined value i.e 10.
				# if so then add 10 points in employee avail leaves.
				#if not then add Planned Leave poins which is set by Super Admin To current PL points .
			# Then reset SL Leaves of employees to the SL points which is set by Super Admin .
		//
		
		
		
		$is_new_year = date('z');
		$time = date('H:i');
		$max_days      = (int) cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); 
		
		
		/* echo $is_new_year .'<br/>';
		echo $time;
		
		die; */
		echo "<br/><pre>";  
		echo "Time : ". $time.'<br/><pre>';
		echo "Is_New_Year : ". $is_new_year.' (IF 0 THEN IT IS NEW YEAR)<br/><pre>';
		echo "Day : ". date('d').' <br/><pre>';
		echo "Max Days Of This Month : ". $max_days.' <br/><pre>';
		
		if($time == '01:00' && $is_new_year === '0'){
			$this->run_newyear_sick_leave();
			$this->run_newyear_planned_leave();
			die("New Year Crone Run Successfully");
		}
		
		
		//Regular Sick Leave Crone
		//Run crone on every 1st day of the month around 00.01 AM 
		

		
		//if(date('d') == 1 && $time == '00:30' && $is_new_year !== '0'){
		if(date('d') == 1 && $time == '00:30'){
			$this->run_regular_sick_leave();
			die("Regular Sick Leave Crone Run Successfully");
		}
		
		
		
		//Regular Planned Leave Crone
		//Run crone on every last day of the month around 11.00 PM 
		
		
		
		
	//	if(date('d') == $max_days && $time == '23:30' && $is_new_year !== '0'){
		if(date('d') == $max_days && $time == '23:30'){
			//Planned Leave
			$this->run_regular_plan_leave();
			die("Regular Plan Leave Crone Run Successfully");
		}

		$this->close_connection(); 
	}  

	public function close_connection()    {  
		$this->db->close(); 
	}
}


?>
<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Download Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/helpers/download_helper.html
 */

// ------------------------------------------------------------------------


function resizeImage($filename){
	$config['image_library'] = 'gd2';
	$config['source_image'] = '/uploads/otheractivity/'.$filename;
	$config['create_thumb'] = TRUE;
	$config['maintain_ratio'] = TRUE;
	$config['width']         = 900;
	$config['height']       = 500;

	$this->load->library('image_lib', $config);

	$this->image_lib->resize();
}

function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
   // $minutes = ($time % 60);
  $seconds = ($time % (60*60));
    return sprintf($format, $hours, $minutes);
}

function fn_ems_generate_random_password(){
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&()_-';
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass);
}

function fn_ems_debug( $data ){
	if( is_array($data) ){
		echo '<pre>';print_r( $data );die;
	}else{
		echo $data;die;
	}
}
function fn_ems_filter_login_inputs( $data = array() ){
	if( empty($data) ){
		return false;
	}	
	//trim
	foreach($data as $key => $value){
		$data[$key]	=	addslashes( trim($value) );
	}
	
	return $data;
	
}

function fn_ems_filter_inputs( $data = array() ){
	if( empty($data) ){
		return false;
	}	
	//trim
	foreach($data as $key => $value){
		$data[$key]	=	addslashes( trim($value) );
	}
	
	return $data;
}


function fn_ems_user_permissions($data){
	switch($data['user_designation']){
		
		# 3	-	HR ADMIN
		# 4	-	Super Admin
		# 6 -	Manager
		# Rest are  - Employees
		
		case 3:	
			$exclude = array(3,4,6);
			break;
		case 4:
			$exclude = array(4);
			break;
		case 6:
			$exclude = array(3,4,6);
			break;
		default:
			$exclude = array(3,4,6);
			break;
	}
}


function fn_ems_exclude_users($data){

	$exclude = array();
	$ci =& get_instance();
	
	$exclude = array();
	switch($data['role']){
		
		# H	-	HR ADMIN
		# S	-	Super Admin
		# Rest are  - Employees
		
		case 'H':	
			$exclude = array("'H'","'S'");
			break;
		case 'S':
			$exclude = array("'S'");
			break;
		default:
			$exclude = array("'H'","'S'");
			break;
	}
	
	return $exclude;
}


function if_it_is_reporting_employee($manager,$user_id){
	$ci =& get_instance();
	$ci->load->database();
	//List all reporting employees
	$sql = " SELECT id FROM ems_users WHERE reporting_manager = '".$manager['id']."' ";
	
	
	$query = $ci->db->query( $sql );

	$emp_ids = array();
	if($query->num_rows()){
		$result = $query->result_array();
		foreach($result as $key => $value){
			$emp_ids[] = $value['id'];
		}
	}
	
	
	if(!empty( $emp_ids ) && in_array($user_id ,$emp_ids )){
		return true;
	}
	
	return false;
	
}


function if_it_is_reporting_manager($employee,$reporting_manager){
	$ci =& get_instance();
	
	$ci->load->database();

	$sql = " SELECT * FROM ems_users WHERE id = '".$employee['id']."' AND reporting_manager = '".$reporting_manager."' ";
	
	
	$query = $ci->db->query( $sql );
	
	
	if($query->num_rows()){
		return true;
	}
	
	return false;
}

function fn_json_encode( $data = array() ){
	if( empty($data) ){
		echo json_encode(array('status' => 0 , 'message'=>'no data passed'));die;
	}
	echo json_encode( $data );die;
}

function modified_filename( $name ,$user_id){

	$ext 		= pathinfo($name, PATHINFO_EXTENSION);
	//$file_name  = base64_encode( crypt((time().'_'.$user_id.'_'.basename($name , ".".$ext)) ,'st') );
	//$file_name  = base64_encode( strtolower($file_name).random_string(7) );
	
	$file_name  = basename($name , ".".$ext);
	$file_name  = strtolower($file_name);
	
	
	$replace 	= array('/','.','=','==',' ');

	
	$file_name = str_replace($replace,'',$file_name);
	$file_name = slugify($file_name);
	$file_name.='.'.$ext;
	
	
	
	
	return $file_name;
	
}


function resize($path="", $width="", $height="", $type=""){
	$ci =& get_instance();
  
	$config['image_library'] = 'gd2';
	$config['source_image'] = $path;
	$config['create_thumb'] = TRUE;
	$config['maintain_ratio'] = TRUE;
	$config['width']         = $width;
	$config['height']       	= $height;
	$config['new_image'] 		= '/assets/images/';

	$this->load->library('image_lib', $config);

	$this->image_lib->resize();
}

function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}


function random_string($length) {
    $original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
    $original_string = implode("", $original_string);
    return substr(str_shuffle($original_string), 0, $length);
}


function email_notification( $data = array()){
	
	if( empty($data) ){
		return false;
	}
	$ci =& get_instance();
	$ci->load->library('email');
	
	//$this->email->from('noreply@versetal.in', 'Versetal Information System');
	$ci->email->from($data['from_email'], $data['from_name']);
	$ci->email->to($data['to']);
	$ci->email->set_mailtype("html");
	$ci->email->subject($data['subject']);
	$ci->email->message($data['message']);
	

	$ci->email->send();
	
	
}


function set_notifications($data = array() ){
	
}


 function new_leave_request($reporting_manager){
		$ci =& get_instance();
		$ci->load->library('email');
		$ci->load->model('leave_model','leave');
		$ci->load->database();
		
		$sql= " SELECT id  FROM ems_users WHERE reporting_manager = '".$reporting_manager."' ";
		$query = $ci->db->query($sql);
		
		$employees  = $query->result_array();
		
		$total_pending = 0;
		$total_approved = 0;
		$total_rejected = 0;
		
		$leaves_array = array();
		foreach($employees as $key => $value){
			$pending = 0;
			$approved = 0;
			$rejected = 0;
			$leaves = $ci->leave->get_leave_application($value['id']);
			if(!empty($leaves)){
				
				foreach($leaves as $_key => $_leave){
					if($_leave['approved'] == 0){			//Pending
						$pending = $pending+1;
						$total_pending = $total_pending+1;
						
					}
					if($_leave['approved'] == 1){			//Approved
						$approved = $approved+1;
						$total_approved = $total_approved+1;
					}
					if($_leave['approved'] == 2){			//Rejected
						$rejected = $rejected+1;
						$total_rejected = $total_rejected+1;
					}
				}
				
			}
			
			$leaves_array['pending'] = $pending;
			$leaves_array['approved'] = $approved;
			$leaves_array['rejected'] = $rejected;
			
			$employees[$key]['leaves'] = $leaves_array;
			
		}
		
		return array('employees' => $employees , 'total_pending' => $total_pending,'total_approved' => $total_approved,'total_rejected' => $total_rejected);
		
	}

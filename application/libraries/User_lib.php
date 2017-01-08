<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_lib {
	var $CI = null;
	function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->library("session");
	} 


	public function get_user_session(){
		
		return $this->CI->session->userdata('login_data');
	}
	
	public function set_user_session($data = array()){
		$this->CI->session->set_userdata('login_data',$data);
	}
	
	public function unset_user_session(){
		if($this->CI->session->userdata('login_data')){
			$this->CI->session->unset_userdata('login_data');
			return true;
		}
		return false;
	}
	
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Registry {
	var $CI = null;
	private  $data = array();
	
	function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->library("session");
	} 

	public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }

    public function set($key, $value) {
        $this->data[$key] = $value;
    }

    public function has($key) {
        return isset($this->data[$key]);
    }
	
	public function set_user_data( $data ){
		if( isset($data) && !empty( $data ) ){
			foreach( $data as $key => $value ){
				$this->data[$key] = $value;
			}
		}else{
			return false;
		}
	}
	
	public function get_user_data(){
		return $this->data;
	}
	
	
}
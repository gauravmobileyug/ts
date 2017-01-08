<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crone extends CI_Controller {

	private $user_data  = array();

	function __construct(){
		parent::__construct();
		$this->load->model('Leave_model' , 'leave');
	}
	
	public function run_crone(){
		$this->leave->run_crone();
	}
	
	
	
	
}

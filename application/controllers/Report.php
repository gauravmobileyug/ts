<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	private $user_data  = array();

	function __construct(){
		parent::__construct();
	
		
		$this->load->library('pagination');	
		//$this->load->library('fpdf');
		$this->load->library('pdf');
		$this->load->library('custompdf');
		
		
		
		
		
		
		$this->load->model('leave_model','leave');
		$this->load->model('user_model','user');
		$this->load->helper('pdf_helper');
		
		$session = $this->user_lib->get_user_session();
		$user_data = $this->user->get_user_data( $session['id'] );
		$this->user_data = $user_data[0];
		$this->exclude = fn_ems_exclude_users( $this->user_data );
		
		if(!$this->user_lib->get_user_session() ){
			$this->session->set_flashdata('failure',$this->lang->line('login_access'));
			redirect(site_url());
		}
		
		if( !in_array($this->user_data['role'],array('H','S')) ){
			$this->load->model('other_model', 'other');
			$status = array("'A'");
			$this->user_data['activities'] = $this->other->get_activity_ids($status);
		}

		
		
	}
	
	
	function timesheet_reports(){
		$data['user_data'] = $this->user_data;
		
		$timesheet_reports  = array();
		$search_data = $this->input->get('search') ;
		if( 	$search_data  != NULL && !empty(	$search_data ) ){
			$data['search_params'] = array_filter(	$search_data );
			$data['timesheet_reports'] = $this->user->timesheet_reports( 	$search_data   );
			
		}
		
		
		
		
		
		
		
		
		$data['main_content'] = 'report/timesheet_reports';
		
		switch($data['user_data']['role']){
			case 'H':
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$this->load->view('employee/template',$data);
			break;
		}
	}
	function leave_reports(){
		$data['user_data'] = $this->user_data;
		
		$timesheet_reports  = array();
			$search_data  = $this->input->get('search');
		if(	$search_data  != NULL && !empty( 	$search_data  ) ){
			$data['search_params'] = array_filter(	$search_data );
			
			$reporting_manager = false;
			
			
			if($data['user_data']['role'] == 'M' ){
				$reporting_manager = $data['user_data']['id'];
			}
			
			if($data['user_data']['role'] == 'E' ){
				
			}
			
			
			
			
			$data['leaves'] = $this->leave->leave_reports( 	$search_data  ,false,false,$reporting_manager );
			
		}
		
		
		
		
		
		
		
		
		$data['main_content'] = 'report/leave_reports';
		
		switch($data['user_data']['role']){
			case 'H':
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$this->load->view('employee/template',$data);
			break;
		}
	}
	
	
	public function list_leaves($user_id){
		
		
		$roles = array('H','S');
		

		$data['user_data'] = $this->user_data;

		
		$data['user_id'] = $user_id;
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/report/list_leaves/'.$user_id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		//limit end
        $page = $this->input->get('per_page');        
        $start = ($page * $config['per_page']) - $config['per_page'];
        if ($start < 0) {
            $start = 0;
        }
		
		$timesheets = array();
		
		$search_params = $this->input->get('params');
		$data['search_params'] = $search_params;
		
		$reporting_manager = false;
		if($data['user_data']['role'] == 'M'){
			$reporting_manager = $data['user_data']['id'];
		}
		
		
		
		$data['total_leaves']		= $this->leave->count_leaves($user_id,$search_params,$reporting_manager);
	
        $data['leaves']  			= $this->leave->get_leaves_history($user_id,$start,$config['per_page'],$search_params,$reporting_manager);		
		
        $config['total_rows']  		= $data['total_leaves'];
        
		$data['employee_details'] 	= $this->user->get_employee( $user_id );
        
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
	
		
		$data['main_content'] = 'report/leaves';
		switch($data['user_data']['role']){
			case 'H':
				$data['editable'] = false;
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
				$data['editable'] = true;
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
				$data['editable'] = false;
				$this->load->view('manager/template' ,$data );
				break;
			default:
				$data['editable'] = true;
				$this->load->view('employee/template',$data);
			break;
		}
		
		
	}
	
	
	public function list_timesheet($user_id){
		
		

		$data['user_data'] = $this->user_data;
		
		$data['user_id'] = $user_id;
		
		$config['per_page']         = 20;
        $config['base_url']         = site_url() . '/report/list_timesheet/'.$user_id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links']        = 25;
		$config['page_query_string'] = TRUE;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		
		//limit end
        $page = $this->input->get('per_page');        
        $start = ($page * $config['per_page']) - $config['per_page'];
        if ($start < 0) {
            $start = 0;
        }
		
		$timesheets = array();
		
		
		$search_params = array();
		if( $this->input->get('params') != '' ){
			$search_params = $this->input->get('params');
		}
	
		
		
		$data['search_params']		= array_filter($search_params);
		
		$data['total_timesheets']	= $this->user->count_timesheet($user_id, $search_params);
        $data['timesheets']  		= $this->user->get_timesheet_history($user_id,$start,$config['per_page'],$search_params );		
        $config['total_rows']  		= $data['total_timesheets'];
        
		//fn_ems_debug( $data['timesheets'] );
		
		$query = $this->db->query( "SELECT firstname, lastname FROM ems_users WHERE id  = '".(int)$user_id."' ");
		$employee_name = '';
		if($query->num_rows()){
			$result = $query->result_array();
			$employee_name = ucwords($result[0]['firstname'].' '.$result[0]['lastname']);
		}
		$data['employee_name'] = $employee_name;
        //initializate the pagination helper 
        $this->pagination->initialize($config);
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
		
	
		
		$data['main_content'] = 'report/timesheets';
		switch($data['user_data']['role']){
			case 'H':
			
			
				$this->load->view('hradmin/template', $data);
				break;
			case 'S':
			
			
				$this->load->view('superadmin/template', $data);
				break;
			case 'M':
			
				
				$this->load->view('manager/template' ,$data );
				break;
			default:
			
			
				$this->load->view('employee/template',$data);
			break;
		}
		
		
	}
	
	public function download_timesheet_pdf( $user_id ){
		$this->user_data;
		$_data = array();
		
		$roles = array('H','S');
		
		if($this->user_data['role'] == 'H' || $this->user_data['role'] == 'M' || $this->user_data['role'] == 'S' ){
			
			$sql = " SELECT reporting_manager FROM ems_users WHERE id = '".$user_id."' ";
			
			$query = $this->db->query( $sql );
			$reporting_manager = 0;
			
			if($query->num_rows()){
				$result = $query->result_array();
				$reporting_manager = $result[0]['reporting_manager'];				
			}
			
			
			if( in_array($this->user_data['role'] , $roles)){
				
			}elseif(!$reporting_manager && !in_array($this->user_data['role'] , $roles)){
				$this->session->set_flashdata('failure',$this->lang->line('no_data_found'));
				redirect(site_url(),'refresh');
			}
			
			$params = $this->input->get('params');
			$search_params = array();
			if( isset( $params ) ){
				$search_params = array_filter( $params );
			}
			
			
			
			$report['timesheets']  = $this->user->get_timesheet_report($user_id,$reporting_manager, $search_params);		
			
			//fn_ems_debug($search_params);
			
			$data['date_range'] = $search_params;
		
			$employee_name = '';
			$employee_id = '';
			
			$total_time = 0;
		
			if(!empty($report['timesheets'])){
				
				foreach($report['timesheets'] as $key => $timesheet){
					
					
					$total_time += $timesheet['time'];
					
				
					$_data['short_description']['user_id'] 		=  $timesheet['user_id'];
					$_data['short_description']['manager'] 		=  $timesheet['manager'];
					$_data['short_description']['reporting_manager'] =  $timesheet['reporting_manager'];
					
					$_data['short_description']['employee'] 	=  $timesheet['employee'];
					$_data['short_description']['employee_id'] 	=  $timesheet['employee_id'];
					
					$employee_name = $timesheet['employee'];
					$employee_id = $timesheet['user_id'];
					
					
					$_data['long_description'][$timesheet['sheet_id']]['ticket_summary']['breif']['date_added'] =  $timesheet['timesheet_date'];
					$_data['long_description'][$timesheet['sheet_id']]['ticket_summary']['breif']['date_updated'] =  $timesheet['date_updated'];
					$_data['long_description'][$timesheet['sheet_id']]['ticket_summary']['breif']['sheet_id'] =  $timesheet['sheet_id'];
					
					
					
					$_data['long_description'][$timesheet['sheet_id']]['ticket_summary']['tickets'][]	= array(
						'ticket_number'	=> $timesheet['ticket_number'],
						'client_name'	=> $timesheet['client_name'],
						'time'			=> $timesheet['time'],
						'description'	=> $timesheet['description']
					); 
				
				}
				$data['timesheet_report'] = $_data;
				$data['total_time'] = $total_time;
				
				$filename = "TS_".ucwords($employee_name.'_'.$employee_id.'_'.time());
				
				
				
				// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
				$pdfFilePath = FCPATH."/reports/timesheet/".$filename.".pdf";
				$data['page_title'] = $filename; // pass data to the view

				if (file_exists($pdfFilePath) == FALSE)
				{
				ini_set('memory_limit','120M'); // boost the memory limit if it's low 😉
				$html = $this->load->view('report/download_timesheet_pdf', $data, true);

				
				$html = str_replace('< /p>',"</p>",$html);
				$html = str_replace('< /',"</",$html);
				$html = str_replace('</ ',"</",$html);








				
				//echo $html; die;
				
				ob_start();
				echo $html;
				$content = ob_get_clean();

				
				try
				{
				$html2pdf = $this->custompdf;
				$html2pdf = new HTML2PDF('P', 'A4', 'fr');
				//      $html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output($filename.'.pdf');
				}
				catch(HTML2PDF_exception $e) {
					echo $e;
					exit;
				}
				
				
				die;
				
				
				
				
				
				
				
				$pdf = $this->pdf->load();
				//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure 😉
				$pdf->WriteHTML($html); // write the HTML into the PDF
				$pdf->Output($pdfFilePath, 'F'); // save to file because we can
				}

				redirect("../reports/timesheet/".$filename.".pdf");


				//fn_ems_debug( $data );
				// header('Content-type: application/pdf'); 
				// header('Content-Disposition: attachment; filename="downloaded.pdf"'); 
				
				//echo $download_pdf;die;
			}else{
				$this->session->set_flashdata('failure',$this->lang->line('no_data_found'));
				redirect(site_url('report/list_timesheet/'.$user_id));
			}
			
		}
		
	}
	
	
	public function download_leaves_pdf( $user_id ){
		
		$roles = array('H','S');
		
		$this->user_data;
		$_data = array();
		if($this->user_data['role'] == 'H' || $this->user_data['role'] == 'S' || $this->user_data['role'] == 'M' || true ){
			
			$sql = " SELECT reporting_manager FROM ems_users WHERE id = '".$user_id."' ";
			
			$query = $this->db->query( $sql );
			$reporting_manager = 0;
			
			if($query->num_rows()){
				$result = $query->result_array();
				$reporting_manager = $result[0]['reporting_manager'];				
			}
			
			
			if( in_array($this->user_data['role'] , $roles)){
				
			}elseif(!$reporting_manager && !in_array($this->user_data['role'] , $roles)){
				$this->session->set_flashdata('failure',$this->lang->line('no_data_found'));
				redirect(site_url() , 'refresh');
			}
			
			$params = $this->input->get('params');
			$search_params = array();
			if( isset( $params ) ){
				$search_params = array_filter( $params );
			}
			
			/* if(!$reporting_manager){
				$this->session->set_flashdata('failure',$this->lang->line('no_data_found'));
				redirect(site_url() , 'refresh');
			} */
			
			$search_params = array();
			if( isset( $_REQUEST['params'] ) ){
				$search_params = array_filter( $_REQUEST['params'] );
			}
			
			
			//fn_ems_debug( $search_params );
			
			$report['leaves']  = $this->leave->get_leave_report($user_id,$reporting_manager,$search_params);		
		
			//fn_ems_debug( $report );
		
			$employee_name = '';
			$employee_id = '';
		
			if(!empty($report['leaves'])){
				
				foreach($report['leaves'] as $key => $leave){
					
					
				
					$_data['short_description']['user_id'] 		=  $leave['user_id'];
					$_data['short_description']['manager'] 		=  $leave['manager'];
					$_data['short_description']['reporting_manager'] =  $leave['reporting_manager'];
					
					$_data['short_description']['employee'] 	=  $leave['employee'];
					$_data['short_description']['employee_id'] 	=  $leave['employee_id'];
					
					$_data['short_description']['opening_sleave'] 	=  $leave['opening_sleave'];
					$_data['short_description']['opening_pleave'] 	=  $leave['opening_pleave'];
					
					
					$_data['long_description'][$leave['id']]['leave_details']	= $leave;
					
					
					$employee_name 	=  $leave['employee'];
					$employee_id 	=  $leave['user_id'];
				
				}
				
				
				$data['leave_report'] = $_data;		
				$data['monthly_added_leaves'] = array();				
				
				$data['monthly_added_leaves'] = $this->db->where("user_id" , $user_id)->order_by('month_id' ,'DESC')->get("ems_user_monthly_leaves")->result_array();
				
				
				//fn_ems_debug( $data['monthly_added_leaves'] );
				
				
				$filename = "LEAVE_".ucwords($employee_name.'_'.$employee_id.'_'.time());
				
				
				
				// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
				$pdfFilePath = FCPATH."/reports/leave/".$filename.".pdf";
				$data['page_title'] = $filename; // pass data to the view

				if (file_exists($pdfFilePath) == FALSE)
				{
				ini_set('memory_limit','120M'); // boost the memory limit if it's low 😉
				$html = $this->load->view('report/download_leaves_pdf', $data , true);



				
				$html = str_replace('< /p>',"</p>",$html);
				$html = str_replace('< /',"</",$html);
				$html = str_replace('</ ',"</",$html);

				//echo '<pre>';print_r(get_class_methods($this->custompdf));die;
				
				ob_start();
				echo $html;
				$content = ob_get_clean();

				try
				{
				$html2pdf = $this->custompdf;
				$html2pdf = new HTML2PDF('P', 'A4', 'fr');
				//      $html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output($filename.'.pdf');
				}
				catch(HTML2PDF_exception $e) {
					echo $e;
					exit;
				}
				
				
				die;
				
				
				
				
				$pdf = $this->pdf->load();
			//	$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure 😉
				$pdf->WriteHTML($html); // write the HTML into the PDF
				$pdf->Output($pdfFilePath, 'F'); // save to file because we can
				}

				redirect("../reports/leave/".$filename.".pdf");
				
				
				
				//fn_ems_debug( $data );
				// header('Content-type: application/pdf'); 
				// header('Content-Disposition: attachment; filename="downloaded.pdf"'); 
				
				//echo $download_pdf;die;
			}else{
				$this->session->set_flashdata('failure',$this->lang->line('no_data_found'));
				redirect(site_url('report/list_leaves/'.$user_id));
			}
			
		}
	}
	
	
	
	
	
}


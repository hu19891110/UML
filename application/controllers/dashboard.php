<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {

	function __construct() {

		parent::__construct();
		
		
		$this->load->database();
		$this->load->library('session');
		
		
		$this->login = new stdClass;
		
		$this->load->library('flexi_auth');	
		
		
		if (! $this->flexi_auth->is_logged_in_via_password()) 
		{
			
			$this->flexi_auth->set_error_message('You must be logged in to access this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('login');
		}
		
		
		$this->data = null;
		
	}

	function index()
	{	
		
		$this->dashboard();
		
	}
	
	function dashboard() 
	{
		//if ($this->flexi_auth->is_admin()) {
			$this->data['message'] = $this->session->flashdata('message');
			$this->load->view('teacher_dashboard_view', $this->data);
		//} else {
		//	$this->data['message'] = $this->session->flashdata('message');
		//	$this->load->view('student_dashboard_view', $this->data);
		//}

	}

}
?>
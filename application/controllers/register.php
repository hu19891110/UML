<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends CI_Controller {
	
	function __construct() {
	
		parent::__construct();
		
		
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
 		$this->load->helper('form');
			
			
		$this->login = new stdClass;
		
		$this->load->library('flexi_auth');	
		
		
		if (! $this->flexi_auth->is_logged_in_via_password()) 
		{
		
			$this->flexi_auth->set_error_message('You must be logged in to access this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('login');

		}
		
		$this->load->vars('base_url', 'http://localhost:8888/');
		$this->load->vars('includes_dir', 'http://localhost:8888/includes/');
		$this->load->vars('current_url', $this->uri->uri_to_assoc(1));
		
		$this->data = null;		
		
		$user_id = $this->flexi_auth->get_user_id();
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
		$this->data['user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);
	}
	
	function index()
	{
		$this->register_account();
	}

	function register_account()
	{
		// If 'Registration' form has been submitted, attempt to register their details as a new account.
		if ($this->input->post('register_user'))
		{		
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->register_account();
		}
		
		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		


		$data['maincontent'] = $this->load->view('register_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);	
	}
	
}
?>
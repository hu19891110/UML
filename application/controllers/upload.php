<?php

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		
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
		
		$currentuser_id = $this->flexi_auth->get_user_id();
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $currentuser_id);
		$this->data['currentuser'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);
	}

	function index()
	{
		$this->data['error'] = ' ';
		$data['maincontent'] = $this->load->view('upload_form', $this->data, TRUE);
		
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}
		
	}

	function do_upload()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = '*';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$this->data['error'] = array('error' => $this->upload->display_errors());
			
			$this->data['maincontent'] = $this->load->view('upload_form', $this->data, TRUE);
			$this->load->view('template-teacher', $this->data);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$this->data['maincontent'] = $this->load->view('upload_success', $data, TRUE);
			$this->load->view('template-teacher', $this->data);
		}
	}
}
?>
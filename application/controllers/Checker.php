<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checker extends CI_Controller {

	function __construct() {
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
		
		$this->data = null;
		
		$this->load->vars('base_url', 'http://'.$_SERVER['HTTP_HOST'].'/');
		$this->load->vars('includes_dir', 'http://'.$_SERVER['HTTP_HOST'].'/includes/');
		$this->load->vars('current_url', $this->uri->uri_to_assoc(1));
		
		$currentuser_id = $this->flexi_auth->get_user_id();
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $currentuser_id);
		$this->data['currentuser'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);
	}
	
	
	
	function index() {
	
		$this->data['error'] = ' ';
		
		$correctfile = $this->flexi_auth->get_correct_file_by_deadline();
		$correctfile = $correctfile->result_array();
		$correctfile = $correctfile[0];
		
		$correctfile_name = (string) $correctfile['student_id'] . '-' . (string)$correctfile['deadline_id'] . '.xml';
		
		$uploads = $this->flexi_auth->get_uploads_by_deadline();
		$uploads = $uploads->result_array();
		
		foreach($uploads as $upload) {
			$handed_in_file = (string) $upload['student_id'] . '-' . (string)$upload['deadline_id'] . '.xml';
			$this->checkFile($correctfile_name, $handed_in_file);
		}
		
		
		
		
		
		$this->data['uploads'] = $uploads;
		
		$data['maincontent'] = $this->load->view('compare_file_view', $this->data, TRUE);
		
		
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}
	
	}
	
	function checkFile($correctfile, $handed_in_file) {
		$config['upload_path'] = './uploads/';
		
		$correctfile = file_get_contents('./uploads/' . $correctfile);
		$correctfile = simplexml_load_string($correctfile);
		
		$handed_in_file = file_get_contents('./uploads/' . $handed_in_file);
		$handed_in_file = simplexml_load_string($handed_in_file);
	
	}

}


?>
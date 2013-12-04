<?php
class my404 extends CI_Controller 
{
    public function __construct()   {
            parent::__construct();
            
        	$this->load->database();
			$this->load->library('session');
			$this->load->helper('url');
			
			$this->login = new stdClass;
			
			$this->load->library('flexi_auth');	
			
	        if (! $this->flexi_auth->is_logged_in_via_password()) 
			{
				$this->flexi_auth->set_error_message('You must be logged in to access this area.', TRUE);
				$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
				redirect('login');
			}
			$currentuser_id = $this->flexi_auth->get_user_id();
			$this->load->model('flexi_auth_model');
			$first_time = $this->flexi_auth_model->first_login($currentuser_id);
			if ($first_time && uri_string() != 'dashboard/change_password/'.$currentuser_id) {
				redirect('dashboard/change_password/'. $currentuser_id);
			}
	
			//$this->output->enable_profiler(TRUE);
			
			$this->data = null;
			
			$this->load->vars('base_url', 'http://'.$_SERVER['HTTP_HOST'].'/');
			$this->load->vars('includes_dir', 'http://'.$_SERVER['HTTP_HOST'].'/includes/');
			$this->load->vars('current_url', $this->uri->uri_to_assoc(1));
			
			$currentuser_id = $this->flexi_auth->get_user_id();
			$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $currentuser_id);
			$this->data['currentuser'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);  
    }
    
    public function index() 
    {
        $this->output->set_status_header('404');
        
        if ($this->flexi_auth->is_admin()) {
			$data['maincontent'] = $this->load->view('404', $this->data, TRUE);
			$this->load->view('template-teacher', $data);
		} else {
			$data['maincontent'] = $this->load->view('404', $this->data, TRUE);
			$this->load->view('template-student', $data);
		}
    }
}
?>
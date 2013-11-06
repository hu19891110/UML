<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {

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

	function index()
	{	
		
		$this->dashboard();
		
	}
	
	function dashboard() 
	{
		if ($this->input->post('add_deadline')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->add_deadline();
		}
		$deadlines = $this->flexi_auth->get_deadlines();
		$this->data['deadlines'] = $deadlines->result_array();
		
		$this->data['classes'] = $this->flexi_auth->get_classes_array();
		
		$this->data['message'] = $this->session->flashdata('message');
		if ($this->flexi_auth->is_admin()) {
			$data['maincontent'] = $this->load->view('teacher_dashboard_view', $this->data, TRUE);
			$this->load->view('template-teacher', $data);
		} else {
			$data['maincontent'] = $this->load->view('student_dashboard_view', $this->data, TRUE);
			$this->load->view('template-student', $data);	
		}


	}
	
	function manage_user_accounts()
    {
		$this->load->model('demo_auth_admin_model');

		// Check user has privileges to view user accounts, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Users'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to view user accounts.</p>');
			redirect('dashboard');
		}
		
		/*
		// If 'Admin Search User' form has been submitted, this example will lookup the users email address and first and last name.
		if ($this->input->post('search_users') && $this->input->post('search_query')) 
		{
			// Convert uri ' ' to '-' spacing to prevent '20%'.
			// Note: Native php functions like urlencode() could be used, but by default, CodeIgniter disallows '+' characters.
			$search_query = str_replace(' ','-',$this->input->post('search_query'));
		
			// Assign search to query string.
			redirect('dashboard/manage_user_accounts/search/'.$search_query.'/page/');
		}
		
		
		// If 'Manage User Accounts' form has been submitted and user has privileges to update user accounts, then update the account details.
		else if ($this->input->post('update_users') && $this->flexi_auth->is_privileged('Update Users')) 
		{
			$this->demo_auth_admin_model->update_user_accounts();
		}
		*/
		// Get user account data for all users. 
		// If a search has been performed, then filter the returned users.
		
		
		//$this->flexi_auth->get_users()->result();
		
		$this->demo_auth_admin_model->get_user_accounts();

		// Set any returned status/error messages.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] =  $this->load->view('userlist_view', $this->data , TRUE);
		$this->load->view('template-teacher', $data);		
    }
    
    function email()
    {
		$this->load->view('includes/email/registration_welcome');	
    }

    function update_user_account($user_id)
	{
		// Check user has privileges to update user accounts, else display a message to notify the user they do not have valid privileges.
	
		if (! $this->flexi_auth->is_privileged('Update Users') && ($user_id != $this->flexi_auth->get_user_id()))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to update user accounts.</p>');
			redirect('dashboard');		
		}

		// If 'Update User Account' form has been submitted, update the users account details.
		if ($this->input->post('update_users_account')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_user_account($user_id);
		}
		if ($this->input->post('delete_users_account'))
		{
			$this->flexi_auth->delete_user($user_id);
			redirect('dashboard/manage_user_accounts');
		}
		
		// Get users current data.
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
		$this->data['user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);
	
		// Get user groups.
		$this->data['groups'] = $this->flexi_auth->get_groups_array();
		
		// Get user groups.
		$this->data['classes'] = $this->flexi_auth->get_classes_array();
		
		// Set any returned status/error messages.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('user_account_update_view', $this->data, TRUE);
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);	
		} else {
			$this->load->view('template-student', $data);
		}
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// User Groups
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
 	/**
 	 * manage_user_groups
 	 * View and manage a table of all user groups.
 	 */
    function manage_user_groups()
    {
		// Check user has privileges to view user groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View User Groups'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to view user groups.</p>');
			redirect('dashboard');		
		}

		// If 'Manage User Group' form has been submitted and user has privileges, delete user groups.
		if ($this->input->post('delete_group') && $this->flexi_auth->is_privileged('Delete User Groups')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->manage_user_groups();
		}

		// Define the group data columns to use on the view page. 
		// Note: The columns defined using the 'db_column()' functions are native table columns to the auth library. 
		// Read more on 'db_column()' functions in the quick help section near the top of this controller. 
		$sql_select = array(
			$this->flexi_auth->db_column('user_group', 'id'),
			$this->flexi_auth->db_column('user_group', 'name'),
			$this->flexi_auth->db_column('user_group', 'description'),
			$this->flexi_auth->db_column('user_group', 'admin')
		);
		$this->data['user_groups'] = $this->flexi_auth->get_groups_array($sql_select);
				
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('user_groups_view', $this->data, TRUE);	
		$this->load->view('template-teacher', $data);		
    }
	
 	/**
 	 * insert_user_group
 	 * Insert a new user group.
 	 */
	function insert_user_group()
	{
		// Check user has privileges to insert user groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Insert User Groups'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to insert new user groups.</p>');
			redirect('dashboard/manage_user_groups');		
		}

		// If 'Add User Group' form has been submitted, insert the new user group.
		if ($this->input->post('insert_user_group')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->insert_user_group();
		}
		
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('user_group_insert_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);
	}
	
 	/**
 	 * update_user_group
 	 * Update the details of a specific user group.
 	 */
	function update_user_group($group_id)
	{
		// Check user has privileges to update user groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update User Groups'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to update user groups.</p>');
			redirect('dashboard/manage_user_groups');		
		}

		// If 'Update User Group' form has been submitted, update the user group details.
		if ($this->input->post('update_user_group')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_user_group($group_id);
		}

		// Get user groups current data.
		$sql_where = array($this->flexi_auth->db_column('user_group', 'id') => $group_id);
		$this->data['class'] = $this->flexi_auth->get_groups_row_array(FALSE, $sql_where);
		
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('user_group_update_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);	
	}



	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Student class
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
 	/**
 	 * manage_student_classes
 	 * View and manage a table of all user groups.
 	 */
 	 
 	 function students_per_class($class_id)
 	 {
 	 
 	 	// Check user has privileges to view user groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Student Classes'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to view student classes.</p>');
			redirect('dashboard');		
		}
		
		$sql_select = array(
			$this->flexi_auth->db_column('user_acc', 'id'),
			$this->flexi_auth->db_column('user_acc', 'username'),
			$this->flexi_auth->db_column('user_acc', 'email')
		);
		$this->data['users'] = $this->flexi_auth->get_users_array($sql_select);
		
		// Get data for the current privilege group.
		$sql_select = array($this->flexi_auth->db_column('user_acc', 'id'));
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'class_id') => $class_id);
		$class_users = $this->flexi_auth->get_users_array($sql_select, $sql_where);
                
		// For the purposes of the example demo view, create an array of ids for all the privileges that have been assigned to a privilege group.
		// The array can then be used within the view to check whether the group has a specific privilege, this data allows us to then format form input values accordingly. 
		$this->data['class_users'] = array();
		
		foreach($class_users as $class_user)
		{	
			$this->data['class_users'][] = $class_user[$this->flexi_auth->db_column('user_acc', 'id')];
		}
		
		$sql_where = array($this->flexi_auth->db_column('student_class', 'id') => $class_id);
		$this->data['class'] = $this->flexi_auth->get_classes_row_array(FALSE, $sql_where);
		
		$this->data['class_id'] = $class_id;
		
 	 	// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];	
		
 	 	$data['maincontent'] = $this->load->view('students_per_class_view', $this->data, TRUE);	
		$this->load->view('template-teacher', $data);	
 	 }
 	 
    function manage_student_classes()
    {
		// Check user has privileges to view user groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Student Classes'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to view student classes.</p>');
			redirect('dashboard');		
		}
		
		
		if ($this->input->post('delete_class') && $this->flexi_auth->is_privileged('Delete Student Class')) 
		{
			if ($delete_classes = $this->input->post('delete_class'))
			{
				foreach($delete_classes as $class_id => $delete)
				{
					// Note: As the 'delete_class' input is a checkbox, it will only be present in the $_POST data if it has been checked,
					// therefore we don't need to check the submitted value.
					$this->flexi_auth->delete_class($class_id);
				}
			}
		}
		// Define the group data columns to use on the view page. 
		// Note: The columns defined using the 'db_column()' functions are native table columns to the auth library. 
		// Read more on 'db_column()' functions in the quick help section near the top of this controller. 
		$sql_select = array(
			$this->flexi_auth->db_column('student_class', 'id'),
			$this->flexi_auth->db_column('student_class', 'name'),
			$this->flexi_auth->db_column('student_class', 'description'),
		);
		$this->data['student_classes'] = $this->flexi_auth->get_classes_array($sql_select);
				
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('student_classes_view', $this->data, TRUE);	
		$this->load->view('template-teacher', $data);		
    }
	
 	/**
 	 * insert_student_class
 	 * Insert a new student class.
 	 */
	function insert_student_class()
	{
		// Check user has privileges to insert user groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Insert Student Class'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to insert new student classes.</p>');
			redirect('dashboard/manage_student_classes');		
		}

		// If 'Add Student Class' form has been submitted, insert the new user group.
		if ($this->input->post('insert_student_class')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->insert_student_class();
		}
		
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('student_class_insert_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);
	}
	
 	/**
 	 * update_student_class
 	 * Update the details of a specific student class.
 	 */
	function update_student_class($class_id)
	{
		// Check user has privileges to update user groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Student Class'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to update student classes.</p>');
			redirect('dashboard/manage_student_classes');		
		}

		// If 'Update student class' form has been submitted, update the user group details.
		if ($this->input->post('update_student_class')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_student_class($class_id);
		}

		// Get user groups current data.
		$sql_where = array($this->flexi_auth->db_column('student_class', 'id') => $class_id);
		$this->data['class'] = $this->flexi_auth->get_classes_row_array(FALSE, $sql_where);
		
		$this->data['class_id'] = $class_id;
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('student_class_update_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);	
	}
	
	
	function add_student_to_class($class_id) 
	{
		// Check user has privileges to update user groups, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Student Class'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to update student classes.</p>');
			redirect('dashboard/manage_student_classes');		
		}
		
		if (!empty($_POST)) {	
			foreach($_POST as $key => $value)
			{
			
			   if(substr($key,0,11) == "add_student")
			   {
			      $user_id = substr($key,11);
			      $sql_update = array($this->login->tbl_col_user_account['class_id'] => $class_id);
				  $sql_where = array($this->login->tbl_col_user_account['id'] => $user_id);
				  $this->db->update($this->login->tbl_user_account, $sql_update, $sql_where);
			   }
			   else if(substr($key,0,14) == "remove_student")
			   {
			      $user_id = substr($key,14);
			      $sql_update = array($this->login->tbl_col_user_account['class_id'] => 1);
				  $sql_where = array($this->login->tbl_col_user_account['id'] => $user_id);
				  $this->db->update($this->login->tbl_user_account, $sql_update, $sql_where);
			   }
			}
		}
		
		// Get all privilege data. 
		$sql_select = array(
			$this->flexi_auth->db_column('user_acc', 'id'),
			$this->flexi_auth->db_column('user_acc', 'username'),
			$this->flexi_auth->db_column('user_acc', 'email')
		);
		$this->data['users'] = $this->flexi_auth->get_users_array($sql_select);
		
		// Get data for the current privilege group.
		$sql_select = array($this->flexi_auth->db_column('user_acc', 'id'));
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'class_id') => $class_id);
		$class_users = $this->flexi_auth->get_users_array($sql_select, $sql_where);
                
		// For the purposes of the example demo view, create an array of ids for all the privileges that have been assigned to a privilege group.
		// The array can then be used within the view to check whether the group has a specific privilege, this data allows us to then format form input values accordingly. 
		$this->data['class_users'] = array();
		
		foreach($class_users as $class_user)
		{	
			echo
			$this->data['class_users'][] = $class_user[$this->flexi_auth->db_column('user_acc', 'id')];
		}
		
		$data['maincontent'] = $this->load->view('add_student_to_class_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);
	}


	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Privileges
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
 	/**
 	 * manage_privileges
 	 * View and manage a table of all user privileges.
 	 * This example allows user privileges to be deleted via checkoxes within the page.
 	 */
    function manage_privileges()
    {
		// Check user has privileges to view user privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('View Privileges'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to view user privileges.</p>');
			redirect('dashboard');		
		}
		
		// If 'Manage Privilege' form has been submitted and the user has privileges to delete privileges.
		if ($this->input->post('delete_privilege') && $this->flexi_auth->is_privileged('Delete Privileges')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->manage_privileges();
		}

		// Define the privilege data columns to use on the view page. 
		// Note: The columns defined using the 'db_column()' functions are native table columns to the auth library. 
		// Read more on 'db_column()' functions in the quick help section near the top of this controller. 
		$sql_select = array(
			$this->flexi_auth->db_column('user_privileges', 'id'),
			$this->flexi_auth->db_column('user_privileges', 'name'),
			$this->flexi_auth->db_column('user_privileges', 'description')
		);
		$this->data['privileges'] = $this->flexi_auth->get_privileges_array($sql_select);
				
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('privileges_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);	
	}
	
 	/**
 	 * insert_privilege
 	 * Insert a new user privilege.
 	 */
	function insert_privilege()
	{
		// Check user has privileges to insert user privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Insert Privileges'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to insert new user privileges.</p>');
			redirect('dashboard/manage_privileges');		
		}

		// If 'Add Privilege' form has been submitted, insert the new privilege.
		if ($this->input->post('insert_privilege')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->insert_privilege();
		}
		
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('privilege_insert_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);	
	}
	
 	/**
 	 * update_privilege
 	 * Update the details of a specific user privilege.
 	 */
	function update_privilege($privilege_id)
	{
		// Check user has privileges to update user privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Privileges'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to update user privileges.</p>');
			redirect('dashboard/manage_privileges');		
		}

		// If 'Update Privilege' form has been submitted, update the privilege details.
		if ($this->input->post('update_privilege')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_privilege($privilege_id);
		}
		
		// Get privileges current data.
		$sql_where = array($this->flexi_auth->db_column('user_privileges', 'id') => $privilege_id);
		$this->data['privilege'] = $this->flexi_auth->get_privileges_row_array(FALSE, $sql_where);
		
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('privilege_update_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);	
	}
	
 	/**
 	 * update_user_privileges
 	 * Update the access privileges of a specific user.
 	 */
    function update_user_privileges($user_id)
    {
		// Check user has privileges to update user privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Privileges'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to update user privileges.</p>');
			redirect('dashboard/manage_user_accounts');		
		}

		// If 'Update User Privilege' form has been submitted, update the user privileges.
		if ($this->input->post('update_user_privilege')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_user_privileges($user_id);
		}

		// Get users profile data.
		$sql_select = array(
			'upro_uacc_fk', 
			'upro_first_name', 
			'upro_last_name',
			$this->flexi_auth->db_column('user_acc', 'group_id'),
			$this->flexi_auth->db_column('user_group', 'name')
        );
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
		$this->data['user'] = $this->flexi_auth->get_users_row_array($sql_select, $sql_where);		

		// Get all privilege data. 
		$sql_select = array(
			$this->flexi_auth->db_column('user_privileges', 'id'),
			$this->flexi_auth->db_column('user_privileges', 'name'),
			$this->flexi_auth->db_column('user_privileges', 'description')
		);
		$this->data['privileges'] = $this->flexi_auth->get_privileges_array($sql_select);
		
		// Get user groups current privilege data.
		$sql_select = array($this->flexi_auth->db_column('user_privilege_groups', 'privilege_id'));
		$sql_where = array($this->flexi_auth->db_column('user_privilege_groups', 'group_id') => $this->data['user'][$this->flexi_auth->db_column('user_acc', 'group_id')]);
		$group_privileges = $this->flexi_auth->get_user_group_privileges_array($sql_select, $sql_where);
                
        $this->data['group_privileges'] = array();
        foreach($group_privileges as $privilege)
        {
            $this->data['group_privileges'][] = $privilege[$this->flexi_auth->db_column('user_privilege_groups', 'privilege_id')];
        }
                
		// Get users current privilege data.
		$sql_select = array($this->flexi_auth->db_column('user_privilege_users', 'privilege_id'));
		$sql_where = array($this->flexi_auth->db_column('user_privilege_users', 'user_id') => $user_id);
		$user_privileges = $this->flexi_auth->get_user_privileges_array($sql_select, $sql_where);
	
		// For the purposes of the example demo view, create an array of ids for all the users assigned privileges.
		// The array can then be used within the view to check whether the user has a specific privilege, this data allows us to then format form input values accordingly. 
		$this->data['user_privileges'] = array();
		foreach($user_privileges as $privilege)
		{
			$this->data['user_privileges'][] = $privilege[$this->flexi_auth->db_column('user_privilege_users', 'privilege_id')];
		}
	
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

        // For demo purposes of demonstrate whether the current defined user privilege source is getting privilege data from either individual user 
        // privileges or user group privileges, load the settings array containing the current privilege sources. 
		$this->data['privilege_sources'] = $this->login->auth_settings['privilege_sources'];
                
		$data['maincontent'] = $this->load->view('user_privileges_update_view', $this->data, TRUE);	
		$this->load->view('template-teacher', $data);		
    }
    
 	/**
 	 * update_group_privileges 
 	 * Update the access privileges of a specific user group.
 	 */
    function update_group_privileges($group_id)
    {
		// Check user has privileges to update group privileges, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_privileged('Update Privileges'))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have access privileges to update group privileges.</p>');
			redirect('dashboard/manage_user_accounts');		
		}

		// If 'Update Group Privilege' form has been submitted, update the privileges of the user group.
		if ($this->input->post('update_group_privilege')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_group_privileges($group_id);
		}
		
		// Get data for the current user group.
		$sql_where = array($this->flexi_auth->db_column('user_group', 'id') => $group_id);
		$this->data['group'] = $this->flexi_auth->get_groups_row_array(FALSE, $sql_where);
                
		// Get all privilege data. 
		$sql_select = array(
			$this->flexi_auth->db_column('user_privileges', 'id'),
			$this->flexi_auth->db_column('user_privileges', 'name'),
			$this->flexi_auth->db_column('user_privileges', 'description')
		);
		$this->data['privileges'] = $this->flexi_auth->get_privileges_array($sql_select);
		
		// Get data for the current privilege group.
		$sql_select = array($this->flexi_auth->db_column('user_privilege_groups', 'privilege_id'));
		$sql_where = array($this->flexi_auth->db_column('user_privilege_groups', 'group_id') => $group_id);
		$group_privileges = $this->flexi_auth->get_user_group_privileges_array($sql_select, $sql_where);
                
		// For the purposes of the example demo view, create an array of ids for all the privileges that have been assigned to a privilege group.
		// The array can then be used within the view to check whether the group has a specific privilege, this data allows us to then format form input values accordingly. 
		$this->data['group_privileges'] = array();
		foreach($group_privileges as $privilege)
		{
			$this->data['group_privileges'][] = $privilege[$this->flexi_auth->db_column('user_privilege_groups', 'privilege_id')];
		}
	
		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

        // For demo purposes of demonstrate whether the current defined user privilege source is getting privilege data from either individual user 
        // privileges or user group privileges, load the settings array containing the current privilege sources. 
        $this->data['privilege_sources'] = $this->login->auth_settings['privilege_sources'];
                
		$data['maincontent'] = $this->load->view('user_group_privileges_update_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);			
    }
    
    function deadline($deadline_id)
    {
    	$sql_where = array($this->flexi_auth->db_column('deadline', 'id') => $deadline_id);
	    $deadline = $this->flexi_auth->get_deadlines(FALSE , $sql_where);
		$this->data['deadline'] = $deadline->row_array();
		
		if($this->flexi_auth->is_admin())
		{
			$data['maincontent'] = $this->load->view('deadline_view_teacher', $this->data, TRUE);
			$this->load->view('template-teacher', $data);
		} else {
			$data['maincontent'] = $this->load->view('deadline_view_student', $this->data, TRUE);
			$this->load->view('template-student', $data);
		}
    }
    
    function manage_deadlines()
    {
	    if ($this->input->post('add_deadline')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->add_deadline();
		}
		if ($this->input->post('delete_deadline')) 
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->delete_deadline();
		}
		$deadlines = $this->flexi_auth->get_deadlines();
		$this->data['deadlines'] = $deadlines->result_array();
		
		$this->data['classes'] = $this->flexi_auth->get_classes_array();
		
		$data['maincontent'] = $this->load->view('manage_deadlines_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);
    }
    
    
    function change_password($user_id)
	{
		if (! $this->flexi_auth->is_privileged('Update Users') && ($user_id != $this->flexi_auth->get_user_id()))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to update user accounts.</p>');
			redirect('dashboard');		
		}
		// If the 'Change Forgotten Password' form has been submitted, then update the users password.
		if ($this->input->post('change_password')) 
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->change_password($user_id);
		}

		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$data['maincontent'] = $this->load->view('change_password_view', $this->data, TRUE);
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}
	}

}
?>
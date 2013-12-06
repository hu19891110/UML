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
		if (isset($_SERVER['HTTP_REFERER'])) {
			$this->load->vars('refered_from', $_SERVER['HTTP_REFERER']);
		} else {
			$this->data['refered_from'] = 'http://'.$_SERVER['HTTP_HOST'].'/dashboard';
		}

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
		//Load model to perform actions
		$this->load->model('demo_auth_admin_model');

		//get all classes
		$this->data['classes'] = $this->flexi_auth->get_classes_array();
		
		//Get all assignments as an array
		$assignments = $this->flexi_auth->get_assignments();
		$this->data['assignments'] = $assignments->result_array();

		//get all classes id, name and description.
		$sql_select = array(
			$this->flexi_auth->db_column('student_class', 'id'),
			$this->flexi_auth->db_column('student_class', 'name'),
			$this->flexi_auth->db_column('student_class', 'description'),
		);
		$this->data['student_classes'] = $this->flexi_auth->get_classes_array($sql_select);

		//get all user accounts and matching user profiles.
		$this->demo_auth_admin_model->get_user_accounts();

		//set error message from session data.
		$this->data['message'] = $this->session->flashdata('message');

		//load dashboard view and load into the correct template.
		$data['maincontent'] = $this->load->view('dashboard_view', $this->data, TRUE);
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}
	}

	function users($update_user_id = FALSE)
	{
		//check whether user is admin (teacher).
		if (!$this->flexi_auth->is_admin()) {
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to view user accounts.</p>');
			redirect('dashboard');
		}
		
		//load model and library
		$this->load->model('demo_auth_admin_model');
		$this->load->library('flexi_auth');
		
		//get all classes
		$this->data['classes'] = $this->flexi_auth->get_classes_array();

		//checks whether a update_user_id is passed in the url.
		//if so, the view changes to update user view.
		if ($update_user_id != FALSE) {
			//checks whether passed update_user_id exists.
			if (!$this->flexi_auth->user_id_exist($update_user_id)) {
				$this->session->set_flashdata('message', '<p class="error_msg">Requested user does not exist.</p>');
				redirect('dashboard/users');
			}
			
			//get information of user to be updated
			$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $update_user_id);
			$this->data['update_user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);
			
			$this->data['update_user_info'] = 1; //user update view will load.
		} else {
			$this->data['update_user_info'] = 0; //add user view will load.
		}
		// If 'add_user' form has been submitted, attempt to register their details as a new account.
		if ($this->input->post('register_user'))
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->register_account();
		}

		// If 'Update User' form has been submitted, update the users account details.
		if ($this->input->post('update_users_account'))
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_user_account($update_user_id); //update user

		}

		// If 'Delete User' button is pressed, delete the user account.
		if ($this->input->post('delete_users_account'))
		{
			//get user id from hidden input field.
			$delete_user_id = $this->input->post('userID');
			$this->flexi_auth->delete_user($delete_user_id);
			$this->flexi_auth->set_status_message('The student account has been deleted.','public', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard/users');
		}

		// Get current users data.
		$user_id = $this->flexi_auth->get_user_id();
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
		$this->data['user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);
		
		//get all user accounts as $users
		$this->demo_auth_admin_model->get_user_accounts();

		// Set any returned status/error messages.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		//load users view and load into the correct template.
		$data['maincontent'] =  $this->load->view('users_view', $this->data , TRUE);
		$this->load->view('template-teacher', $data);
	}


	function update_user_account($user_id)
	{
		// Check user has privileges to update user accounts, else display a message to notify the user they do not have valid privileges.
		if ( !$this->flexi_auth->is_admin() && ($user_id != $this->flexi_auth->get_user_id()))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to update user accounts.</p>');
			redirect('dashboard');
		}
		
		// Check whether user_id exists or not.
		if (!$this->flexi_auth->user_id_exist($user_id)) {
			$this->session->set_flashdata('message', '<p class="error_msg">Requested user does not exist.</p>');
			redirect('dashboard');
		}

		// If 'Update User' form has been submitted, update the users account details.
		if ($this->input->post('update_users_account'))
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->update_user_account($user_id);

		}
		
		// If 'Delete User' button is pressed, delete the user account.
		if ($this->input->post('delete_users_account'))
		{
			$this->flexi_auth->delete_user($user_id);
			redirect('dashboard/users');
		}

		// Get users current data.
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
		$this->data['user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);

		// Get user groups.
		$this->data['classes'] = $this->flexi_auth->get_classes_array();

		// Set any returned status/error messages.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		//load user update view and load into the correct template.
		$data['maincontent'] = $this->load->view('user_update_view', $this->data, TRUE);
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}
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
		if (! $this->flexi_auth->is_admin())
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to view student classes.</p>');
			redirect('dashboard');
		}
		//check whether class exists.
		if (!$this->flexi_auth->class_id_exist($class_id)) {
			$this->session->set_flashdata('message', '<p class="error_msg">Requested class does not exist.</p>');
			redirect('dashboard');
		}

		//select users id, username and email
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

		//get all users in the class
		$this->data['class_users'] = array();
		foreach($class_users as $class_user)
		{
			$this->data['class_users'][] = $class_user[$this->flexi_auth->db_column('user_acc', 'id')];
		}
		
		//get the student class
		$sql_where = array($this->flexi_auth->db_column('student_class', 'id') => $class_id);
		$this->data['class'] = $this->flexi_auth->get_classes_row_array(FALSE, $sql_where);
		
		//set the class id
		$this->data['class_id'] = $class_id;

		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		//load students per class view and load into the correct template.
		$data['maincontent'] = $this->load->view('students_per_class_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);
	}

	function classes($class_id = FALSE)
	{
		// Check user has privileges to view classes, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_admin())
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to view student classes.</p>');
			redirect('dashboard');
		}
		
<<<<<<< HEAD
		//get post info and update user account
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

		// Get all users.
		$sql_select = array(
			$this->flexi_auth->db_column('user_acc', 'id'),
			$this->flexi_auth->db_column('user_acc', 'username'),
			$this->flexi_auth->db_column('user_acc', 'email')
		);
		$this->data['users'] = $this->flexi_auth->get_users_array($sql_select);

		//get all class users
		$sql_select = array($this->flexi_auth->db_column('user_acc', 'id'));
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'class_id') => $class_id);
		$class_users = $this->flexi_auth->get_users_array($sql_select, $sql_where);
		$this->data['class_users'] = array();
		
		foreach($class_users as $class_user)
		{
			$this->data['class_users'][] = $class_user[$this->flexi_auth->db_column('user_acc', 'id')];
		}


=======
>>>>>>> 0ac0771d62d591d42d4afdd40ddb1789ead72856
		if ($class_id != FALSE) {
			// Check user has privileges to classes, else display a message to notify the user they do not have valid privileges.
			if (!$this->flexi_auth->is_admin())
			{
				$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to update student classes.</p>');
				redirect('dashboard/classes');
			}
			
			//check whether class exists.
			if (!$this->flexi_auth->class_id_exist($class_id)) {
				$this->session->set_flashdata('message', '<p class="error_msg">Requested class does not exist.</p>');
				redirect('dashboard');
			}

			// If 'Update student class' form has been submitted, update the user group details.
			if ($this->input->post('update_student_class'))
			{
				$this->load->model('demo_auth_admin_model');
				$this->demo_auth_admin_model->update_student_class($class_id);
			}

			// Get classes current data.
			$sql_where = array($this->flexi_auth->db_column('student_class', 'id') => $class_id);
			$this->data['class'] = $this->flexi_auth->get_classes_row_array(FALSE, $sql_where);

			//get class_id
			$this->data['class_id'] = $class_id;
			// Set any returned status/error messages.
			$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

			$this->data['update_class_info'] = 1; //update class view is loaded
		} else {
			$this->data['update_class_info'] = 0; //add new class view is loaded
		}

		// Check user has privileges to view classes, else display a message to notify the user they do not have valid privileges.
		if (! $this->flexi_auth->is_admin())
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to view student classes.</p>');
			redirect('dashboard');
		}
		
		// If 'Add Student Class' form has been submitted, insert the new user group.
		if ($this->input->post('insert_student_class'))
		{
			$this->load->model('demo_auth_admin_model');
			$this->demo_auth_admin_model->insert_student_class();
		}

		// If 'Delete class' is posted, delete the class
		if ($this->input->post('delete_class') && $this->flexi_auth->is_admin())
		{
			if ($delete_classes = $this->input->post('delete_class'))
			{
				foreach($delete_classes as $class_id => $delete)
				{
					$this->flexi_auth->delete_class($class_id);
					$this->session->set_flashdata('message', '<p class="status_msg">The class has been deleted.</p>');
					redirect('dashboard/classes');
				}
			}
		}
		
		//get all student classes
		$sql_select = array(
			$this->flexi_auth->db_column('student_class', 'id'),
			$this->flexi_auth->db_column('student_class', 'name'),
			$this->flexi_auth->db_column('student_class', 'description'),
		);
		$this->data['student_classes'] = $this->flexi_auth->get_classes_array($sql_select);

		// Set any returned status/error messages.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		//Load classes view and load into the correct template.
		$data['maincontent'] = $this->load->view('classes_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);
	}
	
	function add_student_to_class($class_id)
	{
		// Check user has privileges to add students to classes, else display a message to notify the user they do not have valid privileges.
		if (!$this->flexi_auth->is_admin())
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to update student classes.</p>');
			redirect('dashboard/classes');
		}
		
		//check whether class exists.
		if (!$this->flexi_auth->class_id_exist($class_id)) {
			$this->session->set_flashdata('message', '<p class="error_msg">Requested class does not exist.</p>');
			redirect('dashboard');
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
	

	function change_password($user_id)
	{
		if (! $this->flexi_auth->is_admin() && ($user_id != $this->flexi_auth->get_user_id()))
		{
			$this->session->set_flashdata('message', '<p class="error_msg">You do not have privileges to update user accounts.</p>');
			redirect('dashboard');
		}

		if (!$this->flexi_auth->user_id_exist($user_id)) {
			$this->session->set_flashdata('message', '<p class="error_msg">Requested user does not exist.</p>');
			redirect('dashboard');
		}

		// If the 'Change Forgotten Password' form has been submitted, then update the users password.
		if ($this->input->post('change_password'))
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->change_password($user_id);
		}
		
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
		$this->data['user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);

		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$data['maincontent'] = $this->load->view('change_password_view', $this->data, TRUE);
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}
	}


	function assignments($update_assignment_id = FALSE) {

		if ($update_assignment_id != FALSE) {
			if (!$this->flexi_auth->is_admin()) {
				$this->flexi_auth->set_error_message('You are not privliged to view this area.', TRUE);
				$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
				redirect('dashboard');
			}

			$sql_where = array($this->flexi_auth->db_column('assignment', 'id') => $update_assignment_id);

			$update_assignment = $this->flexi_auth->get_assignments(FALSE, $sql_where);

			$this->data['update_assignment'] = $update_assignment->row_array();

			$assignment_classes = $this->flexi_auth->get_classes_for_assignment($update_assignment_id);

			$this->data['assignment_classes'] = $assignment_classes;

			$this->data['update_assignment_info'] = 1;
		} else {
			$this->data['update_assignment_info'] = 0;
		}
		$this->load->model('demo_auth_admin_model');

		if ($this->input->post('add_assignment')) {
			$this->demo_auth_admin_model->add_assignment();

		}

		if ($this->input->post('delete_assignment'))
		{
			$delete_assignment_id = $this->input->post('assignmentID');
			$this->flexi_auth->delete_assignment($delete_assignment_id);
			$this->session->set_flashdata('message', '<p class="status_msg">The assignment has been deleted.</p>');
			redirect('dashboard/assignments');
		}

		if ($this->input->post('update_assignment'))
		{
			$this->demo_auth_admin_model->update_assignment($update_assignment_id);
		}
		
		$sql_where = array ('assignment_archief' => 0);

		$assignments = $this->flexi_auth->get_assignments(FALSE, $sql_where);
		$this->data['assignments'] = $assignments->result_array();

		$this->data['classes'] = $this->flexi_auth->get_classes_array();
		if (!$this->flexi_auth->is_admin()) {

			$user_id = $this->flexi_auth->get_user_id();
			$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
			$this->data['user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);
			$assignments = $this->flexi_auth->get_assignments();
			$assignments = $assignments->result_array();
			$this->data['assignments'] = $assignments;

			$handed_in_assignments = $this->flexi_auth->get_assignments_handed_in_by_user($user_id);
			$this->data['handed_in_assignments'] = $handed_in_assignments;


			$not_handed_in_assignments = $this->flexi_auth->get_assignments_not_handed_in_by_user($user_id);
			$this->data['not_handed_in_assignments'] = $not_handed_in_assignments;


			$this->data['checked_assignments'] = $this->flexi_auth->get_checked_assignments_per_student($user_id);

			$this->data['notchecked_assignments'] = $this->flexi_auth->get_not_checked_assignments_per_student($user_id);
		}

		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$data['maincontent'] = $this->load->view('assignments_view', $this->data, TRUE);
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}
	}

	function assignment($assignment_id = FALSE) {
		if (!$assignment_id) {
			$this->session->set_flashdata('message', '<p class="error_msg">Invalid assignment ID.</p>');
			redirect('dashboard/assignments');
		}

		$assignment_classes = $this->flexi_auth->get_classes_for_assignment($assignment_id);
		$this->data['assignment_classes'] = $assignment_classes;

		/*
		$class_names = $this->flexi_auth->get_classnames_for_class_id($assignment_id);
		$this->data['class_names'] = $class_names;
		*/
		if ($this->input->post('update_assignment')) {

			$this->load->model('demo_auth_admin_model');
			//$this->demo_auth_admin_model->update_assignment();

		}

		$sql_where = array($this->login->tbl_col_assignment['id'] => $assignment_id);
		$assignment = $this->flexi_auth->get_assignments(FALSE, $sql_where);
		$this->data['assignment'] = $assignment->row_array();

		$this->data['classes'] = $this->flexi_auth->get_classes_array();

		$this->data['message'] = $this->session->flashdata('message');

		$data['maincontent'] = $this->load->view('assignment_view', $this->data, TRUE);
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}

	}

	function assignments_students()
	{
		$this->load->model('demo_auth_admin_model');
		$this->load->library('flexi_auth');

		// Set any returned status/error messages.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$this->demo_auth_admin_model->get_user_accounts();

		$data['maincontent'] =  $this->load->view('assignments_studentlist_view', $this->data , TRUE);
		$this->load->view('template-teacher', $data);
	}

	function assignments_per_student($user_id)
	{

		if (!$this->flexi_auth->is_admin()) {
			$this->flexi_auth->set_error_message('You are not privliged to view this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard');
		}

		if (!$this->flexi_auth->user_id_exist($user_id)) {
			$this->session->set_flashdata('message', '<p class="error_msg">Requested user does not exist.</p>');
			redirect('dashboard');
		}

		$this->load->model('demo_auth_admin_model');
		$this->load->library('flexi_auth');

		$assignments = $this->flexi_auth->get_assignments();
		$assignments = $assignments->result_array();
		$this->data['assignments'] = $assignments;

		$handed_in_assignments = $this->flexi_auth->get_assignments_handed_in_by_user($user_id);
		$this->data['handed_in_assignments'] = $handed_in_assignments;


		$not_handed_in_assignments = $this->flexi_auth->get_assignments_not_handed_in_by_user($user_id);
		$this->data['not_handed_in_assignments'] = $not_handed_in_assignments;

		$this->data['checked_assignments'] = $this->flexi_auth->get_checked_assignments_per_student($user_id);

		$this->demo_auth_admin_model->get_user_accounts();

		// Get users current data.
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
		$this->data['user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);

		// Set any returned status/error messages.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$data['maincontent'] =  $this->load->view('assignments_per_student_view', $this->data , TRUE);
		$this->load->view('template-teacher', $data);
	}

	function checked_assignment_per_student()
	{

		$assignment_id = $this->uri->segment(3, 0);
		$user_id = $this->uri->segment(4, 0);

		if (!$this->flexi_auth->is_admin() && $user_id != $this->flexi_auth->get_user_id()) {
			redirect('dashboard/assignments');
		}

		if ($assignment_id == 0 || $user_id == 0) {
			redirect('dashboard/assignments');
		}
		$this->load->model('demo_auth_admin_model');
		$this->load->library('flexi_auth');

		$sql_where = array($this->login->tbl_col_assignment['id'] => $assignment_id);
		$this->data['assignment_id'] = $assignment_id;

		$assignment = $this->flexi_auth->get_assignments(FALSE, $sql_where);
		$this->data['assignment'] = $assignment->row_array();

		$errors = $this->flexi_auth->get_errors_for_assignment_of_student($assignment_id, $user_id);
		$this->data['errors'] = $errors->result_array();

		$upload = $this->db->get_where('uploads', array('student_id' => $user_id, 'deadline_id' => $assignment_id));
		$this->data['uploads'] = $upload;

		$this->demo_auth_admin_model->get_user_accounts();

		// Get users current data.

		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
		$this->data['user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);

		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$this->data['comment'] = $this->flexi_auth->get_comment($user_id, $assignment_id);

		$data['maincontent'] = $this->load->view('checked_assignments_per_student_view', $this->data, TRUE);
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}

		// If 'Comments' form has been submitted, insert the comments.
		if ($this->input->post('add_comment'))
		{
			$this->load->model('demo_auth_admin_model');

			$comment = $this->input->post('comment');
			//echo $comment;

			$added = $this->flexi_auth->add_comment($comment, $user_id, $assignment_id);

			$this->flexi_auth_model->set_status_message('The comment has been saved.', 'public', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard/checked_assignment_per_student/'. $assignment_id . '/' . $user_id);
		}

	}
	
	function archive(){
		if ($this->flexi_auth->is_admin()) {
			$sql_where = array('assignment_archief' => 1);
		} else {
			$sql_where = array('assignment_archief' => 1);//TODO
		}

		$assignments = $this->flexi_auth->get_assignments(FALSE, $sql_where);
		$this->data['assignments'] = $assignments->result_array();

		$data['maincontent'] = $this->load->view('archive_view', $this->data, TRUE);
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}
	}

	function do_upload()
	{
		//get assignment id from hidden input field.
		$assignment_id = $this->input->post('assignmentID');

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'xml'; //only xml files allowed to be uploaded
		$config['max_size'] = '2000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite'] = TRUE; //overwrite existing uploads
		$config['file_name'] = $this->flexi_auth->get_user_id(). '-' . $assignment_id;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('assignment_file'))
		{
			//Upload not correct, handle error message.
			$error = array('error' => $this->upload->display_errors());
			$error_msg = strip_tags($error['error']);
			$this->flexi_auth->set_error_message($error_msg , TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard/assignments');

		}
		else
		{
			//check whether uploader is admin or not
			if (!$this->flexi_auth->is_admin()) {
				$student_id = $this->flexi_auth->get_user_id();
				$this->flexi_auth->set_student_file_on_deadline($student_id, $assignment_id); //handed in answers
			} else {
				$teacher_id = $this->flexi_auth->get_user_id();
				$this->flexi_auth->set_teacher_file_on_deadline($teacher_id, $assignment_id);//correction file
			}
			$data = array('upload_data' => $this->upload->data());

			$this->session->set_flashdata('message', '<p class="status_msg">Upload has been saved.</p>');
			redirect('dashboard/assignments');
		}
	}
	
	function grade_overview($assignment_id = FALSE)
	{
		//get all checked assignments
		$sql_where = array($this->login->tbl_col_assignment['checked'] => 1,
						$this->login->tbl_col_assignment['id'] => $assignment_id
		);
		$checked_assignments = $this->flexi_auth->get_assignments(FALSE, $sql_where);
		$this->data['checked_assignments'] = $checked_assignments->result_array();
		
		//load model and get all users
		$this->load->model('demo_auth_admin_model');
		$this->demo_auth_admin_model->get_user_accounts();

		//load grade overview view and load into correct template
		$data['maincontent'] = $this->load->view('grade_overview', $this->data, TRUE);
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}

	}
	
	function topdf($assignment_id) {
		//check user is privileged to see this part of the dashboard, of not redirect to dashboard and set message.
		if (!$this->flexi_auth->is_admin()) {
			$this->flexi_auth->set_error_message('You are not privileged to view this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard');
		}
		
		//load pdf library
		$this->load->library('cezpdf');
		
		//get grades for assignment
		$grade_overview = $this->flexi_auth->get_grades_for_assignment($assignment_id);

		$data_table = array();
		foreach($grade_overview->result_array() as $row) {
			$data_table[] = $row;
		}

		$titlecolumn = array( 'upro_first_name' => 'First Name',
			'upro_last_name' => 'Last Name',
			'grade' => 'Grade'
		);
		
		//export to pdf
		$this->cezpdf->ezTable($data_table, $titlecolumn, 'Grades Overview');
		$this->cezpdf->ezStream(array('Content-Disposition'=>'assignment.pdf'));
	}

	function toexcel($assignment_id) {
		//check user is privileged to see this part of the dashboard, of not redirect to dashboard and set message.
		if (!$this->flexi_auth->is_admin()) {
			$this->flexi_auth->set_error_message('You are not privileged to view this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard');
		}

		//get grades for assignment
		$grade_overview = $this->flexi_auth->get_grades_for_assignment($assignment_id);
		
		//export to excel
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename=Grades Assignment '. $assignment_id . '.csv');
		echo "First Name;Last Name;Grade".PHP_EOL;
		foreach($grade_overview->result_array() as $row) {
			echo $row['upro_first_name'] . ';' . $row['upro_last_name'] . ';' . $row['grade'].PHP_EOL;
		}

	}

	function checker()
	{
		//check user is privileged to see this part of the dashboard, of not redirect to dashboard and set message.
		if (!$this->flexi_auth->is_admin()) {
			$this->flexi_auth->set_error_message('You are not priviliged to view this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard');
		}

		//load libraries
		$this->load->library('checker');
		$this->load->library('flexi_auth');

		//reset vars
		$this->data['error'] = '';
		$this->data['assignments'] = '';

		//if check assignment is pressed.
		if ($this->input->post('check_assignment')) {
			$assignment_id = $this->input->post('assignment_id');
			$correctfile = $this->flexi_auth->get_correct_file_by_deadline($assignment_id);
			$correctfile = $correctfile->result_array();
			if (empty($correctfile)) {
				$this->load->model('flexi_auth_model');
				$this->flexi_auth_model->set_error_message('correctfile_missing', 'config');
				$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
				redirect('dashboard/checker');
			}
			
			$correctfile = $correctfile[0];
			
			$correctfile_name = (string) $correctfile['student_id'] . '-' . (string)$correctfile['deadline_id'] . '.xml';

			$uploads = $this->flexi_auth->get_uploads_by_deadline($assignment_id);
			$uploads = $uploads->result_array();

			foreach($uploads as $upload) {
				if ($upload['checked'] == 0) {
					$handed_in_file = (string) $upload['student_id'] . '-' . (string)$upload['deadline_id'] . '.xml';
					$this->checker->checkFile($correctfile_name, $handed_in_file);
					$this->flexi_auth->update_grade($upload['student_id'], $upload['deadline_id']);
				}
			}

			$this->flexi_auth_model->mark_assignment_as_checked($assignment_id);
			redirect('dashboard/checker');
		}

		$sql_where = array($this->login->tbl_col_assignment['checked'] => '0');

		//$assignments = $this->flexi_auth_model->get_assignments(FALSE, $sql_where);
		$assignments = $this->flexi_auth->get_assignments_not_completely_checked();

		$this->data['assignments'] = $assignments;

		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$data['maincontent'] = $this->load->view('checker_view', $this->data, TRUE);
		$this->load->view('template-teacher', $data);

	}
	
	function checkassignment($assignment_id) {
		if (!$this->flexi_auth->is_admin()) {
			$this->flexi_auth->set_error_message('You are not priviliged to view this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard');
		}

		$this->load->library('checker');
		$this->load->library('flexi_auth');

		$this->data['error'] = '';

		$this->data['assignments'] = '';
		
		$sql_where = array('assignment_id' => $assignment_id);
		$assignment = $this->flexi_auth->get_assignments(FALSE, $sql_where);
		$assignment = $assignment->row_array();
		
		$current_time = date('F d, Y G:i');
		$assignment_time = $assignment['assignment_enddate'];
		$datetime2 = strtotime($assignment_time);
		$datetime1 = strtotime($current_time);
		$datediff = $datetime2 - $datetime1;
		$days_left = floor($datediff/(60*60*24)); 
		
		$correctfile = $this->flexi_auth->get_correct_file_by_deadline($assignment_id);
		$correctfile = $correctfile->result_array();
		
		if (empty($correctfile)) {
			$this->load->model('flexi_auth_model');
			$this->flexi_auth_model->set_error_message('correctfile_missing', 'config');
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard/assignment/' . $assignment_id);
		}	
		if($days_left > 0) {
			$this->load->model('flexi_auth_model');
			$this->flexi_auth_model->set_error_message('Assignment\'s deadline not over yet.', 'public', true);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard/assignment/' . $assignment_id);
		}
		
		$correctfile = $correctfile[0];

		$correctfile_name = (string) $correctfile['student_id'] . '-' . (string)$correctfile['deadline_id'] . '.xml';

		$uploads = $this->flexi_auth->get_uploads_by_deadline($assignment_id);
		$uploads = $uploads->result_array();

		foreach($uploads as $upload) {

			$handed_in_file = (string) $upload['student_id'] . '-' . (string)$upload['deadline_id'] . '.xml';
			$this->checker->checkFile($correctfile_name, $handed_in_file);
			$this->flexi_auth->update_grade($upload['student_id'], $upload['deadline_id']);

		}
		
		$this->flexi_auth_model->mark_assignment_as_checked($assignment_id);
		
		$this->flexi_auth_model->set_status_message('The assignment has been checked.', 'public', TRUE);
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
		redirect('dashboard/assignment/' . $assignment_id);

	}
	
	function archive_assignment($assignment_id) {
		if ($this->flexi_auth->archive_assignment($assignment_id)) {
			$this->flexi_auth->set_status_message('Assignment has been put into the archive.','public', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard/assignments');
		} else {
			$this->flexi_auth->set_error_message('Assignment has not been put into the archive.','public', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard/assignments');
		}
	}
	
	function change_substraction($id = NULL){
		$this->load->library('form_validation');
		$this->load->model('demo_auth_admin_model');
		if (!$this->flexi_auth->is_admin()) {
			$this->flexi_auth->set_error_message('You are not privileged to view this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard');
		}
		
		if($this->input->post('substraction')) {//post
			$newSubstraction = $this->input->post('substraction');
			$this->demo_auth_admin_model->editSubstraction($id,$newSubstraction);
			$id = NULL;
		}
		
			
			$this->data['substraction'] = $this->demo_auth_admin_model->getSubstractionOverview();
			$this->data['id'] = $id;

			if(isset($id)){
				$this->data['edit'] = $this->demo_auth_admin_model->getSubstraction($id)->row();
			}
			$data['maincontent'] = $this->load->view('substraction_overview', $this->data, TRUE);
			$this->load->view('template-teacher', $data);
		
	}
	

}
?>
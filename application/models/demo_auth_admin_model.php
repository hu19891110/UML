<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demo_auth_admin_model extends CI_Model {
	
	// The following method prevents an error occurring when $this->data is modified.
	// Error Message: 'Indirect modification of overloaded property Demo_cart_admin_model::$data has no effect'.
	public function &__get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
		
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// User Accounts
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

 	/**
	 * get_user_accounts
	 * Gets a paginated list of users that can be filtered via the user search form, filtering by the users email and first and last names.
	 */
	function get_user_accounts()
	{
		// Select user data to be displayed.
		$sql_select = array(
			$this->flexi_auth->db_column('user_acc', 'id'),
			$this->flexi_auth->db_column('user_acc', 'email'),
			$this->flexi_auth->db_column('user_acc', 'suspend'),
			$this->flexi_auth->db_column('user_group', 'name'),
			'upro_first_name',
			'upro_last_name',
			'uacc_times_logged_in',
			'uacc_username'
		);
		$this->flexi_auth->sql_select($sql_select);

		// For this example, prevent any 'Master Admin' users (User group id of 3) being listed to non 'Master Admin' users.
		//if (! $this->flexi_auth->in_group('Master Admin'))
		//{
			$sql_where[$this->flexi_auth->db_column('user_acc', 'id').' !='] = $this->flexi_auth->get_user_id();
			$this->flexi_auth->sql_where($sql_where);
		//}	
		

		// Get url for any search query or pagination position.
		$uri = $this->uri->uri_to_assoc(3);

		// Set pagination limit, get current position and get total users.
		$limit = 10;
		$offset = (isset($uri['page'])) ? $uri['page'] : FALSE;		
		
		// Set SQL WHERE condition depending on whether a user search was submitted.
		if (array_key_exists('search', $uri))
		{
			// Set pagination url to include search query.
			$pagination_url = 'dashboard/users/search/'.$uri['search'].'/';
			$config['uri_segment'] = 6; // Changing to 6 will select the 6th segment, example 'controller/function/search/query/page/10'.

			// Convert uri '-' back to ' ' spacing.
			$search_query = str_replace('-',' ',$uri['search']);
								
			// Get users and total row count for pagination.
			// Custom SQL SELECT, WHERE and LIMIT statements have been set above using the sql_select(), sql_where(), sql_limit() functions.
			// Using these functions means we only have to set them once for them to be used in future function calls.
			$total_users = $this->flexi_auth->search_users_query($search_query)->num_rows();			
			
			$this->flexi_auth->sql_limit($limit, $offset);
			$this->data['users'] = $this->flexi_auth->search_users_array($search_query);
		}
		else
		{
			// Set some defaults.
			$pagination_url = 'dashboard/users/';
			$search_query = FALSE;
			$config['uri_segment'] = 4; // Changing to 4 will select the 4th segment, example 'controller/function/page/10'.
			
			// Get users and total row count for pagination.
			// Custom SQL SELECT and WHERE statements have been set above using the sql_select() and sql_where() functions.
			// Using these functions means we only have to set them once for them to be used in future function calls.
			$total_users = $this->flexi_auth->get_users_query()->num_rows();

			$this->flexi_auth->sql_limit($limit, $offset);
			$this->data['users'] = $this->flexi_auth->get_users_array();
		}
		
		// Create user record pagination.
		$this->load->library('pagination');	
		$config['base_url'] = base_url().$pagination_url.'page/';
		$config['total_rows'] = $total_users;
		$config['per_page'] = $limit; 
		$this->pagination->initialize($config); 
		
		// Make search query and pagination data available to view.
		$this->data['search_query'] = $search_query; // Populates search input field in view.
		$this->data['pagination']['links'] = $this->pagination->create_links();
		$this->data['pagination']['total_users'] = $total_users;
	}

 	/**
	 * update_user_accounts
	 * The function loops through all POST data checking the 'Suspend' and 'Delete' checkboxes that have been checked, and updates/deletes the user accounts accordingly.
	 */
	function update_user_accounts()
    {
		// If user has privileges, delete users.
		if ($this->flexi_auth->is_admin()) 
		{
			if ($delete_users = $this->input->post('delete_user'))
			{
				foreach($delete_users as $user_id => $delete)
				{
					// Note: As the 'delete_user' input is a checkbox, it will only be present in the $_POST data if it has been checked,
					// therefore we don't need to check the submitted value.
					$this->flexi_auth->delete_user($user_id);
				}
			}
		}
			
		// Update User Suspension Status.
		// Suspending a user prevents them from logging into their account.
		if ($user_status = $this->input->post('suspend_status'))
		{
			// Get current statuses to check if submitted status has changed.
			$current_status = $this->input->post('current_status');
			
			foreach($user_status as $user_id => $status)
			{
				if ($current_status[$user_id] != $status)
				{
					if ($status == 1)
					{
						$this->flexi_auth->update_user($user_id, array($this->flexi_auth->db_column('user_acc', 'suspend') => 1));
					}
					else
					{
						$this->flexi_auth->update_user($user_id, array($this->flexi_auth->db_column('user_acc', 'suspend') => 0));
					}
				}
			}
		}
			
		// Save any public or admin status or error messages to CI's flash session data.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
		
		// Redirect user.
		redirect('dashboard/users');		
	}

 	/**
	 * update_user_account
	 * Updates the account and profile data of a specific user.
	 * Note: The user profile table ('user_profiles') is used in this demo as an example of relating additional user data to the auth libraries account tables. 
	 */
	function update_user_account($user_id)
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$validation_rules = array(
			array('field' => 'update_first_name', 'label' => 'First Name', 'rules' => 'required'),
			array('field' => 'update_last_name', 'label' => 'Last Name', 'rules' => 'required'),
			array('field' => 'update_email_address', 'label' => 'Email Address', 'rules' => 'required|valid_email|identity_available['.$user_id.']'),
			array('field' => 'update_username', 'label' => 'Username', 'rules' => 'min_length[4]|identity_available['.$user_id.']'),
			array('field' => 'update_group', 'label' => 'User Group', 'rules' => 'required|integer'),
			array('field' => 'update_class', 'label' => 'Student Class', 'rules' => 'required|integer')
		);

		$this->form_validation->set_rules($validation_rules);
		
		if ($this->form_validation->run())
		{
			// 'Update User Account' form data is valid.
			// IMPORTANT NOTE: As we are updating multiple tables (The main user account and user profile tables), it is very important to pass the
			// primary key column and value in the $profile_data for any custom user tables being updated, otherwise, the function will not
			// be able to identify the correct custom data row.
			// In this example, the primary key column and value is 'upro_id' => $user_id.
			
			$first_name = $this->input->post('update_first_name');
			$last_name = $this->input->post('update_last_name');
			$profile_data = array(
				'upro_uacc_fk' => $user_id,
				'upro_first_name' => $first_name,
				'upro_last_name' => $last_name,
				$this->flexi_auth->db_column('user_acc', 'email') => $this->input->post('update_email_address'),
				$this->flexi_auth->db_column('user_acc', 'username') => $this->input->post('update_username'),
				$this->flexi_auth->db_column('user_acc', 'group_id') => $this->input->post('update_group'),
				$this->flexi_auth->db_column('user_acc', 'class_id') => $this->input->post('update_class')
			);			
			
			// If we were only updating profile data (i.e. no email, username or group included), we could use the 'update_custom_user_data()' function instead.
			$this->flexi_auth->update_user($user_id, $profile_data);
				
			// Save any public or admin status or error messages to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());

			//redirect to the appropriate user page
			$current_session_id = $this->flexi_auth->get_user_id();

			if($current_session_id == $user_id){
				$user = $this->flexi_auth->get_user_id();
				redirect('dashboard/update_user_account/'.$user);
			}
			else 
				redirect('dashboard/users');	
			
			
		}
		
		return FALSE;
	}

 	/**
	 * delete_users
	 * Delete all user accounts that have not been activated X days since they were registered.
	 */
	function delete_users($inactive_days)
	{
		// Deleted accounts that have never been activated.
		$this->flexi_auth->delete_unactivated_users($inactive_days);

		// Save any public or admin status or error messages to CI's flash session data.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
		
		// Redirect user.
		redirect('dashboard/users');			
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Student Classes
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
  	/**
	 * insert_student_class
	 * Inserts a new student class.
	 */
	function insert_student_class()
	{	
		$this->load->library('form_validation');

		// Set validation rules.
		$validation_rules = array(
			array('field' => 'insert_class_name', 'label' => 'Class Name', 'rules' => 'required|alpha_dash|min_length[2]|callback_classnameRegex'),
		);
		
		$this->form_validation->set_rules($validation_rules);
		
		if ($this->form_validation->run())
		{
			// Get user group data from input.
			$class_name = $this->input->post('insert_class_name');
			$class_desc = $this->input->post('insert_class_description');

			$this->flexi_auth->insert_class($class_name, $class_desc);
				
			// Save any public or admin status or error messages to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			
			// Redirect user.
			redirect('dashboard/classes');			
		} else {
			$this->flexi_auth_model->set_error_message('There are fields not filled in.', 'public', true);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard/classes');
		}
	}
	
  	/**
	 * update_user_group
	 * Updates a specific user group.
	 */
	function update_student_class($class_id)
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$validation_rules = array(
			array('field' => 'update_class_name', 'label' => 'Class Name', 'rules' => 'required'),
		);
		
		$this->form_validation->set_rules($validation_rules);
		
		if ($this->form_validation->run())
		{
			// Get user class data from input.
			$data = array(
				$this->flexi_auth->db_column('student_class', 'name') => $this->input->post('update_class_name'),
				$this->flexi_auth->db_column('student_class', 'description') => $this->input->post('update_class_description')
			);			

			$this->flexi_auth->update_class($class_id, $data);
				
			// Save any public or admin status or error messages to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			
			// Redirect user.
			redirect('dashboard/classes');			
		}
	}
	
    
    public function get_uploaddata_for_assignment_of_student($assignment_id, $student_id)
	{
		$upload = $this->db->get_where('uploads', array('student_id' => $student_id, 'deadline_id' => $assignment_id));
		
		return $upload;
	}
	

	function add_assignment()
	{
		$this->load->library('form_validation');
		$linked_to_class = false;

		// Set validation rules.
		$validation_rules = array(
			array('field' => 'add_assignment_name', 'label' => 'Assignment Name', 'rules' => 'required'),
			/* array('field' => 'add_assignment_desc', 'label' => 'Assignment description', 'rules' => 'required'), */
			array('field' => 'add_assignment_enddate', 'label' => 'Assignment enddate', 'rules' => 'required')
		);
		
		$this->form_validation->set_rules($validation_rules);
		
		if ($this->form_validation->run())
		{
			// Get deadline data from input.
			$assignment_name = $this->input->post('add_assignment_name');
			$assignment_desc = $this->input->post('add_assignment_desc'); 
			$assignment_enddate = $this->input->post('add_assignment_enddate');
		
			foreach($this->input->post('add') as $row)
			{
				if ($row['current_status'] != $row['new_status'])
				{
					// Assign deadline to class.
					if ($row['new_status'] == 1)
					{
						$assignment_id = $this->flexi_auth->add_assignment($assignment_name, $assignment_desc, $assignment_enddate);
						$this->flexi_auth->link_assignment_to_class($assignment_id, $row['id']);	
						$linked_to_class = true;
					}
				}
			}
			if($linked_to_class)
			{
				// Save any public or admin status or error messages to CI's flash session data.
				$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
				$this->session->set_flashdata('message', '<p class="status_msg">You have succesfully added a new assignment.</p>');
				
			}
			else{
				// Save any public or admin status or error messages to CI's flash session data.
				$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
				$this->session->set_flashdata('message', '<p class="error_msg">The Assignment Class is empty.</p>');
			}
			// Redirect user.
			redirect('dashboard/assignments');	
		} else {
			$this->load->model('flexi_auth_model');
			$this->flexi_auth_model->set_error_message('add_assignment_unsuccessful', 'config');

			if(!$this->input->post('add_assignment_name')) {
				$this->flexi_auth_model->set_error_message('The Assignment Name is empty.', 'public', true);
			}
			if(!$this->input->post('add_assignment_enddate')) {
				$this->flexi_auth_model->set_error_message('The Enddate Name is empty.', 'public', false);
			}
			
			if(!$linked_to_class){
				$this->flexi_auth_model->set_error_message('The Assignment Class is empty.', 'public', false);
			}
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('dashboard/assignments');
		}
	}
	
	
	function update_assignment($assignment_id)
	{	
		
		$this->load->library('form_validation');

		// Set validation rules.
		$validation_rules = array(
			array('field' => 'update_assignment_name', 'label' => 'Assignment Name', 'rules' => 'required'),
			/* array('field' => 'update_assignment_desc', 'label' => 'Assignment description', 'rules' => 'required'), */
			array('field' => 'update_assignment_enddate', 'label' => 'Assignment enddate', 'rules' => 'required')
		);
		
		$this->form_validation->set_rules($validation_rules);
		
		if ($this->form_validation->run())
		{ 
			// Get user class data from input.
			
			$data = array(
				$this->flexi_auth->db_column('assignment', 'name') => $this->input->post('update_assignment_name'),
				$this->flexi_auth->db_column('assignment', 'desc') => $this->input->post('update_assignment_desc'), 
				$this->flexi_auth->db_column('assignment', 'enddate') => $this->input->post('update_assignment_enddate')
			);

			$this->flexi_auth->update_assignment($assignment_id, $data);
			
			foreach($this->input->post('update') as $row)
			{
				if ($row['current_status'] != $row['new_status'])
				{
					// Link assignment to class.
					if ($row['new_status'] == 1)
					{
						$this->flexi_auth->link_assignment_to_class($assignment_id, $row['id']);
					}
					// Unlink assignment to class.
					else
					{	
						$this->flexi_auth->unlink_assignment_from_class($assignment_id, $row['id']);
					}
				}
			}
			
			
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			
			redirect('dashboard/assignments/'. $assignment_id);			
		} else {
			$this->session->set_flashdata('message', '<p class="error_msg">Please fill in the correct information.</p>');
			redirect('dashboard/assignments/'. $assignment_id);	
		}
	}
	
	public function getSubstractionOverview(){
		return $this->db->get('uml_errors');
	}
	public function getSubstraction($id){
		$this->db->where('ue_id',$id);
		return $this->db->get('uml_errors');
	}
	public function editSubstraction($id,$newSubstraction){
		$this->db->where('ue_id',$id);
		$data = array ('ue_error_value' => $newSubstraction);
		$this->db->update('uml_errors',$data);
	}

}

/* End of file demo_auth_admin_model.php */
/* Location: ./application/models/demo_auth_admin_model.php */
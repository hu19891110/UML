<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Name: flexi auth
*
* Author: 
* Rob Hussey
* flexiauth@haseydesign.com
* haseydesign.com/flexi-auth
*
* Copyright 2012 Rob Hussey
* 
* Previous Authors / Contributors:
* Ben Edmunds, benedmunds.com
* Phil Sturgeon, philsturgeon.co.uk
* Mathew Davies
* Filou Tschiemer (User Group Privileges)
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
* 
* http://www.apache.org/licenses/LICENSE-2.0
* 
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*
* Description: A full login authorisation and user management library for CodeIgniter based on Ion Auth (By Ben Edmunds) which itself was based on Redux Auth 2 (Mathew Davies)
* Released: 13/09/2012
* Requirements: PHP5 or above and Codeigniter 2.0+
*/

// Load the flexi auth Lite library to allow it to be extended.
load_class('Flexi_auth_lite', 'libraries', FALSE);

class Flexi_auth extends Flexi_auth_lite
{
	public function __construct()
	{
		parent::__construct();
		
		$this->CI->load->model('flexi_auth_model');
	}	
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// LOGIN / VALIDATION FUNCTIONS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * login
	 * Verifies a users identity and password, if valid, they are logged in.
	 *
	 * @return void
	 * @author Mathew Davies
	 */
	public function login($identity = FALSE, $password = FALSE, $remember_user = FALSE) 
	{
		if ($this->CI->flexi_auth_model->login($identity, $password, $remember_user))
		{
			$this->CI->flexi_auth_model->set_status_message('login_successful', 'config');
			return TRUE;
		}

		// If no specific error message has been set, set a generic error.
		if (! $this->CI->flexi_auth_model->error_messages)
		{
			$this->CI->flexi_auth_model->set_error_message('login_unsuccessful', 'config');
		}
		
		return FALSE;
	}
		
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * ip_login_attempts_exceeded
	 * Validates whether the number of failed login attempts from a unique IP address has exceeded a defined limit.
	 * The function can be used in conjunction with showing a Captcha for users repeatedly failing login attempts.
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function ip_login_attempts_exceeded()
	{
		return $this->CI->flexi_auth_model->ip_login_attempts_exceeded();
	}
	
	/**
	 * recaptcha
	 * Generates the html for Google reCAPTCHA.
	 * Note: If the reCAPTCHA is located on an SSL secured page (https), set $ssl = TRUE.
	 *
	 * @return string
	 * @author Rob Hussey
	 */
	public function recaptcha($ssl = FALSE)
	{
		return $this->CI->flexi_auth_model->recaptcha($ssl);
	}
	
	/**
	 * validate_recaptcha
	 * Validates if a Google reCAPTCHA answer submitted via http POST data is correct.
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function validate_recaptcha()
	{
		return $this->CI->flexi_auth_model->validate_recaptcha();
	}
	
	/**
	 * math_captcha
	 * Generates a math captcha question and answer.
	 * The question is returned as a string, whilst the answer is set as a CI flash session. 
	 * Use the 'validate_math_captcha()' function to validate the users submitted answer.
	 *
	 * @return string
	 * @author Rob Hussey
	 */
	public function math_captcha()
	{
		$captcha = $this->CI->flexi_auth_model->math_captcha();
		
		$this->CI->session->set_flashdata($this->CI->login->session_name['math_captcha'], $captcha['answer']);
		
		return $captcha['equation'];
	}
	
	/**
	 * validate_math_captcha
	 * Validates if a submitted math captcha answer is correct.
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function validate_math_captcha($answer = FALSE)
	{
		return ($answer == $this->CI->session->flashdata($this->CI->login->session_name['math_captcha']));
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * min_password_length
	 * Gets the minimum valid password character length.
	 *
	 * @return int
	 * @author Rob Hussey
	 */
	public function min_password_length()
	{
		return $this->CI->login->auth_security['min_password_length'];
	}
	
	/**
	 * valid_password_chars
	 * Validate whether the submitted password only contains valid characters defined by the config file.
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function valid_password_chars($password = FALSE)
	{
		return (bool) preg_match("/^[".$this->CI->login->auth_security['valid_password_chars']."]+$/i", $password);
	}
	

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// USER TASK FUNCTIONS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * activate_user
	 * Activates a users account allowing them to login to their account. 
	 * If $verify_token = TRUE, a valid $activation_token must also be submitted.
	 *
	 * @return void
	 * @author Rob Hussey
	 */
	public function activate_user($user_id, $activation_token = FALSE, $verify_token = TRUE)
	{
		if ($this->CI->flexi_auth_model->activate_user($user_id, $activation_token, $verify_token))
		{
			$this->CI->flexi_auth_model->set_status_message('activate_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('activate_unsuccessful', 'config');
		return FALSE;
	}

	/**
	 * resend_activation_token
	 * Resends user a new activation token incase they have lost the previous one.
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function resend_activation_token($identity) 
	{
		// Get primary identity.
		$identity = $this->CI->flexi_auth_model->get_primary_identity($identity);
		
		if (empty($identity))
		{
			$this->CI->flexi_auth_model->set_error_message('activation_email_unsuccessful', 'config');
			return FALSE;
		}
		
		// Get user information.
		$sql_select = array(
			$this->CI->login->tbl_col_user_account['id'],
			$this->CI->login->tbl_col_user_account['active']
		);
		
		$sql_where[$this->CI->login->primary_identity_col] = $identity;
		
		$user = $this->CI->flexi_auth_model->get_users($sql_select, $sql_where)->row();

		$user_id = $user->{$this->CI->login->database_config['user_acc']['columns']['id']};
		$active_status = $user->{$this->CI->login->database_config['user_acc']['columns']['active']};		
		
		// If account is already activated.
		if ($active_status == 1)
		{
			$this->CI->flexi_auth_model->set_status_message('account_already_activated', 'config');
			return TRUE;
		}
		// Else, run the deactivate_user() function to reset the users activation token.
		else if ($this->CI->flexi_auth_model->deactivate_user($user_id))
		{
			// Get user information.
			$sql_select = array(
				$this->CI->login->primary_identity_col,
				$this->CI->login->tbl_col_user_account['activation_token'],
				$this->CI->login->tbl_col_user_account['email']
			);
			$sql_where[$this->CI->login->primary_identity_col] = $identity;
			$user = $this->CI->flexi_auth_model->get_users($sql_select, $sql_where)->row();
			
			$email = $user->{$this->CI->login->database_config['user_acc']['columns']['email']}; 
			$activation_token = $user->{$this->CI->login->database_config['user_acc']['columns']['activation_token']};
			
			// Set email data.
			$email_to = $email;
			$email_title = ' - Account Activation';
		
			$user_data = array(
				'user_id' => $user_id,
				'identity' => $identity,
				'activation_token' => $activation_token
			);
			$template = $this->CI->login->email_settings['email_template_directory'].$this->CI->login->email_settings['email_template_activate'];

			if ($this->CI->flexi_auth_model->send_email($email_to, $email_title, $user_data, $template))
			{
				$this->CI->flexi_auth_model->set_status_message('activation_email_successful', 'config');
				return TRUE;
			}
		}
		
		$this->CI->flexi_auth_model->set_error_message('activation_email_unsuccessful', 'config');
		return FALSE;
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * validate_current_password
	 * Validates a submitted 'Current' password against the database for a specific user. 
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function validate_current_password($current_password, $identity)
	{
		return ($this->CI->flexi_auth_model->verify_password($identity, $current_password));
	}	
	
	/**
	 * change_password
	 * Validates a submitted 'Current' password against the database, if valid, the database is updated with the 'New' password. 
	 *
	 * @return bool
	 * @author Mathew Davies
	 */
	public function change_password($identity, $current_password, $new_password)
	{
		if ($this->CI->flexi_auth_model->change_password($identity, $current_password, $new_password))
		{
			$this->CI->flexi_auth_model->set_status_message('password_change_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('password_change_unsuccessful', 'config');
		return FALSE;
	}	
	
	/**
	 * forgotten_password
	 * Sends the user an email containing a link the user must click to verify they have requested to change their forgotten password.
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function forgotten_password($identifier) 
	{
		// Get users primary identity.
		if (!$identity = $this->CI->flexi_auth_model->get_primary_identity($identifier))
		{
			$this->CI->flexi_auth_model->set_error_message('email_forgot_password_unsuccessful', 'config');
			return FALSE;
		}
	
		if ($this->CI->flexi_auth_model->forgotten_password($identity))
		{
			// Get user information.
			$sql_select = array(
				$this->CI->login->tbl_col_user_account['id'],
				$this->CI->login->tbl_col_user_account['email'],
				$this->CI->login->tbl_col_user_account['forgot_password_token']
			);			
			$sql_where[$this->CI->login->primary_identity_col] = $identity;
			
			$user = $this->CI->flexi_auth_model->get_users($sql_select, $sql_where)->row();
			$user_id = $user->{$this->CI->login->database_config['user_acc']['columns']['id']};
			$forgotten_password_token = $user->{$this->CI->login->database_config['user_acc']['columns']['forgot_password_token']}; 

			// Set email data.
			$email_to = $user->{$this->CI->login->database_config['user_acc']['columns']['email']};
			$email_title = ' - Forgotten Password Verification';
			
			$user_data = array(
				'user_id' => $user_id,
				'identity' => $identity,
				'forgotten_password_token' => $forgotten_password_token
			);
			$template = $this->CI->login->email_settings['email_template_directory'].$this->CI->login->email_settings['email_template_forgot_password'];
			
			if ($this->CI->flexi_auth_model->send_email($email_to, $email_title, $user_data, $template))
			{
				$this->CI->flexi_auth_model->set_status_message('email_forgot_password_successful', 'config');
				return TRUE;
			}
		}
		
		$this->CI->flexi_auth_model->set_error_message('email_forgot_password_unsuccessful', 'config');
		return FALSE;
	}

	/**
	 * validate_forgotten_password
	 * Validates a forgotten password token that was passed by clicking a link from a 'forgotten_password()' function email.
	 *
	 * @return void
	 * @author Rob Hussey
	 */
	public function validate_forgotten_password($user_id, $token)
	{
		return $this->CI->flexi_auth_model->validate_forgotten_password_token($user_id, $token);
	}

	/**
	 * forgotten_password_complete
	 * This function is similar to the above 'validate_forgotten_password()' function, however, if validated the function also updates the database
	 * with a new password, then if defined via $send_email, an email will be sent to the user containing the new password.
	 *
	 * @return void
	 * @author Rob Hussey
	 */
	public function forgotten_password_complete($user_id, $forgot_password_token, $new_password = FALSE, $send_email = FALSE)
	{
		if ($this->CI->flexi_auth_model->validate_forgotten_password_token($user_id, $forgot_password_token))
		{
			$sql_select = array(
				$this->CI->login->primary_identity_col,
				$this->CI->login->tbl_col_user_account['salt'],
				$this->CI->login->tbl_col_user_account['email']
			);
			
			$sql_where[$this->CI->login->tbl_col_user_account['id']] = $user_id;
			
			$user = $this->CI->flexi_auth_model->get_users($sql_select, $sql_where)->row();

			if (!is_object($user))
			{
				$this->CI->flexi_auth_model->set_error_message('password_change_unsuccessful', 'config');
				return FALSE;
			}

			$identity = $user->{$this->CI->login->db_settings['primary_identity_col']};
			$database_salt = $user->{$this->CI->login->database_config['user_acc']['columns']['salt']};

			// If no new password is set via $new_password, the function will generate a new one.
			$new_password = $this->CI->flexi_auth_model->change_forgotten_password($user_id, $forgot_password_token, $new_password, $database_salt);
			
			// Send user email with new password if function variable $send_email = TRUE.
			if ($send_email)
			{
				// Set email data
				$email_to = $user->{$this->CI->login->database_config['user_acc']['columns']['email']};
				$email_title = ' - New Password';
			
				$user_data = array(
					'identity' => $identity,
					'new_password' => $new_password
				);
				$template = $this->CI->login->email_settings['email_template_directory'].
					$this->CI->login->email_settings['email_template_forgot_password_complete'];

				if ($this->CI->flexi_auth_model->send_email($email_to, $email_title, $user_data, $template))
				{
					$this->CI->flexi_auth_model->set_status_message('email_new_password_successful', 'config');
					return TRUE;
				}
			}
			// If new password is not set to be emailed, but has been successfully changed.
			else if ($new_password)
			{
				$this->CI->flexi_auth_model->set_status_message('password_change_successful', 'config');
				return TRUE;
			}
		}
		
		$this->CI->flexi_auth_model->set_error_message('password_token_invalid', 'config');
		return FALSE;
	}
	
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// USER MANAGEMENT / CRUD FUNCTIONS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * insert_user
	 * Inserts user account and profile data, returning the users new id.
	 *
	 * @return void
	 * @author Rob Hussey
	 */
	public function insert_user($email, $username = FALSE, $password, $class_id, $user_data, $group_id = FALSE, $activate = FALSE) 
	{
		$user_id = $this->CI->flexi_auth_model->insert_user($email, $username, $password, $class_id, $user_data, $group_id);

		if ($user_id)
		{
			// Check whether to auto activate the user.
			if ($activate)
			{
				// If an account activation time limit is set by the config file, retain activation token.
				$clear_token = ($this->CI->login->auth_settings['account_activation_time_limit'] > 0) ? FALSE : TRUE;
				
				$this->CI->flexi_auth_model->activate_user($user_id, FALSE, FALSE, $clear_token);		
			}
			
			$sql_select = array(
				$this->CI->login->primary_identity_col,
				$this->CI->login->tbl_col_user_account['activation_token']
			);
			
			$sql_where[$this->CI->login->tbl_col_user_account['id']] = $user_id;
			
			$user = $this->CI->flexi_auth_model->get_users($sql_select, $sql_where)->row(); 

			if (!is_object($user))
			{
				$this->CI->flexi_auth_model->set_error_message('account_creation_unsuccessful', 'config');
				return FALSE;
			}
			
			$identity = $user->{$this->CI->login->db_settings['primary_identity_col']};
			$activation_token = $user->{$this->CI->login->database_config['user_acc']['columns']['activation_token']};
			
			// Prepare account activation email.
			// If the $activation_token is not empty, the account must be activated via email before the user can login.
			if (!empty($activation_token))
			{
				// Set email data.
				$email_to = $email;
				$email_title = ' - Account Activation';
			
				$user_data = array(
					'user_id' => $user_id,
					'identity' => $identity,
					'activation_token' => $activation_token
				);
				$template = $this->CI->login->email_settings['email_template_directory'].$this->CI->login->email_settings['email_template_activate'];

				if ($this->CI->flexi_auth_model->send_email($email_to, $email_title, $user_data, $template))
				{
					$this->CI->flexi_auth_model->set_status_message('activation_email_successful', 'config');
					return $user_id;
				}

				$this->CI->flexi_auth_model->set_error_message('activation_email_unsuccessful', 'config');
				return FALSE;
			}
			
			$this->CI->flexi_auth_model->set_status_message('account_creation_successful', 'config');
			return $user_id;
		}
		else
		{
			$this->CI->flexi_auth_model->set_error_message('account_creation_unsuccessful', 'config');
			return FALSE;
		}
	}
	
	/**
	 * update_user
	 * Updates the main user account table and any linked custom user tables with the submitted data.
	 *
	 * @return void
	 * @author Phil Sturgeon
	 */
	public function update_user($user_id, $user_data)
	{
		if ($this->CI->flexi_auth_model->update_user($user_id, $user_data))
		{
			$this->CI->flexi_auth_model->set_status_message('update_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('update_unsuccessful', 'config');
		return FALSE;
	}

	/**
	 * delete_user
	 * Deletes a user account and all linked custom user tables from the database.
	 *
	 * @return void
	 * @author Phil Sturgeon
	 */
	public function delete_user($user_id)
	{
		if ($this->CI->flexi_auth_model->delete_user($user_id))
		{
			$this->CI->flexi_auth_model->set_status_message('delete_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('delete_unsuccessful', 'config');
		return FALSE;
	}
	
	/**
	 * delete_unactivated_users
	 * Delete users that have not activated their account within a set time period.
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function delete_unactivated_users($inactive_days = 28, $sql_where = FALSE)
	{
		$users = $this->CI->flexi_auth_model
			->get_unactivated_users($inactive_days, $this->CI->login->tbl_col_user_account['id'], $sql_where);
				
		if ($users->num_rows() > 0)
		{
			$users = $users->result_array();
		
			foreach ($users as $user)
			{
				$user_id = $user[$this->CI->login->database_config['user_acc']['columns']['id']];
				$this->CI->flexi_auth_model->delete_user($user_id);
			}
			$this->CI->flexi_auth_model->set_status_message('delete_successful', 'config');
			return TRUE;
		}
		
		$this->CI->flexi_auth_model->set_error_message('delete_unsuccessful', 'config');
		return FALSE;
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	/**
	 * insert_custom_user_data
	 * Inserts data into a custom user table and returns the table name and row id of each record inserted.
	 *
	 * @return array/void
	 * @author Rob Hussey
	 */
	public function insert_custom_user_data($user_id = FALSE, $custom_data = FALSE)
	{
		if ($row_data = $this->CI->flexi_auth_model->insert_custom_user_data($user_id, $custom_data))
		{
			$this->CI->flexi_auth_model->set_status_message('update_successful', 'config');
			return $row_data;
		}

		$this->CI->flexi_auth_model->set_error_message('update_unsuccessful', 'config');
		return FALSE;
	}
	
	
	
	/**
	 * update_custom_user_data
	 * Updates a custom user table with any submitted data.
	 * To identify which row to update, a table name and row id can be submitted, alternatively, data can be updated by submitting custom data
	 * that contains an array key and value of the primary key column and row id from any of the custom tables set via the config file.
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function update_custom_user_data($table = FALSE, $row_id = FALSE, $custom_data = FALSE)
	{
		if ($this->CI->flexi_auth_model->update_custom_user_data($table, $row_id, $custom_data))
		{
			$this->CI->flexi_auth_model->set_status_message('update_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('update_unsuccessful', 'config');
		return FALSE;
	}

	/**
	 * delete_custom_user_data
	 * Deletes a data row from a custom user table.
	 *
	 * @return void
	 * @author Rob Hussey
	 */
	public function delete_custom_user_data($table = FALSE, $row_id = FALSE)
	{
		if ($this->CI->flexi_auth_model->delete_custom_user_data($table, $row_id))
		{
			$this->CI->flexi_auth_model->set_status_message('delete_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('delete_unsuccessful', 'config');
		return FALSE;
	}

	public function insert_class($name, $description = NULL, $custom_data = array())
	{
		if ($class_id = $this->CI->flexi_auth_model->insert_class($name, $description, $custom_data));
		{
			$this->CI->flexi_auth_model->set_status_message('update_successful','config');
			return $class_id;
		}

		$this->CI->flexi_auth_model->set_error_message('update_unsuccessful', 'config');
		return FALSE;
	}

	public function update_class($class_id, $class_data)
	{
		if ($this->CI->flexi_auth_model->update_class($class_id, $class_data))
		{
			$this->CI->flexi_auth_model->set_status_message('update_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('update_unsuccessful', 'config');
		return FALSE;
	}
	
	public function update_file_by_deadline($student_id, $deadline_id, $grade, $faults) {
		$this->CI->flexi_auth_model->update_file_by_deadline($student_id, $deadline_id, $grade, $faults);
	}
	
	public function get_correct_file_by_deadline($deadline_id) {
		return $this->CI->flexi_auth_model->get_correct_file_by_deadline($deadline_id);
	}

	public function delete_class($sql_where)
	{
		if ($this->CI->flexi_auth_model->delete_class($sql_where))
		{
			$this->CI->flexi_auth_model->set_status_message('delete_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('delete_unsuccessful', 'config');
		return FALSE;
	}
	
	
	function add_student_to_class($user_id,$user_data)
	{
		if ($this->CI->flexi_auth_model->update_user($user_id, $user_data))
		{
			$this->CI->flexi_auth_model->set_status_message('update_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('update_unsuccessful', 'config');
		return FALSE;
	}
	
	public function add_assignment($assignment_name, $assignment_desc, $assignment_enddate)
	{	
		$assignment_id = $this->CI->flexi_auth_model->add_assignment($assignment_name, $assignment_desc, $assignment_enddate);
		if ($assignment_id != FALSE)
		{
			$this->CI->flexi_auth_model->set_status_message('add_deadline_successful', 'config');
			return $assignment_id;
		}

		$this->CI->flexi_auth_model->set_error_message('add_deadline_unsuccessful', 'config');
		return FALSE;
	}
	
	public function delete_assignment($sql_where)
	{
		if ($this->CI->flexi_auth_model->delete_assignment($sql_where))
		{
			$this->CI->flexi_auth_model->set_status_message('delete_assignment_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('delete_assignment_unsuccessful', 'config');
		return FALSE;
	}
	
	public function update_assignment($assignment_id, $assignment_data)
	{
		if ($this->CI->flexi_auth_model->update_assignment($assignment_id, $assignment_data))
		{
			$this->CI->flexi_auth_model->set_status_message('update_assignment_successful', 'config');
			return TRUE;
		}
		return FALSE;
	}
	
	
	function link_assignment_to_class($assignment_id, $class_id) {
		if ($this->CI->flexi_auth_model->link_assignment_to_class($assignment_id, $class_id))
		{
			$this->CI->flexi_auth_model->set_status_message('add_deadline_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('add_assignment_unsuccessful', 'config');
		return FALSE;
		
	}
	
	function unlink_assignment_from_class($assignment_id, $class_id) {
		if ($this->CI->flexi_auth_model->unlink_assignment_to_class($assignment_id, $class_id))
		{
			$this->CI->flexi_auth_model->set_status_message('update_assignment_successful', 'config');
			return TRUE;
		}

		$this->CI->flexi_auth_model->set_error_message('update_assignment_unsuccessful', 'config');
		return FALSE;
	}
	
	public function	add_comment($comments, $student_id, $deadline_id) {
		
		return $this->CI->flexi_auth_model->add_comments($comments, $student_id, $deadline_id);
			
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * identity_available
	 * Returns whether a user identity is available in the database. 
	 * The identity columns are defined via the $config['database']['settings']['identity_cols'] variable in the config file.
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function identity_available($identity = FALSE, $user_id = FALSE)
	{
		return $this->CI->flexi_auth_model->identity_available($identity, $user_id);
	}
	
	/**
	 * email_available
	 * Returns whether an email address is available in the database. 
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function email_available($email = FALSE, $user_id = FALSE)
	{
		return $this->CI->flexi_auth_model->email_available($email, $user_id);
	}
	
	/**
	 * username_available
	 * Returns whether a username is available in the database. 
	 *
	 * @return bool
	 * @author Rob Hussey
	 */
	public function username_available($username = FALSE, $user_id = FALSE)
	{
		return $this->CI->flexi_auth_model->username_available($username, $user_id);
	}
	
		/**
	 * template_data
	 * flexi auth sends emails for a number of functions, this function can set additional data variables that can then be used by the template files.
	 *
	 * @return void
	 * @author Rob Hussey
	 */
	public function template_data($template, $template_data)
	{
		if (empty($template) && empty($template_data))
		{
			return FALSE;
		}

		// Set template data placeholder.
		$data = $this->CI->login->template_data;

		// Change default template if set
		if (!empty($template))
		{
			$data['template'] = $template;
		}

		// Add additional template data if set
		if (!empty($template_data))
		{
			$data['template_data'] = $template_data;
		}
		
		$this->CI->login->template_data = $data;
	}
	
	public function send_email($email_to = FALSE, $email_title = FALSE, $template = FALSE, $email_data = array())
	{
		if (!$email_to || !$template || empty($email_data))
		{
			return FALSE;
		}
	
		$template = $this->CI->login->email_settings['email_template_directory'].$template;

		return $this->CI->flexi_auth_model->send_email($email_to, $email_title, $email_data, $template);
	}
	
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// GET USER FUNCTIONS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
		
	/**
	 * search_users_query
	 * Search user table using SQL WHERE 'x' LIKE '%y%' statement
	 * Note: Additional WHERE statements can be passed using the $sql_where parameter.
	 *
	 * @return object
	 * @author Rob Hussey
	 */
	public function search_users_query($search_query = FALSE, $exact_match = FALSE, $sql_select = FALSE, $sql_where = FALSE, $sql_group_by = TRUE)
	{
		return $this->CI->flexi_auth_model->search_users($search_query, $exact_match, $sql_select, $sql_where, $sql_group_by);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * get_users_group_query
	 * Gets records from the user group table typically for a filtered set of users. 
	 *
	 * @return object
	 * @author Rob Hussey
	 */
	public function get_users_group_query($sql_select = FALSE, $sql_where = FALSE)
	{
		$sql_select = ($sql_select) ? $sql_select : $this->CI->login->tbl_user_group.'.*';

		if (! $sql_where)
		{
			$sql_where = array($this->CI->login->tbl_col_user_account['id'] => $this->CI->login->session_data[$this->CI->login->session_name['user_id']]);
		}
	
		return $this->CI->flexi_auth_model->get_users($sql_select, $sql_where);
	}
	
	
	public function get_student_class($user_id) {
		return $this->CI->flexi_auth_model->get_student_class($user_id);
	}
	
	public function get_deadlines_by_class($class_id) {
		return $this->CI->flexi_auth_model->get_deadlines_by_class($class_id);
	}

	public function get_classes_query($sql_select = FALSE, $sql_where = FALSE)
	{
		return $this->CI->flexi_auth_model->get_classes($sql_select, $sql_where);
	}
	
	function get_classes_for_assignment($assignment_id) {
		return $this->CI->flexi_auth_model->get_classes_for_assignment($assignment_id);

	}
	
	public function get_uploads($sql_select = FALSE, $sql_where = FALSE)
	{
		return $this->CI->flexi_auth_model->get_uploads($sql_select, $sql_where);
	}
	
	public function get_upload_date_time($assignment_id, $student_id)
	{
		return $this->CI->flexi_auth_model->get_upload_date_time($assignment_id, $student_id);
	}
	
	public function get_assignments($sql_select = FALSE, $sql_where = FALSE)
	{
		return $this->CI->flexi_auth_model->get_assignments($sql_select, $sql_where);
	}
	
	public function get_assignments_handed_in_by_user($user_id) {
	
		return $this->CI->flexi_auth_model->get_assignments_handed_in_by_user($user_id);
	
	}
	
	public function get_assignments_not_handed_in_by_user($user_id) {
	
		return $this->CI->flexi_auth_model->get_assignments_not_handed_in_by_user($user_id);
			
	}
	
	public function get_checked_assignments_per_student($student_id) {
		return $this->CI->flexi_auth_model->get_checked_assignments_per_student($student_id);
	}
	
	public function get_not_checked_assignments_per_student($student_id) {
		return $this->CI->flexi_auth_model->get_not_checked_assignments_per_student($student_id);
	}
	
	public function get_errors_for_assignment_of_student($assignment_id, $student_id)
	{
		return $this->CI->flexi_auth_model->get_errors_for_assignment_of_student($assignment_id, $student_id);
	}
	
	public function get_error_value($error_id) 
	{
		return $this->CI->flexi_auth_model->get_error_value($error_id); 
	}
	
	public function calculate_grade($student_id, $assignment_id)
	{
		return $this->CI->flexi_auth_model->calculate_grade($student_id, $assignment_id);
	}

	public function update_grade($student_id, $assignment_id)
	{
		return $this->CI->flexi_auth_model->update_grade($student_id, $assignment_id);
	}
	
	public function set_student_file_on_deadline($student_id, $deadline_id) {
		
		return $this->CI->flexi_auth_model->set_student_file_on_deadline($student_id, $deadline_id);
	
	}
	
	public function set_teacher_file_on_deadline($teacher_id, $deadline_id) {
		
		return $this->CI->flexi_auth_model->set_teacher_file_on_deadline($teacher_id, $deadline_id);
	}
	
	public function upload_too_late($upload_id, $assignment_id)
	{
		return $this->CI->flexi_auth_model->upload_too_late($upload_id, $assignment_id);
	}
	
	public function get_upload_id($assignment_id, $student_id)
	{
		return $this->CI->flexi_auth_model->get_upload_id($assignment_id, $student_id);
	}
	
	public function get_grade_for_assignment_by_student($assignment_id, $student_id)
	{
		return $this->CI->flexi_auth_model->get_grade_for_assignment_by_student($assignment_id, $student_id);
	}
	
	public function get_grades_for_assignment($assignment_id) {
		return $this->CI->flexi_auth_model->get_grades_for_assignment($assignment_id);
	}
	
	public function get_comment($user_id, $assignment_id) {
		return $this->CI->flexi_auth_model->get_comment($user_id, $assignment_id);
	}
	
	public function get_classname_for_class_id($class_id) {
		return $this->CI->flexi_auth_model->get_classname_for_class_id($class_id);
	}
	
	public function user_id_exist($user_id) {
		return $this->CI->flexi_auth_model->user_id_exist($user_id);
	}
		
	public function class_id_exist($class_id) {
		return $this->CI->flexi_auth_model->class_id_exist($class_id);
	}
	
	public function answers_already_uploaded($user_id, $assignment_id) {
		return $this->CI->flexi_auth_model->answers_already_uploaded($user_id, $assignment_id);
	}
	public function answers_already_checked($user_id, $assignment_id) {
		return $this->CI->flexi_auth_model->answers_already_checked($user_id, $assignment_id);
	}
	
	public function get_assignments_not_completely_checked() {
		return $this->CI->flexi_auth_model->get_assignments_not_completely_checked();
	}
	
	public function archive_assignment($assignment_id) {
		return  $this->CI->flexi_auth_model->archive_assignment($assignment_id);
	}
	
	public function get_amount_students_not_handed_in($assignment_id) {
		return $this->CI->flexi_auth_model->get_amount_students_not_handed_in($assignment_id);
	}
	
	public function get_substraction_late($user_id, $assignment_id) {
		return $this->CI->flexi_auth_model->get_substraction_late($user_id, $assignment_id);
	}
	
}



/* End of file flexi_auth.php */
/* Location: ./application/controllers/flexi_auth.php */
<html>
	<head>
		<title></title>
	</head>
	<body>
		<div class="large-12 columns padding">
			<h2>
				Assignments Overview
			</h2>

			<h3>
				Upload test answers
			</h3><?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div><?php } ?>


			<?php echo $error;?>

			<?php echo form_open_multipart('assignments/do_upload');?>
			<input type="file" name="userfile" size="20"><br>
			<br>

			User <?php echo $this->flexi_auth->get_user_id();?> 

			<label for="group">Group:</label>
			<select id="group" name="update_group" class="tooltip_trigger" title="Set the users group, that can define them as an admin, public, moderator etc.">
				<?php foreach($groups as $group) { ?>
				<?php $user_group = ($group[$this->flexi_auth->db_column('user_group', 'id')] == $user[$this->flexi_auth->db_column('user_acc', 'group_id')]) ? TRUE : FALSE;?>
				<option value="<?php echo $group[$this->flexi_auth->db_column('user_group', 'id')];?>" <?php echo set_select('update_group', $group[$this->flexi_auth->db_column('user_group', 'id')], $user_group);?>>
					<?php echo $group[$this->flexi_auth->db_column('user_group', 'name')];?>
				</option>
				<?php } ?>
			


			</select> <input type="submit" value="Upload" class="small button">
		</div><!-- end large 12 columns -->
	</body>
</html>
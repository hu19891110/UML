<div class="large-12 columns" >

	<div class="h2bg">
		<h2>
			<?php 
			if ($this->flexi_auth->is_admin()) {
				$user_id = $user['uacc_id'];
				$user_name = $user['uacc_username'];
			} else {
				$user_id = $currentuser['uacc_id'];
				$user_name = $currentuser['uacc_username'];
			}
			
			$assignment_grade = $this->flexi_auth->calculate_grade($user_id, $assignment_id);
			?>
			<span class="cijfer"><?php echo $assignment_grade;?> </span>
	 		Student <?php echo $user_name; ?> 	
	 		<?php if ($this->flexi_auth->is_admin()) { ?>
	 		<span class="backtoass"><a
	 			href="<?php echo $base_url.'dashboard/assignments_per_student/'.$user_id;?>"> 
	 			Back to all assignments of the student</a>
	 		</span>
	 		<?php } ?>
		</h2>
	
		<h4>
			<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>	
			
			<?php if ($this->flexi_auth->is_admin()) { ?>
	 		<span class="goedkeuren"> Approve all | Disapprove all </span>
	 		<?php } ?>
			
		</h4>	
	</div>
	<? 
	
		foreach ($errors as $error) {
			 $error_id = $error[$this->flexi_auth->db_column('checker_error', 'error_id')];
			 $error_value = $this->flexi_auth->get_error_value($error_id,$assignment_id);
			 $error_value = round($error_value, 1);
			 ?>
			 <?php if ($this->flexi_auth->is_admin()) { ?>
			 <span class="notcheckedbutton"></span>
			 <span class="checkedbutton"></span>
	 		 <?php } ?>
	 		 <?php if ($error_id == 17) { 
	 		 $error_value = $this->flexi_auth->get_substraction_late($user_id, $assignment_id);
			  } ?>
			 <span class="mistake"><?php echo $error_value;?></span>
			 <?
			 			 if ($error_id == 1) {
				 ?>
				 <p>Relationship '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': The relationship exists in the handed in model but has another name.</p>
				 <?php
			 } else if ($error_id == 2) {
				 ?>
				 <p>Relationship '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': This relationship does NOT have the same start destination. </p>
				 <?php
			 } else if ($error_id == 3) {
				 ?>
				 <p>Relationship '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': This relationship does NOT have the same destination. </p>
				 <?php
			 } else if ($error_id == 4) {
				 ?>
				 <p>Relationship '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>': This relationship is NOT of the same type.</p>
				 <?php
			 } else if ($error_id == 5) {
				 ?>
				 <p> Multiplicty error</p>
				 <?php
			 } else if ($error_id == 6) {
				 ?>
				 <p>Class '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>', attribute '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'attribute')];?>': the datatype (<?php echo $error[$this->flexi_auth->db_column('checker_error', 'datatype')];?>) does not match. </p>
				 <?php
			 } else if ($error_id == 7) {
				 ?>
				 <p>Class '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>', operation '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'operation')];?>': the datatype (<?php echo $error[$this->flexi_auth->db_column('checker_error', 'datatype')];?>) does not match. </p>
				 <?php
			 } else if ($error_id == 8) {
				 ?>
				 <p>Parameter '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'parameter')];?>' is missing from the operation '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'operation')];?>' </p>
				 <?php
			 } else if ($error_id == 9) {
				 ?>
				 <p>Operation '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'operation')];?>' is missing from the class '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>' </p>
				 <?php
			 } else if ($error_id == 10) {
				 ?>
				 <p>Class '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>': The attribute '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'attribute')];?>' is missing in the handed in model. </p>

				 <?php
			 } else if ($error_id == 11) {
				 ?>
				 <p>The sterotype from the class '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>' is incorrect. </p>
				 <?php
			 } else if ($error_id == 12) {
				 ?>
				 <p>The returntype from the operation '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'operation')];?>' is incorrect. </p>
				 <?php
			 } else if ($error_id == 13) {
				 ?>
				 <p>The following part(s) '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'eigenschappen')];?>' from the operation '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'operation')];?>' is/are incorrect. </p>
				 <?php
			 } else if ($error_id == 14) {
				 ?>
				 <p>The following part(s) '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'eigenschappen')];?>' from the attribute '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'attribute')];?>' is/are incorrect. </p>
				 <?php
			 } else if ($error_id == 15) {
				 ?>
				 <p>Class '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'class')];?>' is missing in the handed in model.</p>
				 <?php
			 } else if ($error_id == 16) {
				 ?>
				 <p>The relation '<?php echo $error[$this->flexi_auth->db_column('checker_error', 'relatie')];?>' is missing in the handed in model. </p>
				 <?php
			} else if ($error_id = 17) {
				?>
				<p>The student handed in his assignment <?php echo $error[$this->flexi_auth->db_column('checker_error', 'eigenschappen')];?> days after the deadline. </p>
				<?php
			}
			echo '<br/><br/>';		
		}
		
	?>	
		
		<h2>Comments</h2>
		 <?php if ($this->flexi_auth->is_admin()) { ?>
		<!--Teacher comment section-->
		<?php echo form_open(); ?>
		<li>
			<label for="comments">Comments:</label>
			<textarea id="comment" name="comment" class="width_400 tooltip_trigger"
				title="Optional comments on the handed in file for the student."><?php echo $comment;?></textarea>
		</li>
		<?php if ($comment == '') { ?>
			<input type="submit" name="add_comment" id="add_comment" value="Add comment" class="button small"/> 
		<?php } else { ?>
			<input type="submit" name="add_comment" id="add_comment" value="Update comment" class="button small"/>
		<?php } ?> 
		<?php echo form_close(); ?>
		<?php } else { ?>
		
		<!--Student comment section-->
		<?php if ($comment == '') {
			echo '<p>The teacher did not make any comments on your assignment.</p>';
		} else {
			echo '<p>'. $comment . '</p>';
		}
		?>
		<?php } ?>
		
	 
	
	
</div> <!-- end large-12 columns -->	
<div class="large-12 columns padding">

	<h2>Checking System</h2>
	
	<?php if (!empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
<?php if(!empty($assignments)) { ?>	
	<h3> Which assignment do you want to check? </h3>
	<?php echo form_open(current_url()); ?> 
	<ul>
		<li>
			<select id="assignments" name="assignment_id" class="tooltip_trigger"
				title="Choose an assignment to check.">
				<?php foreach($assignments as $assignment) { ?>
					<option value="<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>" >
						<?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?>
					</option>
				<?php } ?>
			</select>
		</li>
		<li>
			<br/>
			<input type="submit" name="check_assignment" id="submit" value="Check assignment" class="small button"/>
		</li>
	</ul>
<?php } ?>

<?php if(empty($assignments)) { ?>
	<?php echo "No assignments to be checked"; ?>
<?php } ?>	

</div> <!-- end large 12 columns --> 
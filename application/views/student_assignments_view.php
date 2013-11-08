<div class="large-12 columns padding">

	<h2>Assignments Overview</h2>
	<div class="large-12 columns">
		<div class="large-6 columms">
		<h3>Upload assignment</h3>
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>

		<?php print_r($error);?>

		<?php echo form_open_multipart('assignments/do_upload');?>
		
		
		<div class="large-6 columns">
			<h3>Upload Assignment</h3>
				<?php
				$form_name = array('name' => 'deadline');
				echo form_open(current_url(), $form_name);	?>

				<ul>
					<li>
						
						<table>

						<table style="width: 300px;">
							<thead>
								<tr>
									<th class="tooltip_trigger"
										title="The time of the deadline"/>
										Deadline Time
									</th>

									<th style="text-align:right;" class="spacer_150 align_ctr tooltip_trigger"

										title="If checked, the deadline will be for this assignment."/>
										Select deadline
									</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($deadlines as $deadline) { ?>
								<tr>
									<td>
										<input type="hidden" name="add[<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>][id]" value="<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>"/>
										<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'enddate')];?>
									</td>
									
									<td class="align_ctr">

										<?php 
											// Define form input values.
											$current_status = 0; 
											$new_status = NULL;
										?>
										<input type="hidden" name="add[<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>][current_status]" value="<?php echo $current_status ?>"/>
										<input type="hidden" name="add[<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>][new_status]" value="0"/>
										
										<input style="float:right;" type="checkbox" name="add[<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>][new_status]" value="1" <?php echo $new_status ?>/>

									</td>
								</tr>
							<?php } ?>
							</tbody>
							</table>				
					</li> 
					<input type="file" name="userfile" size="20" />									 
					<li>
					<input type="submit" name="add_deadline" id="add_deadline" value="Add Deadline" class="small button"/>
					</li>
				</ul>
				<?php echo form_close();?>
			</div><!--large-6 columns -->
		</div>


</div> <!-- end large 12 columns --> 
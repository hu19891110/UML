<?php  { ?>
<!-- main content -->
<div class="large-12 columns">
	
	<div class="h2bg">
	<h2>Archive</h2>
	<h4>View archived assignments</h4>
	</div>	
	
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
		
		<?php echo form_open(); ?>
		<table class="tablesorter">
			<thead>
			<tr>
			<th>Assignment</th>
			<th>Deadline of assignment</th>
			<th>View details</th>
			<th>View grades</th>
			</tr>
			</thead>
			<tbody>
		
			<?php 
			foreach ($assignments as $assignment)
			{ ?>
			<tr>
				<td><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></td>
				<td>
					<?php  
					$enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
					echo date_format($enddate, 'd-m-Y H:i');
					?>
				</td>
				<td> <a href="<?php echo $base_url . 'dashboard/assignment/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">View details</a> </td>
				<td> <a href="<?php echo $base_url . 'dashboard/grade_overview/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">View grades</a> </td>	  			
				
				
			</tr>	
			<?php } ?>	
			
			</tbody>
		</table>
		
		<?php echo form_close(); ?>
		</div>
		</div> 
</div>
<?php } ?>
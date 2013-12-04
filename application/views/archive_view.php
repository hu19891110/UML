<!--<?php if ($this->flexi_auth->is_admin()) { ?>-->
<!-- main content -->
<div class="large-12 columns padding">
	
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
			<th></th>
			<th></th>
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
				<td> <a href="<?php echo $base_url . 'dashboard/archive_assignment/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">View details</a> </td>
				<td> <a href="<?php echo $base_url . 'dashboard/grade_overview/'. $assignment[$this->flexi_auth->db_column('assignment', 'id')];?>">View grades</a> </td>	  			
				</td>
				
			</tr>	
			<?php } ?>	
			
			</tbody>
		</table>
		
		<?php echo form_close(); ?>
		</div>
		</div> 
</div>
<?php } ?>
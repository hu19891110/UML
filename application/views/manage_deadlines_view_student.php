<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
<h2>View deadlines</h2> 
			
				<?php echo form_open(current_url()); ?>
				<table id="asstocheck" class="large-5 columns" style="max-width:800px;">
  				<thead>
    				<tr>
      			<th colspan="2" style="text-align: center;">Upcoming deadlines</th>
    				</tr>
  				</thead>
  				<tbody>
  				<tr>
      			<th>Deadline</th>
      			<th>Date of deadline</th>
    			</tr>
      			<?php 
      			foreach ($deadlines as $deadline)
      			{ ?>
      			<tr>
	      			<td><input type="hidden" name="delete[<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>][id]" value="<?php echo $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>"/>
	      			<a href="<?php echo $base_url . 'dashboard/deadline/'. $deadline[$this->flexi_auth->db_column('deadline', 'id')];?>"><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'desc')];?></a></td>
	      			<td><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'enddate')];?></td>
	      		
	      			<?php 
					}
					?>
	      			
	      		
      			</tbody>
      			<tfoot>
      			
      			</tfoot>
				</table>
				<?php echo form_close(); ?>
										
				
		</div> <!-- end 12 columns --> 		

<div class="large-12 columns">

<h2>Substraction overview </h2>
<?php if(isset($id)){?>
						<?php echo form_open(current_url());	?>  	
					<div class="w100 frame">
						<ul>
							<li><strong>Edit the substraction for: </strong><i><?php echo $edit->ue_desc;?></i></li>
							<li class="info_req">
								<label for="substraction">New substraction</label>
								<input type="text" id="substraction" name="substraction" value="<?php echo $edit->ue_error_value; ?>"/>
							</li>
							<li>
								<input type="submit" name="change_password" id="submit" value="Save" class="button small"/>
							</li>
						</ul>
					</div>
				<?php echo form_close(); }?>

<table style="width: 1000px;" class="assignmentstudents responsive">
				<thead>
				<tr>
					<th>Name </th>	
					<th>Description </th>
					<th>Substraction </th>
					<th> </th>
				</tr>
				</thead>
					<tbody>
					<?php 
					 if ($substraction->num_rows() > 0) { ?>
					<?php foreach ($substraction->result() as $substract) { ?> 
								<tr>
									<td><?php echo $substract->ue_name; ?></td>
									<td><?php echo $substract->ue_desc; ?></td>
									<td><?php echo $substract->ue_error_value; ?></td>
									<td><a href="<?php echo base_url();?>dashboard/change_substraction/<?php echo $substract->ue_id;?>"> edit </a></td>
								</tr>
							
								<?php }  } 
						else { ?>
								<tr>
									<td colspan="7" class="highlight_red">
										No grades are available.
									</td>
								</tr>
							
						<?php } ?>
						</tbody>
						
					</table>
					
						
</div>
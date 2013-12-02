<!-- main content -->
<div class="large-12 columns">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
		
				<div class="h2bg" style="height: 70px !important;">
					<h2><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></h2>
					<h4>Assignment details</h4>
				</div>
				
				<h3> Description: </h3><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'desc')];?>
				<h3> Date of deadline: </h3> 
					<?php $enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      		echo date_format($enddate, 'd-m-Y H:i'); ?>
									


</div> <!-- end 12 columns --> 
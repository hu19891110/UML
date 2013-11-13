<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
		
				
				<h3><?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?></h3>
				<p> <?php echo $assignment[$this->flexi_auth->db_column('assignment', 'desc')];?> </p>
				<p> Enddate and time: <?php echo $assignment[$this->flexi_auth->db_column('assignment', 'enddate')];?></p>
									


</div> <!-- end 12 columns --> 
<!-- main content -->
<div class="large-12 columns padding">
	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
		
				
				<h3><?php echo $deadline[$this->flexi_auth->db_column('deadline', 'desc')];?></h3>
				
				<p> Enddate and time: <?php echo $deadline[$this->flexi_auth->db_column('deadline', 'enddate')];?></p>
									


</div> <!-- end 12 columns --> 
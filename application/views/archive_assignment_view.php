<?php if ($this->flexi_auth->is_admin()) { ?>

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
				<h3> Description of the assignment:</h3> <?php echo $assignment[$this->flexi_auth->db_column('assignment', 'desc')];?> 
				
				<h3>Date of deadline:</h3>
					<?php  
	      			$enddate = date_create( $assignment[$this->flexi_auth->db_column('assignment', 'enddate')] );
	      			echo date_format($enddate, 'd-m-Y H:i');
	      		?>
				
				<h3>Assignment classes: </h3>
				<?php 
				
					$i = 0;
					$numItems = count($assignment_classes);
					
					foreach ($assignment_classes as $assignment_class) {
						$class_id = $assignment_class;
						$class_name = $this->flexi_auth->get_classname_for_class_id($class_id);
						
						$i++;
						
						if ($i == $numItems)
							echo $class_name, '. ';	
						else
							echo $class_name, ', ';
					}	
	?>
	<a class="button small" href="<?php echo $base_url.'dashboard/archive' ?>">Back</a>	
</div> <!-- end 12 columns --> 

<?php } ?>
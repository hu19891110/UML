<html>
<body>
	<!-- Include head -->
	<?php $this->load->view('includes/head'); ?>
	<!-- Include header -->
	<?php //$this->load->library('flexi_auth');
		  if (!$this->flexi_auth->is_admin()) { 
			  $this->load->view('includes/header-student'); 
		  } else {
			  $this->load->view('includes/header-teacher');
		  } ?>
	
	<!-- Main content komt hier -->
	<?php echo $maincontent ?>
	
	<!-- Include footer -->
	<?php $this->load->view('includes/footer'); ?>
</body>
</html>
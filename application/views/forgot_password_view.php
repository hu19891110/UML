<html>
<head>
	<meta name="robots" content="index, follow"/>
	<meta name="designer" content="Five-IT"/> 
	<meta name="copyright" content="Copyright <?php echo date('Y');?> Five-IT, All rights Reserved"/>
	<meta http-equiv="imagetoolbar" content="no"/>	
	
	<link rel="stylesheet" href="<?php echo $includes_dir;?>css/login.css?v=1.0">
</head>
	
<body>	
	<!-- Main Content -->
			<div id="loginbox">
				<div id="titlebox"><h2>Forgot password</h2></div>
				<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<div class="w100 frame">
						<ul>
							<li class="info_req">
								<label for="identity">Email or Username:</label>
								<input type="text" id="identity" name="forgot_password_identity" value="" class="tooltip_trigger"
									title="Please enter either your email address or username defined during registration."
								/>
							</li>
							<li>
								<label for="submit">Send Email:</label>
								<input type="submit" name="send_forgotten_password" id="submit" value="Submit" class="link_button large"/>
			
							</li>
						</ul>
					</div>	
				<?php echo form_close();?>
	</div> <!-- einde loginbox --> 
<body>
</html>	


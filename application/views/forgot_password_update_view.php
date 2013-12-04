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
							<li>
								<small>
									Password length must be more than <?php echo $this->flexi_auth->min_password_length(); ?> characters in length.<br/>
									Only alpha-numeric, dashes, underscores, periods and comma characters are allowed.
								</small> <br/><br/>
							</li>
							<li class="info_req">
								<label for="new_password">New Password:</label> <br/>
								<input class="forgot" type="password" id="new_password" name="new_password" value=""/>
							</li>
							<li class="info_req">
								<label for="confirm_new_password">Confirm New Password:</label>
								<input class="forgot" type="password" id="confirm_new_password" name="confirm_new_password" value=""/>
							</li>
							<li class="info_req">
								<input type="submit" name="change_forgotten_password" id="submit" value="Submit" class="link_button large"/>
							</li>
						</ul>
					</div>
				<?php echo form_close();?>
			
	</div> <!-- einde loginbox --> 
<body>
</html>	



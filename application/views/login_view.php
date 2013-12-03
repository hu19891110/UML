<!DOCTYPE html>

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
				<div id="titlebox"><h2>Login</h2></div>
	
			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>
				<div class="loginform">
				<?php echo form_open(current_url(), 'class="parallel"');?>  	
						<ul class="loginform">
							<li>
								<label for="identity">Username:</label><br>
								<input type="text" class="username" id="identity" name="login_identity" value="<?php echo set_value('login_identity', '');?>" class="tooltip_parent"/>
							</li>
							<li>
								<label for="password">Password:</label><br>
								<input type="password" class="password" id="password" name="login_password" value="<?php echo set_value('login_password', '');?>"/>
							</li>
							<div class="captcha">
						<?php 
							if (isset($captcha)) 
							{ 
								echo "<li>\n";
								echo $captcha;
								echo "</li>\n";
							}
						?>
					</div>
							<li>
								<!-- <label for="submit">Login:</label> -->
								<input type="submit" name="login_user" id="submit" value="Sign in" class="link_button large"/>
							</li>
						</ul>
										<div class="forgotpassword"> <a href="<?php echo $base_url . 'login/forgotten_password'?>">Lost your password?</a></div>

				<?php echo form_close();?>
	</div> <!-- einde loginbox --> 
<body>
</html>	
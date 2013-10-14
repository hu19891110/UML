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
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
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
						<?php 
							/*
							# Below are 2 examples, the first shows how to implement 'reCaptcha' (By Google - http://www.google.com/recaptcha),
							# the second shows 'math_captcha' - a simple math question based captcha that is native to the flexi auth library. 
							# This example is setup to use reCaptcha by default, if using math_captcha, ensure the 'auth' controller and 'demo_auth_model' are updated.
						
							# reCAPTCHA Example
							# To activate reCAPTCHA, ensure the 'if' statement immediately below is uncommented and then comment out the math captcha 'if' statement further below.
			 				# You will also need to enable the recaptcha examples in 'controllers/auth.php', and 'models/demo_auth_model.php'.
							#
							*/
							
							if (isset($captcha)) 
							{ 
								echo "<li>\n";
								echo $captcha;
								echo "</li>\n";
							}
							
							/* math_captcha Example
							# To activate math_captcha, ensure the 'if' statement immediately below is uncommented and then comment out the reCAPTCHA 'if' statement just above.
							# You will also need to enable the math_captcha examples in 'controllers/auth.php', and 'models/demo_auth_model.php'.
							if (isset($captcha))
							{
								echo "<li>\n";
								echo "<label for=\"captcha\">Captcha Question:</label>\n";
								echo $captcha.' = <input type="text" id="captcha" name="login_captcha" class="width_50"/>'."\n";
								echo "</li>\n";
							}
							#*/
						?>
							<li>
								<input type="checkbox" id="remember_me" name="remember_me" value="1" <?php echo set_checkbox('remember_me', 1); ?>/>
								<label for="remember_me">Remember Me</label>
							</li>
							<li>
								<!-- <label for="submit">Login:</label> -->
								<input type="submit" name="login_user" id="submit" value="Sign in" class="link_button large"/>
							</li>
						</ul>
				<?php echo form_close();?>
				<div class="forgotpassword"><a href="<?php echo site_url('') ?>">Lost your password?</a></div>
			
			
			</div>
		</div>
	</div>
<body>
</html>	
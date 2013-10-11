<html>
<body>

	<?php if (! empty($message)) { ?>
		<div id="message">
			<?php echo $message; ?>
		</div>
	<?php } ?>
	
	
<h1>Teacher Dashboard</h1>

<a href="<?php echo site_url('register') ?>">Register new student</a>
<a href="<?php echo site_url('logout') ?>">Logout</a>
<a href="<?php echo site_url('dashboard/manage_user_accounts') ?>">View all users</a>

</body>
</html>	
	
	

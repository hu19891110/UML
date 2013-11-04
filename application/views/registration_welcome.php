<html>
<head>
	<meta charset="utf-8" />
	<meta name="robots" content="index, follow"/>
	<meta name="designer" content="Five-IT"/> 
	<meta name="copyright" content="Copyright <?php echo date('Y');?> Five-IT, All rights Reserved"/>
	<meta http-equiv="imagetoolbar" content="no"/>	
	<meta name="viewport" content="width=device-width">
	<title> UML Checker </title>
	
	<link rel="stylesheet" href="<?php echo $includes_dir;?>Foundation/css/foundation.css">
	<link rel="stylesheet" href="<?php echo $includes_dir;?>Foundation/css/normalize.css">
	<link rel="stylesheet" href="<?php echo $includes_dir;?>css/style-email.css">
	<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>	
</head>


<body id="email">

	<div class="large-12 columns padding">
		<div class="header">
 			<h1 class="email"> <span class="UML">UML</span> CHECKER</h1>
		</div> <!-- end header --> 
	

		<p>Dear Thomas,<!-- <?php echo $name ?> --></p>
	
		<p>You have been registered at UMLchecker.</p>
	
		<p>Your login identity is: <span style="font-weight:bold"> ThomasPrikkel<!-- <?php echo $identity;?> --> </span> </p>
		<p>Your password is: <span style="font-weight:bold"> Dusdat <!-- <?php echo $password;?> --> </span> </p>
	
		<p><small>This password will need to be changed the first time you log in.</small></p>
	
		<p>Kind regards, </p>
	
		<p>UMLchecker staff</p>
	</div>
</body>
</html>
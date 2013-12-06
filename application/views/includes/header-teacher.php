<body>
<!-- Begin header -->
<div class="header_wrapper">
	<div class="header">
	
		<div class="row">
 			 <div class="large-9 columns">
 			 	<h1> <span class="UML">UML</span> CHECKER</h1>
 			 	<h2>check your UML files</h2>
 			 </div>
 			 <div class="large-3 columns koptekst">
 			 	<span> Welcome <a href="<?php echo $base_url;?>dashboard/update_user_account/<?php echo $currentuser['uacc_id']; ?>"> <?php echo $currentuser['upro_first_name'].' '.$currentuser['upro_last_name']; ?></a></span> <br/> <br/>
 			 	<a href="<?php echo site_url('logout') ?>">Logout</a> 

 			 </div>
		</div> <!-- end row -->

	</div> <!-- end header --> 
	
</div>
<!-- end header wrapper -->
	
<div id="container">	
	<div class="row">
		<nav class="top-bar">

		<section class="top-bar-section">
    		<!-- Left Nav Section -->
    		<ul class="left">
			<li class="divider"></li>
      	<li><a href="<?php echo site_url('dashboard') ?>">Dashboard</a></li>
      	<li class="divider"></li>
      	<li><a href="<?php echo site_url('dashboard/classes') ?>">Classes</a></li>
     		<li class="divider"></li>
      	<li><a href="<?php echo site_url('dashboard/users') ?>">Students</a></li>
      	<li class="divider"></li>
      	<li><a href="<?php echo site_url('dashboard/assignments') ?>">Assignments</a></li>
    </ul>

    <!-- Right Nav Section -->
    <ul class="right">
      <li class="divider hide-for-small"></li>
      <li class="divider"></li>
      <li><a href="<?php echo site_url('dashboard/archive') ?>">Archive</a></li>
      <li class="divider"></li>
    	<li><a href="<?php echo $base_url;?>dashboard/update_user_account/<?php echo $currentuser['uacc_id']; ?>">User Details</a></li>
      <li class="divider"></li>
      
     </ul>
    <!-- end right nav section -->
  </section>
</nav>


	
	
	
	
	
	

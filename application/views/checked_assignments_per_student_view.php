<div class="large-12 columns">

	<div class="h2bg">
	<h2> Student <!-- <?php echo $user['uacc_username'];?> --> </h2>
	<h4> Assignment Software Engineering <!-- <?php echo $assignment[$this->flexi_auth->db_column('assignment', 'name')];?> --> 	
		<span style="clear:both; float:right;"> Alles goedkeuren | Alles afkeuren </span>
	</h4>
	</div> <!-- end h2bg --> 
	
	<p> <b> Line 15:</b> The name of the class should be 'student' in stead of 'students' <br/>
	<small> For this mistake 1 point is substracted </small>
	</p>
	
	<p> <b> Line 19:</b> The attribute of the class Student should be 'name' in stead of 'id' <br/>
	<small> For this mistake 2 points are substracted </small>
	</p>
	
	<p> <b> Line 20:</b> The method of the class Mario should be 'getDirection(position)' in stead of 'getDirection()' <br/>
	<small> For this mistake 2 points are substracted </small>
	</p>
	
	<!-- 
	<a style="clear: both; float: left;" 
	href="<?php echo $base_url.'dashboard/handedin_assignments_per_student/'
	.$assignment[$this->flexi_auth->db_column('assignment', 'id')];?>"> Back to all assignments of the student</a>
	-->
	
</div> <!-- end large-12 columns -->	
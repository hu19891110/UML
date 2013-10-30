	</div> <!-- end row (uit header)-->
</div> <!-- end main content/container (uit header) -->


<!-- begin footer -->
<div class="footer_wrapper">
	<div class="footer">

		<p>   </p>

	</div>
</div>
<!-- end footer -->
</body>
</html>

 <script>
  document.write('<script src=' +
  ('__proto__' in {} ? '<?php echo $includes_dir;?>Foundation/js/vendor/zepto' : '<?php echo $includes_dir;?>Foundation/js/vendor/jquery') +
  '.js><\/script>')
  </script>
  
  <script type="text/javascript">
$('#passwordcheckbox').change(function(){
    if ($('#passwordcheckbox').is(':checked') == true){
      $('#password').prop('disabled', true);
      $('#confirm_password').prop('disabled', true);
      console.log('checked');
   } else {
     $('#password').prop('disabled', false);
     $('#confirm_password').prop('disabled', false);
     console.log('unchecked');
   }

});
</script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation.min.js"></script>
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.topbar.js"></script>
  <!--
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.interchange.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.abide.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.dropdown.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.placeholder.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.forms.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.alerts.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.magellan.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.reveal.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.tooltips.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.clearing.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.cookie.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.joyride.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.orbit.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.section.js"></script>
  
  <script src="<?php echo $includes_dir;?>Foundation/js/foundation/foundation.topbar.js"></script>
  
  -->
  
  <script>
    $(document).foundation();
  </script>
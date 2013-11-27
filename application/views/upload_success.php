<div class="large-12 columns padding">

<title>Upload Form</title>

<h3>Your file was successfully uploaded!</h3>
 
<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>

<p><?php echo anchor('assignments', 'Upload Another File!'); ?></p>

<div class="large-12 columns padding">
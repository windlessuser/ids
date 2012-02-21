<div id="zone_form" class="form">


    <?php 
	echo form_open('zone/add_zone');
	echo form_input('zone', 'Kingston');
	echo form_submit('submit', 'Add');
	echo form_close();
	?>

</div><!-- end zone_form-->

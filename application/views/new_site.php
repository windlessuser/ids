<?php echo validation_errors(); 
      if(isset($error)) echo $error;
?>
<div id="new_site_form" class="form">
	<h1>Enter new Site</h1>	
	<?php	echo form_open('new_site/site_name/');
                echo '<p> Name: </p>';
		echo form_input('name', 'Name');
		$options = array(
                  'poi'  => 'Point of Interest',
                  'diner'=> 'Dining and Nightlife area',
                  'shop' => 'Shopping and Entertianment area'
                );
        echo '<p> Type: </p>';
		echo form_dropdown('type', $options, 'poi');
        echo '<p>Rank: </p>';
		echo form_input('rank', '99');
		echo form_submit('submit', 'Next');
		echo form_close();
	?>
</div>



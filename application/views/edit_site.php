<?php echo validation_errors(); 
      if(isset($error)) echo $error;
?>
<div id="new_site_form" class="form">
	<h1>Edit Site Name and Rank</h1>	
	<?php echo form_open('edit_site/site_name/'.$site['id']);
        echo '<p> Name: </p>';
		echo form_input('name', $site['name']) . form_checkbox('ignore_name', 'yes', FALSE) . ' ignore';
        echo '<p> Rank: </p>';
		echo form_input('rank', $site['rank']) . form_checkbox('ignore_rank', 'yes', FALSE) . ' ignore';
		echo form_submit('submit', 'Next');
		echo form_close();
	?>
</div>



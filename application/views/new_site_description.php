<div id="description_form" class="form">
	<h1>Enter Description</h1>	
	<?php	echo form_open('new_site/description');
		echo form_textarea('description','Description goes here',150,300);
        echo '<p> Type: </p>';
		if(strcasecmp($site['type'],'shop') == 0){
			$options = array();
			foreach($categories as $row){
				$options[$row->name] = $row->name;
			}
			echo form_dropdown('type', $options, 'Books and Stationary');
		}
		else
			echo form_input('type','Bar');
		echo form_submit('submit', 'Next');
		echo form_close();
	?>
</div>

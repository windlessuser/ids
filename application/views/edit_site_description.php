<div id="description_form" class="form">
	<h1>Enter Description</h1>	
	<?php	echo form_open('edit_site/description/'.$site['id']);
		echo form_textarea('description',$site['description'],150,300) . form_checkbox('ignore_desc', 'yes', FALSE) . ' ignore';
                echo '<p> Type: </p>';
		echo form_input('sub_type',$site['sub_type']) . form_checkbox('ignore_sub', 'yes', FALSE) . ' ignore';
		echo form_hidden('type',$site['type']);
		echo form_submit('submit', 'Next');
		echo form_close();
	?>
</div>

<div id="image_form" class="form">
	<h1>Enter image</h1>	
	<?php	echo form_open_multipart('edit_site/image/'.$site['id']) ;
		echo form_upload('image'). form_checkbox('ignore', 'yes', FALSE) . ' ignore';
		echo form_submit('submit', 'Next');
		echo form_close();
	?>
        
        <?php if(isset($error)) echo $error;?>
</div>

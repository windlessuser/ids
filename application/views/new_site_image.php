<div id="image_form" class="form">
	<h1>Enter image</h1>	
	<?php	echo form_open_multipart('new_site/image');
		echo form_upload('image');
		echo form_submit('submit', 'Next');
		echo form_close();
	?>
        
        <?php if(isset($error)) echo $error;?>
</div>

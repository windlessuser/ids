<?php
	echo '<h1> Enter a New Company </hi>';
	echo form_open('event/add_company_commit');
	echo form_fieldset('Name');
	echo form_input('name','Name');
	echo form_fieldset_close();
	echo form_submit('submit','Submit');
	echo form_close();
?>
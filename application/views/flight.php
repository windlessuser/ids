<?php
	if(isset($feed)){ 
		$this->output->set_header('content-type:text/xml');
		echo $feed;
	}
	else
		$this->flight_model->print_instructions();
?>
<?php 
$this->table->set_heading('ID','Zone','remove');
if(isset($zones)){
	foreach($zones as $zone){
		$this->table->add_row(anchor(site_url("zone/change_zone/$zone->id"),$zone->id),anchor(site_url("zone/change_zone/$zone->id"),$zone->name),anchor(site_url("zone/remove_zone/$zone->id"),'X'));
	}
}
 echo $this->table->generate();
?>

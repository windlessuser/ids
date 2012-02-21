<?php
 $this->table->set_heading('ID', 'NAME','TOP TEN MAP','Point of Interests','Dining and Nightlife','Shoping and Transportation','EDIT','REMOVE');
 if(isset($host_table)){
     foreach($host_table->result() as $row){
         $this->table->add_row(anchor(site_url("site/site_table/$row->id"),$row->id),anchor(site_url("edit_host/index/$row->id"),$row->name),anchor(site_url("site/top_ten_map/$row->id"),'Map'),anchor(site_url("poi/site_table/$row->id"),'table'),anchor(site_url("diner/site_table/$row->id"),'table'),anchor(site_url("shop/site_table/$row->id"),'table'),anchor(site_url("edit_host/index/$row->id"),'edit'),anchor(site_url("host/delete_host/$row->id"),'X'));
     }
 }
 echo $this->table->generate();
?>

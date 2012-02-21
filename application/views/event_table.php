<?php
 $this->table->set_heading('ID','date', 'start','end','event','location','company','edit','remove');
 if(isset($events)){
     foreach($events->result() as $row){
         $this->table->add_row($row->id,$row->date,$row->start,$row->end,$row->event,$row->location,$row->company,anchor(site_url("event/edit/$row->id"),'edit'),anchor(site_url("event/remove/$row->id"),'CANCEL'));
     }
 }
 echo $this->table->generate();
?>

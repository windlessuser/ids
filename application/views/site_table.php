<?php
 $this->table->set_heading('RANK', 'NAME','TIMES ACCESSED','EDIT','REMOVE');
 if(isset($site_table)){
     foreach($site_table->result() as $row){
         $this->table->add_row(anchor(site_url("site/index/$host/1/$row->rank"),$row->rank),anchor(site_url("site/index/$host/1/$row->rank"),$row->name),anchor(site_url("site/index/$host/1/$row->rank"),$row->count),anchor(site_url("edit_site/index/$row->id"),'edit'),anchor(site_url("site/delete_site/$host/$row->id"),'X'));
     }
 }
 echo $this->table->generate();
?>

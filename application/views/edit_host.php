<?php
    if(isset($map))
        $frame_map = $map;
    else
        $frame_map = $home;
        ?>
<div id ="address" class="form">
<h1>Enter Address</h1>
<img src="<?php echo $frame_map; ?>" width="500" height="500" />
    <?php 
	echo form_open('edit_host/conf_host_map/' .$id);
        echo '<p> Name: </p>';
        $name = $old_host['name'];
	echo form_input('name',$name);
        echo '<p> Address: </p>';
	echo form_input('address', $old_host['full']);
        $options = array(
            '13' => 13,
            '14' => 14,
            '15' => 15,
            '16' => 16,
            '17' => 17,
            '18' => 18
        );
        echo '<p> Zoom </p>' . form_dropdown('zoom',$options,'15');
	echo form_submit('submit', 'Get Map');
	echo form_close();
        if(isset($map)){
            echo form_open('edit_host/update_host/'.$id);	
            echo 'Map information is correct: ';
            echo form_checkbox('yes', 'yes', FALSE);
            echo form_hidden('host',$old_host);
            echo form_submit('submit', 'Proceed');
            echo form_close();
        }
	?>
</div>
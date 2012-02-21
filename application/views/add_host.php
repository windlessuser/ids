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
	echo form_open('host/conf_host_map');
        echo '<p> Name: </p>';
        $host = $this->session->userdata('new_host');
        if(isset($host['name']))
            $name = $host['name'];
        else
            $name = 'Name';
	echo form_input('name',$name);
        echo '<p> Address: </p>';
	echo form_input('address', 'Swallowfield Rd,Kingston,St Andrew Parish,Jamaica');
        $options = array(
            '13' => 13,
            '14' => 14,
            '15' => 15,
            '16' => 16,
            '17' => 17,
            '18' => 18
        );
        echo '<p> Zoom </p>' . form_dropdown('zoom',$options,'13');
	echo form_submit('submit', 'Get Map');
	echo form_close();
        if(isset($map)){
            echo form_open('host/insert_host');	
            echo 'Map information is correct: ';
            echo form_checkbox('yes', 'yes', FALSE);
            echo form_submit('submit', 'Proceed');
            echo form_close();
        }
	?>
</div>
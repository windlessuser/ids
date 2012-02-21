<?php $new_site = $this->session->userdata('new_site');
    if(isset($new_site['map']))
        $frame_map = $new_site['map'];
    else
        $frame_map = $home;
        ?>
<div id ="address" class="form">
<h1>Enter Address</h1>
<img src="<?php echo $frame_map; ?>" width="400" height="300" />
    <?php 
	echo form_open('new_site/get_map');
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
            echo form_open('new_site/conf_map');
            echo 'Map information is correct: ';
            echo form_checkbox('yes', 'yes', FALSE);
            echo form_hidden('map', $map);
            echo form_submit('submit', 'Proceed');
            echo form_close();
        }
	?>
</div>

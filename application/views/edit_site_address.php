<?php 
    if(isset($site['map']))
        $frame_map = $site['map'];
    else
        $frame_map = $home;
        ?>
<div id ="address" class="form">
<h1>Enter Address</h1>
<img src="<?php echo $frame_map; ?>" width="400" height="300"/>
    <?php 
	echo form_open('edit_site/get_map/'.$site['id']);
	echo form_input('address', $site['full'])  . form_checkbox('ignore', 'yes', FALSE) . ' ignore';
        $options = array(
            '13' => 13,
            '14' => 14,
            '15' => 15,
            '16' => 16,
            '17' => 17,
            '18' => 18
        );
        echo "<p> Zoom </p>" . form_dropdown('zoom',$options,'13');
	echo form_submit('submit', 'Get Map');
	echo form_close();
        if(isset($map)){
            echo form_open('edit_site/conf_map/'.$site['id']);
            echo 'Map information is correct: ';
            echo form_checkbox('yes', 'yes', FALSE);
            echo form_hidden('map', $map);
	    echo form_hidden('site',$site);
            echo form_submit('submit', 'Proceed');
            echo form_close();
        }
	?>
</div>

<ol>
	<?php foreach($categories as $row): ?>
		<li> <?php echo anchor(site_url("shop/cats/$row->id/1"),$row->name);?></li>
	<?php endforeach;?>
</ol>
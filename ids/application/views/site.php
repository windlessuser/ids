<table>
	<row>
<?php 
if(isset($sites)):
	foreach($sites as $site):
?>
	<title><?php echo $site->title;?></title>
	<link><?php echo $site->url;?></link>
	<description><?php echo $site->description;?></description>
	<image><?php echo $site->images;?></image>
	<rank><?php echo $site->rank;?></rank>
	<?php endforeach; else: ?>
	<title><?php echo $site->title;?></title>
	<link><?php echo $site->url;?></link>
	<description><?php echo $site->description;?></description>
	<image><?php echo $site->images;?></image>
	<rank><?php echo $site->rank;?></rank>
	<?php endif; ?>
	</row>
</table>



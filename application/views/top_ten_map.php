<?php 
header('content-type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
?>
<table>
	<row>
		<map>
			<?php echo str_replace('&',"&amp;",$map); ?> 
		</map>
	</row>
</table>
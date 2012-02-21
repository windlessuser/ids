<?php 
header('content-type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
?>
<table>	
<?php
if(isset($sites)):
	foreach($sites->result() as $site):
?>
	<row>
		<title><?php echo str_replace("&", '&amp;',xmlentities($site->name));?></title>
		<image><?php echo $site->images;?></image>
		<rank><?php echo $site->rank;?></rank>
		<?php if(isset($limit) && $limit == 1): ?>
		<link><?php echo $site->url;?></link>
		<description><?php echo str_replace("&", '&amp;',xmlentities($site->description));?></description>
		<map><?php echo str_replace("&", '&amp;',xmlentities($site->map));?></map>
		<street><?php echo $site->street;?></street>
		<town><?php echo $site->town; ?></town>
		<district><?php echo $site->district; ?></district>
		<parish><?php echo xmlentities($site->parish); ?></parish>
        <address><?php echo str_replace("&", '&amp;',xmlentities($site->full)); ?></address>
        <open><?php echo $site->open; ?></open>
        <close><?php echo $site->close; ?></close>
        <phone><?php echo $site->phone; ?></phone>
        <email><?php echo $site->email; ?></email>
		<?php endif;?>	
	</row>
		<?php endforeach; unset($site); endif; if(isset($site)): ?>
	<row>
		<title><?php echo str_replace("&", '&amp;',xmlentities($site['name']));?></title>
		<image><?php echo $site['images'];?></image>
		<rank><?php echo $site['rank'];?></rank>
		<?php if(isset($limit) && $limit == 1): ?>
		<link><?php echo $site['url'];?></link>
		<description><?php echo str_replace("&", '&amp;',xmlentities($site['description']));?></description>
		<street><?php echo $site['street'];?></street>
		<town><?php echo $site['town']; ?></town>
		<district><?php echo $site['district']; ?></district>
		<parish><?php echo str_replace("&", '&amp;',xmlentities($site['parish'])); ?></parish>
        <address><?php echo str_replace("&", '&amp;',xmlentities($site['full'])); ?></address>
        <map><?php echo str_replace("&", '&amp;',xmlentities($site['map'])); ?></map>
        <open><?php echo $site['open']; ?></open>
        <close><?php echo $site['close']; ?></close>
        <phone><?php echo $site['phone']; ?></phone>
        <email><?php echo $site['email']; ?></email>
		<?php endif;?>	
	</row>
	<?php elseif(!isset($sites)):?>
	<row>
		<title></title>
		<image></image>
		<rank></rank>
		<?php if(isset($limit) && $limit == 1): ?>
		<description></description>
		<link></link>
		<street></street>
		<town></town>
		<district></district>
		<parish></parish>
        <address></address>
		<map></map>
		<open></open>
        <close></close>
        <phone></phone>
        <email></email>
		<?php endif;?>	
	</row>
	<?php endif;?>
</table>



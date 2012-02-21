<?php 
header('content-type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
?>
<table>
    <?php 
        if(isset($events)):
            foreach($events->result() as $event):      
    ?>
    <row>
    	<date><?php echo $event->date; ?></date>
        <start><?php echo $event->start;?> </start>
        <end><?php echo $event->end; ?></end>
        <event><?php echo $event->event; ?></event>
        <location><?php echo $event->location; ?></location>
        <company><?php echo $event->company; ?></company>
    </row>
    <?php 
            endforeach;
        else:
    ?>
    <row>
    	<date></date>
        <start></start>
        <end></end>
        <event></event>
        <location></location>
        <company></company>
    </row>
    <?php
        endif;
    ?>
</table>
<?php
echo validation_errors();
$day=date("d");
$month=date("m");
$year=date("Y");
$hour=date("h");
$min=date("i");
$am_pm=date("a");
$pm_am=array(1 => "am",2 => "pm");
echo form_open('edit_site/miscelleanous/'.$site['id']);
echo form_fieldset('Open');
echo 'Hour';
        echo '<select name="open_hour">';
        for($i=1;$i<=12;$i++){ if($i==(int)$hour) $tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
echo 'Minute';
        echo '<select name="open_min">';
        for($i=0;$i<=59;$i++){ if($i==(int)$min)$tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
$options = array(
        	'AM'=> 'AM',
        	'PM' => 'PM'
        );
		echo form_dropdown('open_am_pm',$options,'am');
		echo form_checkbox('ignore_open', 'yes', FALSE) . ' ignore';
        echo form_fieldset_close();
echo form_fieldset('Close');
echo 'Hour';
        echo '<select name="close_hour">';
        for($i=1;$i<=12;$i++){ if($i==(int)$hour) $tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
echo 'Minute';
        echo '<select name="close_min">';
        for($i=0;$i<=59;$i++){ if($i==(int)$min)$tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
		echo form_dropdown('close_am_pm',$options,'am');
		echo form_checkbox('ignore_close', 'yes', FALSE) . ' ignore';
        echo form_fieldset_close();
echo form_fieldset('Contact');
echo 'Phone';
echo form_input('phone',$site['phone']) . form_checkbox('ignore_phone', 'yes', FALSE) . ' ignore ';
echo 'email';
echo form_input('email',$site['email']). form_checkbox('ignore_email', 'yes', FALSE) . ' ignore ';
echo 'website url';
echo form_input('url',$site['url']) . form_checkbox('ignore_url', 'yes', FALSE) . ' ignore ';
echo form_fieldset_close();
echo form_submit('submit','Submit');
echo form_close()
?>
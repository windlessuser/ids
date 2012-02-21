<?php
$day=date("d");
$month=date("m");
$year=date("Y");
$hour=date("h");
$min=date("i");
$am_pm=date("a");
$pm_am=array(1 => "am",2 => "pm");
if(isset($event))
    $event = $event->row();
else
    redirect('event/table');
?>


        <?php
        echo form_open('event/edit_commit/'.$event->id);
        echo form_fieldset('Start time');
        echo 'Year';
        echo '<select name="start_year">';
        for($i=$year;$i<=($year+10);$i++){ if($i==(int)$year) $tst=" SELECTED"; else $tst='';
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
        ?>
 
        <?php
        echo 'Month';
        echo '<select name="start_month">';
        for($i=0;$i<=12;$i++){ if($i==(int)$month)$tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
        ?>
 
        <?php
        echo 'Day';
        echo '<select name="start_day">';
        for($i=0;$i<=31;$i++){ if($i==(int)$day)$tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
        ?>
 
        <?php
        echo 'Hour';
        echo '<select name="start_hour">';
        for($i=1;$i<=12;$i++){ if($i==(int)$hour) $tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
        ?>
 
        <?php
        echo 'Minute';
        echo '<select name="start_min">';
        for($i=0;$i<=59;$i++){ if($i==(int)$min)$tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
        ?>
 
        <?php
        $options = array(
        	'AM'=> 'AM',
        	'PM' => 'PM'
        );
		echo form_dropdown('start_am_pm',$options,'am');
        echo form_fieldset_close();
        ?>

        <?php
        echo form_fieldset('End time');
        echo 'Year';
        echo '<select name="end_year">';
        for($i=$year;$i<=($year+10);$i++){ if($i==(int)$year) $tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
        ?>
 
        <?php
        echo 'Month';
        echo '<select name="end_month">';
        for($i=0;$i<=12;$i++){ if($i==(int)$month)$tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
        ?>
 
        <?php
        echo 'Day';
        echo '<select name="end_day">';
        for($i=0;$i<=31;$i++){ if($i==(int)$day)$tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
        ?>
 
        <?php
        echo 'Hour';
        echo '<select name="end_hour">';
        for($i=0;$i<=23;$i++){ if($i==(int)$hour) $tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
        ?>
 
        <?php
        echo 'Minute';
        echo '<select name="end_min">';
        for($i=0;$i<=59;$i++){ if($i==(int)$min)$tst=" SELECTED"; else $tst="";
            echo '<option value="'.$i.'"'.$tst .'>'.$i;
        }
        echo '</select>';
        ?>
 
        <?php
        echo form_dropdown('end_am_pm',$options,'am');
        echo form_fieldset_close();
        ?>

        <?php
            echo form_fieldset('Event');
            echo form_input('event', $event->event);
            echo form_fieldset_close();
        ?>

        <?php
            echo form_fieldset('Location');
            echo form_input('location', $event->location);
            echo form_fieldset_close();
        ?>

        <?php
            echo form_fieldset('Company');
            $options = array();
			foreach($companies->result() as $row){
				$options[$row->name] = $row->name;
			}
			echo form_dropdown('company',$options,$event->company);
            echo form_fieldset_close();
        ?>

        <?php
        echo form_submit('submit', 'Submit');
	echo form_close();
        ?>

<?php
class class_lists extends class_process{
	public function can_apply_on($will_take_effect, $can_apply_on, $can_take_off_on){

	parent::select_settings($will_take_effect, $can_apply_on, $can_take_off_on);
?>
	<ul style = "list-style: none;">
		<?php foreach ($all_week_days AS $can_apply_on){ ?>
			<li><input type = "checkbox" name = "can_apply_on[]" value = "<?php echo $can_apply_on; ?>" id = "1_<?php echo $can_apply_on; ?>" <?php if(in_array($can_apply_on, $arr_can_apply_on)) {echo 'checked';} ?> /><label for = "1_<?php echo $can_apply_on; ?>"><?php echo $can_apply_on; ?></label></li>
		<?php } ?>
	</ul>
<?php
	}
}				
?>
<?php $value = $object->getValue(); ?>
<?php if($context == SD_CONTEXT_EDITING): ?>
	<div class="input-group">
		<select name="<?=$object->getName();?>">
			<option <?=(empty($value)) ? 'selected="selected"' : ''; ?> >empty</option>
			<option <?=($value === 'true') ? 'selected="selected"' : ''; ?> value="true">true</option>
			<option <?=($value === 'false') ? 'selected="selected"' : ''; ?> value="false">false</option>
		</select>
	</div>
<?php else: ?>
	<?php if(empty($value)): ?>
		<p class="empty">empty</p>
	<?php else: ?>
		<?=$value;?>
	<?php endif; ?>
<?php endif; ?>
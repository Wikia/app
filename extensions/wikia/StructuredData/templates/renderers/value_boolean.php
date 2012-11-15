<?php $value = $object->getValue(); ?>
<?php if($context == SD_CONTEXT_EDITING): ?>
	<div class="input-group">
		<select name="<?=$object->getPropertyName();?>">
			<option <?=is_null($value) ? 'selected="selected"' : ''; ?> value="-1">empty</option>
			<option <?=$value  ? 'selected="selected"' : ''; ?> value="1">true</option>
			<option <?=!$value ? 'selected="selected"' : ''; ?> value="0">false</option>
		</select>
	</div>
<?php else: ?>
<?php if(is_null($value)): ?>
		<p class="empty">empty</p>
	<?php else: ?>
		<?=($value?'TRUE':'FALSE');?>
	<?php endif; ?>
<?php endif; ?>
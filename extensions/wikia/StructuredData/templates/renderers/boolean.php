<?php $value = $object->getValue(); ?>
<?php if($context == SD_CONTEXT_EDITING): ?>
	<div class="input-group">
		<input type="checkbox" name="<?=$object->getName();?>" <?=($value == 'true') ?
			'checked="checked"' : ''; ?> />
	</div>
<?php else: ?>
	<?php if(empty($value)): ?>
		<p class="empty">empty</p>
	<?php else: ?>
		<?=$value;?>
	<?php endif; ?>
<?php endif; ?>
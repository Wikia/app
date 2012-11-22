<?php $value = $object->getValue(); ?>
<?php if($context == SD_CONTEXT_EDITING): ?>
	<div class="input-group">
		<?php if ( in_array( $object->getPropertyName(), array('schema:description', 'schema:text') ) ) : ?>
			<textarea name="<?=$object->getPropertyName();?>"><?=$value;?></textarea>
		<?php elseif ($object->getPropertyName() == 'schema:name' && empty($isCreateMode)) : ?>
			<?= $object->getValue();?>
		<?php else : ?>
			<input type="text" value="<?=$value;?>" name="<?=$object->getPropertyName();?>" />
		<?php endif; ?>
	</div>
<?php else: ?>
	<?php if(empty($value)): ?>
		<p class="empty">empty</p>
	<?php else: ?>
		<?=$object->getValue();?>
	<?php endif; ?>
<?php endif; ?>
<? // for K. Drogo: $params['isCreateMode']); ?>

<?php $value = $object->getValue(); ?>
<?php if($context == SD_CONTEXT_EDITING): ?>
	<div class="input-group">
		<?php if ( in_array( $object->getPropertyName(), array('schema:description', 'schema:text') ) ) : ?>
			<textarea name="<?=$object->getPropertyName();?>"><?=$value;?></textarea>
		<?php elseif ($object->getPropertyName() == 'schema:name' && $params['isCreateMode'] === false) : ?>
			<?= $object->getValue();?>
			<input type="hidden" value="<?=$value;?>" name="<?php echo isset($params['fieldName']) ? $params['fieldName'] : $object->getPropertyName() ;?>" />
		<?php elseif ( !is_object( $value ) ) : ?>
			<input type="text" value="<?=$value;?>" name="<?php echo isset($params['fieldName']) ? $params['fieldName'] : $object->getPropertyName() ;?>" />
			<?php if ($object->getType()->isCollection()) : ?>
				<button class="secondary remove"><?= wfMsg('structureddata-object-edit-remove-reference') ?></button>
			<?php endif; ?>
		<?php elseif ( isset( $value->id ) && ( !empty( $value->id ) ) ) : ?>
			<input type="hidden" name="<?=$params['fieldName'];?>" value="<?=$value->id;?>" />
			<?php if ($object->getType()->isCollection()) : ?>
				<?=$value->id;?>
				<button class="secondary remove"><?= wfMsg('structureddata-object-edit-remove-reference') ?></button>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php else: ?>
	<?php if(empty($value)):
		if($context == SD_CONTEXT_SPECIAL): ?>
			<p class="empty"><?= wfMsg('structureddata-object-empty-property') ?></p>
		<?php endif; ?>
	<?php else: ?>
		<?=( is_object( $value ) && isset( $value->id ) ) ? $value->id : $value; ?>
	<?php endif; ?>
<?php endif; ?>

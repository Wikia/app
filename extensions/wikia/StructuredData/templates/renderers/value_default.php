<?php $value = $object->getValue(); ?>
<?php if($context == SD_CONTEXT_EDITING): ?>
	<div class="input-group">
		<?php if ( in_array( $object->getPropertyName(), array('schema:description', 'schema:text') ) ) : ?>
			<textarea name="<?=$object->getPropertyName();?>"><?=$value;?></textarea>
		<?php elseif ($object->getPropertyName() == 'schema:name' && $params['isCreateMode'] === false) : ?>
			<?= $object->getValue();?>
			<input type="hidden" value="<?=$value;?>" name="<?=$object->getPropertyName();?>" />
		<?php elseif ( !is_object( $value ) ) : ?>
			<input type="text" value="<?=$value;?>" name="<?=$object->getPropertyName();?>" />
		<?php elseif ( isset( $value->id ) && ( !empty( $value->id ) ) ) : ?>
			<input type="hidden" name="<?=$params['fieldName'];?>" value="<?=$value->id;?>" />
		<?php endif; ?>
	</div>
<?php else: ?>
	<?php if(empty($value)):
		if($context == SD_CONTEXT_SPECIAL): ?>
			<p class="empty">empty</p>
		<?php endif; ?>
	<?php else: ?>
		<?=( is_object( $value ) && isset( $value->id ) ) ? $value->id : $value; ?>
	<?php endif; ?>
<?php endif; ?>
<? // for K. Drogo: $params['isCreateMode']); ?>

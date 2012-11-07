<?php $value = $object->getValue(); ?>
<?php if($context == SD_CONTEXT_EDITING): ?>
	<input type="text" value="<?=$value;?>" name="<?=$object->getObject()->getName();?>" />
<?php else: ?>
<?php if(empty($value)): ?>
	<p class="empty">empty</p>
<?php else: ?><?=$object->getValue();?><?php endif; ?>
<?php endif; ?>

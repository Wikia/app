<?php
	$value = $object->getValue();
?>
<?php if($context == SD_CONTEXT_EDITING): ?>
	<div class="input-group">
		<input type="text" value="<?=$value;?>" name="<?=$object->getName();?>" />
	</div>
<?php else: ?>
	<?php if (empty($value)) :?>
		<p class="empty">empty</p>
	<?php else : ?>
		<a href="<?php echo $value; ?>"><?php echo $value; ?></a>
	<?php endif; ?>
<?php endif; ?>
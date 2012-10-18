<?php 
	$value = $object->getValue();
?>
<?php if (empty($value)) :?>
	<p class="empty">empty</p>	
<?php else : ?>
	<a href="<?php echo $value; ?>"><?php echo $value; ?></a>
<?php endif; ?>
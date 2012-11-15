<?php
if ($context == SD_CONTEXT_EDITING):
	echo '<select name="' . $object->getPropertyName() .  '" >';
	echo '<option value="">choose...</option>';
	$types = $object->getType()->getAcceptedValues();
	$currentValue = $object->getValue();
	foreach ($types['enum'] as $value) {
		$selected = ($currentValue == $value) ? ' selected="selected"' : '';
	echo '<option value="' . $value . $selected . '">' . $value . '</option>';
}
echo '</select>';
else:
	if(empty($value)): ?>
	<p class="empty">empty</p>
	<?php else: ?><?=$object->getValue();?><?php endif; ?>
<?php endif; ?>


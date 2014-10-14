<?php
/* @var SDElementPropertyValue $object */
if ($context == SD_CONTEXT_EDITING):
	echo '<select name="' . $object->getPropertyName() .  '" >';
	echo '<option value="">' . wfMsg('structureddata-object-prop-enum-default') . '</option>';
	$types = $object->getType()->getAcceptedValues();
	$currentValue = $object->getValue();
	foreach ($types['enum'] as $value) {
		$selected = ($currentValue == $value) ? ' selected="selected"' : '';
	echo '<option value="' . $value . '"'.$selected.'>' . $value . '</option>';
}
echo '</select>';
else:
	$value = $object->getValue();
	if(empty($value)):
		if($context == SD_CONTEXT_SPECIAL): ?>
			<p class="empty"><?= wfMsg('structureddata-object-empty-property') ?></p>
		<? endif; ?>
	<?php else: ?><?=$value;?><?php endif; ?>
<?php endif; ?>


<? foreach ($element->getFields() as $fieldName => $field): ?>
	<?=$element->renderField($fieldName) ?>
<? endforeach ?>
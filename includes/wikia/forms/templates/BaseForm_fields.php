<? foreach ($form->getFields() as $fieldName => $field): ?>
	<?=$form->renderField($fieldName) ?>
<? endforeach ?>
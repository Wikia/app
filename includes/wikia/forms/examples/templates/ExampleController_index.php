<? // render whole form at once - this way is good only for standard forms (without any special HTML attributes or tags)?>
<?= $form->render() ?>

<? // render form HTML composed by yourself?>
<?= $form->renderStart(['class' => 'testClass']) ?>

<?= $form->renderFieldRow('defaultField', ['placeholder' => 'something here']) ?>
<?= $form->renderFieldRow('fieldName', ['class' => 'fieldClassName', 'label' => ['class' => 'labelClass']]) ?>
<?= $form->renderFieldRow('fieldName2') ?>
<?= $form->renderFieldRow('fieldName3', ['disabled' => 'disabled']) ?>
<?= $form->renderFieldRow('fieldName4') ?>
<?= $form->renderFieldRow('fieldName5') ?>
<?// some custom work here?>
<?= $form->renderFieldRow('fieldName6') ?>
<?= $form->renderFieldRow('fieldName7') ?>
<?= $form->renderFieldRow('fieldName8') ?>
<?= $form->renderFieldRow('fieldName9') ?>
<div>
	<?// some custom work here?>
	<?= $form->renderFieldLabel('fieldName10') ?><?= $form->renderField('fieldName10') ?>
</div>

<? for ($i = 0; $i < 5; $i++): ?>
	<?= $form->renderFieldRow('collectionField', [], $i) ?>
<? endfor?>


<?= $form->renderFieldRow('submitButton', ['class' => 'alternative']) ?>
<?= $form->renderEnd() ?>
<? // render whole form at once - this way is good only for standard forms (without any special HTML attributes or tags)?>
<h2> <?= wfMessage('example-form-render-whole') ?></h2>
<?= $form->render() ?>

<? // render form HTML composed by yourself?>
<h2> <?= wfMessage('example-form-render-fields') ?></h2>
<?= $form->renderStart(['class' => 'testClass']) ?>

<div>
	<?= $form->renderFieldRow('defaultField', ['placeholder' => 'something here']) ?>
</div>
<?= $form->renderFieldRow('contactFormSubject', ['class' => 'fieldClassName', 'label' => ['class' => 'labelClass']]) ?>
<?// some custom work here?>
<?= $form->renderFieldRow('contactFormMessage', ['disabled' => 'disabled']) ?>

<? for ($i = 0; $i < 5; $i++): ?>
	<?= $form->renderFieldRow('collectionField', [], $i) ?>
<? endfor?>


<?= $form->renderFieldRow('contactFormSubmit', ['class' => 'alternative']) ?>
<?= $form->renderEnd() ?>

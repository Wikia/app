<label for="<?=$fieldId?>" <?= (isset($class))? ' '. 'class="' . $class . '" ' : '' ?> >
	<? if (!empty($icon)): ?>
		<img src="<?= $wg->blankImgUrl ?>" class="input-icon" />
	<? endif ?>
	<?=$text?>
</label>
<? if ($data['type'] !== 'hidden'): ?>
	<div class="input-group
		<?= (isset($inputData['class']))? ' '.$inputData['class'] : '' ?>
	">
<? endif ?>

<? if (!empty($data['label'])): ?>
    <label for="<?=$data['name']?>" <?= (isset($data['label']['class']))? ' '. 'class="' . $data['label']['class'] . '" ' : '' ?> >
		<? if (!empty($data['icon'])): ?>
        	<img src="<?= $data['wg']->blankImgUrl ?>" class="input-icon" />
		<? endif ?>
		<?=$data['label']['text']?>
    </label>
<? endif ?>

<?	switch ($data['type']):
		case 'text':
		case 'hidden': ?>
			<input name="<?= $data['name'] ?>" type="<?= $data['type'] ?>" <?= $data['attributes'] ?> /><? break; ?>
	<?	case 'textarea': ?>
			<textarea name="<?= $data['name'] ?>" <?= $data['attributes'] ?> ></textarea><? break ?>
<?	endswitch ?>

<? if (!empty($data['errorMessage'])): ?>
    <p class="error error-msg"><?=$data['errorMessage']?></p>
<? endif ?>

<? if ($data['type'] !== 'hidden'): ?>
	</div>
<? endif ?>

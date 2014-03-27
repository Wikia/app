<? if ($data['type'] !== 'hidden'): ?>
	<div class="input-group
		<?= (isset($data['class']))? ' '.$data['class'] : '' ?>
	">
<? endif ?>

<? if (!empty($data['label'])): ?>
    <label for="<?=$data['id']?>" <?= (isset($data['labelclass']))? ' '. 'class="' . $data['labelclass'] . '" ' : '' ?> >
		<? if (!empty($data['icon'])): ?>
        	<img src="<?= $data['wg']->blankImgUrl ?>" class="input-icon" />
		<? endif ?>
		<?=$data['label']?>
    </label>
<? endif ?>

<?	switch ($data['type']):
		case 'checkbox': ?>
			<input name="<?= $data['name'] ?>" type="checkbox" id="<?= $data['id'] ?>" <?= $data['attributes'] ?> value="1" <? if ($data['value']):?>checked="checked"<? endif?> />
			<? break; ?>
	<?	case 'text':
		case 'hidden': ?>
			<input name="<?= $data['name'] ?>" type="<?= $data['type'] ?>" id="<?= $data['id'] ?>" <?= $data['attributes'] ?> value="<?= htmlspecialchars($data['value'])?>"/>
			<? break; ?>
	<?	case 'textarea': ?>
			<textarea name="<?= $data['name'] ?>" id="<?= $data['id'] ?>" <?= $data['attributes'] ?> ><?= htmlspecialchars($data['value'])?></textarea><? break; ?>
	<?  case 'select': ?>
			<select name="<?= $data['name'] ?>" id="<?= $data['id'] ?>" <?= $data['attributes'] ?>>
				<? foreach ($data['choices'] as $option): ?>
					<option value="<?= $option['value'] ?>" <?= $option['value'] == $data['value'] ? 'selected' : '' ?>><?= $option['option'] ?></option>
				<? endforeach ?>
			</select>
			<? break; ?>
<?	endswitch ?>

<? if (!empty($data['errorMessage'])): ?>
    <p class="error error-msg"><?=$data['errorMessage']?></p>
<? endif ?>

<? if ($data['type'] !== 'hidden'): ?>
	</div>
<? endif ?>

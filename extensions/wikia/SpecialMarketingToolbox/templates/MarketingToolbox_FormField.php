<div class="input-group
<?= (isset($inputData['class']))? ' '.$inputData['class'] : '' ?>
">
	<? if (!empty($inputData['label'])): ?>
		<label for="<?=$inputData['name']?>"><?=$inputData['label']?></label>
	<? endif ?>
	<input type="text" <?=$inputData['attributes']?><?= ($inputData['isRequired'])? ' class="required"' : '' ?> name="<?=$inputData['name']?>" value="<?= htmlspecialchars($inputData['value'])?>" />

	<p class="error error-msg"><?=$inputData['errorMessage']?></p>
</div>
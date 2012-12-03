<div class="input-group<? if ($inputData['label']): ?> required<? endif ?>">
	<? if (!empty($inputData['label'])): ?>
		<label for="<?=$inputData['name']?>"><?=$inputData['label']?></label>
	<? endif ?>
	<input type="text" <?=$inputData['attributes']?> name="<?=$inputData['name']?>" value="<?=$inputData['value']?>" />

	<p class="error error-msg"><?=$inputData['errorMessage']?></p>
</div>
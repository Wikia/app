<div class="input-group
<? if ($inputData['isRequired']): ?> required<? endif ?>
<?= (isset($inputData['class']))? ' '.$inputData['class'] : '' ?>
">
	<? if (!empty($inputData['label'])): ?>
		<label for="<?=$inputData['name']?>"><?=$inputData['label']?></label>
	<? endif ?>
	<input type="text" <?=$inputData['attributes']?> name="<?=$inputData['name']?>" value="<?= htmlspecialchars($inputData['value'])?>" />

	<p class="error error-msg"><?=$inputData['errorMessage']?></p>
</div>
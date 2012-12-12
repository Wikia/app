<div class="input-group
<?= (isset($inputData['class']))? ' '.$inputData['class'] : '' ?>
">
	<? if (!empty($inputData['label'])): ?>
		<label for="<?=$inputData['name']?>"><?=$inputData['label']?></label>
	<? endif ?>

	<? switch ($inputData['type']):
		case 'text':
		case 'hidden': ?>
		<input type="<?=$inputData['type']?>" <?=$inputData['attributes']?> id="MarketingToolbox<?=$inputData['name']?>" name="<?=$inputData['name']?>" value="<?= htmlspecialchars($inputData['value'])?>" />
			<? break ?>
		<? case 'textarea': ?>
			<textarea <?=$inputData['attributes']?> name="<?=$inputData['name']?>"><?= htmlspecialchars($inputData['value'])?></textarea>
			<? break ?>
	<? endswitch ?>

	<? if (!empty($inputData['errorMessage'])): ?>
		<p class="error error-msg"><?=$inputData['errorMessage']?></p>
	<? endif ?>
</div>
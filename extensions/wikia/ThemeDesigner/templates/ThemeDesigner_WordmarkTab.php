<section id="WordmarkTab" class="WordmarkTab">
	<fieldset class="text">
		<h1><?= wfMsg('themedesigner-text-wordmark') ?></h1>
		<button class="secondary"><img src="<?= $wgStylePath ?>/common/blank.gif"> Edit</button>
		<select id="wordmark-font"></select>
		<select id="wordmark-size">
			<option value="small"><?= wfMsg('themedesigner-small') ?></option>
			<option value="medium"><?= wfMsg('themedesigner-medium') ?></option>
			<option value="large"><?= wfMsg('themedesigner-large') ?></option>
		</select>
		<span id="wordmark"></span>
	</fieldset>
	<fieldset class="graphic">
		<h1><?= wfMsg('themedesigner-text-wordmark') ?></h1>
	</fieldset>
</section>
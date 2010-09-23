<section id="WordmarkTab" class="WordmarkTab">
	<fieldset class="text">
		<h1><?= wfMsg('themedesigner-text-wordmark') ?></h1>

		<ul class="controls">
			<li>
				<button class="secondary" id="wordmark-edit-button"><img src="<?= $wgExtensionsPath ?>/wikia/ThemeDesigner/images/secondary_edit.png"> <?= wfMsg('themedesigner-button-edit') ?></button>
			</li>
			<li>
				<h2><?= wfMsg('themedesigner-font') ?></h2>
				<select id="wordmark-font">
					<option value="default"><?= wfMsg('themedesigner-default') ?></option>
					<option value="cpmono">CP Mono</option>
					<option value="fontin">Fontin</option>
					<option value="garton">Garton</option>
					<option value="idolwild">Idolwild</option>
					<option value="imfell">IM Fell</option>
					<option value="josefin">Josefin</option>
					<option value="megalopolis">Megalopolis</option>
					<option value="orbitron">Orbitron</option>
					<option value="pixiefont">Pixiefont</option>
					<option value="prociono">Prociono</option>
					<option value="tangerine">Tangerine</option>
					<option value="titillium">Titillium</option>
					<option value="veggieburger">Veggieburger</option>
					<option value="yanone">Yanone</option>
				</select>
			</li>
			<li>
				<h2><?= wfMsg('themedesigner-size') ?></h2>
				<select id="wordmark-size">
					<option value="small"><?= wfMsg('themedesigner-small') ?></option>
					<option value="medium"><?= wfMsg('themedesigner-medium') ?></option>
					<option value="large"><?= wfMsg('themedesigner-large') ?></option>
				</select>
			</li>
		</ul>

		<div id="wordmark"></div>

		<div id="wordmark-edit">
			<input type="text">
			<button><?= wfMsg('themedesigner-button-save') ?></button>
		</div>

		<div id="wordmark-shield"></div>

	</fieldset>
	<fieldset class="graphic">
		<h1><?= wfMsg('themedesigner-graphic-wordmark') ?></h1>
		<h2><?= wfMsg('themedesigner-upload-a-graphic') ?></h2>

		<form onsubmit="return AIM.submit(this, ThemeDesigner.wordmarkUploadCallback)" action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=moduleProxy&moduleName=ThemeDesigner&actionName=WordmarkUpload&outputType=html" method="POST" enctype="multipart/form-data">
			<input id="WordMarkUploadFile" name="wpUploadFile" type="file" />
			<input type="submit" value="Upload" onclick="return ThemeDesigner.wordmarkUpload(event);"/> <?= wfMsg('themedesigner-rules-wordmark') ?>
		</form>

		<div class="preview">
			<img src="<?= $wgStylePath ?>/common/blank.gif" class="wordmark">
			<a href="#"><?= wfMsg('themedesigner-dont-use-a-graphic') ?></a>
		</div>

	</fieldset>
</section>
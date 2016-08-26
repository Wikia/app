<section id="WordmarkTab" class="WordmarkTab">
	<fieldset class="text">
        <span id="or"><?= wfMsg('themedesigner-or') ?></span>
		<h1><?= wfMsg('themedesigner-text-wordmark') ?></h1>

		<ul class="controls">
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

		<div id="wordmark-edit">
			<input type="text">
			<button><?= wfMsg('themedesigner-button-change-text') ?></button>
		</div>

		<div id="wordmark-shield"></div>

	</fieldset>
	<fieldset class="graphic">
		<h1><?= wfMsg('themedesigner-graphic-wordmark') ?></h1>
		<h2><?= wfMsg('themedesigner-upload-a-graphic') ?> <span class="form-questionmark" rel="tooltip" title="<?= wfMsg('themedesigner-rules-wordmark') ?>"></span></h2>
		<?php if ( empty( $wg->EnableUploads ) ) { ?>
			<p><?= wfMessage( 'themedesigner-upload-disabled' )->plain(); ?></p>
		<?php } else { ?>
			<form id="WordMarkUploadForm" action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=WordmarkUpload" method="POST" enctype="multipart/form-data">
				<input id="WordMarkUploadFile" name="wpUploadFile" class="file-upload" type="file" />
				<input id="token" name="token" type="hidden" value="<?= $token ?>" />
				<br />
				<input type="submit" value="<?= wfMsg( 'themedesigner-button-upload-wordmark' ) ?>" onclick="return ThemeDesigner.wordmarkUpload(event);"/>
			</form>
		<?php } ?>


		<div class="preview">
			<span><?= wfMsg( 'themedesigner-wodmark-preview' ) ?></span>
			<img src="<?= $wg->BlankImgUrl ?>" class="wordmark">
			<a href="#"><?= wfMsg('themedesigner-dont-use-a-graphic') ?></a>
		</div>

	</fieldset>
	<fieldset class="favicon">
		<h1><?= wfMsg('themedesigner-favicon-heading') ?></h1>
		<h2>
			<?= wfMsg('themedesigner-upload-a-graphic') ?>
			<span class="form-questionmark" rel="tooltip" title="<?= htmlspecialchars( wfMessage( 'themedesigner-rules-favicon' )->parse() ) ?>"></span>
		</h2>
		<?php if ( empty( $wg->EnableUploads ) ) { ?>
			<p><?= wfMessage( 'themedesigner-upload-disabled' )->plain(); ?></p>
		<?php } else { ?>
			<form id="FaviconUploadForm" action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=FaviconUpload" method="POST" enctype="multipart/form-data">
				<input id="FaviconUploadFile" name="wpUploadFile" class="file-upload" type="file" />
				<input id="token" name="token" type="hidden" value="<?= $token ?>" />
				<input type="submit" value="<?= wfMsg( 'themedesigner-button-upload-wordmark' ) ?>" />
			</form>
		<?php } ?>

		<div class="preview">
			<span><?= wfMsg('themedesigner-wodmark-preview') ?></span>
			<img src="<?= $faviconUrl ?>">
			<a href="#"><?= wfMsg('themedesigner-dont-use-a-graphic') ?></a>
		</div>
	</fieldset>
</section>

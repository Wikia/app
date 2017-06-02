<section id="WordmarkTab" class="WordmarkTab">
	<fieldset class="text">
		<h1><?= wfMsg('themedesigner-text-wordmark') ?></h1>

		<div id="wordmark-edit">
			<input type="text">
			<button><?= wfMsg('themedesigner-button-change-text') ?></button>
		</div>

	</fieldset>
	<fieldset class="graphic">
		<h1><?= wfMsg('themedesigner-graphic-wordmark') ?></h1>
		<h2><?= wfMsg('themedesigner-upload-a-graphic') ?> <span class="form-questionmark" rel="tooltip" title="<?= wfMsg('themedesigner-rules-wordmark') ?>"></span></h2>
		<?php if ( empty( $wg->EnableUploads ) ) { ?>
			<p><?= wfMessage( 'themedesigner-upload-disabled' )->plain(); ?></p>
		<?php } else { ?>
			<form id="WordMarkUploadForm" action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=WordmarkUpload&format=html" method="POST" enctype="multipart/form-data">
				<input id="WordMarkUploadFile" name="wpUploadFile" class="file-upload" type="file" />
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
			<form id="FaviconUploadForm" action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=FaviconUpload&format=html" method="POST" enctype="multipart/form-data">
				<input id="FaviconUploadFile" name="wpUploadFile" class="file-upload" type="file" />
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

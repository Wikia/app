<section id="WordmarkTab" class="WordmarkTab">
	<fieldset class="text">
        <h1><?= wfMessage('themedesigner-text-wordmark')->text() ?></h1>

		<div id="wordmark-edit">
			<input type="text">
			<button><?= wfMessage( 'themedesigner-button-change-text' )->text() ?></button>
		</div>

	</fieldset>
	<fieldset class="graphic">
		<h1><?= wfMessage( 'themedesigner-graphic-wordmark' )->text() ?></h1>
		<h2><?= wfMessage( 'themedesigner-upload-a-graphic' )->text() ?> <span class="form-questionmark" rel="tooltip"
																   title="<?= wfMessage( 'themedesigner-rules-wordmark' )->text() ?>"></span>
		</h2>
		<?php if ( empty( $wg->EnableUploads ) ) { ?>
			<p><?= wfMessage( 'themedesigner-upload-disabled' )->text(); ?></p>
		<?php } else { ?>
			<form id="WordMarkUploadForm"
				  action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=WordmarkUpload&format=html"
				  method="POST" enctype="multipart/form-data">
				<input id="WordMarkUploadFile" name="wpUploadFile" class="file-upload" type="file"/>
				<br/>
				<input type="submit" value="<?= wfMessage( 'themedesigner-button-upload-wordmark' )->text() ?>"
					   onclick="return ThemeDesigner.wordmarkUpload(event);"/>
			</form>
		<?php } ?>


		<div class="preview">
			<span><?= wfMessage( 'themedesigner-wodmark-preview' )->text() ?></span>
			<img src="<?= $wg->BlankImgUrl ?>" class="wordmark">
			<a href="#"><?= wfMessage( 'themedesigner-dont-use-a-graphic' )->text() ?></a>
		</div>

	</fieldset>
	<fieldset class="favicon">
		<h1><?= wfMessage( 'themedesigner-favicon-heading' )->text() ?></h1>
		<h2>
			<?= wfMessage( 'themedesigner-upload-a-graphic' )->text() ?>
			<span class="form-questionmark" rel="tooltip"
				  title="<?= htmlspecialchars( wfMessage( 'themedesigner-rules-favicon' )->parse() ) ?>"></span>
		</h2>
		<?php if ( empty( $wg->EnableUploads ) ) { ?>
			<p><?= wfMessage( 'themedesigner-upload-disabled' )->plain(); ?></p>
		<?php } else { ?>
			<form id="FaviconUploadForm"
				  action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=FaviconUpload&format=html"
				  method="POST" enctype="multipart/form-data">
				<input id="FaviconUploadFile" name="wpUploadFile" class="file-upload" type="file"/>
				<input type="submit" value="<?= wfMessage( 'themedesigner-button-upload-wordmark' )->text() ?>"/>
			</form>
		<?php } ?>

		<div class="preview">
			<span><?= wfMessage( 'themedesigner-wodmark-preview' )->text() ?></span>
			<img src="<?= $faviconUrl ?>">
			<a href="#"><?= wfMessage( 'themedesigner-dont-use-a-graphic' )->text() ?></a>
		</div>
	</fieldset>
</section>

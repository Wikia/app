<section id="WordmarkTab" class="WordmarkTab">
	<fieldset class="text">
        <h1><?= wfMessage('themedesigner-text-wordmark')->escaped() ?></h1>

		<div id="wordmark-edit">
			<input type="text">
			<button><?= wfMessage( 'themedesigner-button-change-text' )->escaped() ?></button>
		</div>

	</fieldset>
	<fieldset class="graphic">
		<h1><?= wfMessage( 'themedesigner-graphic-wordmark' )->escaped() ?></h1>
		<h2><?= wfMessage( 'themedesigner-upload-a-graphic' )->escaped() ?> <span class="form-questionmark" rel="tooltip"
																   title="<?= wfMessage( 'themedesigner-rules-wordmark' )->escaped() ?>"></span>
		</h2>
		<?php if ( empty( $wg->EnableUploads ) ) { ?>
			<p><?= wfMessage( 'themedesigner-upload-disabled' )->escaped(); ?></p>
		<?php } else { ?>
			<form id="WordMarkUploadForm"
				  action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=WordmarkUpload&format=html"
				  method="POST" enctype="multipart/form-data">
				<input id="WordMarkUploadFile" name="wpUploadFile" class="file-upload" type="file"/>
				<br/>
				<input type="submit" value="<?= wfMessage( 'themedesigner-button-upload-wordmark' )->escaped() ?>"
					   onclick="return ThemeDesigner.wordmarkUpload(event);"/>
			</form>
		<?php } ?>


		<div class="preview">
			<span><?= wfMessage( 'themedesigner-wodmark-preview' )->escaped() ?></span>
			<img src="<?= $wg->BlankImgUrl ?>" class="wordmark">
			<a href="#"><?= wfMessage( 'themedesigner-dont-use-a-graphic' )->escaped() ?></a>
		</div>

	</fieldset>
	<fieldset class="favicon">
		<h1><?= wfMessage( 'themedesigner-favicon-heading' )->escaped() ?></h1>
		<h2>
			<?= wfMessage( 'themedesigner-upload-a-graphic' )->escaped() ?>
			<span class="form-questionmark" rel="tooltip"
				  title="<?= htmlspecialchars( wfMessage( 'themedesigner-rules-favicon' )->parse() ) ?>"></span>
		</h2>
		<?php if ( empty( $wg->EnableUploads ) ) { ?>
			<p><?= wfMessage( 'themedesigner-upload-disabled' )->escaped(); ?></p>
		<?php } else { ?>
			<form id="FaviconUploadForm"
				  action="<?= $wg->ScriptPath ?>/wikia.php?controller=ThemeDesigner&method=FaviconUpload&format=html"
				  method="POST" enctype="multipart/form-data">
				<input id="FaviconUploadFile" name="wpUploadFile" class="file-upload" type="file"/>
				<input type="submit" value="<?= wfMessage( 'themedesigner-button-upload-wordmark' )->escaped() ?>"/>
			</form>
		<?php } ?>

		<div class="preview">
			<span><?= wfMessage( 'themedesigner-wodmark-preview' )->escaped() ?></span>
			<img src="<?= $faviconUrl ?>">
			<a href="#"><?= wfMessage( 'themedesigner-dont-use-a-graphic' )->escaped() ?></a>
		</div>
	</fieldset>
</section>

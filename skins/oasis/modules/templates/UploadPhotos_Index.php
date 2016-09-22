<div id="UploadPhotos" class="UploadPhotos">
	<form action="<?= $wg->ScriptPath ?>/wikia.php?controller=UploadPhotos&method=Upload&format=html" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="wpSourceType" value="file">

		<div class="step-1">
			<h1><?= wfMessage( 'oasis-upload-photos-title' )->escaped(); ?></h1>
			<input type="file" name="wpUploadFile">
			<input type="submit" value="<?= wfMessage( 'Upload' )->escaped(); ?>">
			<img class="ajaxwait" src="<?= $wg->StylePath ?>/common/images/ajax.gif"><br>
			<label class="override"><input type="checkbox" name="wpDestFileWarningAck"><?= wfMessage( 'oasis-upload-photos-overwrite-file' )->escaped() ?></label>
			<div class="status"></div>

			<div class="options">
				<label for="wpDestFile"><?= wfMessage( 'filename' )->escaped(); ?>:</label><input type="text" name="wpDestFile" autocomplete="off"><br>
				<label for="wpUploadDescription"><?= wfMessage( 'oasis-upload-photos-caption' )->escaped(); ?>:</label><textarea name="wpUploadDescription"></textarea><br>
				<label for="wpLicense"><?= wfMessage( 'license' )->escaped(); ?></label><?= $licensesHtml ?><br>
				<div id="mw-license-preview"></div>
				<div class="toggles">
					<label><input type="checkbox" name="wpWatchthis" checked=""><?= wfMessage( 'watchthisupload' )->escaped(); ?></label>
					<label><input type="checkbox" name="wpIgnoreWarning"><?= wfMessage( 'ignorewarnings' )->escaped(); ?></label>
				</div>
			</div>
		</div>

		<div class="advanced">
			<img src="<?=$wg->BlankImgUrl?>" class="chevron">
			<a href="#"
			   data-more="<?= wfMessage( 'oasis-upload-photos-more-options' )->escaped(); ?>"
			   data-fewer="<?= wfMessage( 'oasis-upload-photos-fewer-options' )->escaped(); ?>"
			>
				<?= wfMessage( 'oasis-upload-photos-more-options' )->escaped(); ?>
			</a>
		</div>

		<div class="step-2">
			<div class="conflict"></div>
			<input type="submit" value="<?= wfMessage( 'oasis-upload-photos-force' )->escaped(); ?>">
			<img class="ajaxwait" src="<?= $wg->StylePath ?>/common/images/ajax.gif">
		</div>
	</form>
</div>

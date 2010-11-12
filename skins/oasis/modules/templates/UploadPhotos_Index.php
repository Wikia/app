<div id="UploadPhotos" class="UploadPhotos">
	<h1><?= wfMsg('oasis-upload-photos-title') ?></h1>
	<form onsubmit="return AIM.submit(this, UploadPhotos.uploadCallback)" action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=moduleProxy&moduleName=UploadPhotos&actionName=Upload&outputType=html" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="wpSourceType" value="file">
		<input type="hidden" name="wpDestFileWarningAck" value="yes">
		<input type="file" name="wpUploadFile" size="60">
		<input type="submit" value="Upload"><br>
		<label><input type="checkbox" name="wpWatchthis" checked=""><?= wfMsg('watchthisupload') ?></label>
		<label><input type="checkbox" name="wpIgnoreWarning"><?= wfMsg('ignorewarnings') ?></label>
		<div class="status"></div>
		<a class="advanced" href="#"><?= wfMsg('oasis-upload-photos-advanced') ?></a>
		<div class="options">
			<label for="wpDestFile"><?= wfMsg('filename') ?>:</label><input type="text" name="wpDestFile" size="60"><br>
			<label for="wpUploadDescription"><?= wfMsg('summary') ?>:</label><textarea name="wpUploadDescription"></textarea><br>
			<label for="wpLicense"><?= wfMsg('license') ?></label><select name="wpLicense"><?= $licensesHtml ?></select><br>
		</div>
	</form>
</div>
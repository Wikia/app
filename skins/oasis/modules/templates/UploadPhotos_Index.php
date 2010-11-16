<div id="UploadPhotos" class="UploadPhotos">
	<form onsubmit="return AIM.submit(this, UploadPhotos.uploadCallback)" action="<?= $wgScriptPath ?>/index.php?action=ajax&rs=moduleProxy&moduleName=UploadPhotos&actionName=Upload&outputType=html" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="wpSourceType" value="file">
		
		<div class="step-1">
			<h1><?= wfMsg('oasis-upload-photos-title') ?></h1>
			<input type="file" name="wpUploadFile" size="60">
			<input type="submit" value="<?= wfMsg('Upload') ?>">
			<img class="ajaxwait" src="/skins/common/images/ajax.gif"><br>
			<label><input type="checkbox" name="wpWatchthis" checked=""><?= wfMsg('watchthisupload') ?></label>
			<label class="override"><input type="checkbox" name="wpDestFileWarningAck">Overwrite File</label>
			<div class="status"></div>
			<a class="advanced" href="#"><?= wfMsg('oasis-upload-photos-advanced') ?></a>
			<div class="options">
				<label for="wpDestFile"><?= wfMsg('filename') ?>:</label><input type="text" name="wpDestFile" size="60" autocomplete="off"><br>
				<label for="wpUploadDescription"><?= wfMsg('summary') ?>:</label><textarea name="wpUploadDescription"></textarea><br>
				<label for="wpLicense"><?= wfMsg('license') ?></label><select name="wpLicense"><?= $licensesHtml ?></select><br>
				<label><input type="checkbox" name="wpIgnoreWarning"><?= wfMsg('ignorewarnings') ?></label>
			</div>
		</div>
		<div class="step-2">
			<div class="conflict"></div>
			<input type="submit" value="<?= wfMsg('oasis-upload-photos-force') ?>">
			<img class="ajaxwait" src="/skins/common/images/ajax.gif">
		</div>
	</form>
</div>
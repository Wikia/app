<div id="UploadPhotos" class="UploadPhotos">
	<form onsubmit="return AIM.submit(this, UploadPhotos.uploadCallback)" action="<?= $wg->ScriptPath ?>/index.php?action=ajax&rs=moduleProxy&moduleName=UploadPhotos&actionName=Upload&outputType=html" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="wpSourceType" value="file">
		
		<div class="step-1">
			<h1><?= wfMsg('oasis-upload-photos-title') ?></h1>
			<input type="file" name="wpUploadFile" size="60">
			<input type="submit" value="<?= wfMsg('Upload') ?>">
			<img class="ajaxwait" src="<?= $wg->StylePath ?>/common/images/ajax.gif"><br>
			<label class="override"><input type="checkbox" name="wpDestFileWarningAck">Overwrite File</label>
			<div class="status"></div>

			<div class="options">
				<label for="wpDestFile"><?= wfMsg('filename') ?>:</label><input type="text" name="wpDestFile" size="60" autocomplete="off"><br>
				<label for="wpUploadDescription"><?= wfMsg('oasis-upload-photos-caption') ?>:</label><textarea name="wpUploadDescription"></textarea><br>
				<label for="wpLicense"><?= wfMsg('license') ?></label><?= $licensesHtml ?><br>
				<div id="mw-license-preview"></div>
				<div class="toggles">
					<label><input type="checkbox" name="wpWatchthis" checked=""><?= wfMsg('watchthisupload') ?></label>
					<label><input type="checkbox" name="wpIgnoreWarning"><?= wfMsg('ignorewarnings') ?></label>
				</div>
			</div>
		</div>

		<div class="advanced">
			<img src="<?=$wg->BlankImgUrl?>" class="chevron">
			<a href="#" data-more="<?= wfMsg('oasis-upload-photos-more-options') ?>" data-fewer="<?= wfMsg('oasis-upload-photos-fewer-options') ?>"><?= wfMsg('oasis-upload-photos-more-options') ?></a>
		</div>

		<div class="step-2">
			<div class="conflict"></div>
			<input type="submit" value="<?= wfMsg('oasis-upload-photos-force') ?>">
			<img class="ajaxwait" src="/skins/common/images/ajax.gif">
		</div>
	</form>
</div>
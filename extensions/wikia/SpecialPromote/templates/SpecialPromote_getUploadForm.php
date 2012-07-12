<? if ($checkAccess): ?>
<form class="WikiaForm SpecialUploadForm"
	  action="<?= $wg->ScriptPath ?>/wikia.php?controller=SpecialPromoteController&method=uploadImage&format=html"
	  id="ImageUploadForm" method="POST" enctype="multipart/form-data">
	<p class="error"></p>

	<div class="input-group">
		<? if($uploadType == 'additional'): ?>
		<h1><?= wfMsg('promote-upload-main-image-form-modal-title'); ?></h1>
		<p class='copy'>
			<?= wfMsg('promote-upload-main-image-form-modal-copy'); ?>
		</p>
		<? else: ?>
		<h1><?= wfMsg('promote-upload-additional-image-form-modal-title'); ?></h1>
		<p class='copy'>
			<?= wfMsg('promote-upload-additional-image-form-modal-copy'); ?>
		</p>
		<? endif;  ?>
	</div>
	<div class="input-group">
		<input type="file" name="wpUploadFile"/>
		<input type="hidden" name="uploadType" value="<?= $uploadType; ?>"/>
		<? if (!empty($imageIndex)): ?>
		<input type="hidden" name="imageIndex" value="<?= $imageIndex; ?>"/>
		<? endif; ?>
	</div>
	<div class="input-group submit-buttons">
		<input type="submit" class="wikia-button submit" id="submit-button" value="<?= wfMsg('promote-upload-submit-button'); ?>"/>
	</div>

</form>
<? else: ?>
	<?= wfMsg('promote-wrong-rights'); ?>
<? endif; ?>

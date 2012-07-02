<form action="<?= $wg->ScriptPath ?>/wikia.php?controller=SpecialPromoteController&method=uploadImage&format=html" id="ImageUploadForm" method="POST" enctype="multipart/form-data">
	<p class="error"></p>
	<input type="file" name="wpUploadFile" />
	<input type="hidden" name="uploadType" value="<?= $uploadType; ?>" />
	<? if(!empty($imageIndex)): ?>
		<input type="hidden" name="imageIndex" value="<?= $imageIndex; ?>" />
	<? endif; ?>
	<input type="submit" id="submit-button" value="Submit" />
</form>
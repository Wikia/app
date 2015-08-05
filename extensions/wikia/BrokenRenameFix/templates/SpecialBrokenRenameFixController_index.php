<div class="brf-form-description"><?= $description ?></div>
<div class="brf-form-notices"><?= $formNotices ?></div>
<div class="brf-form-container">
	<form class="brf-form" action="<?= $actionUrl ?>" method="POST">
		<label class="brf-form-label" for="brf-form-user-id"><?= $userIdLabel ?></label>
		<input class="brf-form-input" type="text" name="brf-form-user-id" id="brf-form-user-id" value="<?= Sanitizer::encodeAttribute( $userIdValue ) ?>">

		<label class="brf-form-label" for="brf-form-old-name"><?= $oldNameLabel ?></label>
		<input class="brf-form-input" type="text" name="brf-form-old-name" id="brf-form-old-name" value="<?= Sanitizer::encodeAttribute( $oldNameValue ) ?>">

		<label class="brf-form-label" for="brf-form-new-name"><?= $newNameLabel ?></label>
		<input class="brf-form-input" type="text" name="brf-form-new-name" id="brf-form-new-name" value="<?= Sanitizer::encodeAttribute( $newNameValue ) ?>">

		<input type="hidden" name="brf-form-token" value="<?= $editToken ?>">

		<input class="brf-form-submit" type="submit" value="<?= $submitText ?>">
	</form>
</div>

<?php
if ( !empty( $err ) ) {
	echo $err;
}
?>

<?= wfMessage( 'specialcontact-intro-security' )->useDatabase( false )->parseAsBlock(); ?>

<h2><?= wfMessage( 'specialcontact-form-header' )->escaped() ?></h2>

<form id="contactform" method="POST" action="" enctype="multipart/form-data">
	<input name="wpEmail" type="hidden" value="<?= $encEmail ?>" />
	<input name="wpUserName" type="hidden" value="<?= $encName ?>" />
	<input name="wpEditToken" type="hidden" value="<?= Sanitizer::encodeAttribute( $editToken ) ?>" />

	<? if ( $isLoggedIn ): ?>
	<?= wfMessage( 'specialcontact-logged-in-as', $encName )->parseAsBlock(); ?>
	<?= wfMessage( 'specialcontact-mail-on-file', $encEmail )->parseAsBlock(); ?>
	<? else: ?>
	<p>
		<label for="wpUserName">
			<?= wfMessage( 'specialcontact-username' )->escaped() ?>
			<input name="wpUserName" type="text" value="<?= $encName ?>" />
		</label>
	</p>

	<p>
		<label for="wpEmail">
			<?= wfMessage( 'specialcontact-yourmail' )->escaped() ?>
			<input name="wpEmail" type="email" value="<?= $encEmail ?>" />
		</label>
	</p>
	<? endif; ?>

	<p>
		<label for="wpIssueType">
			<?= wfMessage( 'specialcontact-label-security-type' )->escaped() ?>
			<select name="wpIssueType">
				<? foreach ( $issueTypes as $value => $messageKey ): ?>
				<option value="<?= Sanitizer::encodeAttribute( $value ) ?>"><?= wfMessage( $messageKey )->escaped() ?></option>
				<? endforeach; ?>
			</select>
		</label>
	</p>

	<p>
		<label for="wpUrl">
			<?= wfMessage( 'specialcontact-label-security-link' )->escaped() ?>
			<input name="wpUrl" type="text" value="" />
		</label>
	</p>

	<p>
		<label for="wpDescription"><?= wfMessage( 'specialcontact-label-security-description' )->escaped() ?></label>
		<textarea name="wpDescription"><?= wfMessage( 'specialcontact-default-security-description' )->escaped() ?></textarea>
	</p>


	<p>
		<label for="wpScreenshot1"><?= wfMessage( 'specialcontact-label-screenshot' )->escaped() ?></label>
		<input id="wpScreenshot1" name="wpScreenshot[]" type="file" accept="image/*" multiple />
	</p>

	<?php
	if ( !$isLoggedIn && isset( $captchaForm ) ) {
		echo '<div class="captcha">' .
			wfMessage( 'specialcontact-captchatitle' )->escaped() .
			$captchaForm .
			wfMessage( 'specialcontact-captchainfo' )->escaped() .
			"</div>\n";
	}
	?>

	<p><input type="submit" value="<?= wfMessage( 'specialcontact-mail' )->escaped() ?>" /></p>

	<? if ( $isLoggedIn && $hasEmail && $hasEmailConf ): ?>
	<input type="checkbox" name="wgCC" value="1" /> <?= wfMessage( 'specialcontact-ccme' )->escaped(); ?>
	<? endif; ?>

	<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?= Sanitizer::encodeAttribute( $_SERVER['HTTP_USER_AGENT'] ); ?>" />
	<input type="hidden" id="wpAbTesting" name="wpAbTesting" value="[unknown]" />
</form>

<?php
if ( !empty( $err ) ) {
	echo $err;
}
?>

<?= wfMessage( 'specialcontact-intro-data-access' )->useDatabase( false )->parseAsBlock(); ?>

<h2><?= wfMessage( 'specialcontact-form-header' )->escaped() ?></h2>
<form id="contactform" method="POST" action="" enctype="multipart/form-data">
	<input name="wpEditToken" type="hidden" value="<?= Sanitizer::encodeAttribute( $editToken ) ?>" />

	<p>
		<label for="wpUserName">
			<?= wfMessage( 'specialcontact-label-data-access-username' )->escaped() ?>
			<input name="wpUserName" type="text" value="<?= $encName ?>" />
		</label>
	</p>

	<p>
		<label for="wpContactRealName">
			<?= wfMessage( 'specialcontact-realname' )->escaped() ?>
			<input name="wpContactRealName" type="text" value="<?= $encRealName ?>" />
		</label>
	</p>

	<p>
		<label for="wpEmail">
			<?= wfMessage( 'specialcontact-label-data-access-email' )->escaped() ?>
			<input name="wpEmail" type="email" value="<?= $encEmail ?>" />
		</label>
	</p>

	<?php
	if ( isset( $captchaForm ) ) {
		echo '<div class="captcha">' .
			wfMessage( 'specialcontact-captchatitle' )->escaped() .
			$captchaForm .
			wfMessage( 'specialcontact-captchainfo' )->escaped() .
			"</div>\n";
	}
	?>

	<p><input type="submit" value="<?= wfMessage( 'specialcontact-mail' )->escaped() ?>" /></p>

	<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?= Sanitizer::encodeAttribute( $_SERVER['HTTP_USER_AGENT'] ); ?>" />
	<input type="hidden" id="wpAbTesting" name="wpAbTesting" value="[unknown]" />
</form>

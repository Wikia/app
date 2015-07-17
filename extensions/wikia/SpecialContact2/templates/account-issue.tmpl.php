<?php
if ( !empty($err) ) {
	print $err;
}

echo wfMessage( 'specialcontact-intro-account-issue' )->parseAsBlock();
?>

<h2><?= wfMessage( 'specialcontact-form-header' )->escaped() ?></h2>

<form id="contactform" method="post" action="" enctype="multipart/form-data">

<p>
<label for="wpUserName"><?= wfMessage( 'specialcontact-username' )->escaped() ?></label>
<input name="wpUserName" value="<?= $encName ?>" />
</p>

<p>
<label for="wpEmail"><?= wfMessage( 'specialcontact-yourmail' )->escaped() ?></label>
<input name="wpEmail" value="<?= $encEmail ?>" />
</p>

<p>
<label for="wpContactWikiName"><?= wfMessage( 'specialcontact-wikiname' )->escaped() ?></label>
<input name="wpContactWikiName" />
</p>

<p>
<label for="wpDescription"><?= wfMessage( 'specialcontact-label-account-issue-description' )->escaped() ?></label>
<textarea name="wpDescription"></textarea>
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

<?php
if ( $isLoggedIn && $hasEmail ) {
	if ( $hasEmailConf ) {
		echo '<input type="checkbox" name="wgCC" value="1" />' . wfMessage( 'specialcontact-ccme' )->escaped();
	} else {
		echo '<s><i>' . wfMessage( 'specialcontact-ccme' )->escaped() . '</i></s><br/>' . wfMessage( 'specialcontact-ccdisabled' )->parse();
	}
}
?>

<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?= htmlspecialchars( $_SERVER['HTTP_USER_AGENT'] ); ?>" />
<input type="hidden" id="wpAbTesting" name="wpAbTesting" value="[unknown]" />
</form>


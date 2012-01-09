<?php
if ( !empty($err) ) {
        print $err;
}

echo wfMsgExt( 'specialcontact-intro-bug', array( 'parse' ) );
?>

<h2><?= wfMsg( 'specialcontact-form-header' ) ?></h2>

<form id="contactform" method="post" action="" enctype="multipart/form-data">
<input name="wpEmail" type="hidden" value="<?= $encEmail ?>" />
<input name="wpUserName" type="hidden" value="<?= $encName ?>" />

<?php if ( $isLoggedIn ) {
	echo wfMsgExt( 'specialcontact-logged-in-as', array( 'parse' ), $encName );
	echo wfMsgExt( 'specialcontact-mail-on-file', array( 'parse' ), $encEmail );
} else {
?>
<p>
<label for="wpUserName"><?= wfMsg( 'specialcontact-username' ) ?></label>
<input name="wpUserName" value="<?= $encName ?>" />
</p>

<p>
<label for="wpEmail"><?= wfMsg( 'specialcontact-yourmail' ) ?></label>
<input name="wpEmail" value="<?= $encEmail ?>" />
</p>
<?php } ?>

<p>
<label for="wpContactWikiName"><?= wfMsg( 'specialcontact-label-bug-link' ) ?></label>
<input name="wpContactWikiName" />
</p>

<p>
<label for="wpFeature"><?= wfMsg( 'specialcontact-label-bug-feature' ) ?></label>
<input name="wpFeature" />
</p>

<p>
<label for="wpDescription"><?= wfmsg( 'specialcontact-label-bug-description' ) ?></label>
<textarea name="wpDescription"></textarea>
</p>

<p>
<label for="wpScreenshot"><?= wfMsg( 'specialcontact-label-screenshot' ) ?></label>
<input name="wpScreenshot" type="file" accept="image/*" />
</p>
         
<?php
if( !$isLoggedIn && (isset($captchaForm)) ) {
	echo "<div class='captcha'>" .
		wfMsg( 'specialcontact-captchatitle' ) .
		$captchaForm .
		wfMsg( 'specialcontact-captchainfo' ) .
		"</div>\n";
}
?>

<input type="submit" value="<?= wfMsg( 'specialcontact-mail' ) ?>" />

<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" />
</form>

<p><?= wfMsgExt( 'specialcontact-noform-footer', array( 'parse' ) ) ?></p>

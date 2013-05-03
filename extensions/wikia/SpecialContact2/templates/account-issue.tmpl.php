<?php
if ( !empty($err) ) {
        print $err;
}

echo wfMsgExt( 'specialcontact-intro-account-issue', array( 'parse' ) );
?>

<h2><?= wfMsg( 'specialcontact-form-header' ) ?></h2>

<form id="contactform" method="post" action="" enctype="multipart/form-data">

<p>
<label for="wpUserName"><?= wfMsg( 'specialcontact-username' ) ?></label>
<input name="wpUserName" value="<?= $encName ?>" />
</p>

<p>
<label for="wpEmail"><?= wfMsg( 'specialcontact-yourmail' ) ?></label>
<input name="wpEmail" value="<?= $encEmail ?>" />
</p>

<p>
<label for="wpContactWikiName"><?= wfMsg( 'specialcontact-wikiname' ) ?></label>
<input name="wpContactWikiName" />
</p>

<p>
<label for="wpDescription"><?= wfMsg( 'specialcontact-label-account-issue-description' ) ?></label>
<textarea name="wpDescription"></textarea>
</p>

<p>
<label for="wpScreenshot1"><?= wfMsg( 'specialcontact-label-screenshot' ) ?></label>
<input id="wpScreenshot1" name="wpScreenshot[]" type="file" accept="image/*" />
</p>

<p class="additionalScreenShot">
<label for="wpScreenshot2"><?= wfMsg( 'specialcontact-label-additionalscreenshot' ) ?></label>
<input id="wpScreenshot2" name="wpScreenshot[]" type="file" accept="image/*" />
</p>

<p class="additionalScreenShot">
<label for="wpScreenshot3"><?= wfMsg( 'specialcontact-label-additionalscreenshot' ) ?></label>
<input id="wpScreenshot3" name="wpScreenshot[]" type="file" accept="image/*" />
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
<input type="hidden" id="wpAbTesting" name="wpAbTesting" value="[unknown]" />
</form>


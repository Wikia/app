<?php
if ( !empty($err) ) {
        print $err;
}

echo wfMsgExt( 'specialcontact-intro-bad-ad', array( 'parse' ) );
?>

<h2><?= wfMsg( 'specialcontact-form-header' ) ?></h2>

<form id="contactform" method="post" action="" enctype="multipart/form-data">
<input hidden="wpContactCategory" value="bad-ad" />

<p>
<label for="wpContactWikiName"><?= wfMsg( 'specialcontact-label-bad-ad-link' ) ?></label>
<input name="wpContactWikiName" />
</p>

<p>
<label for="wpDescription"><?= wfmsg( 'specialcontact-label-ba-ad-description' ) ?></label>
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

<?php
if ( !empty($err) ) {
        print $err;
}

echo wfMsgExt( 'specialcontact-intro-close-account', array( 'parse' ) );
?>

<h2><?= wfMsg( 'specialcontact-form-header' ) ?></h2>

<form id="contactform" method="post" action="">
<input name="wpEmail" type="hidden" value="<?= $encEmail ?>" />
<input name="wpUserName" type="hidden" value="<?= $encName ?>" />

<?= wfMsgExt( 'specialcontact-logged-in-as', array( 'parse' ), $encName, 'link' ) ?>

<?= wfMsgExt( 'specialcontact-mail-on-file', array( 'parse' ), $encEmail, 'link' ) ?>

<p>
<input type="checkbox" name="wpReadHelp" required />
<label for="wpReadHelp"><?= wfMsgExt( 'specialcontact-label-close-account-read-help', array( 'parseinline' ) ) ?></label>
</p>

<p>
<input type="checkbox" name="wpConfirm" required />
<label for="wpConfirm"><?= wfMsg( 'specialcontact-label-close-account-confirm' ) ?></label>
</p>

<input type="submit" value="<?= wfMsg( 'specialcontact-mail' ) ?>" />

<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>" />
<input type="hidden" id="wpAbTesting" name="wpAbTesting" value="[unknown]" />
</form>

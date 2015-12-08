<?php
if ( !empty($err) ) {
        print $err;
}

echo wfMessage( 'specialcontact-intro-close-account' )->parseAsBlock();
?>

<h2><?= wfMessage( 'specialcontact-form-header' )->escaped() ?></h2>

<form id="contactform" method="post" action="">
<input name="wpEmail" type="hidden" value="<?= $encEmail ?>" />
<input name="wpUserName" type="hidden" value="<?= $encName ?>" />
<input name="wpEditToken" type="hidden" value="<?= Sanitizer::encodeAttribute( $editToken ) ?>" />

<?= wfMessage( 'specialcontact-logged-in-as', $encName )->parseAsBlock() ?>

<?= wfMessage( 'specialcontact-mail-on-file', $encEmail )->parseAsBlock() ?>

<p>
<input type="checkbox" name="wpReadHelp" required />
<label for="wpReadHelp"><?= wfMessage( 'specialcontact-label-close-account-read-help' )->parse() ?></label>
</p>

<p>
<input type="checkbox" name="wpConfirm" required />
<label for="wpConfirm"><?= wfMessage( 'specialcontact-label-close-account-confirm' )->escaped() ?></label>
</p>

<input type="submit" value="<?= wfMessage( 'specialcontact-mail' )->escaped() ?>" />

<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?= Sanitizer::encodeAttribute( $_SERVER['HTTP_USER_AGENT'] ); ?>" />
<input type="hidden" id="wpAbTesting" name="wpAbTesting" value="[unknown]" />
</form>

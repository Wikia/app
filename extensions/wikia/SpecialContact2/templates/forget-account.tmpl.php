<?php
if ( !empty($err) ) {
        print $err;
}

echo wfMessage( 'specialcontact-intro-forget-account' )->parseAsBlock();
?>

<h2><?= wfMessage( 'specialcontact-form-header' )->escaped() ?></h2>

<form id="contactform" method="post" action="">
<input name="wpEmail" type="hidden" value="<?= $encEmail ?>" />
<input name="wpUserName" type="hidden" value="<?= $encName ?>" />
<input name="wpEditToken" type="hidden" value="<?= Sanitizer::encodeAttribute( $editToken ) ?>" />

<?= wfMessage( 'specialcontact-logged-in-as', $encName )->parseAsBlock() ?>

<?= wfMessage( 'specialcontact-mail-on-file', $encEmail )->parseAsBlock() ?>

<p>
	<input type="text" name="wpCountry" required />
	<label for="wpFullName"><?= wfMessage( 'specialcontact-label-forget-account-country-info' )->escaped() ?></label>
</p>

<p>
	<input type="text" name="wpFullName" required />
	<label for="wpFullName"><?= wfMessage( 'specialcontact-label-forget-account-full-name' )->escaped() ?></label>
</p>

<p>
	<input type="email" name="wpEmailAddress" required />
	<label for="wpEmailAddress"><?= wfMessage( 'specialcontact-label-forget-account-email-address' )->escaped() ?></label>
</p>

<p>
	<input type="checkbox" name="wpIsOnBehalf" required />
	<label for="wpIsOnBehalf"><?= wfMessage( 'specialcontact-label-forget-account-is-on-behalf' )->escaped() ?></label>
</p>

<p class="wp-relationship-input-wrapper" style="display: none;">
	<input type="text" name="wpRelationship" required disabled />
	<label for="wpRelationship"><?= wfMessage( 'specialcontact-label-forget-account-relationship' )->escaped() ?></label>
</p>

<p>
	<input type="checkbox" name="wpPreviousRequest" required />
	<label for="wpPreviousRequest"><?= wfMessage( 'specialcontact-label-forget-account-previous-request' )->escaped() ?></label>
</p>

<p>
	<input type="checkbox" name="wpProcessingConsent" required />
	<label for="wpProcessingConsent"><?= wfMessage( 'specialcontact-label-forget-account-processing-consent' )->escaped() ?></label>
</p>

<p>
	<?= wfMessage( 'specialcontact-label-forget-account-data-processing-info' )->escaped() ?>
</p>

<p>
	<input type="checkbox" name="wpConfirm" required />
	<label for="wpConfirm"><?= wfMessage( 'specialcontact-label-forget-account-confirm-checkbox' )->escaped() ?></label>
</p>

<input type="submit" value="<?= wfMessage( 'specialcontact-label-forget-account-confirm' )->escaped() ?>" />

<p>
	<?= wfMessage( 'specialcontact-label-forget-account-data-deletion-info' )->escaped() ?>
</p>

<input type="hidden" id="wpBrowser" name="wpBrowser" value="<?= Sanitizer::encodeAttribute( $_SERVER['HTTP_USER_AGENT'] ); ?>" />
<input type="hidden" id="wpAbTesting" name="wpAbTesting" value="[unknown]" />
</form>

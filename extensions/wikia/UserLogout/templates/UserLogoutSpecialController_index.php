<form action="<?= Sanitizer::encodeAttribute( $logoutUrl ); ?>" method="post">
	<fieldset>
		<legend><?= wfMessage( 'userlogout' )->escaped(); ?></legend>
		<input type="hidden" name="redirect" value="<?= Sanitizer::encodeAttribute( $redirectUrl ); ?>" />
		<input type="submit" class="wds-button" value="<?= wfMessage( 'confirm' )->escaped(); ?>" />
	</fieldset>
</form>

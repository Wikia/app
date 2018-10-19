<div class="auth-preferences facebook-state-<?= Sanitizer::encodeAttribute( $state ); ?>">
	<div id="fbConnectPreferences">
		<span id="facebook-connect-button" class="wds-button facebook-button" role="button">
			<?= wfMessage( 'prefs-fbconnect-prefstext' )->escaped(); ?>
		</span>
	</div>
	<div id="fbDisconnectPreferences">
		<span id="facebook-disconnect-button" class="wds-button facebook-button" role="button">
			<?= wfMessage( 'prefs-fbconnect-disconnect-prefstext' )->escaped(); ?>
		</span>
	</div>
	<div id="googleConnectPreferences">
		<iframe class="google-button" src="<?= $googleConnectAuthUrl; ?>"></iframe>
	</div>
</div>

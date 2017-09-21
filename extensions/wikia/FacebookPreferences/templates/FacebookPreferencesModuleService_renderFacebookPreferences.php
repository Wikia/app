<div class="facebook-preferences facebook-state-<?= Sanitizer::encodeAttribute( $state ); ?>">
	<div id="fbConnectPreferences">
		<p><?= wfMessage( 'fbconnect-convert' )->escaped(); ?></p>
		<span id="facebook-connect-button" class="wds-button facebook-button" role="button">
			<?= wfMessage( 'prefs-fbconnect-prefstext' )->escaped(); ?>
		</span>
	</div>
	<div id="fbDisconnectPreferences">
		<p><?= wfMessage( 'fbconnect-disconnect-account-link' )->parse(); ?></p>
		<span id="facebook-disconnect-button" class="wds-button facebook-button" role="button">
			<?= wfMessage( 'prefs-fbconnect-disconnect-prefstext' )->escaped(); ?>
		</span>
	</div>
</div>

<div class="auth-preferences facebook-state-<?= Sanitizer::encodeAttribute( $state ); ?>">
	<div id="fbConnectPreferences">

		<span id="facebook-connect-button" class="wds-button facebook-button" role="button">
			<img src="/resources/wikia/ui_components/button/images/facebook-icon.svg"
				 class="facebook-icon"><?= wfMessage( 'prefs-fbconnect-prefstext' )->escaped(); ?>
		</span>
	</div>
	<div id="fbDisconnectPreferences">
		<img src="/resources/wikia/ui_components/button/images/facebook-icon.svg"
			 class="facebook-icon">
		<span id="facebook-disconnect-button" class="wds-button facebook-button" role="button">
			<?= wfMessage( 'prefs-fbconnect-disconnect-prefstext' )->escaped(); ?>
		</span>
	</div>
	<div id="googleConnectPreferences">
		<iframe class="google-button" src="<?= $googleConnectAuthUrl; ?>"></iframe>
	</div>
	<div id="twitchConnectPreferences">
		<iframe class="twitch-button" src="<?= $twitchConnectAuthUrl; ?>"></iframe>
	</div>
</div>

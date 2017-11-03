<?php

class FacebookPreferencesHooks {
	public static function onGetPreferences( User $user, array &$preferences ): bool {
		$html = F::app()->renderView(
			FacebookPreferencesModuleService::class,
			'renderFacebookPreferences'
		);

		$preferences[] = [
			'help' => $html,
			'label' => '',
			'type' => 'info',
			'section' => 'fbconnect-prefstext/fbconnect-status-prefstext',
		];

		return true;
	}

}

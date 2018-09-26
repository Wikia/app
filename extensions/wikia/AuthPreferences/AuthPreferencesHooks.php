<?php

class AuthPreferencesHooks {
	public static function onGetPreferences( User $user, array &$preferences ): bool {
		$html = F::app()->renderView(
			AuthPreferencesModuleService::class,
			'renderAuthPreferences'
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

<?php

use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\ExternalAuth\FacebookService;

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

	public static function onCloseAccount( User $user ) {
		/** @var FacebookService $facebookService */
		$facebookService = Injector::getInjector()->get( FacebookService::class );

		$facebookService->unlinkAccount( $user );

		return true;
	}
}

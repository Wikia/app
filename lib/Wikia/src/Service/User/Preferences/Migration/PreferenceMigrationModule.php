<?php

namespace Wikia\Service\User\Preferences\Migration;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class PreferenceMigrationModule implements Module {

	const PREFERENCE_CORRECTION_RAMP = 0;

	public function configure( InjectorBuilder $builder ) {
		global $wgGlobalUserPreferenceWhiteList, $wgLocalUserPreferenceWhiteList, $wgCityId;

		$preferenceCorrectionEnabled = isset( $wgCityId ) && $wgCityId % 100 < self::PREFERENCE_CORRECTION_RAMP;

		$builder
			->bind( PreferenceCorrectionService::PREFERENCE_CORRECTION_ENABLED )->to($preferenceCorrectionEnabled)
			->bind( PreferenceScopeService::GLOBAL_SCOPE_PREFS )->to( $wgGlobalUserPreferenceWhiteList )
			->bind( PreferenceScopeService::LOCAL_SCOPE_PREFS )->to( $wgLocalUserPreferenceWhiteList );
	}
}

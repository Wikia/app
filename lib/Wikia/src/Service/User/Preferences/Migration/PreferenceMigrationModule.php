<?php

namespace Wikia\Service\User\Preferences\Migration;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Util\Statistics\BernoulliTrial;

class PreferenceMigrationModule implements Module {

	const PREFERENCE_CORRECTION_RAMP = 0;
	const PREFERENCE_CORRECTION_SAMPLE_RATE = 0.2;

	public function configure( InjectorBuilder $builder ) {
		global $wgGlobalUserPreferenceWhiteList, $wgLocalUserPreferenceWhiteList, $wgCityId;

		$preferenceCorrectionEnabled = isset( $wgCityId ) && $wgCityId % 100 < self::PREFERENCE_CORRECTION_RAMP;

		$builder
			->bind( PreferenceCorrectionService::PREFERENCE_CORRECTION_ENABLED )->to( $preferenceCorrectionEnabled )
			->bind( PreferenceCorrectionService::PREFERENCE_CORRECTION_SAMPLER )->to( new BernoulliTrial( self::PREFERENCE_CORRECTION_SAMPLE_RATE ) )
			->bind( PreferenceScopeService::GLOBAL_SCOPE_PREFS )->to( $wgGlobalUserPreferenceWhiteList )
			->bind( PreferenceScopeService::LOCAL_SCOPE_PREFS )->to( $wgLocalUserPreferenceWhiteList );
	}
}

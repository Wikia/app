<?php

namespace Wikia\Service\User\Preferences\Migration;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class PreferenceMigrationModule implements Module {

	public function configure( InjectorBuilder $builder ) {
		global $wgGlobalUserPreferenceWhiteList, $wgLocalUserPreferenceWhiteList;

		$builder
			->bind( PreferenceScopeService::GLOBAL_SCOPE_PREFS )->to( $wgGlobalUserPreferenceWhiteList )
			->bind( PreferenceScopeService::LOCAL_SCOPE_PREFS )->to( $wgLocalUserPreferenceWhiteList );
	}
}

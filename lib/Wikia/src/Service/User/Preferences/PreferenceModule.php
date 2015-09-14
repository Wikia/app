<?php

namespace Wikia\Service\User\Preferences;

use User;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use Wikia\Persistence\User\Preferences\PreferencePersistenceModuleMySQL;
use Wikia\Persistence\User\Preferences\PreferencePersistenceSwaggerService;

class PreferenceModule implements Module {
	const SWAGGER_SERVICE_RAMP_USAGE = 0;

	public function configure(InjectorBuilder $builder) {
		$builder
			->bind(PreferencePersistence::class)->toClass(PreferencePersistenceSwaggerService::class)
			->bind(PreferenceService::HIDDEN_PREFS)->to(function() {
				global $wgHiddenPrefs;
				return $wgHiddenPrefs;
			})
			->bind(PreferenceService::DEFAULT_PREFERENCES)->to(function() {
				return User::getDefaultPreferences();
			})
			->bind(PreferenceService::FORCE_SAVE_PREFERENCES)->to(function() {
				global $wgGlobalUserProperties;
				return $wgGlobalUserProperties;
			});
	}
}

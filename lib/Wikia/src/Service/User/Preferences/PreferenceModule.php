<?php

namespace Wikia\Service\User\Preferences;

use User;
use Wikia\Cache\BagOStuffCacheProvider;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use Wikia\Persistence\User\Preferences\PreferencePersistenceModuleMySQL;
use Wikia\Persistence\User\Preferences\PreferencePersistenceSwaggerService;

class PreferenceModule implements Module {
	const PREFERENCE_CACHE_VERSION = 1;

	public function configure(InjectorBuilder $builder) {
		$builder
			->bind(PreferencePersistence::class)->toClass(PreferencePersistenceSwaggerService::class)
			->bind(PreferenceService::CACHE_PROVIDER)->to(function() {
				global $wgMemc;
				$provider = new BagOStuffCacheProvider($wgMemc);
				$provider->setNamespace(PreferenceService::class.":".self::PREFERENCE_CACHE_VERSION);

				return $provider;
			})
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

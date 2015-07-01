<?php

namespace Wikia\Service\User;

use User;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Persistence\User\PreferencePersistenceModuleMySQL;

class PreferenceModule implements Module {
	public function configure(InjectorBuilder $builder) {
		$builder
			->addModule(self::getMySQLPersistenceModule())
			->bind(PreferenceService::class)->toClass(PreferenceKeyValueService::class)
			->bind(UserPreferences::HIDDEN_PREFS)->to(function() {
				global $wgHiddenPrefs;
				return $wgHiddenPrefs;
			})
			->bind(UserPreferences::DEFAULT_PREFERENCES)->to(function() {
				return User::getDefaultOptions();
			})
			->bind(UserPreferences::FORCE_SAVE_PREFERENCES)->to(function() {
				global $wgGlobalUserProperties;
				return $wgGlobalUserProperties;
			});
	}

	private static function getMySQLPersistenceModule() {
		$masterProvider = function() {
			global $wgExternalSharedDB;
			return wfGetDB(DB_MASTER, [], $wgExternalSharedDB);
		};
		$slaveProvider = function() {
			global $wgExternalSharedDB;
			return wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);
		};

		return new PreferencePersistenceModuleMySQL($masterProvider, $slaveProvider);
	}
}

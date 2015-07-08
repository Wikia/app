<?php

namespace Wikia\Service\User;

use User;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Persistence\User\PreferencePersistence;
use Wikia\Persistence\User\PreferencePersistenceModuleMySQL;
use Wikia\Persistence\User\PreferencePersistenceSwaggerService;

class PreferenceModule implements Module {
	public function configure(InjectorBuilder $builder) {
		$builder
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

		self::bindMysqlService($builder);
//		self::bindSwaggerService($builder);
	}

	private static function bindMysqlService(InjectorBuilder $builder) {
		$masterProvider = function() {
			global $wgExternalSharedDB;
			return wfGetDB(DB_MASTER, [], $wgExternalSharedDB);
		};
		$slaveProvider = function() {
			global $wgExternalSharedDB;
			return wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);
		};

		$builder->addModule(new PreferencePersistenceModuleMySQL($masterProvider, $slaveProvider));
	}

	private static function bindSwaggerService(InjectorBuilder $builder) {
		$builder->bind(PreferencePersistence::class)->toClass(PreferencePersistenceSwaggerService::class);
	}
}

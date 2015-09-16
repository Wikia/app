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
			->bind(PreferenceService::class)->toClass(PreferenceKeyValueService::class)
			->bind(UserPreferences::HIDDEN_PREFS)->to(function() {
				global $wgHiddenPrefs;
				return $wgHiddenPrefs;
			})
			->bind(UserPreferences::DEFAULT_PREFERENCES)->to(function() {
				return User::getDefaultPreferences();
			})
			->bind(UserPreferences::FORCE_SAVE_PREFERENCES)->to(function() {
				global $wgGlobalUserProperties;
				return $wgGlobalUserProperties;
			});

		self::bindService($builder);
	}

	private static function bindService(InjectorBuilder $builder) {
		global $wgCityId;

		if (isset($wgCityId) && $wgCityId % 100 < self::SWAGGER_SERVICE_RAMP_USAGE) {
			self::bindSwaggerService($builder);
		} else {
			self::bindMysqlService($builder);
		}
	}

	private static function bindMysqlService(InjectorBuilder $builder) {
		$masterProvider = function() {
			global $wgExternalSharedDB, $wgSharedDB;

			if (isset($wgSharedDB)) {
				$db = wfGetDB(DB_MASTER, [], $wgExternalSharedDB);
			} else {
				$db = wfGetDB(DB_MASTER);
			}

			return $db;
		};
		$slaveProvider = function() {
			global $wgExternalSharedDB, $wgSharedDB;

			if (isset($wgSharedDB)) {
				$db = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);
			} else {
				$db = wfGetDB(DB_SLAVE);
			}

			return $db;
		};
		$whiteListProvider = function () {
			global $wgLocalUserPreferenceWhiteList;
			global $wgGlobalUserPreferenceWhiteList;
			$wgUserPreferenceWhiteList = [
				'literals' => array_merge( (array)$wgLocalUserPreferenceWhiteList[ 'literals' ],
					(array)$wgGlobalUserPreferenceWhiteList[ 'literals' ] ),
				'regexes' => array_merge( (array)$wgLocalUserPreferenceWhiteList[ 'regexes' ],
					(array)$wgGlobalUserPreferenceWhiteList[ 'regexes' ] ),
			];
			return $wgUserPreferenceWhiteList;
		};

		$builder->addModule(new PreferencePersistenceModuleMySQL($masterProvider, $slaveProvider, $whiteListProvider));
	}

	private static function bindSwaggerService(InjectorBuilder $builder) {
		$builder->bind(PreferencePersistence::class)->toClass(PreferencePersistenceSwaggerService::class);
	}
}

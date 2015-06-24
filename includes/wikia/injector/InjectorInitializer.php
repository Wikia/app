<?php

use Wikia\DependencyInjection\Injector;
use Wikia\Persistence\User\PreferencePersistenceModuleMySQL;
use Wikia\Service\User\PreferenceKeyValueService;
use Wikia\Service\User\PreferenceService;

class InjectorInitializer {
	public static function init() {
		static $initialized = false;

		if ($initialized) {
			return;
		}

		Injector::getInjector()
			->bind(PreferenceService::class, PreferenceKeyValueService::class)
			->addModule(self::getPreferencePersistenceModule())
			->build();
	}

	private static function getPreferencePersistenceModule() {
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

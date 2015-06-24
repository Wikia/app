<?php

use Doctrine\Common\Cache\CacheProvider;
use Wikia\DependencyInjection\Injector;
use Wikia\Persistence\User\PreferencePersistenceModuleMySQL;
use Wikia\Service\User\PreferenceKeyValueService;
use Wikia\Service\User\PreferenceService;
use Wikia\DependencyInjection\InjectorBuilder;

class InjectorInitializer {
	public static function init(CacheProvider $cacheProvider = null) {
		Injector::setInjector(
			(new InjectorBuilder())
				->withCache($cacheProvider)
				->bind(PreferenceService::class)->toClass(PreferenceKeyValueService::class)
				->addModule(self::getPreferencePersistenceModule())
				->build());
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

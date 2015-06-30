<?php

namespace Wikia\DependencyInjection;

use Doctrine\Common\Cache\CacheProvider;
use UserPreferencesModule;

class InjectorInitializer {
	public static function init(CacheProvider $cacheProvider = null) {
		Injector::setInjector(
			(new InjectorBuilder())
				->withCache($cacheProvider)
				->addModule(new UserPreferencesModule())
				->build());
	}
}

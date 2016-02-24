<?php

namespace Wikia\DependencyInjection;

use Doctrine\Common\Cache\CacheProvider;
use Wikia\Service\Gateway\ConsulUrlProviderModule;
use Wikia\Service\Swagger\ApiProviderModule;
use Wikia\Service\User\Preferences\Migration\PreferenceMigrationModule;
use Wikia\Service\User\Preferences\PreferenceModule;
use Wikia\Service\User\Attributes\AttributesModule;
use Wikia\Service\User\Auth\AuthModule;

class InjectorInitializer {
	public static function init(CacheProvider $cacheProvider = null) {
		Injector::setInjector(
			(new InjectorBuilder())
				->withCache($cacheProvider)
				->addModule(new PreferenceModule())
				->addModule(new PreferenceMigrationModule())
				->addModule(new AttributesModule())
				->addModule(new AuthModule())
				->addModule(new ConsulUrlProviderModule())
				->addModule(new ApiProviderModule())
				->build());
	}
}

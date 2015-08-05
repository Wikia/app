<?php

namespace Wikia\DependencyInjection;

use Doctrine\Common\Cache\CacheProvider;
use Wikia\Service\Gateway\ConsulUrlProviderModule;
use Wikia\Service\User\Preferences\PreferenceModule;
use Wikia\Service\User\Attributes\AttributesModule;

class InjectorInitializer {
	public static function init(CacheProvider $cacheProvider = null) {
		Injector::setInjector(
			(new InjectorBuilder())
				->withCache($cacheProvider)
				->addModule(new PreferenceModule())
				->addModule(new AttributesModule())
				->addModule(new ConsulUrlProviderModule())
				->build());
	}
}

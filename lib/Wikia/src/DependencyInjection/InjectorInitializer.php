<?php

namespace Wikia\DependencyInjection;

use Doctrine\Common\Cache\CacheProvider;
use Wikia\Service\Gateway\KubernetesUrlProviderModule;
use Wikia\Service\Swagger\ApiProviderModule;
use Wikia\Service\User\Attributes\AttributesModule;
use Wikia\Service\User\Auth\AuthModule;
use Wikia\Service\User\Permissions\PermissionsModule;
use Wikia\Service\User\Preferences\Migration\PreferenceMigrationModule;
use Wikia\Service\User\Preferences\PreferenceModule;

class InjectorInitializer {
	public static function init( CacheProvider $cacheProvider = null ) {
		Injector::setInjector( static::newDefaultInjectorBuilder( $cacheProvider )->build() );
	}

	public static function newInjectorWithOverrides( callable ...$overridingModules ): Injector {
		$injectorBuilder = static::newDefaultInjectorBuilder();

		foreach ( $overridingModules as $module ) {
			$module( $injectorBuilder );
		}

		return $injectorBuilder->build();
	}

	private static function newDefaultInjectorBuilder( CacheProvider $cacheProvider = null ): InjectorBuilder {
		return ( new InjectorBuilder() )->withCache( $cacheProvider )
			->addModule( new PreferenceModule() )
			->addModule( new PreferenceMigrationModule() )
			->addModule( new AttributesModule() )
			->addModule( new PermissionsModule() )
			->addModule( new AuthModule() )
			->addModule( new KubernetesUrlProviderModule() )
			->addModule( new ApiProviderModule() );
	}
}

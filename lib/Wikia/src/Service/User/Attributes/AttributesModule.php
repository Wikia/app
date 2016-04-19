<?php

namespace Wikia\Service\User\Attributes;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Persistence\User\Attributes\AttributePersistence;
use Wikia\Persistence\User\Attributes\AttributePersistenceSwagger;
use Wikia\Cache\BagOStuffCacheProvider;

class AttributesModule implements Module {
	const ATTRIBUTES_CACHE_VERSION = 1;

	public function configure( InjectorBuilder $builder ) {
		$builder
			->bind( AttributeService::class )->toClass( AttributeKeyValueService::class )
			->bind( AttributePersistence::class )->toClass( AttributePersistenceSwagger::class )
			->bind( UserAttributes::CACHE_PROVIDER )->to( function() {
				global $wgMemc;
				$provider = new BagOStuffCacheProvider( $wgMemc );
				$provider->setNamespace( UserAttributes::class . ":" . self::ATTRIBUTES_CACHE_VERSION );

				return $provider;
			} )
			->bind( UserAttributes::DEFAULT_ATTRIBUTES )->to( function() {
				return \User::getDefaultOptions();
			} );
	}
}
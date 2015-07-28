<?php

namespace Wikia\Service\User\Attributes;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Persistence\User\Attributes\AttributePersistence;
use Wikia\Persistence\User\Attributes\AttributePersistenceSwagger;

class AttributesModule implements Module {
	public function configure( InjectorBuilder $builder ) {
		$builder
			->bind( AttributeService::class )->toClass( AttributeKeyValueService::class )
			->bind( AttributePersistence::class )->toClass( AttributePersistenceSwagger::class )
			->bind( UserAttributes::DEFAULT_ATTRIBUTES )->to( function() {
				return \User::getDefaultOptions();
			} );
	}
}
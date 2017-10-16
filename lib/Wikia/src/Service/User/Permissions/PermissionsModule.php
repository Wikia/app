<?php

namespace Wikia\Service\User\Permissions;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class PermissionsModule implements Module {

	public function configure( InjectorBuilder $builder ) {
		$builder
			->bind( PermissionsService::class )->toClass( PermissionsServiceImpl::class );
	}
}

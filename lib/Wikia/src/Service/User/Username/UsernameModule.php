<?php

namespace Wikia\Service\User\Username;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class UsernameModule implements Module {

	public function configure( InjectorBuilder $builder ) {
		$builder
			->bind( UsernameService::class )->toClass( FallbackUsernameService::class );
	}
}
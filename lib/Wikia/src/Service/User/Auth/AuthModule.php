<?php

namespace Wikia\Service\User\Auth;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Service\User\Auth\AuthService;
use Wikia\Service\User\Auth\MediaWikiAuthService;

class AuthModule implements Module {

	public function configure( InjectorBuilder $builder ) {
		$builder
			->bind( AuthService::class )
			->toClass( MediaWikiAuthService::class );
	}

}

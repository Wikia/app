<?php

namespace Wikia\Service\User\Auth;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Service\Helios\HeliosClient;
use Wikia\Service\Helios\HeliosClientImpl;

class AuthModule implements Module {

	public function configure( InjectorBuilder $builder ) {
		$builder
			->bind( AuthService::class )->toClass( MediaWikiAuthService::class )
			->bind( HeliosClient::class )->toClass( HeliosClientImpl::class )
			->bind( CookieHelper::class )->toClass( HeliosCookieHelper::class )
			->bind( HeliosClientImpl::BASE_URI )->to( function () {
				global $wgHeliosBaseUri;
				return $wgHeliosBaseUri;
			} )
			->bind( HeliosClientImpl::CLIENT_ID )->to( function () {
				global $wgHeliosClientId;
				return $wgHeliosClientId;
			} )
			->bind( HeliosClientImpl::CLIENT_SECRET )->to( function () {
				global $wgHeliosClientSecret;
				return $wgHeliosClientSecret;
			} );
	}
}

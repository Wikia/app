<?php

namespace Wikia\Service\User\Auth;

use DI\Container;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Service\Gateway\UrlProvider;
use Wikia\Service\Helios\HeliosClient;
use Wikia\Service\Helios\HeliosClientImpl;
use Wikia\Util\Statistics\BernoulliTrial;

class AuthModule implements Module {

	public function configure( InjectorBuilder $builder ) {
		$builder
			->bind( AuthService::class )->toClass( MediaWikiAuthService::class )
			->bind( HeliosClient::class )->toClass( HeliosClientImpl::class )
			->bind( CookieHelper::class )->toClass( HeliosCookieHelper::class )
			->bind( HeliosClientImpl::SCHWARTZ_TOKEN )->to( function () {
				global $wgTheSchwartzSecretToken;
				return $wgTheSchwartzSecretToken;
			} )
			->bind( HeliosClientImpl::BASE_URI )->to( function ( Container $c ) {
					global $wgAuthServiceName, $wgAuthServiceInternalUrl;

					if ( !empty( $wgAuthServiceInternalUrl ) && ( new BernoulliTrial( 0.5 ) )->shouldSample() ) {
						return $wgAuthServiceInternalUrl;
					}

					/** @var UrlProvider $urlProvider */
					$urlProvider = $c->get(UrlProvider::class);
					return "http://".$urlProvider->getUrl($wgAuthServiceName)."/";
			} );
	}
}

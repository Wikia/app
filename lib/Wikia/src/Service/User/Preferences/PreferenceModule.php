<?php

namespace Wikia\Service\User\Preferences;

use Interop\Container\ContainerInterface;
use User;
use Wikia\Cache\BagOStuffCacheProvider;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use Wikia\Persistence\User\Preferences\PreferencePersistenceSwaggerService;
use Wikia\Service\User\Preferences\Migration\PreferenceScopeService;

class PreferenceModule implements Module {
	const PREFERENCE_CACHE_VERSION = 3;

	public function configure( InjectorBuilder $builder ) {
		$builder
			->bind( PreferenceService::class )->toClass( PreferenceServiceImpl::class )
			->bind( PreferencePersistence::class )->toClass( PreferencePersistenceSwaggerService::class )
			->bind( PreferenceServiceImpl::CACHE_PROVIDER )->to( function() {
				global $wgMemc;
				$provider = new BagOStuffCacheProvider( $wgMemc );
				$provider->setNamespace( PreferenceService::class . ":" . self::PREFERENCE_CACHE_VERSION );

				return $provider;
			} )
			->bind( PreferenceServiceImpl::HIDDEN_PREFS )->to( function() {
				global $wgHiddenPrefs;
				return $wgHiddenPrefs;
			} )
			->bind( PreferenceServiceImpl::DEFAULT_PREFERENCES )->to( function( ContainerInterface $c ) {
				/** @var PreferenceScopeService $scopeService */
				$scopeService = $c->get( PreferenceScopeService::class );
				$defaultOptions = User::getDefaultOptions();
				$defaultPreferences = new UserPreferences();

				foreach ( $defaultOptions as $name => $val ) {
					if ( $scopeService->isGlobalPreference( $name ) ) {
						$defaultPreferences->setGlobalPreference( $name, $val );
					} elseif ( $scopeService->isLocalPreference( $name ) ) {
						list( $prefName, $wikiId ) = $scopeService->splitLocalPreference( $name );
						$defaultPreferences->setLocalPreference( $prefName, $wikiId, $val );
					}
				}

				return $defaultPreferences;
			} )
			->bind( PreferenceServiceImpl::FORCE_SAVE_PREFERENCES )->to( function() {
				global $wgGlobalUserProperties;
				return $wgGlobalUserProperties;
			} );
	}
}

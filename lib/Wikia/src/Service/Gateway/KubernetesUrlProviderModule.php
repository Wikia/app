<?php

namespace Wikia\Service\Gateway;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class KubernetesUrlProviderModule implements Module {
	public function configure( InjectorBuilder $builder ) {
		global $wgWikiaEnvironment, $wgWikiaDatacenter;

		$builder
			->bind( UrlProvider::class )->toClass( KubernetesUrlProvider::class )
			->bind( KubernetesUrlProvider::URL_PROVIDER_WIKIA_ENVIRONMENT )->to( $wgWikiaEnvironment )
			->bind( KubernetesUrlProvider::URL_PROVIDER_DATACENTER )->to( $wgWikiaDatacenter );
	}
}

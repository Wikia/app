<?php
namespace Wikia\Service\Gateway;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class KubernetesUrlProviderModule implements Module {
	public function configure( InjectorBuilder $builder ) {
		global $wgWikiaEnvironment, $wgWikiaDatacenter;

		$builder->bind( KubernetesUrlProvider::URL_PROVIDER_WIKIA_ENVIRONMENT )
			->to( $wgWikiaEnvironment );
		$builder->bind( KubernetesUrlProvider::URL_PROVIDER_DATACENTER )
			->to( $wgWikiaDatacenter );
	}
}

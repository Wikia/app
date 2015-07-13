<?php

namespace Wikia\Service\Gateway;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class ConsulUrlProviderModule implements Module {
	public function configure(InjectorBuilder $builder) {
		global $wgConsulUrl, $wgConsulServiceTag;

		$builder
			->bind(UrlProvider::class)->toClass(ConsulUrlProvider::class)
			->bind(ConsulUrlProvider::BASE_URL)->to($wgConsulUrl)
			->bind(ConsulUrlProvider::SERVICE_TAG)->to($wgConsulServiceTag);
	}
}

<?php
/**
 * ConsulModule
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Service\Gateway;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class ConsulUrlProviderModule implements Module {
	public function configure(InjectorBuilder $builder) {
		$builder
			->bind(UrlProvider::class)->toClass(ConsulUrlProvider::class)
			->bind(ConsulUrlProvider::BASE_URL)->to("http://consul.service.sjc.consul:8500") // TODO: get from a global
			->bind(ConsulUrlProvider::SERVICE_TAG)->to("testing");
	}
}

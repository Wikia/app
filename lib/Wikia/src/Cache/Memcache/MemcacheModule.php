<?php

namespace Wikia\Cache\Memcache;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class MemcacheModule implements Module {

	public function configure(InjectorBuilder $builder) {
		$builder->bind(Memcache::BAG_O_STUFF)->to(function() {
			global $wgMemc;
			return $wgMemc;
		});
	}
}

<?php

namespace ContributionPrototype;

use Interop\Container\ContainerInterface;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\Service\Gateway\UrlProvider;

class ContributionPrototypeModule implements Module {

	public function configure(InjectorBuilder $builder) {
		$builder
				->bind(CPArticleRenderer::class)->to(function(ContainerInterface $c) {
					global $wgContributionPrototypeExternalHost, $wgCityId, $wgDBname;

					return new CPArticleRenderer(
							$wgContributionPrototypeExternalHost, 
							$wgCityId, 
							$wgDBname,
							$c->get(UrlProvider::class));
				});
	}
}

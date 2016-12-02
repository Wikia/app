<?php

namespace ContributionPrototype;

use Wikia\DependencyInjection\Injector;
use Wikia\Service\Gateway\UrlProvider;

class Utils {

	/**
	 * @return CPArticleRenderer
	 */
	public static function getRenderer() {
		global $wgContributionPrototypeExternalHost, $wgCityId, $wgDBname;

		/** @var UrlProvider $urlProvider */
		$urlProvider = Injector::getInjector()->get(UrlProvider::class);

		return new CPArticleRenderer(
				$wgContributionPrototypeExternalHost,
				$wgCityId,
				$wgDBname,
				$urlProvider);
	}
}

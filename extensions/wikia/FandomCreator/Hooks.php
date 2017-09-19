<?php

namespace FandomCreator;

use Wikia\DependencyInjection\Injector;
use Wikia\Service\Gateway\UrlProvider;
use WikiaController;

class Hooks {
	const SERVICE_NAME = "content-graph-service";

	public static function onNavigationApiGetData(WikiaController $controller) {
		self::api();
	}

	private static function getEntityPath($entityId) {
		return "/wiki/${entityId}";
	}

	/**
	 * @return FandomCreatorApi
	 */
	private static function api() {
		static $instance = null;

		if ($instance == null) {
			global $wgFandomCreatorCommunityId, $wgFandomCreatorOverrideUrl;

			if (!empty($wgFandomCreatorOverrideUrl)) {
				$fandomCreatorUrl = $wgFandomCreatorOverrideUrl;
			} else {
				/** @var UrlProvider $urlProvider */
				$urlProvider = Injector::getInjector()->get(UrlProvider::class);
				$fandomCreatorUrl = $urlProvider->getUrl(self::SERVICE_NAME);
			}

			$instance = new FandomCreatorApi("http://$fandomCreatorUrl", $wgFandomCreatorCommunityId);
		}

		return $instance;
	}
}
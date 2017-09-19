<?php

namespace FandomCreator;

use Wikia\DependencyInjection\Injector;
use Wikia\Service\Gateway\UrlProvider;
use WikiaDispatchableObject;

class Hooks {
	const SERVICE_NAME = "content-graph-service";

	public static function onNavigationApiGetData(WikiaDispatchableObject $dispatchable, int $maxTopLevelElements) {
		$sitemap = self::api()->getSitemap();
		if ($sitemap === null || !isset($sitemap->home->children)) {
			return;
		}

		$sitemapData = [];
		foreach ($sitemap->home->children as $i => $child) {
			if ($i >= $maxTopLevelElements) {
				break;
			}

			$sitemapData[] = self::convertToSitemapData($child);
		}

		$dispatchable->getResponse()->setData([
				'navigation' => [
						'wikia' => [],
						'wiki' => $sitemapData
				]
		]);
	}

	private static function convertToSitemapData($entry) {
		$data = [
				'text' => $entry->name,
				'href' => self::getEntityPath($entry->id)
		];

		if (isset($entry->children)) {
			$data['children'] = [];
			foreach ($entry->children as $child) {
				$data['children'][] = self::convertToSitemapData($child);
			}
		}

		return $data;
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
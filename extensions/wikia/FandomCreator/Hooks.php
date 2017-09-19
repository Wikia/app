<?php

namespace FandomCreator;

use Wikia\DependencyInjection\Injector;
use Wikia\Service\Gateway\UrlProvider;
use WikiaDispatchableObject;

class Hooks {
	const SERVICE_NAME = "content-graph-service";
	const COMMUNITY_CENTRAL_ID_VALUE = '-1';

	public static function onNavigationApiGetData( WikiaDispatchableObject $dispatchable, string $communityId, array $maxElementsPerLevel ) {
		if (!self::isValidCommunityId($communityId)) {
			return;
		}

		$sitemap = self::api()->getSitemap($communityId);
		if ( $sitemap === null || !isset( $sitemap->home->children ) ) {
			return;
		}

		$sitemapData = [];
		foreach ( $sitemap->home->children as $i => $child ) {
			if ( $i >= $maxElementsPerLevel[0] ) {
				break;
			}

			$nextData = self::convertToSitemapData( $child, 1, $maxElementsPerLevel );
			if ( $nextData !== null ) {
				$sitemapData[] = $nextData;
			}
		}

		$dispatchable->getResponse()->setData( [
				'navigation' => [
						'wikia' => [],
						'wiki' => $sitemapData
				]
		] );
	}

	public static function onDesignSystemApiGetAllElements(WikiaDispatchableObject $dispatchable, string $communityId) {
		if (!self::isValidCommunityId($communityId)) {
			return;
		}

		$community = self::api()->getCommunity($communityId);
		if ($community === null) {
			return;
		}

		$currentData = $dispatchable->getResponse()->getData();
		$currentData['community-header']['sitename']['title']['value'] = $community->displayName;
		$currentData['community-header']['sitename']['href'] = '/';

		$theme = null;
		if (isset($community->configurations)) {
			foreach ($community->configurations as $config) {
				if ($config->key === 'theme') {
					$theme = json_decode($config->value);
					break;
				}
			}
		}

		if (!empty($theme->graphics->wordmark)) {
			// need to recreate entirely in case it wasn't set by the DS api
			$currentData['community-header']['wordmark'] = [
					'type' => 'link-image',
					'href' => '/',
					'image-data' => [
							'type' => 'image-external',
							'url' => $theme->graphics->wordmark,
							'width' => '250',
							'height' => '65',
					],
					'title' => [
							'type' => 'text',
							'value' => $community->displayName,
					],
					'tracking_label' => 'wordmark-image',
			];
		}

		if (!empty($theme->graphics->header)) {
			$currentData['community-header']['background_image'] = $theme->graphics->header;
		}

		$dispatchable->getResponse()->setData($currentData);
	}

	private static function convertToSitemapData( $entry, $currentLevel, $maxElementsPerLevel ) {
		$numLevels = count( $maxElementsPerLevel );
		if ( $currentLevel > $numLevels ) {
			return null;
		}

		$data = [
				'text' => $entry->name,
				'href' => self::getEntityPath( $entry->id )
		];

		$nextLevel = $currentLevel + 1;
		if ( isset( $entry->children ) && $nextLevel <= $numLevels ) {
			$data['children'] = [];
			foreach ( $entry->children as $i => $child ) {
				if ( $i >= $maxElementsPerLevel[$currentLevel] ) {
					break;
				}

				$data['children'][] = self::convertToSitemapData( $child, $nextLevel, $maxElementsPerLevel );
			}
		}

		return $data;
	}

	// having '0' here is kinda crappy but we need the extension enabled on community
	// because the design system api is only accessible on community
	private static function isValidCommunityId($communityId) {
		return is_string($communityId) && !empty($communityId) && $communityId !== self::COMMUNITY_CENTRAL_ID_VALUE;
	}

	private static function getEntityPath( $entityId ) {
		return "/wiki/${entityId}";
	}

	/**
	 * @return FandomCreatorApi
	 */
	private static function api() {
		static $instance = null;

		if ( $instance == null ) {
			global $wgFandomCreatorOverrideUrl;

			if ( !empty( $wgFandomCreatorOverrideUrl ) ) {
				$fandomCreatorUrl = $wgFandomCreatorOverrideUrl;
			} else {
				/** @var UrlProvider $urlProvider */
				$urlProvider = Injector::getInjector()->get( UrlProvider::class );
				$fandomCreatorUrl = $urlProvider->getUrl( self::SERVICE_NAME );
			}

			$instance = new FandomCreatorApi( "http://$fandomCreatorUrl" );
		}

		return $instance;
	}
}
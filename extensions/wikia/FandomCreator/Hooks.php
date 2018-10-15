<?php

namespace FandomCreator;

use Wikia\Factory\ServiceFactory;
use WikiaDispatchableObject;
use WikiFactory;

class Hooks {
	const SERVICE_NAME = "content-graph-service";
	const COMMUNITY_CENTRAL_ID_VALUE = '-1';

	public static function onNavigationApiGetData( WikiaDispatchableObject $dispatchable, string $communityId, array $maxElementsPerLevel ) {
		if ( !self::isValidCommunityId( $communityId ) ) {
			return;
		}

		$sitemap = self::api()->getSitemap( $communityId );
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

	public static function onDesignSystemCommunityHeaderModelGetData( &$data, $cityId ) {
		$communityId =
			WikiFactory::getVarValueByName( "wgFandomCreatorCommunityId", $cityId, false, "" );

		if ( !self::isValidCommunityId( $communityId ) ) {
			return;
		}

		$sitemap = self::api()->getSitemap( $communityId );

		if ( $sitemap === null ) {
			return;
		}

		$discussionsLink = array_values( array_filter( $data['navigation'], function ( $item ) {
			if ( isset( $item['title']['key'] ) &&
			     $item['title']['key'] === 'community-header-discuss'
			) {
				return true;
			}

			return false;
		} ) );

		$data['navigation'] = self::convertToCommunityHeaderNavigation( $sitemap );

		if ( isset( $discussionsLink[0] ) ) {
			$data['navigation'][] = $discussionsLink[0];
		}
	}

	public static function onDesignSystemApiGetAllElements( WikiaDispatchableObject $dispatchable, string $communityId ) {
		if ( !self::isValidCommunityId( $communityId ) ) {
			return;
		}

		$community = self::api()->getCommunity( $communityId );
		if ( $community === null ) {
			return;
		}

		$data = $dispatchable->getResponse()->getData();
		$data['community-header']['sitename']['title']['value'] = $community->displayName;

		if ( !empty( $community->theme->graphics->wordmark ) ) {
			// need to recreate entirely in case it wasn't set by the DS api
			$data['community-header']['wordmark'] = [
					'type' => 'link-image',
					'href' => '/',
					'image-data' => [
							'type' => 'image-external',
							'url' => $community->theme->graphics->wordmark,
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

		if ( !empty( $community->theme->graphics->header ) ) {
			$data['community-header']['background_image'] = $community->theme->graphics->header;
		}

		$dispatchable->getResponse()->setData( $data );
	}

	private static function convertToCommunityHeaderNavigation( $items, $level = 1 ) {
		$convertedNavigation = [];
		$moreItems = null;

		foreach ( $items as $index => $item ) {
			$convertedItem = [
				'type' => 'dropdown',
				'title' => [
					'type' => 'text',
					'value' => $item->name,
				],
				'href' => '/wiki/' . $item->id . '/' . self::slugify( $item->name ),
				'tracking_label' => 'custom-level-' . $level,
			];

			if ( isset( $item->children ) ) {
				$convertedItem['items'] =
					self::convertToCommunityHeaderNavigation( $item->children, $level + 1 );
			}

			if ( $index === 3 && $level === 1 ) {
				$moreItems = [
					'type' => 'dropdown',
					'title' => [
						'type' => 'text',
						'value' => 'More',
					],
					'items' => [],
				];
			}

			if ( $moreItems ) {
				$moreItems['items'][] = $convertedItem;
			} else {
				$convertedNavigation[] = $convertedItem;
			}
		}

		if ( $moreItems ) {
			$convertedNavigation[] = $moreItems;
		}

		return $convertedNavigation;
	}

	// based on https://github.com/Wikia/fandom-creator/blob/ec6a223e238c7de3f426ec322e5caedfbacf0701/react-client/src/slugify.js
	private static function slugify( $input ) {
		$noPunctuation =
			preg_replace( '/[\x{2000}-\x{206F}\x{2E00}-\x{2E7F}\\\'!"#$%&()*+,.\/:;<=>?@[\]^_`{|}~]/u',
				'', $input );
		$toLowercase = strtolower( $noPunctuation );

		return preg_replace( '/(-|\s){1,}/', '-', $toLowercase );
	}

	public static function onMercuryApiGetWikiVariables( WikiaDispatchableObject $dispatchable, $communityId ) {
		if ( !self::isValidCommunityId( $communityId ) ) {
			return;
		}

		$community = self::api()->getCommunity( $communityId );
		if ( $community === null ) {
			return;
		}

		$data = $dispatchable->getResponse()->getData()['data'];
		$data['siteName'] = $community->displayName;
		if ( isset( $data['htmlTitle']['parts'][0] ) ) {
			$data['htmlTitle']['parts'][0] = $community->displayName;
		}

		$data['theme']['page-opacity'] = '100';
		if ( !empty( $community->theme->colors->buttons ) ) {
			$data['theme']['color-buttons'] = $community->theme->colors->buttons;
		}

		if ( !empty( $community->theme->colors->links ) ) {
			$data['theme']['color-links'] = $community->theme->colors->links;
		}

		if ( !empty( $community->theme->colors->header ) ) {
			$data['theme']['color-community-header'] = $community->theme->colors->header;
		}

		if ( !empty( $community->theme->colors->pageBackground ) ) {
			$data['theme']['color-body'] = $community->theme->colors->pageBackground;
			$data['theme']['color-body-middle'] = $community->theme->colors->pageBackground;
		}

		if ( !empty( $community->theme->colors->articleBackground ) ) {
			$data['theme']['color-page'] = $community->theme->colors->articleBackground;
		}

		if ( !empty( $community->theme->graphics->background ) ) {
			$data['theme']['background-image'] = $community->theme->graphics->background;
			$data['theme']['background-image-width'] = '';
			$data['theme']['background-image-height'] = '';
			$data['theme']['background-fixed'] = true;
			$data['theme']['background-tiled'] = false;
		}

		$dispatchable->getResponse()->setData( ['data' => $data] );
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
	private static function isValidCommunityId( $communityId ) {
		return is_string( $communityId ) && !empty( $communityId ) && $communityId !== self::COMMUNITY_CENTRAL_ID_VALUE;
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
				$urlProvider = ServiceFactory::instance()->providerFactory()->urlProvider();
				$fandomCreatorUrl = $urlProvider->getUrl( self::SERVICE_NAME );
			}

			$instance = new FandomCreatorApi( "http://$fandomCreatorUrl" );
		}

		return $instance;
	}
}

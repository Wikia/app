<?php

namespace FandomCreator;

use Wikia\DependencyInjection\Injector;
use Wikia\Service\Gateway\UrlProvider;
use WikiaDispatchableObject;

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
		$data['community-header']['sitename']['href'] = '/';

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

		// remove "explore" menu since it's forcefully added by the DS api. array_values is needed because array_filter
		// turns the array into an assoc. array, so when json_encoded navigation is an object instead of an array
		$data['community-header']['navigation'] = array_values( array_filter( $data['community-header']['navigation'], function( $navItem ) {
			$type = isset( $navItem['type'] ) ? $navItem['type'] : false;
			$titleType = isset( $navItem['title']['type'] ) ? $navItem['title']['type'] : false;
			$titleKey = isset( $navItem['title']['key'] ) ? $navItem['title']['key'] : false;

			if ( $type === 'dropdown' && $titleType === 'translatable-text' && $titleKey === 'community-header-explore' ) {
				return false;
			}

			return true;
		} ) );

		$dispatchable->getResponse()->setData( $data );
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
				/** @var UrlProvider $urlProvider */
				$urlProvider = Injector::getInjector()->get( UrlProvider::class );
				$fandomCreatorUrl = $urlProvider->getUrl( self::SERVICE_NAME );
			}

			$instance = new FandomCreatorApi( "http://$fandomCreatorUrl" );
		}

		return $instance;
	}
}
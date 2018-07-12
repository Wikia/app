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
		$communityId = WikiFactory::getVarValueByName( "wgFandomCreatorCommunityId", $cityId, false, "" );

		if ( !self::isValidCommunityId( $communityId ) ) {
			return;
		}

		$sitemap = self::api()->getSitemap( $communityId );

		$discussionsLink =
			array_values( array_filter( $data['navigation'],
				function ( $item ) {
					if ( isset( $item['title']['key'] ) &&
					     $item['title']['key'] === 'community-header-discuss'
					) {
						return true;
					}

					return false;
				} ) );

		$data['navigation'] =
			self::convertToCommunityHeaderNavigation( $sitemap );

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
//			return;
		}

		$data = $dispatchable->getResponse()->getData();
//		$data['community-header']['sitename']['title']['value'] = $community->displayName;
//		$data['community-header']['sitename']['href'] = '/';
//
//		if ( !empty( $community->theme->graphics->wordmark ) ) {
//			// need to recreate entirely in case it wasn't set by the DS api
//			$data['community-header']['wordmark'] = [
//					'type' => 'link-image',
//					'href' => '/',
//					'image-data' => [
//							'type' => 'image-external',
//							'url' => $community->theme->graphics->wordmark,
//							'width' => '250',
//							'height' => '65',
//					],
//					'title' => [
//							'type' => 'text',
//							'value' => $community->displayName,
//					],
//					'tracking_label' => 'wordmark-image',
//			];
//		}
//
//		if ( !empty( $community->theme->graphics->header ) ) {
//			$data['community-header']['background_image'] = $community->theme->graphics->header;
//		}

		// remove "explore" menu since it's forcefully added by the DS api. array_values is needed because array_filter
		// turns the array into an assoc. array, so when json_encoded navigation is an object instead of an array
//		$data['community-header']['navigation'] = array_values( array_filter( $data['community-header']['navigation'], function( $navItem ) {
//			$type = isset( $navItem['type'] ) ? $navItem['type'] : false;
//			$titleType = isset( $navItem['title']['type'] ) ? $navItem['title']['type'] : false;
//			$titleKey = isset( $navItem['title']['key'] ) ? $navItem['title']['key'] : false;
//
//			if ( $type === 'dropdown' && $titleType === 'translatable-text' && $titleKey === 'community-header-explore' ) {
//				return false;
//			}
//
//			return true;
//		} ) );

		$discussionsLink =
			array_values( array_filter( $data['community-header']['navigation'],
				function ( $item ) {
					if ( isset( $item['title']['key'] ) &&
					     $item['title']['key'] === 'community-header-discuss'
					) {
						return true;
					}

					return false;
				} ) );

		$data['community-header']['navigation'] =
			self::convertToCommunityHeaderNavigation( json_decode( '[{"id":"4192918","name":"Seasons","children":[{"id":"4192921","name":"Season 1","children":[{"id":"4192926","name":"Daybreak"},{"id":"4192929","name":"Kill the Messenger"},{"id":"4192930","name":"No Good Horses"},{"id":"4192931","name":"The Long Black Train"},{"id":"4192932","name":"Coming Home"}]}]},{"id":"4192919","name":"Characters","children":[{"id":"4193072","name":"Dutton Family","children":[{"id":"4192922","name":"John Dutton"},{"id":"4192923","name":"Beth Dutton"},{"id":"4192934","name":"Jamie Dutton"},{"id":"4192936","name":"Kayce Dutton"},{"id":"4192940","name":"Lee Dutton"},{"id":"4193189","name":"Evelyn Dutton"}]},{"id":"4193073","name":"Yellowstone Ranch","children":[{"id":"4192938","name":"Rip Wheeler"},{"id":"4193071","name":"Jimmy Hurdstrom"}]},{"id":"4193074","name":"Broken Rock Reservation","children":[{"id":"4193066","name":"Tate Dutton"},{"id":"4193067","name":"Chief Thomas Rainwater"},{"id":"4193069","name":"Monica Dutton"},{"id":"4193070","name":"Felix Long"},{"id":"4193176","name":"Robert Long"},{"id":"4193177","name":"Ben Waters"}]},{"id":"4193075","name":"Supporting Characters","children":[{"id":"4192937","name":"Cole Hauser"},{"id":"4192941","name":"Danny Huston"},{"id":"4192942","name":"Dan Jenkins"},{"id":"4193065","name":"Alan"},{"id":"4193068","name":"Gil Birmingham"},{"id":"4193076","name":"Governor Lynelle Perry"},{"id":"4193078","name":"Bob Schwartz"},{"id":"4193175","name":"Senator Huntington"},{"id":"4193178","name":"Dirk Hurdstram"}]}]},{"id":"4192920","name":"Cast","children":[{"id":"4192924","name":"Kevin Costner"},{"id":"4192925","name":"Kelly Reilly"},{"id":"4192933","name":"Wes Bentley"},{"id":"4192935","name":"Luke Grimes"},{"id":"4192939","name":"Dave Annable"},{"id":"4193077","name":"Michael Nouri"},{"id":"4193079","name":"Rudy Ramos"},{"id":"4193080","name":"Wendy Moniz"},{"id":"4193081","name":"Kelsey Asbille"},{"id":"4193145","name":"Jefferson White"},{"id":"4193174","name":"Jill Hennessy"}]},{"id":"4193064","name":"About Yellowstone","children":[{"id":"4192927","name":"Taylor Sheridan"},{"id":"4192928","name":"John Linson"}]}]',
				true ) );

		if ( isset( $discussionsLink[0] ) ) {
			$data['community-header']['navigation'][] = $discussionsLink[0];
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
					'value' => $item['name'],
				],
				'href' => '/wiki/' . $item['id'] . '/' . self::slugify( $item['name'] ),
				'tracking_label' => 'custom-level-' . $level,
			];

			if ( isset( $item['children'] ) ) {
				$convertedItem['items'] =
					self::convertToCommunityHeaderNavigation( $item['children'], $level + 1 );
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

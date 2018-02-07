<?php

class DesignSystemCommunityHeaderModel extends WikiaModel {
	const WORDMARK_TYPE_GRAPHIC = 'graphic';

	private $productInstanceId;
	private $langCode;
	private $themeSettings;
	private $settings;
	private $mainPageUrl;

	private $wordmarkData = null;
	private $sitenameData = null;
	private $bgImageUrl = null;
	private $exploreMenu = null;
	private $discussLinkData = null;
	private $wikiLocalNavigation = null;

	public function __construct( string $cityId, string $langCode ) {
		parent::__construct();

		$this->productInstanceId = $cityId;
		$this->langCode = $langCode;
		$this->themeSettings = new ThemeSettings( $cityId );
		$this->settings = $this->themeSettings->getSettings( $cityId );
		$this->mainPageUrl = wfProtocolUrlToRelative( GlobalTitle::newMainPage( $this->productInstanceId )->getFullURL() );
	}

	public function getData(): array {
		$data = [
			'sitename' => $this->getSiteNameData(),
			'navigation' => $this->getNavigation()
		];

		if ( !empty( $this->getBackgroundImageUrl() ) ) {
			$data[ 'background_image' ] = $this->getBackgroundImageUrl();
		}

		if ( !empty( $this->getWordmarkData() ) ) {
			$data[ 'wordmark' ] = $this->getWordmarkData();
		}

		return $data;
	}

	public function getWordmarkData(): array {
		if ( $this->wordmarkData === null ) {
			$this->wordmarkData = [];

			if ( $this->settings[ 'wordmark-type' ] === self::WORDMARK_TYPE_GRAPHIC ) {
				$imageTitle = Title::newFromText( ThemeSettings::WordmarkImageName, NS_IMAGE );

				if ( $imageTitle instanceof Title ) {
					$file = wfFindFile( $imageTitle );

					if ( $file instanceof File && $file->width > 0 && $file->height > 0 ) {
						$this->wordmarkData = [
							'type' => 'link-image',
							'href' => $this->mainPageUrl,
							'image-data' => [
								'type' => 'image-external',
								'url' => $this->themeSettings->getWordmarkUrl(),
								'width' => $file->width,
								'height' => $file->height
							],
							'title' => [
								'type' => 'text',
								'value' => $this->themeSettings->getSettings()[ 'wordmark-text' ],
							],
							'tracking_label' => 'wordmark-image',
						];
					}
				}
			}
		}

		return $this->wordmarkData;
	}

	public function getSiteNameData(): array {
		if ( $this->sitenameData === null ) {
			$this->sitenameData = [
				'type' => 'link-text',
				'title' => [
					'type' => 'text',
					'value' => $this->themeSettings->getSettings()[ 'wordmark-text' ]
				],
				'href' => $this->mainPageUrl,
				'tracking_label' => 'sitename'
			];
		}

		return $this->sitenameData;
	}

	public function getBackgroundImageUrl(): string {
		if ( $this->bgImageUrl === null ) {
			$this->bgImageUrl = $this->themeSettings->getCommunityHeaderBackgroundUrl();
		}

		return $this->bgImageUrl;
	}

	public function getNavigation(): array {
		$localNav = $this->getWikiLocalNavigation();
		array_push( $localNav, $this->getExploreMenu() );

		$discuss = $this->getDiscussLinkData();
		if ( !empty( $discuss ) ) {
			array_push( $localNav, $discuss );
		}

		return $localNav;
	}

	public function getWikiLocalNavigation( $wikitext = null ): array {
		global $wgCityId;

		if ( $this->wikiLocalNavigation === null ) {
			if ( empty( $wikitext ) ) {
				$navigationMessage = GlobalTitle::newFromText( NavigationModel::WIKI_LOCAL_MESSAGE, NS_MEDIAWIKI, $this->productInstanceId );

				$wikitext = $navigationMessage->getContent();
			}

			//No need for foreignCall if we're getting data for the same wiki
			if ( $this->productInstanceId == $wgCityId ) {
				$localNavData = ( new NavigationModel() )->getFormattedWiki( NavigationModel::WIKI_LOCAL_MESSAGE, $wikitext )[ 'wiki' ];

			} else {
				//Navigation is created by parsing a message to do that properly
				//we need full context of a wiki that we generate navigation for
				$localNavData = ApiService::foreignCall( WikiFactory::getWikiByID( $this->productInstanceId )->city_dbname, [
					'controller' => 'NavigationApi',
					'method' => 'getData',
					'uselang' => $this->langCode
				], ApiService::WIKIA )[ 'navigation' ][ 'wiki' ];
			}

			$this->wikiLocalNavigation = $this->formatLocalNavData( $localNavData, 1 );
		}

		return $this->wikiLocalNavigation;
	}

	public function getExploreMenu(): array {
		if ( $this->exploreMenu === null ) {
			$wgEnableCommunityPageExt = WikiFactory::getVarValueByName( 'wgEnableCommunityPageExt', $this->productInstanceId );
			$wgEnableForumExt = WikiFactory::getVarValueByName( 'wgEnableForumExt', $this->productInstanceId );
			$wgEnableDiscussions = WikiFactory::getVarValueByName( 'wgEnableDiscussions', $this->productInstanceId );
			$wgEnableSpecialVideosExt = WikiFactory::getVarValueByName( 'wgEnableSpecialVideosExt', $this->productInstanceId );

			$exploreItems = [
				[
					'title' => 'WikiActivity',
					'key' => 'community-header-wiki-activity',
					'tracking' => 'explore-activity',
					'include' => true,
				],
				[
					'title' => 'Random',
					'key' => 'community-header-random-page',
					'tracking' => 'explore-random',
					'include' => true,
				],
				[
					'title' => 'Community',
					'key' => 'community-header-community',
					'tracking' => 'explore-community',
					'include' => !empty( $wgEnableCommunityPageExt ),
				],
				[
					'title' => 'Videos',
					'key' => 'community-header-videos',
					'tracking' => 'explore-videos',
					'include' => !empty( $wgEnableSpecialVideosExt ),
				],
				[
					'title' => 'Images',
					'key' => 'community-header-images',
					'tracking' => 'explore-images',
					'include' => true,
				],
				[
					'title' => 'Forum',
					'key' => 'community-header-forum',
					'tracking' => 'explore-forum',
					'include' => !empty( $wgEnableForumExt ) && !empty( $wgEnableDiscussions ),
				],
			];

			$this->exploreMenu = [
				'type' => 'dropdown',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'community-header-explore',
				],
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-explore-tiny'
				],
				'items' => array_map( function ( $item ) {
					return [
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => $item[ 'key' ],
						],
						'href' => $this->getFullUrl( $item[ 'title' ], NS_SPECIAL, true),
						'tracking_label' => $item[ 'tracking' ]
					];
				}, array_values( array_filter( $exploreItems, function ( $item ) {
					return $item[ 'include' ];
				} ) ) )
			];
		}

		return $this->exploreMenu;
	}

	private function getFullUrl( $pageTitle, $namespace, $protocolRelative = false ) {
		$url = GlobalTitle::newFromText( $pageTitle, NS_SPECIAL, $this->productInstanceId )->getFullURL();
		if ( $protocolRelative ) {
			$url = wfProtocolUrlToRelative( $url );
		}
		return $url;
	}

	public function getDiscussLinkData(): array {
		if ( $this->discussLinkData === null ) {
			$wgEnableForumExt = WikiFactory::getVarValueByName( 'wgEnableForumExt', $this->productInstanceId );
			$wgEnableDiscussions = WikiFactory::getVarValueByName( 'wgEnableDiscussions', $this->productInstanceId );

			$url = '';
			$key = '';
			$tracking = '';

			if ( !empty( $wgEnableDiscussions ) ) {
				$url = '/d/f';
				$key = 'community-header-discuss';
				$tracking = 'discuss';
			} else if ( !empty( $wgEnableForumExt ) ) {
				$url = $this->getFullUrl( 'Forum', NS_SPECIAL, true );
				$key = 'community-header-forum';
				$tracking = 'forum';
			}

			$this->discussLinkData = empty( $url ) ? [] : [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => $key,
				],
				'href' => $url,
				'tracking_label' => $tracking,
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-reply-small',
				]
			];
		}

		return $this->discussLinkData;
	}

	private function formatLocalNavData( array $items, int $nestingLevel ): array {
		return array_map( function ( $item ) use ( $nestingLevel ) {
			$ret = [
				'type' => isset( $item[ 'children' ] ) ? 'dropdown' : 'link-text',
				'title' => [
					'type' => 'text',
					'value' => $item[ 'text' ]
				],
				'href' => $item[ 'href' ],
				'tracking_label' => 'custom-level-' . $nestingLevel,
			];

			if ( isset( $item[ 'children' ] ) ) {
				$ret[ 'items' ] = $this->formatLocalNavData( $item[ 'children' ], $nestingLevel + 1 );
			}

			return $ret;
		}, $items );
	}
}

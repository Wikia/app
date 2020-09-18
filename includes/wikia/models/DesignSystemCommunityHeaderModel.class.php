<?php

class DesignSystemCommunityHeaderModel extends WikiaModel {
	const WORDMARK_TYPE_GRAPHIC = 'graphic';
	const FANDOM_STORE_ITEM_LIMIT = 10;
	const ENABLE_FANDOM_STORE_VAR = 'wgEnableFandomShop';

	private $productInstanceId;
	private $langCode;
	private $themeSettings;
	private $settings;
	private $homePageUrl;

	private $wordmarkData = null;
	private $sitenameData = null;
	private $bgImageUrl = null;
	private $exploreMenu = null;
	private $discussLinkData = null;
	private $wikiLocalNavigation = null;

	public function __construct( string $langCode ) {
		global $wgCityId, $wgServer, $wgScriptPath;

		parent::__construct();

		$this->productInstanceId = $wgCityId;
		$this->langCode = $langCode;
		$this->themeSettings = new ThemeSettings( $wgCityId );
		$this->settings = $this->themeSettings->getSettings();
		$this->homePageUrl = wfProtocolUrlToRelative( $wgServer . $wgScriptPath );
	}

	public function getData(): array {
		$data = [
			'sitename' => $this->getSiteNameData(),
			'navigation' => $this->getNavigation(),
			'counter' => $this->getArticlesCounter(),
			'buttons' => $this->getActionButtons(),
		];

		if ( !empty( $this->getBackgroundImageUrl() ) ) {
			$data[ 'background_image' ] = $this->getBackgroundImageUrl();
		}

		if ( !empty( $this->getWordmarkData() ) ) {
			$data[ 'wordmark' ] = $this->getWordmarkData();
		}

		Hooks::run( 'DesignSystemCommunityHeaderModelGetData', [ &$data, $this->productInstanceId ] );

		return $data;
	}

	public function getArticlesCounter() {
		$value = \RequestContext::getMain()->getLanguage()->formatNum( SiteStats::articles() );

		if( $value === 1 ) {
			$labelKey = 'community-header-page';
		} else {
			$labelKey = 'community-header-pages';
		}

		return [
			'value' => $value,
			'label' => [
				'type' => 'translatable-text',
				'key' => $labelKey,
			]
		];
	}

	public function getActionButtons() {
		$wgUser = \RequestContext::getMain()->getUser();

		if ( $wgUser->isLoggedIn() ) {
			if ( $wgUser->isAllowed( 'admindashboard' ) ) {
				$buttons = $this->adminButtons();
			} else {
				$buttons = $this->userButtons();
			}
			$buttons[] = [
				'type' => 'link-group',
				'items' => $this->dropdownButtons()
			];
		} else {
			$buttons = $this->anonButtons();
		}

		return $buttons;
	}

	private function anonButtons(): array {
		return [
			$this->getButton(
				$this->getSpecialPageURL( 'CreatePage' ),
				'add-new-page',
				'community-header-add-new-page',
				'community-header-add-new-page',
				'wds-icons-page-small'
			)
		];
	}

	private function userButtons(): array {
		return [
			$this->getButton(
				$this->getSpecialPageURL( 'CreatePage' ),
				'add-new-page',
				'community-header-add',
				'community-header-add-new-page',
				'wds-icons-page-small'
			),
			$this->getButton(
				$this->getSpecialPageURL( 'WikiActivity' ),
				'wiki-activity',
				null,
				'community-header-wiki-activity',
				'wds-icons-activity-small'
			),
		];
	}

	private function adminButtons(): array {
		return [
			$this->getButton(
				$this->getSpecialPageURL( 'CreatePage' ),
				'add-new-page',
				null,
				'community-header-add-new-page',
				'wds-icons-page-small'
			),
			$this->getButton(
				$this->getSpecialPageURL( 'WikiActivity' ),
				'wiki-activity',
				null,
				'community-header-wiki-activity',
				'wds-icons-activity-small'
			),
			$this->getButton(
				$this->getSpecialPageURL( 'AdminDashboard' ),
				'admin-dashboard',
				null,
				'community-header-admin-dashboard',
				'wds-icons-dashboard-small'
			),
		];
	}

	private function dropdownButtons() {
		return [
			$this->getButton(
				$this->getSpecialPageURL( 'Upload' ),
				'more-add-new-image',
				'community-header-add-new-image'
			),
			$this->getButton(
				$this->getSpecialPageURL( 'Videos' ),
				'more-add-new-video',
				'community-header-add-new-video'
			),
			$this->getButton(
				$this->getSpecialPageURL( 'RecentChanges' ),
				'more-recent-changes',
				'community-header-recent-changes'
			),
		];
	}

	private function getButton( $href, $trackingLabel, $labelKey = null, $titleKey = null, $iconName = null): array {
		$button = [
			'type' => 'link-button',
			'href' => $href,
			'tracking_label' => $trackingLabel,
		];

		if ( !empty($labelKey) ) {
			$button['label'] = [
				'type' => 'translatable-text',
				'key' => $labelKey,
			];
		}

		if ( !empty( $titleKey ) ) {
			$button['title'] = [
				'type' => 'translatable-text',
				'key' => $titleKey
			];
		}

		if ( !empty( $iconName ) ) {
			$button['image-data'] = [
				'type' => 'wds-svg',
				'name' => $iconName
			];
		}

		return $button;
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
							'href' => $this->homePageUrl,
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
			// SUS-2975: Site name is user input, so it comes pre-escaped.
			// We must decode HTML entities present in the text to avoid double escaping.
			$sitename =
				Sanitizer::decodeCharReferences( $this->themeSettings->getSettings()['wordmark-text'] );

			$this->sitenameData = [
				'type' => 'link-text',
				'title' => [
					'type' => 'text',
					'value' => $sitename,
				],
				'mobile_title' => [
					'type' => 'text',
					'value' => F::app()->wg->Sitename,
				],
				'href' => $this->homePageUrl,
				'tracking_label' => 'sitename',
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

	public function getLandingPagePreference() {
		global $wgUser;

		return UserService::getLandingPagePreference( $wgUser );
	}

	public function getNavigation(): array {
		$localNav = $this->getWikiLocalNavigation();
		array_push( $localNav, $this->getExploreMenu() );

		$discuss = $this->getDiscussLinkData();
		$mainPage = $this->getMainPageLinkData();
		if ( !empty( $mainPage ) ) {
			array_push( $localNav, $mainPage );
		} elseif ( !empty( $discuss ) ) {
			array_push( $localNav, $discuss );
		}

		return $localNav;
	}

	public function getWikiLocalNavigation( $wikitext = null ): array {
		if ( $this->wikiLocalNavigation === null ) {

			$model = new NavigationModel();
			$localNavData = $model->getFormattedWiki( NavigationModel::WIKI_LOCAL_MESSAGE, $wikitext )[ 'wiki' ];

			$this->wikiLocalNavigation = $this->formatLocalNavData( $localNavData, 1 );
		}

		return $this->wikiLocalNavigation;
	}

	public function getExploreMenu(): array {
		$storeData = $this->getFandomStoreDataFromCache();
		$enableShop = WikiFactory::getVarValueByName( self::ENABLE_FANDOM_STORE_VAR, Wikia::COMMUNITY_WIKI_ID );

		if ( $this->exploreMenu === null ) {
			$wgEnableCommunityPageExt =
				WikiFactory::getVarValueByName( 'wgEnableCommunityPageExt',
					$this->productInstanceId, false, F::app()->wg->enableCommunityPageExt );
			$wgEnableForumExt =
				WikiFactory::getVarValueByName( 'wgEnableForumExt', $this->productInstanceId, false,
					F::app()->wg->enableForumExt );
			$wgEnableDiscussions =
				WikiFactory::getVarValueByName( 'wgEnableDiscussions', $this->productInstanceId,
					false, F::app()->wg->enableDiscussions );
			$wgEnableSpecialVideosExt =
				WikiFactory::getVarValueByName( 'wgEnableSpecialVideosExt',
					$this->productInstanceId, false, F::app()->wg->enableSpecialVideosExt );

			$exploreItems = [
				[
					'url' => Title::newMainPage()->getFullURL(),
					'key' => 'community-header-main-page',
					'tracking' => 'explore-main-page',
					'include' => in_array( $this->getLandingPagePreference(), [
						UserPreferencesV2::LANDING_PAGE_RECENT_CHANGES,
						UserPreferencesV2::LANDING_PAGE_WIKI_ACTIVITY,
					] ),
				],
				[
					'url' => $this->getFullUrl( 'WikiActivity', NS_SPECIAL, true ),
					'key' => 'community-header-wiki-activity',
					'tracking' => 'explore-activity',
					'include' => true,
				],
				[
					'url' => $this->getFullUrl( 'Random', NS_SPECIAL, true ),
					'key' => 'community-header-random-page',
					'tracking' => 'explore-random',
					'include' => true,
				],
				[
					'url' => $this->getFullUrl( 'Community', NS_SPECIAL, true ),
					'key' => 'community-header-community',
					'tracking' => 'explore-community',
					'include' => !empty( $wgEnableCommunityPageExt ),
				],
				[
					'url' => $this->getFullUrl( 'Videos', NS_SPECIAL, true ),
					'key' => 'community-header-videos',
					'tracking' => 'explore-videos',
					'include' => !empty( $wgEnableSpecialVideosExt ),
				],
				[
					'url' => $this->getFullUrl( 'Images', NS_SPECIAL, true ),
					'key' => 'community-header-images',
					'tracking' => 'explore-images',
					'include' => true,
				],
				[
					'url' => $this->getFullUrl( 'Forum', NS_SPECIAL, true ),
					'key' => 'community-header-forum',
					'tracking' => 'explore-forum',
					'include' => !empty( $wgEnableForumExt ) && !empty( $wgEnableDiscussions ),
				],
			];

			// $enableShop serves as feature flag set to wiki factory variable
			// if community has store data, add to explore dropdown
			if ( $enableShop && $storeData ) {
				array_push( $exploreItems,  $storeData );
			}

			$this->exploreMenu = [
				'type' => 'dropdown',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'community-header-explore',
				],
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-book-tiny'
				],
				'items' => array_map( function ( $item ) {
					return [
						'type' => 'link-text',
						'title' => array_key_exists( 'key', $item ) ? [
							'type' => 'translatable-text',
							'key' => $item[ 'key' ]
						] : [
							'type' => 'link-text',
							'value' => $item[ 'value' ]
						],
						'href' => $item[ 'url' ],
						'tracking_label' => $item[ 'tracking' ],
						'items' => array_key_exists( 'items', $item ) ? array_map( function ( $item ) {
							return [
								'type' => 'link-text',
								'title' => [
									'type' => 'text',
									'value' => $item['value']
								],
								'href' => $item[ 'url' ],
								'tracking_label' => $item[ 'tracking' ],
							];
						}, $item[ 'items' ] ) : [],
					];
				}, array_values( array_filter( $exploreItems, function ( $item ) {
					return $item[ 'include' ];
				} ) ) )
			];
		}

		return $this->exploreMenu;
	}

	private function getFullUrl( $pageTitle, $namespace, $protocolRelative = false ) {
		$url = Title::newFromText( $pageTitle, $namespace)->getFullURL();
		if ( $protocolRelative ) {
			$url = wfProtocolUrlToRelative( $url );
		}
		return $url;
	}

	public function getMainPageLinkData(): array {
		if ( self::getLandingPagePreference() == UserPreferencesV2::LANDING_PAGE_FEEDS ) {
			return [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'community-header-main-page',
				],
				'href' => wfProtocolUrlToRelative( Title::newMainPage()->getFullURL() ),
				'tracking_label' => 'main-page',
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-home-tiny',
				],
			];
		}

		return [];
	}

	public function getDiscussLinkData(): array {
		if ( $this->discussLinkData === null ) {
			$wgEnableForumExt = WikiFactory::getVarValueByName( 'wgEnableForumExt', $this->productInstanceId );
			$wgEnableDiscussions = WikiFactory::getVarValueByName( 'wgEnableDiscussions', $this->productInstanceId );

			$url = '';
			$key = '';
			$tracking = '';

			if ( !empty( $wgEnableDiscussions ) ) {
                $url = WikiFactory::cityIdToLanguagePath( $this->productInstanceId ) . '/f';
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
					'name' => 'wds-icons-comment-tiny',
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

	private function getSpecialPageURL( $name ): string {
		return SpecialPage::getTitleFor( $name )->getLocalURL();
	}

	private function getFandomStoreDataFromCache() {
		global $wgMemc, $wgCityId;

		$memcKey = wfSharedMemcKey( DesignSystemApiController::MEMC_PREFIX_FANDOM_STORE, $wgCityId );
		$cachedStoreData = $wgMemc->get( $memcKey );
		var_dump( $memcKey );
		var_dump( $cachedStoreData );
		return !empty( $cachedStoreData->results ) ? $this->formatFandomStoreData( $cachedStoreData->results ) : null;
	}

	private function formatFandomStoreData( $apiData ) {
		// get copy of links from api data
		$arrObj = new ArrayObject( $apiData );
		$links = $arrObj->getArrayCopy();

		// remove store item object from list
		$firstItem = array_shift( $links );

		// if no links or not url data, return null
		if ( !$links ??  count( $links ) < 1 ?? !$firstItem->url) {
			return null;
		}

		// Only display 9 items + show more link
		if ( count( $links ) > self::FANDOM_STORE_ITEM_LIMIT ) {
			// create a show more item
			$showMoreItem = (object) [
				"url" => $firstItem->url,
				"text" => 'Show More'
			];
			// get the first 9 links
			$links = array_slice( $links, null, self::FANDOM_STORE_ITEM_LIMIT - 1 );
			// add show more item to end of links
			array_push( $links, $showMoreItem );
		}

		return [
			'url' => $firstItem->url,
			'value' => 'Shop',
			'tracking' => 'explore-shop',
			'include' => true,
			'items' => array_map( function ( $item ) {
				$lower = strtolower( $item->text ? $item->text : null );
				return [
					'tracking' => 'explore-shop-' . $lower,
					'url' => $item->url ? $item->url : '#',
					'value' => $item->text ? $item->text : null,
				];
			}, $links ),
		];
	}
}

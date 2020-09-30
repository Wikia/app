<?php

class DesignSystemGlobalNavigationModel extends WikiaModel {
	const DEFAULT_LANG = 'en';
	const PRODUCT_WIKIS = 'wikis';
	const PRODUCT_FANDOMS = 'fandoms';

	const HOMEPAGE_URL = 'https://www.fandom.com';

	private $product;
	private $productInstanceId;
	private $lang;
	private $isWikiaOrgCommunity;

	/**
	 * constructor
	 *
	 * @param string $product Name of product, ex: fandoms, wikis
	 * @param int $productInstanceId Identifier for given product, ex: wiki id
	 * @param string $lang
	 */
	public function __construct( $product, $productInstanceId, $isWikiaOrgCommunity, $lang = self::DEFAULT_LANG ) {
		parent::__construct();

		$this->product = $product;
		$this->productInstanceId = $productInstanceId;
		$this->lang = $lang;
		$this->isWikiaOrgCommunity = $isWikiaOrgCommunity;
	}

	public function getData() {
		global $wgUser, $wgUCPCommunityCNWAddress;

		$data = [
			'logo' => $this->getLogo(),
			'search' => [
				'module' => $this->getSearchData()
			],
			'create_wiki' => [
				'header' => [
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-create-wiki-link-start-wikia'
					],
					'href' => WikiFactory::getLocalEnvURL( $wgUCPCommunityCNWAddress ),
					'tracking_label' => 'start-a-wiki',
				]
			]
		];

		if ( $this->lang === static::DEFAULT_LANG && !$this->isWikiaOrgCommunity ) {
			$data[ 'fandom_overview' ] = $this->getVerticalsSection();
			$data[ 'wikis' ] = [
				'header' => [
					'type' => 'line-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-wikis-header',
					],
					'tracking_label' => 'link.wikis',
				],
				'links' => [
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-wikis-explore'
						],
						'href' => $this->getHref( 'explore-wikis' ),
						'tracking_label' => 'link.explore',
					],
					$this->getCommunityCentralLink(),
				]
			];
		} else {
			$data[ 'wikis' ] = [
				'links' => [
					$this->getCommunityCentralLink()
				]
			];
		}

		if ( $wgUser->isLoggedIn() ) {
			$data[ 'user' ] = $this->getLoggedInUserData( $wgUser );

			if ( $this->product !== static::PRODUCT_FANDOMS ) {
				$data[ 'notifications' ] = $this->getNotifications( $wgUser );
			}
		} else {
			$data[ 'anon' ] = $this->getAnonUserData();
		}

		return $data;
	}

	private function getHref( $hrefKey, $protocolRelative = false, $useWikiBaseDomain = false ) {
		global $wgServer;

		$url = DesignSystemSharedLinks::getInstance()->getHref( $hrefKey, $this->lang );
		if ( $protocolRelative ) {
			$url = wfProtocolUrlToRelative( $url );
		}

		$server = $this->product === static::PRODUCT_FANDOMS ? static::HOMEPAGE_URL : $wgServer;
		if ( $useWikiBaseDomain ) {
			$url = wfForceBaseDomain( $url, $server );
		}
		return $url;
	}

	private function getPageUrl( $pageTitle, $namespace, $query = '', $protocolRelative = false ) {
		global $wgCityId;

		if ( $this->product === static::PRODUCT_WIKIS && $this->productInstanceId == $wgCityId) {
			$url = Title::newFromText($pageTitle, $namespace)->getFullURL();
		} else {
			$wikiId = $this->product === static::PRODUCT_WIKIS ?
				$this->productInstanceId :
				WikiFactory::COMMUNITY_CENTRAL;
			$url =  GlobalTitle::newFromText( $pageTitle, $namespace, $wikiId )->getFullURL( $query );
		}

		if ( $protocolRelative ) {
			$url = wfProtocolUrlToRelative( $url );
		}

		return $url;
	}

	private function getSearchData() {
		// We treat corporate pages and fandom the same way
		$isCorporatePageOrFandom = WikiaPageType::isCorporatePage( $this->productInstanceId );
		$isCorporatePageOrFandom = $isCorporatePageOrFandom || $this->product === static::PRODUCT_FANDOMS;

		$search = [
			'type' => 'search',
			'results' => [
				'tracking_label' => 'search',
			],
			'placeholder-inactive' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-search-placeholder-inactive'
			],
			'placeholder-active' => [
				'type' => 'translatable-text',
			]
		];

		if ( $isCorporatePageOrFandom && $this->lang === static::DEFAULT_LANG ) {
			$search['results']['param-name'] = 's';
			$search['results']['url'] = 'https://www.fandom.com/';
			$search['placeholder-active']['key'] = 'global-navigation-search-placeholder-fandom';
		} elseif ( $isCorporatePageOrFandom ) {
			// Non-English Fandom or non-English corporate pages
			$search['results']['param-name'] = 'query';
			$search['results']['url'] = $this->getCorporatePageSearchUrl();
			$search['placeholder-active']['key'] = 'global-navigation-search-placeholder-wikis';
			$search['hiddenFields'] = [
				'resultsLang' => $this->lang,
				'uselang' => $this->lang,
			];
		} else {
			// Regular wikis
			$search['results']['param-name'] = 'query';
			$search['results']['url'] = $this->getPageUrl( 'Search', NS_SPECIAL, '', true );
			$search['placeholder-active']['key'] = 'global-navigation-search-placeholder-in-wiki';

			$suggestionsUrl = WikiFactory::cityIDtoUrl( $this->productInstanceId ) . '/wikia.php?controller=LinkSuggest&method=getLinkSuggestions&format=json';
			$search['suggestions'] = [
				'url' => wfProtocolUrlToRelative( $suggestionsUrl ),
				'param-name' => 'query',
				'tracking_label' => 'search-suggestion',
			];
			$search['placeholder-active']['params'] = [
				'sitename' => $this->getSitenameData(),
			];
		}

		return $search;
	}

	private function getAnonUserData() {
		return [
			'header' => [
				'type' => 'line-image',
				// 'image' is deprecated, use 'image-data' instead
				'image' => 'wds-icons-user',
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-user',
				],
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-anon-my-account',
				],
				'subtitle' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-anon-my-account',
				],
				'tracking_label' => 'account',
			],
			'links' => [
				[
					'type' => 'link-authentication',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-anon-sign-in',
					],
					'href' => $this->getHref( 'user-signin', false, true ),
					'param-name' => 'redirect',
					'tracking_label' => 'account.sign-in',
				],
				[
					'type' => 'link-authentication',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-anon-register',
					],
					'subtitle' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-anon-register-description',
					],
					'href' => $this->getHref( 'user-register', false, true ),
					'param-name' => 'redirect',
					'tracking_label' => 'account.register',
				],
			],
		];
	}

	private function hasAuthorProfile( $user ) {
		return intval( $user->getGlobalAttribute( 'wordpressId', 0 ), 10 ) > 0;
	}

	private function getLoggedInUserData( $user ) {
		global $wgEnableAuthorProfileLinks;

		$isMessageWallEnabled = $this->isMessageWallEnabled();
		$userName = $user->getName();

		$viewProfileLinks[] = [
			'type' => 'link-text',
			'href' => $this->getPageUrl( $userName, NS_USER, '', true ),
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-user-view-profile'
			],
			'tracking_label' => 'account.profile',
		];

		$logOutLink = [
			'type' => 'link-authentication',
			'href' => $this->getHref( 'user-logout', false, true ),
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-user-sign-out'
			],
			'param-name' => $this->product === static::PRODUCT_FANDOMS ? 'redirect' : 'returnto',
			'tracking_label' => 'account.sign-out',
		];

		if ( !empty( $wgEnableAuthorProfileLinks ) && $this->hasAuthorProfile( $user ) ) {
			$viewProfileLinks[] = [
				'type' => 'link-text',
				'href' => $this->getHref( 'user-author-profile' ) . $userName,
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-user-view-author-profile'
				],
				'tracking_label' => 'account.profile-author',
			];
		}

		$links = [
			static::PRODUCT_WIKIS => array_merge(
				$viewProfileLinks,
				[
					[
						'type' => 'link-text',
						'href' => $isMessageWallEnabled
							? $this->getPageUrl( $userName, NS_USER_WALL, '', true )
							: $this->getPageUrl( $userName, NS_USER_TALK, '', true ),
						'title' => [
							'type' => 'translatable-text',
							'key' => $isMessageWallEnabled
								? 'global-navigation-user-message-wall'
								: 'global-navigation-user-my-talk'
						],
						'tracking_label' => $isMessageWallEnabled ? 'account.message-wall' : 'account.talk',
					],
					[
						'type' => 'link-text',
						'href' => $this->getPageUrl( 'Preferences', NS_SPECIAL, '', true ),
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-user-my-preferences'
						],
						'tracking_label' => 'account.preferences',
					],
					[
						'type' => 'link-text',
						'href' => $this->getHref( 'help' ),
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-user-help'
						],
						'tracking_label' => 'account.help',
					],
					$logOutLink
				]
			),
			static::PRODUCT_FANDOMS => array_merge(
				$viewProfileLinks,
				[
					$logOutLink
				]
			),
		];

		return [
			'header' => [
				'id' => strval( $user->getId() ),
				'type' => 'avatar',
				'username' => [
					'type' => 'text',
					'value' => $userName
				],
				'url' => AvatarService::getAvatarUrl( $userName, 50 ),
				'tracking_label' => 'account',
			],
			'links' => $links[$this->product]
		];
	}

	private function getNotifications( $user ) {
		$userName = $user->getName();

		return [
			'header' => [
				'type' => 'line-image',
				// 'image' is deprecated, use 'image-data' instead
				'image' => 'wds-icons-message',
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-message',
				],
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-notifications-title'
				],
				'tracking_label' => 'notifications',
			],
			'module' => [
				'type' => 'notifications',
				'url' => $this->isMessageWallEnabled()
					? $this->getPageUrl( $userName, NS_USER_WALL, '', true )
					: $this->getPageUrl( $userName, NS_USER_TALK, '', true )
			]
		];
	}

	private function getVerticalsSection() {
		$verticals = [
			'links' => [
				[
					'type' => 'link-branded',
					'brand' => 'games',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-fandom-overview-link-vertical-games'
					],
					'href' => $this->getHref( 'games' ),
					'tracking_label' => 'link.games'
				],
				[
					'type' => 'link-branded',
					'brand' => 'movies',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-fandom-overview-link-vertical-movies'
					],
					'href' => $this->getHref( 'movies' ),
					'tracking_label' => 'link.movies'
				],
				[
					'type' => 'link-branded',
					'brand' => 'tv',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-fandom-overview-link-vertical-tv'
					],
					'href' => $this->getHref( 'tv' ),
					'tracking_label' => 'link.tv'
				]
			]
		];

		if ( $this->product === static::PRODUCT_FANDOMS ) {
			$verticals['links'][] = [
				'type' => 'link-branded',
				'brand' => 'video',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-fandom-overview-link-video'
				],
				'href' => $this->getHref( 'video' ),
				'tracking_label' => 'link.video'
			];
		}

		return $verticals;
	}

	private function isMessageWallEnabled() {
		return WikiFactory::getVarValueByName( 'wgEnableWallExt', $this->productInstanceId );
	}

	private function isWikiaOrgCommunity() {
		return $this->product === self::PRODUCT_WIKIS &&
			WikiFactory::getVarValueByName( 'wgIsInWikiaOrgProgram', $this->productInstanceId );
	}

	private function getCorporatePageSearchUrl() {
		$url = GlobalTitle::newFromText( 'Search', NS_SPECIAL, Wikia::CORPORATE_WIKI_ID )->getFullURL();
		return wfProtocolUrlToRelative( $url );
	}

	private function getCommunityCentralLink() {
		return [
			'type' => 'link-text',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-wikis-community-central'
			],
			'href' => $this->getHref( 'community-central' ),
			'tracking_label' => 'link.community-central',
		];
	}

	private function getSitenameData() {
		return [
			'type' => 'text',
			'value' => WikiFactory::getVarValueByName( 'wgSitename', $this->productInstanceId, false, $this->wg->Sitename ),
		];
	}

	private function getLogo() {
		$logo = [
			// Deprecated
			'header' => [
				'type' => 'link-image',
				'href' => $this->getHref( 'fandom-logo' ),
				// 'image' is deprecated use 'image-data' instead
				'image' => 'wds-company-logo-fandom-powered-by-wikia',
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-company-logo-fandom-powered-by-wikia',
				],
				'title' => [
					'type' => 'text',
					'value' => 'Fandom powered by Wikia'
				],
				'tracking_label' => 'logo',
			],
			'module' => [
				'type' => 'logo',
				'main' => $this->getLogoMain(),
			]
		];


		$tagline = $this->getLogoTagline();
		if ( !empty( $tagline ) ) {
			$logo['module'][ 'tagline' ] = $tagline;
		}

		return $logo;
	}

	private function getLogoMain() {
		if ( $this->isWikiaOrgCommunity === true ) {
			return [
				'type' => 'link-image',
				'href' => $this->getHref( 'wikia-org-logo' ),
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-company-logo-wikia-org',
				],
				'title' => [
					'type' => 'text',
					'value' => 'Wikia.org'
				],
				'tracking_label' => 'logo',
			];
		}

		return [
			'type' => 'link-image',
			'href' => $this->getHref( 'fandom-logo' ),
			// 'image' is deprecated use 'image-data' instead
			'image' => 'wds-company-logo-fandom',
			'image-data' => [
				'type' => 'wds-svg',
				'name' => 'wds-company-logo-fandom',
			],
			'title' => [
				'type' => 'text',
				'value' => 'Fandom powered by Wikia'
			],
			'tracking_label' => 'logo',
		];
	}

	private function getLogoTagline() {
		if ( $this->isWikiaOrgCommunity === true ) {
			return null;
		}

		return [
			'type' => 'link-image',
			'href' => $this->getHref( 'fandom-logo' ),
			'image-data' => [
				'type' => 'wds-svg',
				'name' => 'wds-company-logo-powered-by-wikia',
			],
			'title' => [
				'type' => 'text',
				'value' => 'Fandom powered by Wikia'
			],
			'tracking_label' => 'logo-tagline',
		];
	}
}

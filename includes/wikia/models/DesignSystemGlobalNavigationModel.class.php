<?php

class DesignSystemGlobalNavigationModel extends WikiaModel {
	const DEFAULT_LANG = 'en';
	const PRODUCT_WIKIS = 'wikis';
	const PRODUCT_FANDOMS = 'fandoms';

	private $product;
	private $productInstanceId;
	private $lang;

	/**
	 * constructor
	 *
	 * @param string $product Name of product, ex: fandoms, wikis
	 * @param int $productInstanceId Identifier for given product, ex: wiki id
	 * @param string $lang
	 */
	public function __construct( $product, $productInstanceId, $lang = self::DEFAULT_LANG ) {
		parent::__construct();

		$this->product = $product;
		$this->productInstanceId = $productInstanceId;
		$this->lang = $lang;
	}

	public function getData() {
		global $wgUser;

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
					'href' => $this->getHref( 'create-new-wiki' ),
					'tracking_label' => 'start-a-wiki',
				]
			]
		];

		if ( $this->lang === static::DEFAULT_LANG && !$this->isWikiaOrgCommunity() ) {
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
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-wikis-fandom-university'
						],
						'href' => $this->getHref( 'fandom-university' ),
						'tracking_label' => 'link.fandom-university',
					]
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

		$partnerSlot = $this->getPartnerSlot();
		if ( !empty( $partnerSlot ) ) {
			$data[ 'partner_slot' ] = $partnerSlot;
		}

		return $data;
	}

	private function getHref( $hrefKey ) {
		return DesignSystemSharedLinks::getInstance()->getHref( $hrefKey, $this->lang );
	}

	private function getPageUrl( $pageTitle, $namespace, $query = '' ) {
		$wikiId = $this->product === static::PRODUCT_WIKIS ?
			$this->productInstanceId :
			WikiFactory::COMMUNITY_CENTRAL;
		return GlobalTitle::newFromText( $pageTitle, $namespace, $wikiId )->getFullURL( $query );
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
			$search['results']['url'] = 'http://fandom.wikia.com/';
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
			$search['results']['url'] = $this->getPageUrl( 'Search', NS_SPECIAL );
			$search['placeholder-active']['key'] = 'global-navigation-search-placeholder-in-wiki';

			$search['suggestions'] = [
				'url' => WikiFactory::getHostById( $this->productInstanceId ) . '/index.php?action=ajax&rs=getLinkSuggest&format=json',
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
					'href' => $this->getHref( 'user-signin' ),
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
					'href' => $this->getHref( 'user-register' ),
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
			'href' => $this->getPageUrl( $userName, NS_USER ),
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-user-view-profile'
			],
			'tracking_label' => 'account.profile',
		];

		$logOutLink = [
			'type' => 'link-authentication',
			'href' => $this->getHref( 'user-logout' ),
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
							? $this->getPageUrl( $userName, NS_USER_WALL )
							: $this->getPageUrl( $userName, NS_USER_TALK ),
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
						'href' => $this->getPageUrl( 'Preferences', NS_SPECIAL ),
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
				'image' => 'wds-icons-note',
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-note',
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
					? $this->getPageUrl( $userName, NS_USER_WALL )
					: $this->getPageUrl( $userName, NS_USER_TALK )
			]
		];
	}

	private function getVerticalsSection() {
		return [
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
	}

	private function isMessageWallEnabled() {
		return WikiFactory::getVarValueByName( 'wgEnableWallExt', $this->productInstanceId );
	}

	private function isWikiaOrgCommunity() {
		return $this->product === self::PRODUCT_WIKIS &&
			WikiFactory::getVarValueByName( 'wgIsInWikiaOrgProgram', $this->productInstanceId );
	}

	private function getCorporatePageSearchUrl() {
		return GlobalTitle::newFromText( 'Search', NS_SPECIAL, Wikia::CORPORATE_WIKI_ID )->getFullURL();
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

	private function getPartnerSlot() {
		if ( $this->lang === 'de' ) {
			return [
				'type' => 'link-image',
				'href' => 'http://www.entertainweb.de/',
				'image-data' => [
					'type' => 'image-external',
					'url' => 'https://services.wikia.com/static-assets/image/5588e692-fae8-4dc3-8db6-5f62e37fed47',
				],
				'title' => [
					'type' => 'text',
					'value' => 'entertainweb'
				],
				'tracking_label' => 'entertainweb',
			];
		}
		return null;
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
		if ( $this->isWikiaOrgCommunity() === true ) {
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
		if ( $this->isWikiaOrgCommunity() === true ) {
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

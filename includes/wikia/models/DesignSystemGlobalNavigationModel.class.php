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
			// TODO: restore old logo before 4th October 2016
			// https://wikia-inc.atlassian.net/browse/XW-1966
			'logo' => [
				'header' => [
					'type' => 'link-image',
					'href' => $this->getHref( 'fandom-logo' ),
					'image' => 'wds-company-logo-wikia',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-header'
					],
					'subtitle' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-international-header-subtitle'
					]
				]
			],
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
				]
			]
		];

		if ( $this->lang === static::DEFAULT_LANG ) {
			$data[ 'fandom_overview' ] = $this->getVerticalsSection();
			$data[ 'wikis' ] = [
				'header' => [
					'type' => 'line-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-wikis-header',
					],
				],
				'links' => [
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-wikis-explore'
						],
						'href' => $this->getHref( 'fan-communities' ),
					],
					$this->getCommunityCentralLink(),
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-wikis-fandom-university'
						],
						'href' => $this->getHref( 'fandom-university' ),
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
		$isCorporatePage = WikiaPageType::isCorporatePage( $this->productInstanceId );

		if ( $this->product === static::PRODUCT_FANDOMS ) {
			$searchUrl = '/';
			$searchPlaceholderKey = 'global-navigation-search-placeholder-fandom';
		} else {
			if ( $isCorporatePage ) {
				$searchUrl = $this->getCorporatePageSearchUrl();
				$searchPlaceholderKey = 'global-navigation-search-placeholder-wikis';
			} else {
				$searchUrl = $this->getPageUrl( 'Search', NS_SPECIAL, [ 'fulltext' => 'Search' ] );
				$searchPlaceholderKey = 'global-navigation-search-placeholder-in-wiki';
			}
		}

		$search = [
			'type' => 'search',
			'results' => [
				'url' => $searchUrl,
				'param-name' => $this->product === static::PRODUCT_FANDOMS ? 's' : 'query'
			],
			'placeholder-inactive' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-search-placeholder-inactive'
			],
			'placeholder-active' => [
				'type' => 'translatable-text',
				'key' => $searchPlaceholderKey
			]
		];

		if ( $this->product !== static::PRODUCT_FANDOMS && !$isCorporatePage ) {
			$search['suggestions'] = [
				'url' => WikiFactory::getHostById( $this->productInstanceId ) . '/index.php?action=ajax&rs=getLinkSuggest&format=json',
				'param-name' => 'query'
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
				'image' => 'wds-icons-user',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-anon-my-account',
				],
				'subtitle' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-anon-my-account',
				]
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
					"param-name" => "redirect"
				],
			],
		];
	}

	private function getLoggedInUserData( $user ) {
		$isMessageWallEnabled = $this->isMessageWallEnabled();
		$userName = $user->getName();

		$viewProfileLink = [
			'type' => 'link-text',
			'href' => $this->getPageUrl( $userName, NS_USER ),
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-user-view-profile'
			]
		];
		$logOutLink = [
			'type' => 'link-authentication',
			'href' => $this->getPageUrl( 'UserLogout', NS_SPECIAL ),
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-user-sign-out'
			],
			'param-name' => 'returnto'
		];

		$links = [
			static::PRODUCT_WIKIS => [
				$viewProfileLink,
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
					]
				],
				[
					'type' => 'link-text',
					'href' => $this->getPageUrl( 'Preferences', NS_SPECIAL ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-user-my-preferences'
					]
				],
				[
					'type' => 'link-text',
					'href' => $this->getHref( 'help' ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-user-help'
					]
				],
				$logOutLink
			],
			static::PRODUCT_FANDOMS => [
				$viewProfileLink,
				$logOutLink
			]
		];

		return [
			'header' => [
				'type' => 'avatar',
				'username' => [
					'type' => 'text',
					'value' => $userName
				],
				'url' => AvatarService::getAvatarUrl( $userName, 50 ),
			],
			'links' => $links[$this->product]
		];
	}

	private function getNotifications( $user ) {
		$userName = $user->getName();

		return [
			'header' => [
				'type' => 'line-image',
				'image' => 'wds-icons-bell',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-notifications-title'
				]
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
				],
				[
					'type' => 'link-branded',
					'brand' => 'movies',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-fandom-overview-link-vertical-movies'
					],
					'href' => $this->getHref( 'movies' ),
				],
				[
					'type' => 'link-branded',
					'brand' => 'tv',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-fandom-overview-link-vertical-tv'
					],
					'href' => $this->getHref( 'tv' ),
				]
			]
		];
	}

	private function isMessageWallEnabled() {
		return WikiFactory::getVarValueByName( 'wgEnableWallExt', $this->productInstanceId );
	}

	private function getCorporatePageSearchUrl() {
		return GlobalTitle::newFromText( 'Search', NS_SPECIAL, WikiService::WIKIAGLOBAL_CITY_ID )->getFullURL( [
			'fulltext' => 'Search',
			'resultsLang' => $this->lang
		] );
	}

	private function getCommunityCentralLink() {
		return [
			'type' => 'link-text',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-wikis-community-central'
			],
			'href' => $this->getHref( 'community-central' ),
		];
	}

	private function getSitenameData() {
		return [
			'type' => 'text',
			'value' => WikiFactory::getVarValueByName( 'wgSitename', $this->productInstanceId, false, $this->wg->Sitename ),
		];
	}
}

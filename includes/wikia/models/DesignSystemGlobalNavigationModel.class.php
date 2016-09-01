<?php

class DesignSystemGlobalNavigationModel extends WikiaModel {
	const DEFAULT_LANG = 'en';

	private $wikiId;
	private $lang;

	public function __construct( $wikiId, $lang = self::DEFAULT_LANG ) {
		parent::__construct();

		$this->wikiId = $wikiId;
		$this->lang = $lang;
	}

	public function getData() {
		global $wgUser;

		$data = [
			'logo' => [
				'header' => [
					'type' => 'link-image',
					'href' => $this->getHref( 'fandom-logo' ),
					'image' => 'wds-company-logo-fandom-powered-by-wikia',
					'title' => [
						'type' => 'text',
						'value' => 'Fandom powered by Wikia'
					]
				]
			],
			'search' => [
				'module' => $this->getSearchData()
			],
			'create_wiki' => [
				'links' => [
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-create-wiki-link-start-wikia'
						],
						'href' => $this->getHref( 'create-new-wiki' ),
					]
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
				'links' => $this->getCommunityCentralLink()
			];
		}

		if ( $wgUser->isLoggedIn() ) {
			$data[ 'user' ] = $this->getLoggedInUserData( $wgUser );
			$data[ 'notifications' ] = $this->getNotifications( $wgUser );
		} else {
			$data[ 'anon' ] = $this->getAnonUserData();
		}

		return $data;
	}

	private function getHref( $hrefKey ) {
		return DesignSystemSharedLinks::getInstance()->getHref( $hrefKey, $this->lang );
	}

	private function getPageUrl( $pageTitle, $namespace, $query = '' ) {
		return GlobalTitle::newFromText( $pageTitle, $namespace, $this->wikiId )->getFullURL( $query );
	}

	private function getSearchData() {
		$isCorporatePage = WikiaPageType::isCorporatePage( $this->wikiId );

		$search = [
			'type' => 'search',
			'results' => [
				'url' => $isCorporatePage
					? $this->getCorporatePageSearchUrl()
					: $this->getPageUrl( 'Search', NS_SPECIAL, [ 'fulltext' => 'Search' ] ),
				'param-name' => 'query'
			],
			'placeholder-inactive' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-search-placeholder-inactive'
			],
			'placeholder-active' => [
				'type' => 'translatable-text',
				'key' => $isCorporatePage
					? 'global-navigation-search-placeholder-wikis'
					: 'global-navigation-search-placeholder-in-wiki'
			]
		];

		if ( !$isCorporatePage ) {
			$search['suggestions'] = [
				'url' => WikiFactory::getHostById( $this->wikiId ) . '/index.php?action=ajax&rs=getLinkSuggest&format=json',
				'param-name' => 'query'
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

		return [
			'header' => [
				'type' => 'avatar',
				'username' => [
					'type' => 'text',
					'value' => $userName
				],
				'url' => AvatarService::getAvatarUrl( $userName, 50 ),
			],
			'links' => [
				[
					'type' => 'link-text',
					'href' => $this->getPageUrl( $userName, NS_USER ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-user-view-profile'
					]
				],
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
					'href' => $this->getPageUrl( 'Contents', NS_HELP ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-user-help'
					]
				],
				[
					'type' => 'link-authentication',
					'href' => $this->getPageUrl( 'UserLogout', NS_SPECIAL ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-user-sign-out'
					],
					'param-name' => 'returnto'
				]
			],
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
					'brand' => 'tv',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-fandom-overview-link-vertical-tv'
					],
					'href' => $this->getHref( 'tv' ),
				],
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
				]
			]
		];
	}

	private function isMessageWallEnabled() {
		return WikiFactory::getVarValueByName( 'wgEnableWallExt', $this->wikiId );
	}

	private function isCorporatePage() {
		return WikiFactory::getVarValueByName( 'wgEnableWikiaHomePageExt', $this->wikiId )
			|| WikiFactory::getVarValueByName( 'wgEnableWikiaHubsV3Ext', $this->wikiId );
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
}

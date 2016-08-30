<?php

class DesignSystemGlobalNavigationModel extends WikiaModel {
	const DEFAULT_LANG = 'en';

	private $hrefs = [
		'default' => [
			'fandom-logo' => 'http://fandom.wikia.com',
			'games' => 'http://fandom.wikia.com/games',
			'movies' => 'http://fandom.wikia.com/movies',
			'tv' => 'http://fandom.wikia.com/tv',
			'explore-wikis' => 'http://fandom.wikia.com/explore',
			'community-central' => 'http://community.wikia.com/wiki/Community_Central',
			'fandom-university' => 'http://community.wikia.com/wiki/Wikia_University',
		],
		'en' => [ ]
	];

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
					'image' => 'wds-company-logo-fandom',
					'title' => [
						'type' => 'text',
						'value' => 'Fandom powered by Wikia'
					]
				]
			],
			'verticals' => [
				'links' => [
					[
						'type' => 'link-branded',
						'brand' => 'tv',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-brandlink-vertical-tv'
						],
						'href' => $this->getHref( 'tv' ),
					],
					[
						'type' => 'link-branded',
						'brand' => 'games',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-brandlink-vertical-games'
						],
						'href' => $this->getHref( 'games' ),
					],
					[
						'type' => 'link-branded',
						'brand' => 'movies',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-brandlink-vertical-movies'
						],
						'href' => $this->getHref( 'movies' ),
					]
				]
			],
			'wikis' => [
				'header' => [
					'type' => 'line-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-wikis',
					],
				],
				'links' => [
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-brandlink-wikis-explore'
						],
						'href' => $this->getHref( 'explore-wikis' ),
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-wikis-communitycentral'
						],
						'href' => $this->getHref( 'community-central' ),
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-wikis-fandomuniversity'
						],
						'href' => $this->getHref( 'fandom-university' ),
					]
				]
			],
			'search' => [
				'module' => [
					'type' => 'search',
					'results' => [
						'type' => 'parametrized_url',
						'url' => 'http://starwars.wikia.com/wiki/Special:Search?fulltext=Search',
						'param-name' => 'query'
					],
					'suggestions' => [
						'type' => 'parametrized_url',
						'url' => 'http://starwars.wikia.com/index.php?action=ajax&rs=getLinkSuggest&format=json',
						'param-name' => 'query'
					],
					'placeholder-inactive' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-search-placeholder-inactive'
					],
					'placeholder-active' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-search-placeholder-active'
					]
				]
			],
			'create_wiki' => [
				'header' => [
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'wikia-create-wiki-link-start-wikia'
					],
					'href' => $this->getPageUrl( 'CreateNewWiki', NS_SPECIAL ),
				]
			]
		];

		if ( $wgUser->isLoggedIn() ) {
			$data[ 'user' ] = $this->getLoggedInUserData( $wgUser );
			$data[ 'notifications' ] = $this->getNotifications( $wgUser );
		} else {
			$data[ 'anon' ] = $this->getAnonUserData();
		}

		return $data;
	}

	private function getHref( $hrefKey ) {
		return $this->hrefs[ $this->lang ][ $hrefKey ] ?? $this->hrefs[ 'default' ][ $hrefKey ];
	}

	private function getAnonUserData() {
		return [
			'header' => [
				'type' => 'link-image',
				'href' => '#',
				'image' => 'wds-icons-user',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-userinfo-anon-avatar-title',
				],
			],
			'links' => [
				[
					'type' => 'link-authentication',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-signin-title',
					],
					'href' => 'https://www.wikia.com/signin',
					'param-name' => 'redirect',
				],
				[
					'type' => 'link-authentication',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-register-title',
					],
					'subtitle' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-register-description',
					],
					'href' => 'https://www.wikia.com/register',
					"param-name" => "redirect"
				],
			],
		];
	}

	private function getLoggedInUserData( $user ) {
		global $wgEnableWallExt;

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
						'key' => 'global-navigation-userinfo-profile'
					]
				],
				[
					'type' => 'link-text',
					'href' => $wgEnableWallExt
						? $this->getPageUrl( $userName, NS_USER_WALL )
						: $this->getPageUrl( $userName, NS_USER_TALK ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-talk'
					]
				],
				[
					'type' => 'link-text',
					'href' => $this->getPageUrl( 'Preferences', NS_SPECIAL ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-preferences'
					]
				],
				[
					'type' => 'link-text',
					'href' => $this->getPageUrl( 'Contents', NS_HELP ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-help'
					]
				],
				[
					'type' => 'link-authentication',
					'href' => $this->getPageUrl( 'UserLogout', NS_SPECIAL ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-signout'
					],
					'param-name' => 'returnto'
				]
			],
		];
	}

	private function getNotifications( $user ) {
		global $wgEnableWallExt;

		$userName = $user->getName();

		return [
			'module' => [
				'type' => 'notifications',
				'url' => $wgEnableWallExt
					? $this->getPageUrl( $userName, NS_USER_WALL )
					: $this->getPageUrl( $userName, NS_USER_TALK ),
				'header' => [
					'type' => 'line-image',
					'image' => 'wsd-icons-bell',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-notifications'
					]
				]
			]
		];
	}

	private function getPageUrl( $pageTitle, $pageType ) {
		return GlobalTitle::newFromText( $pageTitle, $pageType, $this->wikiId )->getFullURL();
	}
}

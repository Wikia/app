<?php

class DesignSystemGlobalNavigationModel extends WikiaModel {
	const DEFAULT_LANG = 'en';

	private $hrefs = [
		'default' => [
			'brand-logo' => '#'
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
			'brand_logo' => [
				'type' => 'link-image',
				'href' => $this->getHref( 'brand-logo' ),
				'image' => 'company-fandom',
				'title' => [
					'type' => 'text',
					'value' => 'some_alt_text_here',
				]
			],
			'brand_links' => [
				[
					'type' => 'link-branded',
					'brand' => 'tv',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-brandlink-vertical-tv'
					],
					'href' => 'http:\/\/tv.wikia.com'
				],
				[
					'type' => 'link-branded',
					'brand' => 'games',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-brandlink-vertical-games'
					],
					'href' => 'http:\/\/games.wikia.com'
				],
				[
					'type' => 'link-branded',
					'brand' => 'movies',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-brandlink-vertical-movies'
					],
					'href' => 'http:\/\/movies.wikia.com'
				],
				[
					'type' => 'links-list',
					'brand' => 'wikis',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-brandlink-vertical-wikis',
					],
					'links' => [
						[
							'type' => 'link-text',
							'brand' => 'wikis',
							'title' => [
								'type' => 'translatable-text',
								'key' => 'global-navigation-brandlink-vertical-explorewikis'
							],
							'href' => '#'
						],
						[
							'type' => 'link-text',
							'brand' => 'communitycentral',
							'title' => [
								'type' => 'translatable-text',
								'key' => 'global-navigation-brandlink-vertical-communitycentral'
							],
							'href' => '#'
						]
					]
				]
			],
			'search' => [
				[
					'type' => 'search-endpoint',
					'results' => [
						'type' => 'parametrized-external-resource',
						'param' => 'query',
						'href' => 'http://wikia.com/search'
					],
					'suggestions' => [
						'type' => 'parametrized-external-resource',
						'param' => 'query',
						'href' => 'http://wikia.com/search/suggestions'
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
			'user_info' => $wgUser->isLoggedIn() ? $this->getLoggedInUserData( $wgUser->getId() ) : $this->getAnonUserData(),
			'create_wiki' => [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'wikia-create-wiki-link-start-wikia'
				],
				'href' => '#'
			]
		];

		return $data;
	}

	private function getHref( $hrefKey ) {
		return $this->hrefs[ $this->lang ][ $hrefKey ] ?? $this->hrefs[ 'default' ][ $hrefKey ];
	}

	private function getAnonUserData() {
		return [
			'type' => 'user-anon',
			'avatar' => [
				'type' => 'line-image',
				'image' => 'user',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-userinfo-anon-avatar-title'
				],
			],
			'links' => [
				[
					'type' => 'parametrized-link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-signin-title'
					],
					'href' => '#',
					'param' => 'redirect'
				],
				[
					'type' => 'link-text-with-description',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-register-title'
					],
					'description' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-register-description'
					],
					'href' => '#'
				]
			]
		];
	}

	private function getLoggedInUserData( $userId ) {
		$user = User::newFromId( $userId );
		$userName = $user->getName();

		return [
			'type' => 'user-authenticated',
			'notifications' => [
				'url' => [
					'type' => 'external-resource',
					'href' => '#'
				],
				'image' => [
					'type' => 'line-image',
					'image' => 'notifications',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-notifications'
					]
				]
			],
			'avatar' => [
				'type' => 'external-resource',
				'href' => AvatarService::getAvatarUrl( $userName, 50 ),
			],
			'username' => [
				'type' => 'text',
				'value' => $userName
			],
			'links' => [
				[
					'type' => 'link-text',
					'href' => '#',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-profile'
					]
				],
				[
					'type' => 'link-text',
					'href' => '#',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-talk'
					]
				],
				[
					'type' => 'link-text',
					'href' => $this->getSpecialPageUrl( 'Preferences' ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-preferences'
					]
				],
				[
					'type' => 'link-text',
					'href' => '#',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-help'
					]
				],
				[
					'type' => 'link-text',
					'href' => $this->getSpecialPageUrl( 'UserLogout' ),
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-signout'
					]
				]
			]
		];
	}

	private function getSpecialPageUrl( $specialPageTitle ) {
		return GlobalTitle::newFromText( $specialPageTitle, NS_SPECIAL, $this->wikiId )->getFullURL();
	}
}

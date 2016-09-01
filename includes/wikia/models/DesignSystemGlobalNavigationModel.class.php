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
				'links' => [
					[
						'type' => 'link-image',
						'href' => $this->getHref( 'fandom-logo' ),
						'image' => 'wds-company-logo-fandom',
						'title' => [
							'type' => 'text',
							'value' => 'Fandom powered by Wikia'
						]
					]
				]
			],
			'search' => [
				'module' => [
					'type' => 'search',
					'results' => [
						'url' => $this->getPageUrl( 'Search', NS_SPECIAL, 'fulltext=Search' ),
						'param-name' => 'query'
					],
					'suggestions' => [
						'url' => WikiFactory::getHostById( $this->wikiId ) . '/index.php?action=ajax&rs=getLinkSuggest&format=json',
						'param-name' => 'query'
					],
					'placeholder-inactive' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-search-placeholder-inac`tive'
					],
					'placeholder-active' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-search-placeholder-active'
					]
				]
			],
			'create_wiki' => [
				'links' => [
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'wikia-create-wiki-link-start-wikia'
						],
						'href' => $this->getHref( 'create-new-wiki' ),
					]
				]
			]
		];

		if ( $this->lang === static::DEFAULT_LANG ) {
			$data[ 'verticals' ] = $this->getVerticalsSection();
			$data[ 'wikis' ] = [
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
						'href' => $this->getHref( 'fan-communities' ),
					],
					$this->getCommunityCentralLink(),
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-wikis-fandomuniversity'
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

	private function getAnonUserData() {
		return [
			'header' => [
				'type' => 'line-image',
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
					'href' => $this->getHref( 'user-signin' ),
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
					'href' => $this->getHref( 'user-register' ),
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
			'header' => [
				'type' => 'line-image',
				'image' => 'wsd-icons-bell',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-notifications'
				]
			],
			'module' => [
				'type' => 'notifications',
				'url' => $wgEnableWallExt
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
		];
	}

	private function getCommunityCentralLink() {
		return [
			'type' => 'link-text',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-wikis-communitycentral'
			],
			'href' => $this->getHref( 'community-central' ),
		];
	}
}

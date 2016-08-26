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
		$data = [
			'brand-_ogo' => [
				'type' => 'link-image',
				'href' => '#',
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
					'links' => [ // not branded
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
					'type' => 'search-endpoint',  // new_type
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
			'user-info' => [
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
					'type' => 'external-resource', // new_type
					'href' => '#',
				],
				'username' => [
					'type' => 'text',
					'value' => '_username_',
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
						'href' => '#',
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
						'href' => '#',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-userinfo-signout'
						]
					]
				]
			],
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
}

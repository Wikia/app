<?php

class DesignSystemApiController extends WikiaApiController {
	private $wikiId;
	private $lang;

	private $data = [
		'brand-logo' => [
			'type' => 'brand-logo',
			'href' => '#',
			'elements' => [
				[
					'type' => 'line-image',
					'image' => 'company/logo-fandom',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-logo-fandom',
					]
				],
				[
					'type' => 'line-image',
					'image' => 'company/logo-wikia',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-logo-wikia',
					]
				],
				[
					'type' => 'translatable-text',
					'key' => 'global-navigation-header-title',
				],
			],
		],
		'brand-links' => [
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
				'type' => 'links-branded',
				'brand' => 'wikis',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-header-title',
				],
				'links' => [ // not branded
					[
						'type' => 'link-branded',
						'brand' => 'wikis',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-navigation-brandlink-vertical-wikis'
						],
						'href' => '#'
					],
					[
						'type' => 'link-branded',
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
				'endpoint-href' => 'some.search.link',
				'suggestions-href' => 'suggestions.link', // make object
				'placeholder-inactive' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-search-placeholder-inactive'
				],
				'placeholder-active' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-search-placeholder-active'
				],
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-navigation-search-title'
				]
			]
		],
		'user-info' => [
			'type' => 'user-not-authenticated', // new_type
			'avatar' => [ ],
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-signin-title'
					],
					'href' => '#'
				],
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-register-title'
					],
					'description' => [  // define_new_type?
						'type' => 'translatable-text',
						'key' => 'global-navigation-userinfo-register-description'
					],
					'href' => '#'
				]
			]
		],
		'start-wikia' => [
			'type' => 'link-text',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'wikia-create-wiki-link-start-wikia'
			],
			'href' => '#'
		]
	];

	public function getFooter() {
		$this->checkRequestCompleteness();

		$footerModel = new DesignSystemGlobalFooterModel( $this->wikiId, $this->lang );

		$this->setResponseData( $footerModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	public function getNavigation() {
		global $wgUser;
		$this->checkRequestCompleteness();

		// TODO: change to not mocked data
		$this->setResponseData( $this->data );

		if ( $wgUser) {
			$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
			$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		} else {
			$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		}
	}

	private function checkRequestCompleteness() {
		$wikiId = $this->request->getInt( 'wikiId' );
		$lang = $this->request->getVal( 'lang' );

		if ( WikiFactory::IDtoDB( $wikiId ) === false ) {
			throw new NotFoundApiException( 'Unable to find wiki with ID {$wikiId}' );
		}

		if ( empty( $lang ) ) {
			throw new MissingParameterApiException( 'lang' );
		}

		$this->wikiId = $wikiId;
		$this->lang = $lang;
	}
}

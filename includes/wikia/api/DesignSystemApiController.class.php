<?php

class DesignSystemApiController extends WikiaApiController {
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
		$params = $this->checkRequestCompleteness();

		$footerModel = new DesignSystemGlobalFooterModel( $params[ 'wikiId' ], $params[ 'lang' ] );

		$this->setResponseData( $footerModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	public function getNavigation() {
		$this->checkRequestCompleteness();

		// TODO: change to not mocked data
		$this->setResponseData( $this->data );

		$this->addCachingHeaders();
	}

	/**
	 * return all possible elements of Design System API
	 * @throws \NotFoundApiException
	 */
	public function getAllElements() {
		$params = $this->checkRequestCompleteness();

		$this->setResponseData( [
			'global-footer' => ( new DesignSystemGlobalFooterModel( $params[ 'wikiId' ], $params[ 'lang' ] ) ) ->getData(),
			'global-navigation' => $this->data
		] );

		$this->addCachingHeaders();
	}

	private function checkRequestCompleteness() {
		$wikiId = $this->getRequiredParam( 'wikiId' );
		$lang = $this->getRequiredParam( 'lang' );

		if ( WikiFactory::IDtoDB( $wikiId ) === false ) {
			throw new NotFoundApiException( "Unable to find wiki with ID {$wikiId}" );
		}

		return [
			'wikiId' => $wikiId,
			'lang' => $lang
		];
	}

	/**
	 * add response headers for requests that require differing for anons
	 * and logged in users
	 */
	private function addCachingHeaders() {
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
			$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		} else {
			$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		}
	}
}

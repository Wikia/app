<?php

class DesignSystemApiController extends WikiaApiController {
	private $data = [
		"logo" => [
			"header" => [
				"type" => "link-image",
				"href" => "http://fandom.wikia.com",
				"image" => "wds/full_fandom_logo",
				"title" => [
					"type" => "text",
					"value" => "Fandom",
				]
			]
		],
		"verticals" => [
			"links" => [
				[
					"type" => "link-branded",
					"brand" => "tv",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-brandlink-vertical-tv",
					],
					"href" => "http://tv.wikia.com"
				],
				[
					"type" => "link-branded",
					"brand" => "games",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-brandlink-vertical-games",
					],
					"href" => "http://games.wikia.com",
				],
				[
					"type" => "link-branded",
					"brand" => "movies",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-brandlink-vertical-movies",
					],
					"href" => "http://movies.wikia.com",
				],
			],
		],
		"wikis" => [
			"header" => [
				"type" => "link-branded",
				"brand" => "wikis",
				"href" => "#",
				"title" => [
					"type" => "translatable-text",
					"key" => "global-navigation-brandlink-vertical-wikis",
				],
			],
			"links" => [
				[
					"type" => "link-text",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-brandlink-vertical-explorewikis",
					],
					"href" => "#",
				],
				[
					"type" => "link-text",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-brandlink-vertical-wikis-communitycentral",
					],
					"href" => "#",
				],
			],
		],
		"search" => [
			"modules" => [
				"type" => "search",
				"results" => [
					"url" => "http://wikia.com/search",
					"param" => "query",
				],
				"suggestions" => [
					"url" => "http://wikia.com/search/suggestions",
					"param" => "query",
				],
				"placeholder-inactive" => [
					"type" => "translatable-text",
					"key" => "global-navigation-search-placeholder-inactive",
				],
				"placeholder-active" => [
					"type" => "translatable-text",
					"key" => "global-navigation-search-placeholder-active",
				],
			],
		],
		"anon" => [
			"header" => [
				"type" => "link-image",
				"href" => "#",
				"image" => "anon-avatar",
				"title" => [
					"type" => "translatable-text",
					"key" => "global-navigation-userinfo-anon-avatar-title",
				],
			],
			"links" => [
				[
					"type" => "register",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-signin-title",
					],
					"href" => "#",
					"param" => "redirect",
				],
				[
					"type" => "link-text",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-register-title",
					],
					"subtitle" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-register-description",
					],
					"href" => "#",
				],
			],
		],
		"user" => [
			"header" => [
				"type" => "avatar",
				"username" => [
					"type" => "text",
					"value" => "Username",
				],
				"url" => "http://static.wikia.nocookie.net/591dee3c-0ce9-48c4-96ee-a7bc437c238f/scale-to-width-down/50",
			],
			"links" => [
				[
					"type" => "link-text",
					"href" => "#",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-profile",
					],
				],
				[
					"type" => "link-text",
					"href" => "#",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-talk",
					],
				],
				[
					"type" => "link-text",
					"href" => "#",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-preferences",
					],
				],
				[
					"type" => "link-text",
					"href" => "#",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-help",
					],
				],
				[
					"type" => "link-text",
					"href" => "#",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-signout",
					],
				],
			],
		],
		"notifications" => [
			"modules" => [
				"type" => "notifications",
				"url" => "#",
				"header" => [
					"type" => "line-image",
					"image" => "wsd/notifications",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-notifications",
					],
				],
			],
		],
		"create_wiki" => [
			"header" => [
				"type" => "link-text",
				"title" => [
					"type" => "translatable-text",
					"key" => "wikia-create-wiki-link-start-wikia",
				],
				"href" => "#",
			],
		],

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

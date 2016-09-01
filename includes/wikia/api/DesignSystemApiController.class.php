<?php

class DesignSystemApiController extends WikiaApiController {
	private $data = [
		"logo" => [
			"header" => [
				"type" => "link-image",
				"href" => "http://fandom.wikia.com",
				"image" => "wds-company-logo-fandom",
				"title" => [
					"type" => "text",
					"value" => "Fandom powered by Wikia",
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
					"href" => "http://fandom.wikia.com/tv"
				],
				[
					"type" => "link-branded",
					"brand" => "games",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-brandlink-vertical-games",
					],
					"href" => "http://fandom.wikia.com/games",
				],
				[
					"type" => "link-branded",
					"brand" => "movies",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-brandlink-vertical-movies",
					],
					"href" => "http://fandom.wikia.com/movies",
				],
			],
		],
		"wikis" => [
			"header" => [
				"type" => "line-text",
				"title" => [
					"type" => "translatable-text",
					"key" => "global-navigation-wikis",
				],
			],
			"links" => [
				[
					"type" => "link-text",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-wikis-explore",
					],
					"href" => "#",
				],
				[
					"type" => "link-text",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-wikis-communitycentral",
					],
					"href" => "#",
				],
			],
		],
		"search" => [
			"module" => [
				"type" => "search",
				"results" => [
					"url" => "http://starwars.wikia.com/wiki/Special:Search?fulltext=Search",
					"param-name" => "query",
				],
				"suggestions" => [
					"url" => "http://starwars.wikia.com/index.php?action=ajax&rs=getLinkSuggest&format=json",
					"param-name" => "query",
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
				"image" => "wds-icons-user",
				"title" => [
					"type" => "translatable-text",
					"key" => "global-navigation-userinfo-anon-avatar-title",
				],
			],
			"links" => [
				[
					"type" => "authentication-link",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-signin-title",
					],
					"href" => "https://www.wikia.com/signin",
					"param-name" => "redirect",
				],
				[
					"type" => "authentication-link",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-register-title",
					],
					"subtitle" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-register-description",
					],
					"href" => "https://www.wikia.com/register",
					"param-name" => "redirect"
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
					"href" => "http://community.wikia.com/wiki/Help:Contents",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-help",
					],
				],
				[
					"type" => "authentication-link",
					"href" => "http://starwars.wikia.com/wiki/Special:UserLogout",
					"title" => [
						"type" => "translatable-text",
						"key" => "global-navigation-userinfo-signout",
					],
					"param-name" => "returnto"
				],
			],
		],
		"notifications" => [
			"module" => [
				"type" => "notifications",
				"url" => "#",
				"header" => [
					"type" => "line-image",
					"image" => "wds-icons-bell",
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
				"href" => "http://www.wikia.com/Special:CreateNewWiki",
			],
		],

	];

	public function getFooter() {
		$params = $this->getRequestParameters();

		$footerModel = new DesignSystemGlobalFooterModel( $params['product'], $params[ 'id' ], $params[ 'lang' ] );

		$this->setResponseData( $footerModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	public function getNavigation() {
		$this->getRequestParameters();

		// TODO: change to not mocked data
		$this->setResponseData( $this->data );

		$this->addCachingHeaders();
	}

	/**
	 * return all possible elements of Design System API
	 * @throws \NotFoundApiException
	 */
	public function getAllElements() {
		$params = $this->getRequestParameters();

		$this->setResponseData( [
			'global-footer' => ( new DesignSystemGlobalFooterModel( $params[ 'product' ], $params[ 'id' ], $params[ 'lang' ] ) )->getData(),
			'global-navigation' => $this->data
		] );

		$this->addCachingHeaders();
	}

	private function getRequestParameters() {
		// ultimately, id will be a required param, but fall back to wikiId while transitioning
		$id = $this->getRequest()->getVal( 'id', null );
		if ( $id === null ) {
			$id = $this->getRequiredParam( 'wikiId' );
		}

		// ultimately, product will be a required param, but fall back to "wikis" while transitioning
		$product = $this->getRequest()->getVal( 'product', null );
		if ( $product === null ) {
			$product = 'wikis';
		}

		$lang = $this->getRequiredParam( 'lang' );

		if ( $product === 'wikis' && WikiFactory::IDtoDB( $id ) === false ) {
			throw new NotFoundApiException( "Unable to find wiki with ID {$id}" );
		}

		return [
			'product' => $product,
			'id' => $id,
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

<?php

class DesignSystemApiController extends WikiaApiController {
	const PARAM_PRODUCT = 'product';
	const PARAM_ID = 'id';
	const PARAM_LANG = 'lang';
	const PRODUCT_WIKIS = 'wikis';

	public function getFooter() {
		$params = $this->getRequestParameters();
		$footerModel = new DesignSystemGlobalFooterModel(
			$params[static::PARAM_PRODUCT],
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);

		$this->setResponseData( $footerModel->getData() );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	public function getNavigation() {
		$params = $this->getRequestParameters();

		$this->setResponseData(
			( new DesignSystemGlobalNavigationModel(
				$params[static::PARAM_PRODUCT],
				$params[static::PARAM_ID],
				$params[static::PARAM_LANG]
			) )->getData() );

		$this->addCachingHeaders();
	}

	public function getCommunityHeader() {
		$this->setResponseData($this->getCommunityHeaderMockedData());
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
	}

	/**
	 * return all possible elements of Design System API
	 * @throws \NotFoundApiException
	 */
	public function getAllElements() {
		$params = $this->getRequestParameters();
		$footerModel = new DesignSystemGlobalFooterModel(
			$params[static::PARAM_PRODUCT],
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);
		$navigationModel = new DesignSystemGlobalNavigationModel(
			$params[static::PARAM_PRODUCT],
			$params[static::PARAM_ID],
			$params[static::PARAM_LANG]
		);


		$this->setResponseData( [
			'global-footer' => $footerModel->getData(),
			'global-navigation' => $navigationModel->getData(),
			'community-header' => $this->getCommunityHeaderMockedData()
		] );

		$this->addCachingHeaders();
	}

	private function getRequestParameters() {
		$id = $this->getRequiredParam( static::PARAM_ID );
		$product = $this->getRequiredParam( static::PARAM_PRODUCT );
		$lang = $this->getRequiredParam( static::PARAM_LANG );

		if ( $product === static::PRODUCT_WIKIS && WikiFactory::IDtoDB( $id ) === false ) {
			throw new NotFoundApiException( "Unable to find wiki with ID {$id}" );
		}

		return [
			static::PARAM_PRODUCT => $product,
			static::PARAM_ID => $id,
			static::PARAM_LANG => $lang
		];
	}

	/**
	 * add response headers for requests that require differing for anons
	 * and logged in users
	 */
	private function addCachingHeaders() {
		global $wgUser;

		$this->response->setHeader( 'Vary', 'Accept-Encoding,Cookie' );

		if ( $wgUser->isLoggedIn() ) {
			$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
			$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		} else {
			$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		}
	}

	private function getCommunityHeaderMockedData() {
		return [
			"wordmark" => [
				"type" => "link-image",
				"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
				"image-data" => [
					"type" => "image-external",
					"url" => "http://img2.wikia.nocookie.net/__cb32/masseffect/images/8/89/Wiki-wordmark.png"
				],
				"title" => [
					"type" => "text",
					"value" => "Masseffect",
				],
				"tracking_label" => "wordmark-image"
			],

			"sitename" => [
				"type" => "link-text",
				"title" => [
					"type" => "text",
					"value" => "Masseffect"
				],
				"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
				"tracking_label" => "sitename"
			],

			"background-image" => "https://vignette3.wikia.nocookie.net/masseffect/images/0/0e/Community-header-background/revision/latest/zoom-crop/width/471/height/115?cb=20170609160041",

			"navigation" => [
				[
					"type" => "link-text",
					"title" => [
						"type" => "text",
						"value" => "link 1 1"
					],
					"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
					"tracking_label" => "custom-label-1",
				],

				[
					"type" => "dropdown",
					"title" => [
						"type" => "text",
						"value" => "link 1 2"
					],
					"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
					"tracking_label" => "custom-level-1",
					"items" => [
						[
							"type" => "link-text",
							"title" => [
								"type" => "text",
								"value" => "link 2 1"
							],
							"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
							"tracking_label" => "custom-level-2",
						],

						[
							"type" => "link-text",
							"title" => [
								"type" => "text",
								"value" => "link 2 2"
							],
							"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
							"tracking_label" => "custom-level-2",
						],

						[
							"type" => "link-text",
							"title" => [
								"type" => "text",
								"value" => "link 2 3"
							],
							"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
							"tracking_label" => "custom-level-2",
						],
					]
				],

				[
					"type" => "dropdown",
					"title" => [
						"type" => "text",
						"value" => "link 1 3"
					],
					"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
					"tracking_label" => "custom-level-1",
					"items" => [
						[
							"type" => "link-text",
							"title" => [
								"type" => "text",
								"value" => "link 2 1"
							],
							"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
							"tracking_label" => "custom-level-2",
						],

						[
							"type" => "link-text",
							"title" => [
								"type" => "text",
								"value" => "link 2 2"
							],
							"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
							"tracking_label" => "custom-level-2",
						],

						[
							"type" => "dropdown",
							"title" => [
								"type" => "text",
								"value" => "link 2 3"
							],
							"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
							"tracking_label" => "custom-level-2",
							"items" => [
								[
									"type" => "link-text",
									"title" => [
										"type" => "text",
										"value" => "link 3 1"
									],
									"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
									"tracking_label" => "custom-level-3",
								],

								[
									"type" => "link-text",
									"title" => [
										"type" => "text",
										"value" => "link 3 2"
									],
									"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
									"tracking_label" => "custom-level-3",
								],

								[
									"type" => "link-text",
									"title" => [
										"type" => "text",
										"value" => "link 3 3"
									],
									"href" => "http://masseffect.wikia.com/wiki/Mass_Effect_Wiki",
									"tracking_label" => "custom-level-3",
								],
							]
						]
					]
				]

			]
		];
	}
}

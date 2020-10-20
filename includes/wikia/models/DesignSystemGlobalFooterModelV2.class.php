<?php

class DesignSystemGlobalFooterModelV2 extends WikiaModel {
	const DEFAULT_LANG = 'en';
	const PRODUCT_WIKIS = 'wikis';
	const PRODUCT_FANDOMS = 'fandoms';

	private $product;
	private $productInstanceId;
	private $lang;
	private $isWikiaOrgCommunity;

	/**
	 * DesignSystemGlobalFooterModel constructor.
	 *
	 * @param string $product Name of product, ex: fandoms, wikis
	 * @param int $productInstanceId Identifier for given product, ex: wiki id
	 * @param string $lang
	 */
	public function __construct( $product, $productInstanceId, $isWikiaOrgCommunity, $lang = self::DEFAULT_LANG ) {
		parent::__construct();

		$this->product = $product;
		$this->productInstanceId = $productInstanceId;
		$this->lang = $lang;
		$this->isWikiaOrgCommunity = $isWikiaOrgCommunity;
	}

	public function getData() {
		if ( $this->isWikiaOrgCommunity ) {
			return $this->getWikiaOrgModel();
		}

		$data = [
			'is-wikia-org' => false,
			'header' => [
				'type' => 'link-image',
				// 'image' is deprecated, use 'image-data' instead
				'image' => 'wds-company-logo-fandom-powered-by-wikia-two-lines',
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-company-logo-fandom-white',
				],
				'href' => $this->getHref( 'fandom-logo' ),
				'title' => [
					'type' => 'text',
					'value' => 'Fandom'
				],
				'tracking_label' => 'logo',
			],
			'site_overview' => [
				'header' => [
					'type' => 'line-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-company-overview-header'
					]
				],
				'links' => [
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-company-overview-link-about'
						],
						'href' => $this->getHref( 'about' ),
						'tracking_label' => 'company-overview.about',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-company-overview-link-careers'
						],
						'href' => $this->getHref( 'careers' ),
						'tracking_label' => 'company-overview.careers',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-company-overview-link-press'
						],
						'href' => $this->getHref( 'press' ),
						'tracking_label' => 'company-overview.press',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-company-overview-link-contact'
						],
						'href' => $this->getHref( 'contact' ),
						'tracking_label' => 'company-overview.contact',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-terms-of-use'
						],
						'href' => $this->getHref( 'terms-of-use' ),
						'tracking_label' => 'site-overview.terms-of-use',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-privacy-policy'
						],
						'href' => $this->getHref( 'privacy-policy' ),
						'tracking_label' => 'site-overview.privacy-policy',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-global-sitemap'
						],
						'href' => $this->getHref( 'global-sitemap' ),
						'tracking_label' => 'site-overview.global-sitemap',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-local-sitemap'
						],
						'href' => $this->getLocalSitemapUrl(),
						'tracking_label' => 'site-overview.local-sitemap',
					]
				]
			],
			'fandom_apps' => [
				'header' => [
					'type' => 'line-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-community-apps-header',
					]
				],
				'description' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-apps-description'
				],
			],
			'fandom_stores' => [
				'image' => [
					'type' => 'wds-svg',
					'name' => 'wds-company-store-logo-fandom'
				],
				'links' => [
					[
						'type' => 'link-image',
						// 'image' is deprecated, use 'image-data' instead
						'image' => 'wds-company-store-appstore',
						'image-data' => [
							'type' => 'wds-svg',
							'name' => 'wds-company-store-appstore',
						],
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-community-apps-link-app-store'
						],
						'href' => $this->getHref( 'app-store' ),
						'tracking_label' => 'community-apps.app-store',
					],
					[
						'type' => 'link-image',
						// 'image' is deprecated, use 'image-data' instead
						'image' => 'wds-company-store-googleplay',
						'image-data' => [
							'type' => 'wds-svg',
							'name' => 'wds-company-store-googleplay',
						],
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-community-apps-link-google-play'
						],
						'href' => $this->getHref( 'google-play' ) . '&referrer=utm_source%3Dwikia%26utm_medium%3Dglobalfooter',
						'tracking_label' => 'community-apps.google-play',
					]
				]
			],
			'ddb_stores' => [
				'image' => [
					'type' => 'wds-svg',
					'name' => 'wds-company-store-logo-ddb',
					'caption' => [
						'type' => 'text',
						'value' => 'D&D Beyond'
					],
				],
				'links' => [
					[
						'type' => 'link-image',
						// 'image' is deprecated, use 'image-data' instead
						'image' => 'wds-company-store-appstore',
						'image-data' => [
							'type' => 'wds-svg',
							'name' => 'wds-company-store-appstore',
						],
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-community-apps-link-app-store'
						],
						'href' => $this->getHref( 'ddb-app-store' ),
						'tracking_label' => 'community-apps.app-store-ddb',
					],
					[
						'type' => 'link-image',
						// 'image' is deprecated, use 'image-data' instead
						'image' => 'wds-company-store-googleplay',
						'image-data' => [
							'type' => 'wds-svg',
							'name' => 'wds-company-store-googleplay',
						],
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-community-apps-link-google-play'
						],
						'href' => $this->getHref( 'ddb-google-play' ) . '&referrer=utm_source%3Dwikia%26utm_medium%3Dglobalfooter',
						'tracking_label' => 'community-apps.google-play-ddb',
					]
				]
			],
			'licensing_and_vertical' => $this->getLicensingAndVertical(),
			'mobile_site_button' => [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-mobile-site-link'
				]
			],
			'fandom_overview' => [
				'header' => [
					'type' => 'line-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-overview-header'
					]
				],
				'links' => [
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'text',
							'value' => 'Fandom'
						],
						'href' => $this->getHref( 'fandom-logo' ),
						'tracking_label' => 'explore.fandom',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'text',
							'value' => 'Gamepedia'
						],
						'href' => 'https://www.gamepedia.com/',
						'tracking_label' => 'explore.gamepedia',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'text',
							'value' => 'D&D Beyond'
						],
						'href' => 'https://www.dndbeyond.com/',
						'tracking_label' => 'explore.dnd-beyond',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'text',
							'value' => 'Cortex RPG'
						],
						'href' => 'https://www.cortexrpg.com/',
						'tracking_label' => 'explore.dnd-beyond',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'text',
							'value' => 'Muthead'
						],
						'href' => 'https://www.muthead.com/',
						'tracking_label' => 'explore.muthead',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'text',
							'value' => 'Futhead'
						],
						'href' => 'https://www.futhead.com/',
						'tracking_label' => 'explore.futhead',
					],
				]
			]
		];

		$data['follow_us'] = $this->getFollowUs();
		$data['community'] = $this->getCommunity();
		$data['advertise'] = $this->getAdvertise();

		return $data;
	}

	private function getWikiaOrgModel() {
		$data = [
			'header' => [
				'type' => 'link-image',
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-company-logo-wikia-org',
				],
				'href' => $this->getHref( 'wikia-org-logo' ),
				'title' => [
					'type' => 'text',
					'value' => 'Wikia.org'
				],
				'tracking_label' => 'logo',
			],
			'site_overview' => [
				'links' => [
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-terms-of-use'
						],
						'href' => $this->getHref( 'terms-of-use' ),
						'tracking_label' => 'site-overview.terms-of-use',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-privacy-policy'
						],
						'href' => $this->getHref( 'privacy-policy' ),
						'tracking_label' => 'site-overview.privacy-policy',
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-community-usp-do-not-sell'
						],
						'href' => $this->getProdHref( 'usp-do-not-sell-wikiaorg' ),
						'tracking_label' => 'community.usp-do-not-sell',
					],
				]
			],
			'mobile_site_button' => [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-mobile-site-link'
				]
			],
			'is-wikia-org' => true,
		];

		if ( $this->getHref( 'support' ) ) {
			$data['site_overview']['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-support'
				],
				'href' => $this->getHref( 'support' ),
				'tracking_label' => 'community.support',
			];
		}

		if ( $this->getHref( 'help' ) ) {
			$data['site_overview']['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-help'
				],
				'href' => $this->getHref( 'help' ),
				'tracking_label' => 'community.help',
			];
		}

		return $data;
	}

	private function getSitenameData() {
		if ( $this->product === static::PRODUCT_FANDOMS ) {
			$sitename = 'Fandom';
		} else {
			if ( !empty( $this->wg->SitenameForComscore ) ) {
				$sitename = $this->wg->SitenameForComscore;
			} else {
				$sitename = $this->wg->Sitename;
			}
		}

		return [
			'type' => 'text',
			'value' => $sitename
		];
	}

	private function getVerticalData() {
		// fandom has no set vertical
		if ( $this->product === static::PRODUCT_FANDOMS ) {
			return [];
		}

		$wikiFactoryInstance = WikiFactoryHub::getInstance();
		$verticalData = $wikiFactoryInstance->getWikiVertical( $this->productInstanceId );

		/**
		 * We don't want to show vertical 'Other' instead we show vertical 'Lifestyle'
		 * This is Comscore requirement
		 */
		if ( $verticalData['id'] == WikiFactoryHub::VERTICAL_ID_OTHER ) {
			$verticalMessageKey = $wikiFactoryInstance->getAllVerticals()[WikiFactoryHub::VERTICAL_ID_LIFESTYLE]['short'];
		} else {
			$verticalMessageKey = $verticalData['short'];
		}

		/**
		 * Possible outputs:
		 * - global-footer-licensing-and-vertical-description-param-vertical-tv
		 * - global-footer-licensing-and-vertical-description-param-vertical-games
		 * - global-footer-licensing-and-vertical-description-param-vertical-lifestyle
		 * - global-footer-licensing-and-vertical-description-param-vertical-books
		 * - global-footer-licensing-and-vertical-description-param-vertical-music
		 * - global-footer-licensing-and-vertical-description-param-vertical-comics
		 * - global-footer-licensing-and-vertical-description-param-vertical-movies
		 */
		$verticalMessageKey = 'global-footer-licensing-and-vertical-description-param-vertical-' . $verticalMessageKey;

		return [
			'type' => 'translatable-text',
			'key' => $verticalMessageKey
		];
	}

	private function getLicensingAndVertical() {
		$data = [
			'description' => [
				'type' => 'translatable-text',
				'key' => 'global-footer-licensing-and-vertical-description',
				'params' => [
					'sitename' => $this->getSitenameData(),
					'vertical' => $this->getVerticalData(),
				]
			],
		];

		if ( $this->product === static::PRODUCT_FANDOMS ) {
			$data['description']['params']['license'] = [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-copyright-wikia',
				]
			];
		}

		return $data;
	}

	private function getFollowUs() {
		$data = [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-follow-us-header'
				]
			],
			'links' => [ ]
		];

		$hrefs = $this->getSocialHrefs();

		foreach ( $hrefs as $hrefKey => $hrefUrl ) {
			$data['links'][] = [
				'type' => 'link-image',
				// 'image' is deprecated, use 'image-data' instead
				'image' => 'wds-icons-' . $hrefKey,
				'image-data' => [
					'type' => 'wds-svg',
					'name' => 'wds-icons-' . $hrefKey,
				],
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-follow-us-link-' . $hrefKey
				],
				'href' => $hrefUrl,
				'tracking_label' => 'follow-us.' . $hrefKey,
			];
		}

		return $data;
	}

	private function getCommunity() {
		$data = [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-header'
				]
			],
			'links' => [ ]
		];

		if ( $this->getHref( 'community-central' ) ) {
			$data['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-community-central'
				],
				'href' => $this->getHref( 'community-central' ),
				'tracking_label' => 'community.community-central',
			];
		}

		if ( $this->getHref( 'support' ) ) {
			$data['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-support'
				],
				'href' => $this->getHref( 'support' ),
				'tracking_label' => 'community.support',
			];
		}

		if ( $this->getHref( 'help' ) ) {
			$data['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-help'
				],
				'href' => $this->getHref( 'help' ),
				'tracking_label' => 'community.help',
			];
		}

		$data['links'][] = [
			'type' => 'link-text',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-footer-community-usp-do-not-sell'
			],
			'href' => $this->getProdHref( 'usp-do-not-sell-fandom' ),
			'tracking_label' => 'community.usp-do-not-sell',
		];

		return $data;
	}

	private function getAdvertise() {
		$data = [
			'header' => [
				'type' => 'line-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-advertise-header'
				]
			],
			'links' => [
				[
					'type' => 'link-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-advertise-link-media-kit'
					],
					'href' => $this->getHref( 'media-kit' ),
					'tracking_label' => 'advertise.media-kit',
				]
			]
		];

		if ( $this->getHref( 'media-kit-contact' ) ) {
			$data['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-advertise-link-contact'
				],
				'href' => $this->getHref( 'media-kit-contact' ),
				'tracking_label' => 'advertise.contact',
			];
		}

		return $data;
	}

	private function getLocalSitemapUrl() {
		if ( $this->product !== static::PRODUCT_FANDOMS ) {
			$default = true; // $wgEnableLocalSitemapPageExt = true; in CommonSettings
			$localSitemapAvailable = $this->wg->EnableLocalSitemapPageExt ?? $default;

			if ( $localSitemapAvailable ) {
				return $this->getLocalHref( 'local-sitemap' );
			}
		}

		// Fall back to fandom sitemap when the local one is unavailable
		return $this->getHref( 'local-sitemap-fandom' );
	}

	private function getLocalHref( $hrefKey ) {
		return DesignSystemSharedLinks::getInstance()->getLocalHref( $hrefKey, $this->lang, $this->productInstanceId );
	}

	private function getHref( $hrefKey ) {
		return DesignSystemSharedLinks::getInstance()->getHref( $hrefKey, $this->lang );
	}

	private function getProdHref( $hrefKey ) {
		return DesignSystemSharedLinks::getInstance()->getProdHref( $hrefKey , $this->lang );
	}

	private function getSocialHrefs() {
		return DesignSystemSharedLinks::getInstance()->getSocialHrefs( $this->lang );
	}
}

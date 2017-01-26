<?php

class DesignSystemGlobalFooterModel extends WikiaModel {
	const DEFAULT_LANG = 'en';
	const PRODUCT_WIKIS = 'wikis';
	const PRODUCT_FANDOMS = 'fandoms';

	private $product;
	private $productInstanceId;
	private $lang;

	/**
	 * DesignSystemGlobalFooterModel constructor.
	 *
	 * @param string $product Name of product, ex: fandoms, wikis
	 * @param int $productInstanceId Identifier for given product, ex: wiki id
	 * @param string $lang
	 */
	public function __construct( $product, $productInstanceId, $lang = self::DEFAULT_LANG ) {
		parent::__construct();

		$this->product = $product;
		$this->productInstanceId = $productInstanceId;
		$this->lang = $lang;
	}

	public function getData() {
		$data = [
			'header' => [
				'type' => 'link-image',
				// 'image' is deprecated, use 'image-data' instead
				'image' => 'wds-company-logo-fandom-powered-by-wikia-two-lines',
				'image-data' => $this->getWdsSvgObject( 'wds-company-logo-fandom-powered-by-wikia-two-lines' ),
				'href' => $this->getHref( 'fandom-logo' ),
				'title' => $this->getTextObject( 'Fandom powered by Wikia' ),
				'tracking_label' => 'logo',
			],
			'company_overview' => [
				'header' => $this->getLineTextObject( 'global-footer-company-overview-header' ),
				'links' => $this->getLinkTextObjectList( 'company-overview', [ 'about', 'careers', 'press', 'contact', 'wikia-org' ] ),
			],
			'site_overview' => [
				'links' => $this->getLinkTextObjectList( 'site-overview', [ 'terms-of-use', 'privacy-policy', 'global-sitemap', 'local-sitemap' ] )
			],
			'create_wiki' => [
				'description' => $this->getTranslatableTextObject( 'global-footer-create-wiki-description' ),
				'links' => [ $this->getLinkTextObject( 'global-footer-create-wiki-link-start-wikia', 'create-new-wiki', 'start-a-wiki' ) ]
			],
			'community_apps' => [
				'header' => $this->getLineTextObject( 'global-footer-community-apps-header' ),
				'description' => $this->getTranslatableTextObject( 'global-footer-community-apps-description' ),
				'links' => [
					$this->getLinkImageObject( 'wds-company-store-appstore', 'global-footer-community-apps-link-app-store', 'app-store', 'community-apps.app-store' ),
					$this->getLinkImageObject( 'wds-company-store-googleplay', 'global-footer-community-apps-link-google-play', 'google-play', 'community-apps.google-play' ),
				]
			],
			'licensing_and_vertical' => [
				'description' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-licensing-and-vertical-description',
					'params' => [
						'sitename' => $this->getSitenameData(),
						'vertical' => $this->getVerticalData(),
						'license' => $this->getLicenseData()
					]
				],
			],
		];

		$data['fandom_overview'] = $this->getFandomOverview();
		$data['follow_us'] = $this->getFollowUs();
		$data['community'] = $this->getCommunity();
		$data['advertise'] = $this->getAdvertise();

		return $data;
	}

	private function getLinkTextObjectList( String $section, Array $linkKeys ) {
		return array_map( function( $link ) use ( $section ) {
			return $this->getLinkTextObject(
				'global-footer-' . $section . '-link-' . $link,
				$link,
				$section . '.' . $link
			);
		}, $linkKeys );
	}

	private function getLinkTextObject( $titleKey, $hrefKey, $trackingLabel ) {
		return [
			'type' => 'link-text',
			'title' => $this->getTranslatableTextObject( $titleKey ),
			'href' => $hrefKey == 'local-sitemap' ? $this->getLocalSitemapUrl() : $this->getHref( $hrefKey ),
			'tracking_label' => $trackingLabel,
		];
	}

	private function getLineTextObject( $key ) {
		return [
			'type' => 'line-text',
			'title' => $this->getTranslatableTextObject( $key )
		];
	}

	private function getTranslatableTextObject( $key ) {
		return [
			'type' => 'translatable-text',
			'key' =>  $key
		];
	}

	private function getTextObject( $value ) {
		return [
			'type' => 'text',
			'value' => $value
		];
	}

	private function getWdsSvgObject( $key ) {
		return [
			'type' => 'wds-svg',
			'name' => $key,
		];
	}

	private function getLinkImageObject( $imageKey, $titleKey, $hrefKey, $trackingLabel ) {
		return [
			'type' => 'link-image',
			// 'image' is deprecated, use 'image-data' instead
			'image' => $imageKey,
			'image-data' => $this->getWdsSvgObject( $imageKey ),
			'title' => $this->getTranslatableTextObject( $titleKey ),
			'href' => $this->getHref( $hrefKey ),
			'tracking_label' => $trackingLabel,
		];
	}

	private function getSitenameData() {
		if ( $this->product === static::PRODUCT_FANDOMS ) {
			$sitename = 'Fandom';
		} else {
			$wgSitenameForComscoreForWikiId = WikiFactory::getVarValueByName( 'wgSitenameForComscore', $this->productInstanceId );

			if ( $wgSitenameForComscoreForWikiId ) {
				$sitename = $wgSitenameForComscoreForWikiId;
			} else {
				$wgSitenameForWikiId = WikiFactory::getVarValueByName( 'wgSitename', $this->productInstanceId );

				if ( $wgSitenameForWikiId ) {
					$sitename = $wgSitenameForWikiId;
				} else {
					$sitename = $this->wg->Sitename;
				}
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

		return $this->getTranslatableTextObject( $verticalMessageKey );
	}

	private function getLicenseData() {
		if ( $this->product === static::PRODUCT_FANDOMS ) {
			return $this->getLineTextObject( 'global-footer-copyright-wikia' );
		}

		return [
			'type' => 'link-text',
			'title' => [
				'type' => 'text',
				'value' => WikiFactory::getVarValueByName( 'wgRightsText', $this->productInstanceId ) ?: $this->wg->RightsText,
			],
			'href' => $this->getLicenseUrl(),
			'tracking_label' => 'license',
		];
	}

	private function getFandomOverview() {
		$out = [
			'links' => [ ]
		];

		if ( $this->lang === static::DEFAULT_LANG ) {
			$out['links'] = [
				[
					'type' => 'link-branded',
					'brand' => 'games',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-overview-link-vertical-games'
					],
					'href' => 'http://fandom.wikia.com/games',
					'tracking_label' => 'fandom-overview.games',
				],
				[
					'type' => 'link-branded',
					'brand' => 'movies',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-overview-link-vertical-movies'
					],
					'href' => 'http://fandom.wikia.com/movies',
					'tracking_label' => 'fandom-overview.movies',
				],
				[
					'type' => 'link-branded',
					'brand' => 'tv',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-overview-link-vertical-tv'
					],
					'href' => 'http://fandom.wikia.com/tv',
					'tracking_label' => 'fandom-overview.tv',
				],
			];
		}

		$out['links'][] = [
			'type' => 'link-branded',
			'brand' => 'explore-wikis',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-footer-fandom-overview-link-explore-wikis'
			],
			'href' => $this->getHref( 'explore-wikis' ),
			'tracking_label' => 'fandom-overview.explore-wikis',
		];

		return $out;
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

		if ( $this->getHref( 'fan-contributor' ) ) {
			$data['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-fan-contributor-program'
				],
				'href' => $this->getHref( 'fan-contributor' ),
				'tracking_label' => 'community.fan-contributor',
			];
		}

		if ( $this->getHref( 'wam' ) ) {
			$data['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-wam-score'
				],
				'href' => $this->getHref( 'wam' ),
				'tracking_label' => 'community.wam',
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
			$localSitemapAvailable = WikiFactory::getVarValueByName(
				'wgEnableLocalSitemapPageExt', $this->productInstanceId, false, $default
			);

			if ( $localSitemapAvailable ) {
				return $this->getHref( 'local-sitemap' );
			}
		}

		// Fall back to fandom sitemap when the local one is unavailable
		return $this->getHref( 'local-sitemap-fandom' );
	}

	private function getLicenseUrl() {
		// no license URL for Fandom
		if ( $this->product === static::PRODUCT_FANDOMS ) {
			return '';
		}

		$licenseUrl = WikiFactory::getVarValueByName( 'wgRightsUrl', $this->productInstanceId ) ?: $this->wg->RightsUrl;
		$licensePage = WikiFactory::getVarValueByName( 'wgRightsPage', $this->productInstanceId ) ?: $this->wg->RightsPage;

		if ( $licensePage ) {
			$title = GlobalTitle::newFromText( $licensePage, NS_MAIN, $this->productInstanceId );
			$licenseUrl = $title->getFullURL();
		}

		return $licenseUrl;
	}

	private function getHref( $hrefKey ) {
		return DesignSystemSharedLinks::getInstance()->getHref( $hrefKey, $this->lang );
	}

	private function getSocialHrefs() {
		return DesignSystemSharedLinks::getInstance()->getSocialHrefs( $this->lang );
	}
}

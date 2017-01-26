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
					$this->getLinkImageObject( 'wds-company-store-appstore', 'global-footer-community-apps-link-app-store', $this->getHref( 'app-store' ), 'community-apps.app-store' ),
					$this->getLinkImageObject( 'wds-company-store-googleplay', 'global-footer-community-apps-link-google-play', $this->getHref( 'google-play' ), 'community-apps.google-play' ),
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

	private function getLinkImageObject( $imageKey, $titleKey, $href, $trackingLabel ) {
		return [
			'type' => 'link-image',
			// 'image' is deprecated, use 'image-data' instead
			'image' => $imageKey,
			'image-data' => $this->getWdsSvgObject( $imageKey ),
			'title' => $this->getTranslatableTextObject( $titleKey ),
			'href' => $href,
			'tracking_label' => $trackingLabel,
		];
	}

	private function getLinkBrandedObject( $brand, $titleKey, $href, $trackingLabel) {
		return [
			'type' => 'link-branded',
			'brand' => $brand,
			'title' => $this->getTranslatableTextObject( $titleKey ),
			'href' => $href,
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
				$this->getLinkBrandedObject( 'games', 'global-footer-fandom-overview-link-vertical-games', 'http://fandom.wikia.com/games', 'fandom-overview.games'),
				$this->getLinkBrandedObject( 'movies', 'global-footer-fandom-overview-link-vertical-movies', 'http://fandom.wikia.com/movies', 'fandom-overview.movies' ),
				$this->getLinkBrandedObject( 'tv', 'global-footer-fandom-overview-link-vertical-tv', 'http://fandom.wikia.com/tv', 'fandom-overview.tv'),
			];
		}

		$out['links'][] = $this->getLinkBrandedObject( 'explore-wikis', 'global-footer-fandom-overview-link-explore-wikis', $this->getHref( 'explore-wikis' ), 'fandom-overview.explore-wikis' );

		return $out;
	}

	private function getFollowUs() {
		$data = [
			'header' => $this->getLineTextObject( 'global-footer-follow-us-header' ),
			'links' => [ ]
		];

		$hrefs = $this->getSocialHrefs();
		foreach ( $hrefs as $hrefKey => $hrefUrl ) {
			$data['links'][] = $this->getLinkImageObject( 'wds-icons-' . $hrefKey, 'global-footer-follow-us-link-' . $hrefKey, $hrefUrl, 'follow-us.' . $hrefKey );
		}

		return $data;
	}

	private function getCommunity() {
		$data = [
			'header' => $this->getLineTextObject( 'global-footer-community-header' ),
			'links' => [ ]
		];

		if ( $this->getHref( 'community-central' ) ) {
			$data['links'][] = $this->getLinkTextObject( 'global-footer-community-link-community-central', 'community-central', 'community.community-central' );
		}

		if ( $this->getHref( 'support' ) ) {
			$data['links'][] = $this->getLinkTextObject( 'global-footer-community-link-support', 'support', 'community.support' );
		}

		if ( $this->getHref( 'fan-contributor' ) ) {
			$data['links'][] = $this->getLinkTextObject( 'global-footer-community-link-fan-contributor-program', 'fan-contributor', 'community.fan-contributor' );
		}

		if ( $this->getHref( 'wam' ) ) {
			$data['links'][] = $this->getLinkTextObject( 'global-footer-community-link-wam-score', 'wam', 'community.wam' );
		}

		if ( $this->getHref( 'help' ) ) {
			$data['links'][] = $this->getLinkTextObject( 'global-footer-community-link-help', 'help', 'community.help' );
		}

		return $data;
	}

	private function getAdvertise() {
		$data = [
			'header' => $this->getLineTextObject( 'global-footer-advertise-header' ),
			'links' => [ $this->getLinkTextObject( 'global-footer-advertise-link-media-kit', 'media-kit', 'advertise.media-kit' ) ]
		];

		if ( $this->getHref( 'media-kit-contact' ) ) {
			$data['links'][] = $this->getLinkTextObject( 'global-footer-advertise-link-contact', 'media-kit-contact', 'advertise.contact' );
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

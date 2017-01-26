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
			'header' => $this->getLinkImageObject(
				'wds-company-logo-fandom-powered-by-wikia-two-lines',
				'Fandom powered by Wikia',
				$this->getHref( 'fandom-logo' ),
				'logo',
				false
			),
			'company_overview' => [
				'header' => $this->getLineTextTranslatableObject( 'global-footer-company-overview-header' ),
				'links' => $this->getLinkTextObjectList(
					'company-overview',
					[ 'about', 'careers', 'press', 'contact', 'wikia-org' ]
				),
			],
			'site_overview' => [
				'links' => $this->getLinkTextObjectList(
					'site-overview',
					[ 'terms-of-use', 'privacy-policy', 'global-sitemap', 'local-sitemap' ]
				)
			],
			'create_wiki' => [
				'description' => $this->getTranslatableTextObject( 'global-footer-create-wiki-description' ),
				'links' => [
					$this->getLinkTextTranslatableObject(
						'global-footer-create-wiki-link-start-wikia',
						'create-new-wiki',
						'start-a-wiki'
					)
				]
			],
			'community_apps' => [
				'header' => $this->getLineTextTranslatableObject( 'global-footer-community-apps-header' ),
				'description' => $this->getTranslatableTextObject( 'global-footer-community-apps-description' ),
				'links' => [
					$this->getLinkImageObject(
						'wds-company-store-appstore',
						'global-footer-community-apps-link-app-store',
						$this->getHref( 'app-store' ),
						'community-apps.app-store'
					),
					$this->getLinkImageObject(
						'wds-company-store-googleplay',
						'global-footer-community-apps-link-google-play',
						$this->getHref( 'google-play' ),
						'community-apps.google-play'
					),
				]
			],
			'licensing_and_vertical' => [
				'description' => $this->getTranslatableTextObject(
					'global-footer-licensing-and-vertical-description',
					[
						'sitename' => $this->getSitenameData(),
						'vertical' => $this->getVerticalData(),
						'license' => $this->getLicenseData()
					]
				),
			],
		];

		$data['fandom_overview'] = $this->getFandomOverview();
		$data['follow_us'] = $this->getFollowUs();
		$data['community'] = $this->getCommunity();
		$data['advertise'] = $this->getAdvertise();

		return $data;
	}

	private function getSitenameData() {
		if ( $this->product === static::PRODUCT_FANDOMS ) {
			$sitename = 'Fandom';
		} else {
			$wgSitenameForComscoreForWikiId =
				WikiFactory::getVarValueByName( 'wgSitenameForComscore', $this->productInstanceId );

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

		return $this->getTextObject( $sitename );
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
			$verticalMessageKey =
				$wikiFactoryInstance->getAllVerticals()[WikiFactoryHub::VERTICAL_ID_LIFESTYLE]['short'];
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
			return $this->getLineTextTranslatableObject( 'global-footer-copyright-wikia' );
		}

		return $this->getLinkTextObject(
			WikiFactory::getVarValueByName( 'wgRightsText', $this->productInstanceId ) ?: $this->wg->RightsText,
			$this->getLicenseUrl(),
			'license'
		);
	}

	private function getFandomOverview() {
		$out = [
			'links' => []
		];

		if ( $this->lang === static::DEFAULT_LANG ) {
			$out['links'] = [
				$this->getLinkBrandedObject(
					'games',
					'global-footer-fandom-overview-link-vertical-games',
					'http://fandom.wikia.com/games',
					'fandom-overview.games'
				),
				$this->getLinkBrandedObject(
					'movies',
					'global-footer-fandom-overview-link-vertical-movies',
					'http://fandom.wikia.com/movies',
					'fandom-overview.movies'
				),
				$this->getLinkBrandedObject(
					'tv',
					'global-footer-fandom-overview-link-vertical-tv',
					'http://fandom.wikia.com/tv',
					'fandom-overview.tv'
				),
			];
		}

		$out['links'][] = $this->getLinkBrandedObject(
			'explore-wikis',
			'global-footer-fandom-overview-link-explore-wikis',
			$this->getHref( 'explore-wikis' ),
			'fandom-overview.explore-wikis'
		);

		return $out;
	}

	private function getFollowUs() {
		$data = [
			'header' => $this->getLineTextTranslatableObject( 'global-footer-follow-us-header' ),
			'links' => []
		];

		$hrefs = $this->getSocialHrefs();
		foreach ( $hrefs as $hrefKey => $hrefUrl ) {
			$data['links'][] = $this->getLinkImageObject(
				'wds-icons-' . $hrefKey,
				'global-footer-follow-us-link-' . $hrefKey,
				$hrefUrl,
				'follow-us.' . $hrefKey
			);
		}

		return $data;
	}

	private function getCommunity() {
		$data = [
			'header' => $this->getLineTextTranslatableObject( 'global-footer-community-header' ),
			'links' => []
		];

		$links = [
			[
				'titleKey' => 'global-footer-community-link-community-central',
				'hrefKey' => 'community-central',
				'trackingLabel' => 'community.community-central'
			],
			[
				'titleKey' => 'global-footer-community-link-support',
				'hrefKey' => 'support',
				'trackingLabel' => 'community.support'
			],
			[
				'titleKey' => 'global-footer-community-link-fan-contributor-program',
				'hrefKey' => 'fan-contributor',
				'trackingLabel' => 'community.fan-contributor'
			],
			[
				'titleKey' => 'global-footer-community-link-wam-score',
				'hrefKey' => 'wam',
				'trackingLabel' => 'community.wam'
			],
			[
				'titleKey' => 'global-footer-community-link-help',
				'hrefKey' => 'help',
				'trackingLabel' => 'community.help'
			],
		];

		foreach ( $links as $link ) {
			if ( $this->getHref( $link['hrefKey'] ) ) {
				$data['links'][] =
					$this->getLinkTextTranslatableObject( $link['titleKey'], $link['hrefKey'], $link['trackingLabel'] );
			}
		}

		return $data;
	}

	private function getAdvertise() {
		$data = [
			'header' => $this->getLineTextTranslatableObject( 'global-footer-advertise-header' ),
			'links' => [
				$this->getLinkTextTranslatableObject(
					'global-footer-advertise-link-media-kit',
					'media-kit',
					'advertise.media-kit'
				)
			]
		];

		if ( $this->getHref( 'media-kit-contact' ) ) {
			$data['links'][] = $this->getLinkTextTranslatableObject(
				'global-footer-advertise-link-contact',
				'media-kit-contact',
				'advertise.contact'
			);
		}

		return $data;
	}

	private function getLocalSitemapUrl() {
		if ( $this->product !== static::PRODUCT_FANDOMS ) {
			$default = true; // $wgEnableLocalSitemapPageExt = true; in CommonSettings
			$localSitemapAvailable = WikiFactory::getVarValueByName(
				'wgEnableLocalSitemapPageExt',
				$this->productInstanceId,
				false,
				$default
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
		$licensePage =
			WikiFactory::getVarValueByName( 'wgRightsPage', $this->productInstanceId ) ?: $this->wg->RightsPage;

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

	private function getLinkTextObjectList( String $section, Array $linkKeys ) {
		return array_map(
			function ( $link ) use ( $section ) {
				return $this->getLinkTextTranslatableObject(
					'global-footer-' . $section . '-link-' . $link,
					$link,
					$section . '.' . $link
				);
			},
			$linkKeys
		);
	}

	private function getLinkTextTranslatableObject( $titleKey, $hrefKey, $trackingLabel ) {
		return [
			'type' => 'link-text',
			'title' => $this->getTranslatableTextObject( $titleKey ),
			'href' => $hrefKey == 'local-sitemap' ? $this->getLocalSitemapUrl() : $this->getHref( $hrefKey ),
			'tracking_label' => $trackingLabel,
		];
	}

	private function getLinkTextObject( $titleValue, $href, $trackingLabel ) {
		return [
			'type' => 'link-text',
			'title' => $this->getTextObject( $titleValue ),
			'href' => $href,
			'tracking_label' => $trackingLabel,
		];
	}

	private function getLineTextTranslatableObject( $key ) {
		return [
			'type' => 'line-text',
			'title' => $this->getTranslatableTextObject( $key )
		];
	}

	private function getTranslatableTextObject( $key, $params = null ) {
		$result = [
			'type' => 'translatable-text',
			'key' => $key
		];

		if ( !empty( $params ) ) {
			$result['params'] = $params;
		}

		return $result;
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

	private function getLinkImageObject( $imageKey, $title, $href, $trackingLabel, $translatable = true ) {
		return [
			'type' => 'link-image',
			// 'image' is deprecated, use 'image-data' instead
			'image' => $imageKey,
			'image-data' => $this->getWdsSvgObject( $imageKey ),
			'title' => $translatable ? $this->getTranslatableTextObject( $title ) : $this->getTextObject( $title ),
			'href' => $href,
			'tracking_label' => $trackingLabel,
		];
	}

	private function getLinkBrandedObject( $brand, $titleKey, $href, $trackingLabel ) {
		return [
			'type' => 'link-branded',
			'brand' => $brand,
			'title' => $this->getTranslatableTextObject( $titleKey ),
			'href' => $href,
			'tracking_label' => $trackingLabel,
		];
	}
}

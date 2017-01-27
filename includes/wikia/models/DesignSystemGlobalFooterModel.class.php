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
			'header' => (new WdsLinkImage())
				->setSvgImageData( 'wds-company-logo-fandom-powered-by-wikia-two-lines' )
				->setTitle( 'Fandom powered by Wikia' )
				->setHref( $this->getHref( 'fandom-logo' ) )
				->setTrackingLabel( 'logo' )
				->get(),
			'company_overview' => [
				'header' => (new WdsLineText())->setTranslatableTitle( 'global-footer-company-overview-header' )->get(),
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
				'description' => (new WdsTranslatableText( 'global-footer-create-wiki-description' ))->get(),
				'links' => [
					(new WdsLinkText())
						->setTranslatableTitle( 'global-footer-create-wiki-link-start-wikia' )
						->setHref( $this->getHref( 'create-new-wiki' ) )
						->setTrackingLabel( 'start-a-wiki' )
						->get()
				]
			],
			'community_apps' => [
				'header' => (new WdsLineText())->setTranslatableTitle( 'global-footer-community-apps-header' )->get(),
				'description' => (new WdsTranslatableText( 'global-footer-community-apps-description' ))->get(),
				'links' => [
					(new WdsLinkImage())
						->setSvgImageData( 'wds-company-store-appstore' )
						->setTranslatableTitle( 'global-footer-community-apps-link-app-store' )
						->setHref( $this->getHref( 'app-store' ) )
						->setTrackingLabel( 'community-apps.app-store' )
						->get(),
					(new WdsLinkImage())
						->setSvgImageData( 'wds-company-store-googleplay' )
						->setTranslatableTitle( 'global-footer-community-apps-link-google-play' )
						->setHref( $this->getHref( 'google-play' ) )
						->setTrackingLabel( 'community-apps.google-play' )
						->get(),
				]
			],
			'licensing_and_vertical' => [
				'description' => (new WdsTranslatableText(
					'global-footer-licensing-and-vertical-description',
					[
						'sitename' => $this->getSitenameData(),
						'vertical' => $this->getVerticalData(),
						'license' => $this->getLicenseData()
					]))->get()
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

		return (new WdsText( $sitename ))->get();
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

		return (new WdsTranslatableText( $verticalMessageKey ))->get();
	}

	private function getLicenseData() {
		if ( $this->product === static::PRODUCT_FANDOMS ) {
			return (new WdsLineText())->setTranslatableTitle( 'global-footer-copyright-wikia' )->get();
		}

		return (new WdsLinkText())
			->setTitle( WikiFactory::getVarValueByName( 'wgRightsText', $this->productInstanceId ) ?: $this->wg->RightsText )
			->setHref( $this->getLicenseUrl() )
			->setTrackingLabel( 'license' )
			->get();
	}

	private function getFandomOverview() {
		$out = [
			'links' => []
		];

		if ( $this->lang === static::DEFAULT_LANG ) {
			$out['links'] = [
				(new WdsLinkBranded())
					->setBrand( 'games' )
					->setTranslatableTitle( 'global-footer-fandom-overview-link-vertical-games' )
					->setHref( 'http://fandom.wikia.com/games' )
					->setTrackingLabel( 'fandom-overview.games' )
					->get(),
				(new WdsLinkBranded())
					->setBrand( 'movies' )
					->setTranslatableTitle( 'global-footer-fandom-overview-link-vertical-movies' )
					->setHref( 'http://fandom.wikia.com/movies' )
					->setTrackingLabel( 'fandom-overview.movies' )
					->get(),
				(new WdsLinkBranded())
					->setBrand( 'tv' )
					->setTranslatableTitle( 'global-footer-fandom-overview-link-vertical-tv' )
					->setHref( 'http://fandom.wikia.com/tv' )
					->setTrackingLabel( 'fandom-overview.tv' )
					->get(),
			];
		}

		$out['links'][] = (new WdsLinkBranded())
			->setBrand( 'explore-wikis' )
			->setTranslatableTitle( 'global-footer-fandom-overview-link-explore-wikis' )
			->setHref( $this->getHref( 'explore-wikis' ) )
			->setTrackingLabel( 'fandom-overview.explore-wikis' )
			->get();

		return $out;
	}

	private function getFollowUs() {
		$data = [
			'header' => (new WdsLineText())->setTranslatableTitle( 'global-footer-follow-us-header' )->get(),
			'links' => []
		];

		$hrefs = $this->getSocialHrefs();
		foreach ( $hrefs as $hrefKey => $hrefUrl ) {
			$data['links'][] = (new WdsLinkImage())
				->setSvgImageData( 'wds-icons-' . $hrefKey )
				->setTranslatableTitle( 'global-footer-follow-us-link-' . $hrefKey )
				->setHref( $hrefUrl )
				->setTrackingLabel( 'follow-us.' . $hrefKey )
				->get();
		}

		return $data;
	}

	private function getCommunity() {
		$data = [
			'header' => (new WdsLineText())->setTranslatableTitle( 'global-footer-community-header' )->get(),
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
				$data['links'][] = (new WdsLinkText())
					->setTranslatableTitle( $link['titleKey'] )
					->setHref( $this->getHref( $link['hrefKey'] ) )
					->setTrackingLabel( $link['trackingLabel'] )
					->get();
			}
		}

		return $data;
	}

	private function getAdvertise() {
		$data = [
			'header' => (new WdsLineText())->setTranslatableTitle( 'global-footer-advertise-header' )->get(),
			'links' => [
				(new WdsLinkText())
					->setTranslatableTitle( 'global-footer-advertise-link-media-kit' )
					->setHref( $this->getHref( 'media-kit' ) )
					->setTrackingLabel( 'advertise.media-kit' )
					->get()
			]
		];

		if ( $this->getHref( 'media-kit-contact' ) ) {
			$data['links'][] = (new WdsLinkText())
				->setTranslatableTitle( 'global-footer-advertise-link-contact' )
				->setHref( $this->getHref( 'media-kit-contact' ) )
				->setTrackingLabel( 'advertise.contact' )
				->get();
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
				return (new WdsLinkText())
					->setTranslatableTitle( 'global-footer-' . $section . '-link-' . $link )
					->setHref( $link == 'local-sitemap' ? $this->getLocalSitemapUrl() : $this->getHref( $link ) )
					->setTrackingLabel( $section . '.' . $link )
					->get();
			},
			$linkKeys
		);
	}
}

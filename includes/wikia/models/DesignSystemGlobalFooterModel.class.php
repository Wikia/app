<?php

class DesignSystemGlobalFooterModel extends WikiaModel {
	const DEFAULT_LANG = 'en';

	private $wikiId;
	private $lang;

	public function __construct( $wikiId, $lang = self::DEFAULT_LANG ) {
		parent::__construct();

		$this->wikiId = $wikiId;
		$this->lang = $lang;
	}

	public function setHrefs( $hrefs ) {
		$this->hrefs = $hrefs;
	}

	public function getData() {
		$data = [
			'company_overview' => [
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
						'href' => $this->getHref( 'about' )
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-company-overview-link-careers'
						],
						'href' => $this->getHref( 'careers' )
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-company-overview-link-press'
						],
						'href' => $this->getHref( 'press' )
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-company-overview-link-contact'
						],
						'href' => $this->getHref( 'contact' )
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-company-overview-link-wikia-gives-back'
						],
						'href' => $this->getHref( 'wikia-gives-back' )
					]
				]
			],
			'site_overview' => [
				'links' => [
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-terms-of-use'
						],
						'href' => $this->getHref( 'terms-of-use' )
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-privacy-policy'
						],
						'href' => $this->getHref( 'privacy-policy' )
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-global-sitemap'
						],
						'href' => $this->getHref( 'global-sitemap' )
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-local-sitemap'
						],
						'href' => $this->getLocalSitemapUrl()
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-site-overview-link-api'
						],
						'href' => $this->getHref( 'api' )
					]
				]
			],
			'create_wiki' => [
				'description' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-create-wiki-description'
				],
				'links' => [
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-create-wiki-link-start-wikia'
						],
						'href' => $this->getHref( 'create-new-wiki' )
					]
				]
			],
			'community_apps' => [
				'header' => [
					'type' => 'line-text',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-community-apps-header'
					]
				],
				'description' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-apps-description'
				],
				'links' => [
					[
						'type' => 'link-image',
						'image' => 'wds-company-store-appstore',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-community-apps-link-app-store'
						],
						'href' => 'https://itunes.apple.com/developer/wikia-inc./id422467077'
					],
					[
						'type' => 'link-image',
						'image' => 'wds-company-store-googleplay',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-community-apps-link-google-play'
						],
						'href' => 'https://play.google.com/store/apps/developer?id=Wikia,+Inc.'
					]
				]
			],
			'advertise' => [
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
						'href' => $this->getHref( 'media-kit' )
					],
					[
						'type' => 'link-text',
						'title' => [
							'type' => 'translatable-text',
							'key' => 'global-footer-advertise-link-contact'
						],
						'href' => $this->getHref( 'media-kit-contact' )
					]
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

		if ( $this->lang === self::DEFAULT_LANG ) {
			$data['fandom'] = [
				'header' => [
					'type' => 'link-image',
					'image' => 'wds-company-logo-fandom',
					'href' => 'http://fandom.wikia.com',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-header'
					]
				]
			];
			$data['wikia'] = [
				'header' => [
					'type' => 'line-image',
					'image' => 'wds-company-logo-wikia',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-header'
					]
				]
			];
		} else {
			$data['international_header'] = [
				'header' => [
					'type' => 'line-image',
					'image' => 'wds-company-logo-wikia',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-wikia-header'
					],
					'subtitle' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-international-header-subtitle'
					]
				]
			];
		}

		return $data;
	}

	private function getSitenameData() {
		$wgSitenameForComscoreForWikiId = WikiFactory::getVarValueByName( 'wgSitenameForComscore', $this->wikiId );

		if ( $wgSitenameForComscoreForWikiId ) {
			$sitename = $wgSitenameForComscoreForWikiId;
		} else {
			$wgSitenameForWikiId = WikiFactory::getVarValueByName( 'wgSitename', $this->wikiId );

			if ( $wgSitenameForWikiId ) {
				$sitename = $wgSitenameForWikiId;
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
		$wikiFactoryInstance = WikiFactoryHub::getInstance();
		$verticalData = $wikiFactoryInstance->getWikiVertical( $this->wikiId );

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

	private function getLicenseData() {
		$licenseText = WikiFactory::getVarValueByName( 'wgRightsText', $this->wikiId ) ?: $this->wg->RightsText;

		return [
			'type' => 'link-text',
			'title' => [
				'type' => 'text',
				'value' => $licenseText
			],
			'href' => $this->getLicenseUrl()
		];
	}

	private function getFandomOverview() {
		$out = [
			'links' => [ ]
		];

		if ( $this->lang === self::DEFAULT_LANG ) {
			$out['links'] = [
				[
					'type' => 'link-branded',
					'brand' => 'games',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-overview-link-vertical-games'
					],
					'href' => 'http://fandom.wikia.com/games'
				],
				[
					'type' => 'link-branded',
					'brand' => 'movies',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-overview-link-vertical-movies'
					],
					'href' => 'http://fandom.wikia.com/movies'
				],
				[
					'type' => 'link-branded',
					'brand' => 'tv',
					'title' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-fandom-overview-link-vertical-tv'
					],
					'href' => 'http://fandom.wikia.com/tv'
				],
			];
		}

		$out['links'][] = [
			'type' => 'link-branded',
			'brand' => 'fan-communities',
			'title' => [
				'type' => 'translatable-text',
				'key' => 'global-footer-fandom-overview-link-fan-communities'
			],
			'href' => $this->getHref( 'fan-communities' )
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

		if ( $this->getHref( 'social-facebook' ) ) {
			$data['links'][] = [
				'type' => 'link-image',
				'image' => 'wds-icons-facebook',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-follow-us-link-facebook'
				],
				'href' => $this->getHref( 'social-facebook' )
			];
		}

		if ( $this->getHref( 'social-twitter' ) ) {
			$data['links'][] = [
				'type' => 'link-image',
				'image' => 'wds-icons-twitter',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-follow-us-link-twitter'
				],
				'href' => $this->getHref( 'social-twitter' )
			];
		}

		if ( $this->getHref( 'social-reddit' ) ) {
			$data['links'][] = [
				'type' => 'link-image',
				'image' => 'wds-icons-reddit',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-follow-us-link-reddit'
				],
				'href' => $this->getHref( 'social-reddit' )
			];
		}

		if ( $this->getHref( 'social-youtube' ) ) {
			$data['links'][] = [
				'type' => 'link-image',
				'image' => 'wds-icons-youtube',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-follow-us-link-youtube'
				],
				'href' => $this->getHref( 'social-youtube' )
			];
		}

		if ( $this->getHref( 'social-instagram' ) ) {
			$data['links'][] = [
				'type' => 'link-image',
				'image' => 'wds-icons-instagram',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-follow-us-link-instagram'
				],
				'href' => $this->getHref( 'social-instagram' )
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
				'href' => $this->getHref( 'community-central' )
			];
		}

		if ( $this->getHref( 'support' ) ) {
			$data['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-support'
				],
				'href' => $this->getHref( 'support' )
			];
		}

		if ( $this->getHref( 'fan-contributor' ) ) {
			$data['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-fan-contributor-program'
				],
				'href' => $this->getHref( 'fan-contributor' )
			];
		}

		if ( $this->getHref( 'wam' ) ) {
			$data['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-wam-score'
				],
				'href' => $this->getHref( 'wam' )
			];
		}

		if ( $this->getHref( 'help' ) ) {
			$data['links'][] = [
				'type' => 'link-text',
				'title' => [
					'type' => 'translatable-text',
					'key' => 'global-footer-community-link-help'
				],
				'href' => $this->getHref( 'help' )
			];
		}

		return $data;
	}

	private function getLocalSitemapUrl() {
		$default = true; // $wgEnableLocalSitemapPageExt = true; in CommonSettings
		$localSitemapAvailable = WikiFactory::getVarValueByName(
			'wgEnableLocalSitemapPageExt', $this->wikiId, false, $default
		);

		if ( $localSitemapAvailable ) {
			return $this->getHref( 'local-sitemap' );
		}

		// Fall back to fandom sitemap when the local one is unavailable
		return $this->getHref( 'local-sitemap-fandom' );
	}

	private function getLicenseUrl() {
		$licenseUrl = WikiFactory::getVarValueByName( 'wgRightsUrl', $this->wikiId ) ?: $this->wg->RightsUrl;
		$licensePage = WikiFactory::getVarValueByName( 'wgRightsPage', $this->wikiId ) ?: $this->wg->RightsPage;

		if ( $licensePage ) {
			$title = GlobalTitle::newFromText( $licensePage, NS_MAIN, $this->wikiId );
			$licenseUrl = $title->getFullURL();
		}

		return $licenseUrl;
	}

	private function getHref( $hrefKey ) {
		return DesignSystemSharedLinks::getHref( $hrefKey, $this->lang );
	}
}

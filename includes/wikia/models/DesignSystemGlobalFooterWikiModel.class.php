<?php

class DesignSystemGlobalFooterWikiModel extends DesignSystemGlobalFooterModel {

	protected $wikiId;

	public function __construct( $id, $lang = self::DEFAULT_LANG ) {
		parent::__construct( $id, $lang );

		$this->wikiId = $id;
	}

	protected function getSitenameData() {
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

	protected function getVerticalData() {
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

	protected function getLicenseData() {
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

	protected function getLicenseUrl() {
		$licenseUrl = WikiFactory::getVarValueByName( 'wgRightsUrl', $this->wikiId ) ?: $this->wg->RightsUrl;
		$licensePage = WikiFactory::getVarValueByName( 'wgRightsPage', $this->wikiId ) ?: $this->wg->RightsPage;

		if ( $licensePage ) {
			$title = GlobalTitle::newFromText( $licensePage, NS_MAIN, $this->wikiId );
			$licenseUrl = $title->getFullURL();
		}

		return $licenseUrl;
	}

	protected function getLocalSitemapUrl() {
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
}

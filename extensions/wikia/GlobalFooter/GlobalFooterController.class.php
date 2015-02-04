<?php

class GlobalFooterController extends WikiaController {

	const MEMC_KEY_GLOBAL_FOOTER_LINKS = 'mGlobalFooterLinks';
	const MESSAGE_KEY_GLOBAL_FOOTER_LINKS = 'shared-Oasis-footer-wikia-links';
	const CORPORATE_CATEGORY_ID = 4;

	public function index() {
		$this->response->setVal( 'footerLinks', $this->getGlobalFooterLinks() );
		$this->response->setVal( 'copyright', RequestContext::getMain()->getSkin()->getCopyright() );
		$this->response->setVal( 'isCorporate', WikiaPageType::isWikiaHomePage() );
		$this->response->setVal( 'verticalShort', $this->getVerticalShortName() );
		$this->response->setVal( 'verticalNameMessage', $this->verticalNameMessage() );
		$this->response->setVal( 'logoLink', $this->getLogoLink() );
	}

	public function indexVenus() {
		global $wgLang;
		$globalNavHelper = new GlobalNavigationHelper();
		$this->response->setVal( 'centralUrl', $globalNavHelper->getCentralUrlForLang( $wgLang->getCode() ) );
		$this->response->setVal( 'copyright', RequestContext::getMain()->getSkin()->getCopyright() );
		$this->response->setVal( 'footerLinks', $this->getGlobalFooterLinks() );
		$this->response->setVal( 'verticalShort', $this->getVerticalShortName() );
	}

	private function getGlobalFooterLinks() {
		global $wgCityId, $wgContLang, $wgLang, $wgMemc;

		wfProfileIn( __METHOD__ );

		$catId = WikiFactoryHub::getInstance()->getCategoryId( $wgCityId );
		$memcKey = wfMemcKey( self::MEMC_KEY_GLOBAL_FOOTER_LINKS, $wgContLang->getCode(), $wgLang->getCode(), $catId );

		$globalFooterLinks = $wgMemc->get( $memcKey );
		if ( !empty( $globalFooterLinks ) ) {
			return $globalFooterLinks;
		}

		if ( is_null( $globalFooterLinks = getMessageAsArray( self::MESSAGE_KEY_GLOBAL_FOOTER_LINKS . '-' . $catId ) ) ) {
			if ( is_null( $globalFooterLinks = getMessageAsArray( self::MESSAGE_KEY_GLOBAL_FOOTER_LINKS ) ) ) {
				wfProfileOut( __METHOD__ );

				return [];
			}
		}

		$parsedLinks = [];
		foreach ( $globalFooterLinks as $link ) {
			if ( strpos( trim( $link ), '*' ) === 0 ) {
				$parsedLink = parseItem( $link );
				if ( ( strpos( $parsedLink['text'], 'LICENSE' ) !== false ) || $parsedLink['text'] == 'GFDL' ) {
					$parsedLink['isLicense'] = true;
				} else {
					$parsedLink['isLicense'] = false;
				}
				$parsedLinks[] = $parsedLink;
			}
		}

		wfProfileOut( __METHOD__ );

		return $parsedLinks;
	}

	private function getVerticalShortName() {
		global $wgCityId;

		$wikiVertical = WikiFactoryHub::getInstance()->getWikiVertical( $wgCityId );
		if ( $wikiVertical['id'] ) {
			return $wikiVertical['short'];
		}
		return null;
	}

	private function verticalNameMessage() {
		global $wgCityId;
		$wikiFactoryHub = WikiFactoryHub::getInstance();

		return $wikiFactoryHub->getVerticalNameMessage( $wikiFactoryHub->getVerticalId( $wgCityId ) );
	}

	private function getLogoLink() {
		$verticalShortName = $this->getVerticalShortName();

		if ( WikiaPageType::isWikiaHomePage() || $verticalShortName === null ) {
			global $wgLang;
			$link = ( new GlobalNavigationHelper() )->getCentralUrlForLang( $wgLang->getCode() );
		} else {
			/* possible message keys: global-footer-vertical-tv-link, global-footer-vertical-comics-link,
			global-footer-vertical-movies-link, global-footer-vertical-music-link, global-footer-vertical-books-link,
			global-footer-vertical-games-link, global-footer-vertical-lifestyle-link */
			$link = wfMessage( 'global-footer-vertical-' . $verticalShortName . '-link' )->plain();
		}

		return $link;
	}
}

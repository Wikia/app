<?php

class GlobalFooterController extends WikiaController {

	const MEMC_KEY_GLOBAL_FOOTER_LINKS = 'mGlobalFooterLinks';
	const MESSAGE_KEY_GLOBAL_FOOTER_LINKS = 'shared-Oasis-footer-wikia-links';

	public function index() {
		global $wgLang;
		$globalNavHelper = new GlobalNavigationHelper();
		Wikia::addAssetsToOutput('oasis_global_footer_scss');
		Wikia::addAssetsToOutput('global_footer_js');
		$this->response->setVal( 'centralUrl', $globalNavHelper->getCentralUrlForLang( $wgLang->getCode() ) );
		$this->response->setVal( 'copyright', RequestContext::getMain()->getSkin()->getCopyright() );
		$this->response->setVal( 'footerLinks', $this->getGlobalFooterLinks() );
		$this->response->setVal( 'verticalShort', $this->getVerticalShortName() );
	}

	public function venusIndex() {
		global $wgLang;
		$globalNavHelper = new GlobalNavigationHelper();
		Wikia::addAssetsToOutput('venus_global_footer_scss');
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
}

<?php

use Wikia\Logger\WikiaLogger;

class GlobalFooterController extends WikiaController {

	const MEMC_KEY_GLOBAL_FOOTER_LINKS = 'mGlobalFooterLinks';
	const MEMC_KEY_GLOBAL_FOOTER_VERSION = 1;
	const MESSAGE_KEY_GLOBAL_FOOTER_LINKS = 'shared-Oasis-footer-wikia-links';
	const MEMC_EXPIRY = 3600;

	public function index() {
		Wikia::addAssetsToOutput('old_global_footer_scss');
		Wikia::addAssetsToOutput('global_footer_js');

		$this->response->setVal( 'footerLinks', $this->getGlobalFooterLinks() );
		$this->response->setVal( 'copyright', RequestContext::getMain()->getSkin()->getCopyright() );
		$this->response->setVal( 'isCorporate', WikiaPageType::isWikiaHomePage() );
		$this->response->setVal( 'verticalShort', $this->getVerticalShortName() );
		$this->response->setVal( 'verticalNameMessage', $this->verticalNameMessage() );
		$this->response->setVal( 'logoLink', $this->getLogoLink() );
	}

	public function indexUpdated() {
		Wikia::addAssetsToOutput('updated_global_footer_scss');
		Wikia::addAssetsToOutput('global_footer_js');

		$this->response->setVal( 'footerLinks', $this->getGlobalFooterLinks() );
		$this->response->setVal( 'copyright', RequestContext::getMain()->getSkin()->getCopyright() );
		$this->response->setVal( 'isCorporate', WikiaPageType::isWikiaHomePage() );
		$this->response->setVal( 'verticalShort', $this->getVerticalShortName() );
		$this->response->setVal( 'verticalNameMessage', $this->verticalNameMessage() );
		$this->response->setVal( 'logoLink', $this->getLogoLink() );
	}

	private function getGlobalFooterLinks() {
		global $wgCityId, $wgContLang, $wgLang, $wgMemc;

		wfProfileIn( __METHOD__ );

		$verticalId = WikiFactoryHub::getInstance()->getVerticalId( $wgCityId );
		$memcKey = wfSharedMemcKey(
			self::MEMC_KEY_GLOBAL_FOOTER_LINKS,
			$wgContLang->getCode(),
			$wgLang->getCode(),
			$verticalId,
			self::MEMC_KEY_GLOBAL_FOOTER_VERSION
		);

		$globalFooterLinks = $wgMemc->get( $memcKey );
		if ( !empty( $globalFooterLinks ) ) {
			return $globalFooterLinks;
		}

		if ( is_null( $globalFooterLinks = getMessageAsArray( self::MESSAGE_KEY_GLOBAL_FOOTER_LINKS . '-' . $verticalId ) ) ) {
			if ( is_null( $globalFooterLinks = getMessageAsArray( self::MESSAGE_KEY_GLOBAL_FOOTER_LINKS ) ) ) {
				wfProfileOut( __METHOD__ );
				WikiaLogger::instance()->error(
					"Global Footer's links not found in messages",
					[ 'exception' => new Exception() ]
				);
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

		$wgMemc->set( $memcKey, $parsedLinks, self::MEMC_EXPIRY );

		wfProfileOut( __METHOD__ );

		return $parsedLinks;
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
			$link = ( new WikiaLogoHelper() )->getCentralUrlForLang( $wgLang->getCode() );
		} else {
			/* possible message keys: global-footer-vertical-tv-link, global-footer-vertical-comics-link,
			global-footer-vertical-movies-link, global-footer-vertical-music-link, global-footer-vertical-books-link,
			global-footer-vertical-games-link, global-footer-vertical-lifestyle-link */
			$link = wfMessage( 'global-footer-vertical-' . $verticalShortName . '-link' )->plain();
		}

		return $link;
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

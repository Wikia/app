<?php

use Wikia\Logger\WikiaLogger;

class GlobalFooterController extends WikiaController {

	const MEMC_KEY_GLOBAL_FOOTER_LINKS = 'mGlobalFooterLinks';
	const MEMC_KEY_GLOBAL_FOOTER_VERSION = 3;
	const MESSAGE_KEY_GLOBAL_FOOTER_LINKS = 'shared-Oasis-footer-wikia-links';
	const MEMC_EXPIRY = 3600;
	const SITEMAP_GLOBAL = 'http://www.wikia.com/Sitemap';

	public function index() {
		Wikia::addAssetsToOutput( 'global_footer_scss' );
		Wikia::addAssetsToOutput( 'global_footer_js' );

		$this->response->setVal( 'footerLinks', $this->getGlobalFooterLinks() );
		$this->response->setVal( 'copyright', RequestContext::getMain()->getSkin()->getCopyright() );
		$this->response->setVal( 'isCorporate', WikiaPageType::isWikiaHomePage() );
		$this->response->setVal( 'verticalShort', $this->getVerticalShortName() );
		$this->response->setVal( 'verticalNameMessage', $this->verticalNameMessage() );
		$this->response->setVal( 'logoLink', $this->getLogoLink() );
	}

	private function getGlobalFooterLinks() {
		wfProfileIn( __METHOD__ );

		$memcKey = wfMemcKey(
			self::MEMC_KEY_GLOBAL_FOOTER_LINKS,
			$this->wg->Lang->getCode(),
			WikiaPageType::isMainPage(),
			self::MEMC_KEY_GLOBAL_FOOTER_VERSION
		);

		$globalFooterLinks = $this->wg->Memc->get( $memcKey );
		if ( !empty( $globalFooterLinks ) ) {
			wfProfileOut( __METHOD__ );
			return $globalFooterLinks;
		}

		$globalFooterLinks = getMessageAsArray( self::MESSAGE_KEY_GLOBAL_FOOTER_LINKS );

		if ( is_null( $globalFooterLinks ) ) {
			wfProfileOut( __METHOD__ );
			WikiaLogger::instance()->error(
				"Global Footer's links not found in messages",
				[ 'exception' => new Exception() ]
			);
			return [];
		}

		$parsedLinks = [];
		foreach ( $globalFooterLinks as $link ) {
			$link = trim( $link );
			if ( strpos( $link, '*' ) === 0 ) {
				$parsedLink = parseItem( $link );

				if ( strpos( $parsedLink['text'], 'SITEMAP' ) !== false ) {
					$parsedLinks = array_merge( $parsedLinks, $this->generateSitemapLinks() );
				} elseif ( ( strpos( $parsedLink['text'], 'LICENSE' ) !== false ) || $parsedLink['text'] == 'GFDL' ) {
					$parsedLinks[] = [ 'isLicense' => true ];
				} else {
					$parsedLinks[] = $parsedLink;
				}
			}
		}

		$this->wg->Memc->set( $memcKey, $parsedLinks, self::MEMC_EXPIRY );

		wfProfileOut( __METHOD__ );

		return $parsedLinks;
	}

	private function verticalNameMessage() {
		$wikiFactoryHub = WikiFactoryHub::getInstance();

		return $wikiFactoryHub->getVerticalNameMessage( $wikiFactoryHub->getVerticalId( $this->wg->CityId ) );
	}

	private function getLogoLink() {
		$verticalShortName = $this->getVerticalShortName();

		if ( WikiaPageType::isWikiaHomePage() || $verticalShortName === null ) {
			$link = ( new WikiaLogoHelper() )->getCentralUrlForLang( $this->wg->Lang->getCode() );
		} else {
			/* possible message keys: global-footer-vertical-tv-link, global-footer-vertical-comics-link,
			global-footer-vertical-movies-link, global-footer-vertical-music-link, global-footer-vertical-books-link,
			global-footer-vertical-games-link, global-footer-vertical-lifestyle-link */
			$link = wfMessage( 'global-footer-vertical-' . $verticalShortName . '-link' )->plain();
		}

		return $link;
	}

	private function getVerticalShortName() {
		$wikiVertical = WikiFactoryHub::getInstance()->getWikiVertical( $this->wg->CityId );
		if ( $wikiVertical['id'] ) {
			return $wikiVertical['short'];
		}
		return null;
	}

	private function generateSitemapLinks() {
		$sitemapLinks = [];

		$sitemapLinks[] = parseItem(
			'*' . self::SITEMAP_GLOBAL . '|' . wfMessage( 'global-footer-global-sitemap' )->escaped()
		);

		// Don't link to local sitemap on corporate sites and community.wikia.com (controlled via WikiFactory)
		if ( $this->wg->EnableLocalSitemapPageExt ) {
			$link = LocalSitemapPageHelper::getLocalSitemapArticleDBkey();
			$label = wfMessage( 'global-footer-local-sitemap' )->escaped();
			$sitemapLinks[] = parseItem( '*' . $link . '|' . $label );
		}

		return $sitemapLinks;
	}
}

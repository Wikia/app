<?php

class LanguageWikisIndexHooks {

	const WIKIS_INDEX_PAGE = '/language-wikis';

	/**
	 * Extension setup function, called on every request
	 */
	public static function onExtensionFunctions() {
		global $wgRequest, $wgCityId;
		$requestUrl = $wgRequest->getRequestURL();

		if ( !self::isEmptyDomainWithLanguageWikis() ) {
			// on active wikis the `/language-wikis` path should redirect to the main page
			if ( parse_url( $requestUrl, PHP_URL_PATH ) === self::WIKIS_INDEX_PAGE &&
				WikiFactory::isPublic( $wgCityId ) ) {

				$mainPage = Title::newMainPage();
				self::redirect( $mainPage->getFullURL() );
				exit( 0 );
			}
			return;
		}

		// allow some other extensions (like robots) to render their content instead
		if ( !Hooks::run( 'ShowLanguageWikisIndex', [ $requestUrl ] ) ) {
			return;
		}

		self::handleRequest( $requestUrl, true );
		exit( 0 );
	}

	public static function onGenerateRobotsRules() {
		// don't render rules for an empty domain root
		return !self::isEmptyDomainWithLanguageWikis();
	}

	public static function onClosedWikiPage( $requestUrl ) {
		// when the English wiki is closed, we still want to render the list of existing language wikis
		if ( count( WikiFactory::getLanguageWikis() ) > 0 && self::handleRequest( $requestUrl ) ) {
			// request was handled by the handleRequest method, terminate
			exit( 0 );
		}
		return true;	// proceed with rendering the closed wiki page
	}

	public static function onGetHTMLBeforeWikiaPage( &$beforeWikiaPageHtml ) {
		global $wgCityId;
		$path = parse_url( RequestContext::getMain()->getRequest()->getRequestURL(), PHP_URL_PATH );
		if (
			(
				self::isEmptyDomainWithLanguageWikis() ||
				( !WikiFactory::isPublic( $wgCityId ) && count( WikiFactory::getLanguageWikis() ) > 0 )
			)
			&& $path === self::WIKIS_INDEX_PAGE
		) {
			$beforeWikiaPageHtml .= Html::element(
				'header',
				[ 'class' => 'language-wikis-index-header' ],
				''
			);
		}
		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		$isClosedWikiWithLanguageWikis = self::isClosedWikiWithLanguageWikis();

		if (
			self::isEmptyDomainWithLanguageWikis() ||
			$isClosedWikiWithLanguageWikis
		) {
			$wikis = array_map( function ( $wiki ) {
				return [
					'languageName' => Language::getLanguageName( $wiki['city_lang'] ),
					'url' => wfHttpToHttps( $wiki['city_url'] ),
					'title' => $wiki['city_title']
				];
			}, WikiFactory::getLanguageWikis() );

			$additionalLinks = [
				[
					'url' => '//fandom.wikia.com',
					'title' => wfMessage( 'languagewikisindex-links-fandom' )->escaped()
				],
				[
					'url' => GlobalTitle::newFromText( 'FANDOM University', NS_MAIN, Wikia::COMMUNITY_WIKI_ID )->getFullURL(),
					'title' => wfMessage( 'languagewikisindex-links-fandom-university' )->escaped()
				],
			];

			$wikiVariables['languageWikis'] = [
				'additionalLinks' => $additionalLinks,
				'isClosed' => $isClosedWikiWithLanguageWikis,
				'wikis' => $wikis,
			];

			array_unshift( $wikiVariables['htmlTitle']['parts'], wfMessage( 'languagewikisindex' )->escaped() );
		}

		return true;
	}

	public static function onWikiaCanonicalHref( &$canonicalUrl ) {
		if ( RequestContext::getMain()->getTitle()->isSpecial( 'LanguageWikisIndex' ) ) {
			$canonicalUrl = wfExpandUrl( self::WIKIS_INDEX_PAGE );
		}

		return true;
	}

	public static function isEmptyDomainWithLanguageWikis() {
		global $wgCityId;
		// we recognize an empty domain root with orphaned language path wikis by "fake" city id set by
		// WikiFactoryLoader
		return $wgCityId == WikiFactory::LANGUAGE_WIKIS_INDEX;
	}

	public static function isClosedWikiWithLanguageWikis() {
		global $wgIncludeClosedWikiHandler;

		return $wgIncludeClosedWikiHandler && count( WikiFactory::getLanguageWikis() ) > 0;
	}

	/**
	 * Handles request on empty/closed wikis. For domain root, it redirects to the index page location. On the index
	 * page, it renders the special page with the list of language wikis.
	 *
	 * @param $requestUrl
	 * @param $redirectAll if true, all unknown urls will be redirected to index page. in that case true is returned.
	 * @return bool True when the requestUrl was recognized and correct http response was sent
	 */
	private static function handleRequest( $requestUrl, $redirectAll = false ) {
		global $wgTitle, $wgOut, $wgSuppressCommunityHeader, $wgSuppressPageHeader;

		switch ( parse_url( $requestUrl, PHP_URL_PATH ) ) {
			case '/':
				self::redirect( self::WIKIS_INDEX_PAGE );
				return true;
			case self::WIKIS_INDEX_PAGE:
				// render the Special::LanguageWikisIndex page
				$wgOut->setStatusCode( 200 );
				$wgOut->disallowUserJs();

				$wgTitle = SpecialPage::getTitleFor( 'LanguageWikisIndex' );

				$context = $wgOut->getContext();

				$context->setTitle( $wgTitle );
				$context->setSkin( Skin::newFromKey( 'oasis' ) );
				$wgSuppressCommunityHeader = true;
				$wgSuppressPageHeader = true;

				SpecialPageFactory::executePath( $wgTitle, $context );
				$wgOut->output();
				return true;
			default:
				if ( $redirectAll ) {
					self::redirect( self::WIKIS_INDEX_PAGE );
					return true;
				}
		}
		return false;
	}

	private static function redirect( $target ) {
		global $wgRequest;
		$wgRequest->response()->header( 'Location: ' . $target, true, 301 );
		header( 'X-Redirected-By: LanguageWikisIndex' );
	}
}

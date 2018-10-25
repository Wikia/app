<?php

class LanguageWikisIndexHooks {

	const WIKIS_INDEX_PAGE = '/language-wikis';

	/**
	 * Extension setup function, called on every request
	 */
	public static function onExtensionFunctions() {
		if ( !self::isEmptyDomainWithLanguageWikis() ) {
			return;
		}
		global $wgRequest;

		$requestUrl = $wgRequest->getRequestURL();

		// allow some other extensions (like robots) to render their content instead
		if ( !Hooks::run( 'ShowLanguageWikisIndex', [ $requestUrl ] ) ) {
			return;
		}

		if ( !self::handleRequest( $requestUrl ) ) {
			// for unknown urls on empty domain root, return the 404 code
			http_response_code( 404 );
		}
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

	public static function isEmptyDomainWithLanguageWikis() {
		global $wgCityId;
		// we recognize an empty domain root with orphaned language path wikis by "fake" city id set by
		// WikiFactoryLoader
		return $wgCityId == WikiFactory::LANGUAGE_WIKIS_INDEX;
	}

	/**
	 * Handle wikis index page. For domain root, it redirects to the index page location. On the index page,
	 * it renders the special page with the list of language wikis.
	 *
	 * @param $requestUrl
	 * @return bool True when the requestUrl was recognized and correct http response was sent
	 */
	private static function handleRequest( $requestUrl ) {
		global $wgTitle, $wgOut, $wgRequest, $wgSuppressCommunityHeader, $wgSuppressPageHeader;

		switch( parse_url( $requestUrl, PHP_URL_PATH) ) {
			case '/':
				// use 302, maybe at some point an English wiki gets created
				$wgRequest->response()->header( 'Location: ' . self::WIKIS_INDEX_PAGE , 302 );
				return true;
			case self::WIKIS_INDEX_PAGE:
				// render the Special::LanguageWikisIndex page
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
		}
		return false;
	}
}

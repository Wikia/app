<?php

class LanguageWikisIndexHooks {

	const WIKIS_INDEX_PAGE = '/language-wikis';

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
		if ( count( WikiFactory::getLanguageWikis() ) > 0 && self::handleRequest( $requestUrl ) ) {
			// request was handled, terminate
			exit( 0 );
		}
		return true;
	}

	private static function isEmptyDomainWithLanguageWikis() {
		global $wgCityId;
		return $wgCityId == WikiFactory::LANGUAGE_WIKIS_INDEX;
	}

	private static function handleRequest( $requestUrl ) {
		global $wgTitle, $wgOut, $wgRequest, $wgSuppressCommunityHeader, $wgSuppressPageHeader;

		switch( parse_url( $requestUrl, PHP_URL_PATH) ) {
			case '/':
				// use 302, maybe at some point an English wiki gets created
				$wgRequest->response()->header( 'Location: ' . self::WIKIS_INDEX_PAGE , 302 );
				return true;
			case self::WIKIS_INDEX_PAGE:
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

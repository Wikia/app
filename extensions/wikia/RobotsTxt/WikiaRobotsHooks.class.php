<?php

class WikiaRobotsHooks {
	public static function onShowLanguageWikisIndex( $requestUrl ) {

		if ( self::isRobotsRequestUrl( $requestUrl ) ) {
			// don't show the index page, as we want to render the robots.txt file instead
			return false;
		}
		return true;
	}

	public static function onClosedWikiPage( $requestUrl ) {
		if ( count( WikiFactory::getLanguageWikis() ) > 0 && self::isRobotsRequestUrl( $requestUrl ) ) {
			// skip rendering the close wiki page, we will render robots.txt instead
			return false;
		}
		return true;
	}

	private static function isRobotsRequestUrl( $requestUrl ) {
		return parse_url( $requestUrl, PHP_URL_PATH ) == '/robots.txt';
	}
}

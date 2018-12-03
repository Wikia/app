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
		$url = parse_url( $requestUrl );
		if ( isset( $url[ 'path' ] ) ) {
			if ( $url[ 'path' ] == '/robots.txt' ) {
				return true;
			}
			if ( $url[ 'path' ] == '/wikia.php' && isset( $url[ 'query' ] ) ) {
				$params = [];
				parse_str( $url['query'], $params );
				if ( isset( $params['controller'] ) && $params['controller'] == 'WikiaRobots' ) {
					return true;
				}
			}
		}
		return false;
	}
}

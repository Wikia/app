<?php

use \Wikia\Logger\WikiaLogger;

/**
 * Class MonetizationModuleHelper
 */
class MonetizationModuleHelper extends WikiaModel {

	const SLOT_TYPE_ABOVE_TITLE = 'above_title';
	const SLOT_TYPE_BELOW_TITLE = 'below_title';
	const SLOT_TYPE_IN_CONTENT = 'in_content';
	const SLOT_TYPE_BELOW_CATEGORY = 'below_category';
	const SLOT_TYPE_ABOVE_FOOTER = 'above_footer';
	const SLOT_TYPE_FOOTER = 'footer';

	const CACHE_TTL = 3600;
	// TODO: encapsulate in Monetization Client
	// do not change unless monetization service changes
	const MONETIZATION_SERVICE_CACHE_PREFIX = 'monetization';
	const RENDERING_IN_PROCESS = 1;

	const API_VERSION = 'v1';
	const API_TIMEOUT = 50;				// timeout in milliseconds
	const IN_CONTENT_KEYWORD = '<h2>';

	/**
	 * Show the Module only on File pages, Article pages, and Main pages
	 * @return boolean
	 */
	public static function canShowModule() {
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$status = false;
		$showableNameSpaces = array_merge( $app->wg->ContentNamespaces, [ NS_FILE ] );
		if ( $app->wg->Title->exists()
			&& !$app->wg->Title->isMainPage()
			&& in_array( $app->wg->Title->getNamespace(), $showableNameSpaces )
			&& in_array( $app->wg->request->getVal( 'action' ), [ 'view', null ] )
			&& $app->wg->request->getVal( 'diff' ) === null
			&& $app->wg->User->isAnon()
			&& $app->checkSkin( 'oasis' )
		) {
			$status = true;
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * Get monetization units
	 * @param array $params
	 * @return array|false $result
	 */
	public static function getMonetizationUnits( $params ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$log = WikiaLogger::instance();

		// this cache key must match the one set by the MonetizationService
		// and should not use the wgCachePrefix(), wfSharedMemcKey() or
		// wfMemcKey() methods
		$cacheKey = self::createCacheKey( $params );
		$log->debug( "Monetization: " . __METHOD__ . " - lookup with cache key: $cacheKey" );

		$json_results = $app->wg->Memc->get( $cacheKey );
		if ( $json_results == RENDERING_IN_PROCESS ) {
			// TODO: potentially block until rendering finishes, until then return nothing
			wfProfileOut( __METHOD__ );
			return false;
		} else if ( !empty( $json_results ) ) {
			wfProfileOut( __METHOD__ );
			return json_decode( $json_results, true );
		}

		if ( !endsWith( $app->wg->MonetizationServiceUrl, '/' ) ) {
			$url = $app->wg->MonetizationServiceUrl . '/';
		}

		$url .= 'api/' . self::API_VERSION . '?' . http_build_query( $params );
		$options = [
			'noProxy' => true,
			'curlOptions' => [
				CURLOPT_TIMEOUT_MS => self::API_TIMEOUT,
				CURLOPT_NOSIGNAL => true,
			],
		];
		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$result = json_decode( $req->getContent(), true );
		} else {
			$result = false;
			$loggingParams = array_merge( [ 'method' => __METHOD__ ], $params );
			$log->debug( "Monetization: ".__METHOD__." - cannot get monetization units (".$status->getMessage().").", $loggingParams );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Creates the cache key for the given parameters.
	 *
	 * @param array $params
	 * @return string
	 */
	public static function createCacheKey( array $params ) {
		$cacheKey = self::MONETIZATION_SERVICE_CACHE_PREFIX;

		if ( !empty( $params['s_id'] ) ) {
			$cacheKey .= ':' . $params['s_id'];
		}

		if ( !empty( $params['geo'] ) ) {
			$cacheKey .= ':' . $params['geo'];
		} else {
			// set the default to be rest of world ('ROW')
			$cacheKey .= ':ROW';
		}

		return $cacheKey;
	}

	/**
	 * Very rudimentary way to determine the number of ads to display.
	 * If the page length (text chars count only) is greater than 5K
	 * then it is considered a "long" article, in between 1.5-5K it is
	 * considered "medium" and anything less than 1.5K is considered
	 * "short"
	 *
	 * @param $pageLength
	 * @return int
	 */
	public static function calculateNumberOfAds( $pageLength ) {
		if ( $pageLength > 5000 ) {
			// long length article
			return 3;
		} else if ( $pageLength > 1500 ) {
			// medium length article
			return 2;
		}
		// short articles
		return 1;
	}

	/**
	 * Insert in-content ad unit
	 * @param string $body
	 * @param array $monetizationUnits
	 * @return string
	 */
	public static function insertIncontentUnit( $body, $monetizationUnits ) {
		wfProfileIn( __METHOD__ );

		if ( !empty( $monetizationUnits[self::SLOT_TYPE_IN_CONTENT] ) ) {
			$pos1 = strpos( $body, self::IN_CONTENT_KEYWORD );
			if ( $pos1 === false ) {
				$body .= $monetizationUnits[self::SLOT_TYPE_IN_CONTENT];
			} else {
				$pos2 = strpos( $body, self::IN_CONTENT_KEYWORD, $pos1 + strlen( self::IN_CONTENT_KEYWORD ) );
				if ( $pos2 === false ) {
					$body .= $monetizationUnits[self::SLOT_TYPE_IN_CONTENT];
				} else {
					$body = substr_replace( $body, $monetizationUnits[self::SLOT_TYPE_IN_CONTENT], $pos2, 0 );
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $body;
	}

}

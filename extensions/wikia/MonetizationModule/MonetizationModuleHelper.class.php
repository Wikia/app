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
	 * @global string $wgMonetizationServiceUrl
	 * @param array $params
	 * @return array|false $result
	 */
	public static function getMonetizationUnits( $params ) {
		wfProfileIn( __METHOD__ );
		$log = WikiaLogger::instance();

		global $wgMonetizationServiceUrl, $wgMemc;

		// this cache key must match the one set by the MonetizationService
		// and should not use the wgCachePrefix(), wfSharedMemcKey() or
		// wfMemcKey() methods
		$cacheKey = self::createCacheKey( $params );
		$log->debug( "Monetization: " . __METHOD__ . " - lookup with cache key: $cacheKey" );
		$json_results = $wgMemc->get( $cacheKey );

		if ( $json_results == RENDERING_IN_PROCESS ) {
			// TODO: potentially block until rendering finishes, until then return nothing
			return false;
		} else if ( !empty( $json_results ) ) {
			return json_decode( $json_results, true );
		}

		$apiVersion = 'v1';

		if ( !endsWith( $wgMonetizationServiceUrl, '/' ) ) {
			$url = $wgMonetizationServiceUrl . '/';
		}

		$url .= 'api/' . $apiVersion . '?' . http_build_query( $params );
		$req = MWHttpRequest::factory( $url, [ 'noProxy' => true ] );
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
}

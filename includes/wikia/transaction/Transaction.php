<?php

/**
 * Class Transaction defines various constants and gives access to TransactionTrace singleton object
 */
class Transaction {
	const APP_NAME = 'mediawiki';

	// Transaction names
	const ENTRY_POINT_PAGE = 'page';
	const ENTRY_POINT_SPECIAL_PAGE = 'special_page';
	const ENTRY_POINT_RESOURCE_LOADER = 'assets/resource_loader';
	const ENTRY_POINT_ASSETS_MANAGER = 'assets/assets_manager';
	const ENTRY_POINT_NIRVANA = 'api/nirvana';
	const ENTRY_POINT_AJAX = 'api/ajax';
	const ENTRY_POINT_API = 'api/api';
	const ENTRY_POINT_API_V1 = 'api/v1';
	const ENTRY_POINT_MAINTENANCE = 'maintenance';

	// Parameters
	const PARAM_ENVIRONMENT = 'env';
	const PARAM_HOSTNAME = 'hostname';
	const PARAM_PHP_VERSION = 'php_version';
	const PARAM_MEMCACHED_PROTOCOL = 'memcached_protocol';
	const PARAM_ENTRY_POINT = 'entry_point';
	const PARAM_LOGGED_IN = 'logged_in';
	const PARAM_PARSER_CACHE_USED = 'parser_cache_used';
	const PARAM_PARSER_CACHE_DISABLED = 'parser_cache_disabled';
	const PARAM_SIZE_CATEGORY = 'size_category';
	const PARAM_NAMESPACE = 'namespace';
	const PARAM_ACTION = 'action';
	const PARAM_SKIN = 'skin';
	const PARAM_VERSION = 'version';
	const PARAM_VIEW_TYPE = 'view_type'; // For Category only
	const PARAM_CONTROLLER = 'controller';
	const PARAM_METHOD = 'method';
	const PARAM_FUNCTION = 'function';
	const PARAM_SPECIAL_PAGE_NAME = 'special_page';
	const PARAM_API_ACTION = 'api_action';
	const PARAM_API_LIST = 'api_list';
	const PARAM_WIKI = 'wiki';
	const PARAM_DPL = 'dpl';
	const PARAM_AB_PERFORMANCE_TEST = 'perf_test';
	const PARAM_MAINTENANCE_SCRIPT = 'maintenance_script';

	const PSEUDO_PARAM_TYPE = 'type';

	// Definition of different size categories
	const SIZE_CATEGORY_SIMPLE = 'simple';
	const SIZE_CATEGORY_AVERAGE = 'average';
	const SIZE_CATEGORY_COMPLEX = 'complex';

	// Definition of different events
	const EVENT_ARTICLE_PARSE = 'article_parse';
	const EVENT_MEMCACHE_STATS_COUNTERS = 'memcache_stats_counters';
	const EVENT_MEMCACHE_STATS_KEYS = 'memcache_stats_keys';
	const EVENT_USER_PREFERENCES = 'user_preferences';
	const EVENT_USER_PREFERENCES_COUNTERS = "user_preferences_counters";
	const EVENT_USER_ATTRIBUTES = 'user_attributes';
	const EVENT_USER_AUTH = 'user_auth';

	/**
	 * Returns TransactionTrace singleton instance
	 *
	 * @return TransactionTrace
	 */
	public static function getInstance() {
		static $instance;
		if ( $instance === null ) {
			global $wgWikiaEnvironment, $wgMemcachedMoxiProtocol;
			$instance = new TransactionTrace( array(
				// plugins
				new TransactionTraceNewrelic(),
				new TransactionTraceScribe(),
			) );
			$instance->set( self::PARAM_ENVIRONMENT, $wgWikiaEnvironment );
			$instance->set( self::PARAM_HOSTNAME, wfHostname() );
			$instance->set( self::PARAM_PHP_VERSION, explode( '-', phpversion() )[0] ); // report "5.4.17-1~precise+1" as "5.4.17"
			$instance->set( self::PARAM_MEMCACHED_PROTOCOL, $wgMemcachedMoxiProtocol );
		}
		return $instance;
	}

	/**
	 * Sets an entry point attribute
	 *
	 * @param string $entryPoint Entry point - should be one of Transaction::ENTRY_POINT_xxxxx
	 */
	public static function setEntryPoint( $entryPoint ) {
		self::getInstance()->set( self::PARAM_ENTRY_POINT, $entryPoint );
	}

	/**
	 * Sets a named attribute to be recorded in transaction trace
	 *
	 * @param string $key Name of the parameter - should be one of Transaction::PARAM_xxxxx
	 * @param string $value Value of the parameter
	 */
	public static function setAttribute( $key, $value ) {
		self::getInstance()->set( $key, $value );
	}

	/**
	 * Shorthand for setting "size category" attribute based on thresholds
	 *
	 * @param int $observationCounter Current value
	 * @param int $lowerBound Maximum value that classifies as "simple"
	 * @param int $middleBound Maximum value that classifies as "average"
	 */
	public static function setSizeCategoryByDistributionOffset( $observationCounter, $lowerBound, $middleBound ) {
		if ( $observationCounter <= $lowerBound ) {
			self::setAttribute( self::PARAM_SIZE_CATEGORY, self::SIZE_CATEGORY_SIMPLE );
		} elseif ( $observationCounter <= $middleBound ) {
			self::setAttribute( self::PARAM_SIZE_CATEGORY, self::SIZE_CATEGORY_AVERAGE );
		} else {
			self::setAttribute( self::PARAM_SIZE_CATEGORY, self::SIZE_CATEGORY_COMPLEX );
		}
	}


	/**
	 * Records an event
	 *
	 * @param string $event Event name
	 * @param array $data Event data
	 */
	public static function addEvent( $event, Array $data ) {
		self::getInstance()->addEvent( $event, $data );
	}

	/**
	 * Records a raw event
	 *
	 * @param string $event Event name
	 * @param array $data Event data
	 */
	public static function addRawEvent( $event, Array $data ) {
		self::getInstance()->addRawEvent( $event, $data );
	}

	/**
	 * Returns the automatically generated transaction type name
	 *
	 * @return string
	 */
	public static function getType() {
		return self::getInstance()->getType();
	}

	/**
	 * Returns all attributes of the current transaction
	 *
	 * @return array
	 */
	public static function getAttributes() {
		return self::getInstance()->getAttributes();
	}

	/**
	 * Return required attribute
	 *
	 * @param $name string attribute name
	 * @return mixed|null attribute value or null when not set
	 */
	public static function getAttribute($name) {
		$attributes = self::getAttributes();
		return isset( $attributes[$name] ) ? $attributes[$name] : null;
	}

	/**
	 * Returns all events recorded during current transaction
	 *
	 * @return array
	 */
	public static function getEvents() {
		return self::getInstance()->getEvents();
	}

	/**
	 * Returns all raw events recorded during current transaction
	 *
	 * @return array
	 */
	public static function getRawEvents() {
		return self::getInstance()->getRawEvents();
	}

	/**
	 * Hook handler. Sets a "size category" attribute based on the article that is displayed
	 *
	 * @param Article $article
	 * @param ParserOutput $parserOutput
	 * @return bool true (hook handler)
	 */
	public static function onArticleViewAddParserOutput( Article $article, ParserOutput $parserOutput ) {
		$wikitextSize = $parserOutput->getPerformanceStats( 'wikitextSize' );
		$htmlSize = $parserOutput->getPerformanceStats( 'htmlSize' );
		$expFuncCount = $parserOutput->getPerformanceStats( 'expFuncCount' );
		$nodeCount = $parserOutput->getPerformanceStats( 'nodeCount' );

		if ( !is_numeric( $wikitextSize ) || !is_numeric( $htmlSize ) || !is_numeric( $expFuncCount ) || !is_numeric( $nodeCount ) ) {
			return true;
		}

		if ( $wikitextSize < 3000 && $htmlSize < 5000 && $expFuncCount == 0 && $nodeCount < 100 ) {
			$sizeCategory = self::SIZE_CATEGORY_SIMPLE;
		} elseif ( $wikitextSize < 30000 && $htmlSize < 50000 && $expFuncCount <= 4 && $nodeCount < 3000 ) {
			$sizeCategory = self::SIZE_CATEGORY_AVERAGE;
		} else {
			$sizeCategory = self::SIZE_CATEGORY_COMPLEX;
		}

		Transaction::setAttribute( Transaction::PARAM_SIZE_CATEGORY, $sizeCategory );

		return true;
	}

	/**
	 * Given the list of respons headers detect whether the response can be cached on CDN
	 *
	 * We assume that the response is cacheable if s-maxage entry in Cache-Control header
	 * is greater than 5 seconds - refer to WikiaResponse::setCacheValidity
	 *
	 * Examples:
	 *
	 * - Cache-Control: s-maxage=86400, must-revalidate, max-age=0 (an article, cacheable)
	 * - Cache-Control: public, max-age=2592000 (AssetsManager, cacheable)
	 * - Cache-Control: private, must-revalidate, max-age=0 (special page, not cacheable)
	 *
	 * @param array $headers key - value list of HTTP response headers
	 * @return bool|null will return null for maintenance / CLI scripts
	 */
	public static function isCacheable( $headers ) {
		if ( empty( $headers['Cache-Control'] ) ) {
			return null;
		}

		$cacheControl = $headers['Cache-Control'];
		$sMaxAge = 0;

		// has "private" entry?
		if ( strpos( $cacheControl, 'private' ) !== false ) {
			$sMaxAge = 0;
		}
		// has "s-maxage" entry?
		else if ( preg_match( '#s-maxage=(\d+)#', $cacheControl, $matches ) ) {
			$sMaxAge = intval( $matches[1] );
		}
		// has "max-age" entry?
		else if ( preg_match( '#max-age=(\d+)#', $cacheControl, $matches ) ) {
			$sMaxAge = intval( $matches[1] );
		}

		// TODO: report $sMaxAge value?
		return $sMaxAge > 5;
	}

	/**
	 * Analyze the response header and set "cacheablity" flag
	 *
	 * @return bool true (hook handler
	 */
	public static function onRestInPeace() {
		if ( function_exists( 'apache_response_headers' ) ) {
			$isCacheable = self::isCacheable( apache_response_headers() );

			if ( is_bool( $isCacheable ) ) {
				self::setAttribute( 'cacheable', $isCacheable );
			}
		}
		return true;
	}
}

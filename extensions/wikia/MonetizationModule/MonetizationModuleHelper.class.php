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

	const CACHE_TTL_MIN = 3600;
	const CACHE_TTL_MAX = 7200;

	const VAR_NAME_CACHE_VERSION = 'wgMonetizationModuleCacheVersion';
	const VAR_NAME_API_TIMEOUT = 'wgMonetizationModuleTimeout';

	const API_VERSION = 'v1';
	const API_DISPLAY = 'display/api/';
	const IN_CONTENT_KEYWORD = '<h2>';
	const TOC_KEYWORD = 'id="toc"';

	const FONT_COLOR_DARK_THEME = '#d5d4d4';
	const FONT_COLOR_LIGHT_THEME = '#3a3a3a';

	const KEYWORD_PREFIX = '$set'; 	// used for checking if mapping is needed
	const KEYWORD_THEME_SETTINGS = '$setTheme';
	const KEYWORD_AD_TITLE = '$setAdTitle';
	const KEYWORD_ECOMMERCE_TITLE = '$setEcommTitle';

	const PAGE_SPECIFIC = 'page_specific';

	protected static $mapThemeSettings = [
		'data-color-bg'     => 'color-page',
		'data-color-border' => 'color-page',
		'data-color-link'   => 'color-links',
		'data-color-url'    => 'color-links',
		'data-color-text'   => 'color',
	];

	// list of verticals
	protected static $verticals = [
		WikiFactoryHub::VERTICAL_ID_OTHER       => 'other',
		WikiFactoryHub::VERTICAL_ID_TV          => 'tv',
		WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES => 'gaming',
		WikiFactoryHub::VERTICAL_ID_BOOKS       => 'book',
		WikiFactoryHub::VERTICAL_ID_COMICS      => 'comics',
		WikiFactoryHub::VERTICAL_ID_LIFESTYLE   => 'lifestyle',
		WikiFactoryHub::VERTICAL_ID_MUSIC       => 'music',
		WikiFactoryHub::VERTICAL_ID_MOVIES      => 'movies',
	];

	/**
	 * Show the Module only on File pages, Article pages, and Main pages
	 * @return boolean
	 */
	public function canShowModule() {
		wfProfileIn( __METHOD__ );

		$status = false;
		$showableNameSpaces = array_merge( $this->wg->ContentNamespaces, [ NS_FILE ] );
		if ( !WikiaPageType::isCorporatePage()
			&& $this->wg->Title->exists()
			&& !$this->wg->Title->isMainPage()
			&& in_array( $this->wg->Title->getNamespace(), $showableNameSpaces )
			&& in_array( $this->wg->request->getVal( 'action' ), [ 'view', null ] )
			&& $this->wg->request->getVal( 'diff' ) === null
			&& $this->wg->User->isAnon()
			&& $this->app->checkSkin( 'oasis' )
		) {
			$status = true;
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * Get wiki vertical
	 * @return string - wiki vertical
	 */
	public function getWikiVertical() {
		wfProfileIn( __METHOD__ );

		$verticalId = WikiFactoryHub::getInstance()->getVerticalId( $this->wg->CityId );
		if ( empty( self::$verticals[$verticalId] ) ) {
			$verticalId = WikiFactoryHub::VERTICAL_ID_OTHER;
		}

		$name = self::$verticals[$verticalId];

		wfProfileOut( __METHOD__ );

		return $name;
	}

	/**
	 * Get monetization units
	 * @param array $params
	 * @return array|false $result
	 */
	public function getMonetizationUnits( $params ) {
		wfProfileIn( __METHOD__ );

		$log = WikiaLogger::instance();
		$loggingParams = [ 'method' => __METHOD__, 'params' => $params ];

		// get data from cache for non page specific module only
		if ( !$this->isPageSpecificRequest( $params ) ) {
			$cacheKey = $this->getMemcKey( $params );
			$log->debug( "MonetizationModule: lookup with cache key: $cacheKey", $loggingParams );

			$json_results = $this->wg->Memc->get( $cacheKey );
			if ( !empty( $json_results ) ) {
				$log->info( "MonetizationModule: memcache hit.", $loggingParams );
				wfProfileOut( __METHOD__ );
				return $this->processData( $json_results, $params, false );
			}

			$log->info( "MonetizationModule: memcache miss.", $loggingParams );
		}

		$url = $this->wg->MonetizationServiceUrl;
		if ( !endsWith( $url, '/' ) ) {
			$url .= '/';
		}
		$url .= self::API_DISPLAY . self::API_VERSION . '?' . http_build_query( $params );

		$options = [ 'noProxy' => true ];
		$timeout = WikiFactory::getVarValueByName( self::VAR_NAME_API_TIMEOUT, WikiFactory::COMMUNITY_CENTRAL );
		if ( !empty( $timeout ) ) {
			$options['curlOptions'] = [
				CURLOPT_TIMEOUT_MS => $timeout,
				CURLOPT_NOSIGNAL => true,
			];
		}

		$method = 'GET';
		$result = Http::request( $method, $url, $options );
		if ( $result === false ) {
			$loggingParams['request'] = [
				'url' => $url,
				'method' => $method,
				'options' => $options,
			];
			$log->debug( "MonetizationModule: cannot get monetization units.", $loggingParams );
		} else if ( !empty( $result ) ) {
			$result = $this->processData( $result, $params );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Process data for the ad units (include logic to handle the data)
	 * @param string $data - data from API (json format)
	 * @param array $params - API parameters
	 * @param boolean $setMemc - set to true to set to memcache
	 * @return mixed
	 */
	public function processData( $data, $params, $setMemc = true ) {
		$found = strpos( $data, self::KEYWORD_PREFIX );
		$data = json_decode( $data, true );
		if ( !is_array( $data ) ) {
			return $data;
		}

		$memcKey = $this->getMemcKey( $params );

		// for page specific module
		if ( $this->isPageSpecificResponse( $data ) ) {
			if ( $setMemc ) {
				$this->setMemcache( $memcKey, $data, ['method' => __METHOD__] );
			}

			$params['page_id'] = $this->wg->Title->getArticleID();
			return $this->getMonetizationUnits( $params );
		}

		// check for placeholder
		if ( $found === false ) {
			return $data;
		}

		// set to cache for non page specific
		$setMemc = ( !$this->isPageSpecificRequest( $params ) );
		$data = $this->setThemeSettings( $data, $memcKey, $setMemc );

		return $data;
	}

	/**
	 * Set wiki theme setting to the ad units
	 * @param array $adUnits
	 * @param string $memcKey
	 * @param boolean $setMemc - set to true to set data to memcache
	 * @return array
	 */
	public function setThemeSettings( $adUnits, $memcKey, $setMemc = true ) {
		wfProfileIn( __METHOD__ );

		$adTitle = $this->wf->Message( 'monetization-module-ad-title' )->escaped();
		$adUnits = str_replace( self::KEYWORD_AD_TITLE, $adTitle, $adUnits );

		$ecommTitle = $this->wf->Message( 'monetization-module-ecommerce-title' )->escaped();
		$adUnits = str_replace( self::KEYWORD_ECOMMERCE_TITLE, $ecommTitle, $adUnits );

		$theme = SassUtil::getOasisSettings();
		if ( SassUtil::isThemeDark() ) {
			$theme['color'] = self::FONT_COLOR_DARK_THEME;
		} else {
			$theme['color'] = self::FONT_COLOR_LIGHT_THEME;
		}

		$adSettings = '';
		foreach ( self::$mapThemeSettings as $key => $value ) {
			if ( !empty( $theme[$value] ) ) {
				$adSettings .= $key.'="'.$theme[$value].'" ';
			}
		}

		$adUnits = str_replace( self::KEYWORD_THEME_SETTINGS, $adSettings, $adUnits );

		// set data to cache
		if ( $setMemc ) {
			$this->setMemcache( $memcKey, $adUnits, [ 'method' => __METHOD__ ] );
		}

		wfProfileOut( __METHOD__ );

		return $adUnits;
	}

	/**
	 * Set memcache data (json format)
	 * @param string $memcKey
	 * @param array $data
	 * @param array $loggingParams
	 */
	public function setMemcache( $memcKey, $data, $loggingParams ) {
		$cacheTtl = mt_rand( self::CACHE_TTL_MIN, self::CACHE_TTL_MAX );
		$this->wg->Memc->set( $memcKey, json_encode( $data ), $cacheTtl );

		$loggingParams['memcKey'] = $memcKey;
		$loggingParams['cacheTtl'] = $cacheTtl;
		WikiaLogger::instance()->info( "MonetizationModule: memcache write.", $loggingParams );
	}

	/**
	 * Get memcache key
	 * @param array $params
	 * @return string
	 */
	public function getMemcKey( $params ) {
		$geo = empty( $params['geo'] ) ? 'ALL' : $params['geo'];
		$memcKey = wfMemcKey( 'monetization_module', $params['cache'], $geo, $params['max'] );
		return $memcKey;
	}

	/**
	 * Get cache version
	 * @return string
	 */
	public function getCacheVersion() {
		$defaultVersion = '';
		$version = WikiFactory::getVarValueByName(
			self::VAR_NAME_CACHE_VERSION,
			WikiFactory::COMMUNITY_CENTRAL,
			false,
			$defaultVersion
		);
		return $version;
	}

	/**
	 * Check for page specific request
	 * @param array $params
	 * @return bool
	 */
	public function isPageSpecificRequest( $params ) {
		return array_key_exists( 'page_id', $params );
	}

	/**
	 * Check for page specific response
	 * @param array $data
	 * @return bool
	 */
	public function isPageSpecificResponse( $data ) {
		 return ( !empty( $data['special_instructions'] ) && in_array( self::PAGE_SPECIFIC, $data['special_instructions'] ) );
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
	public function calculateNumberOfAds( $pageLength ) {
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
	public static function insertIncontentUnit( $body, &$monetizationUnits ) {
		wfProfileIn( __METHOD__ );

		// Check for in_content ad
		if ( empty( $monetizationUnits[self::SLOT_TYPE_IN_CONTENT] ) ) {
			wfProfileOut( __METHOD__ );
			return $body;
		}

		$keywordLength = strlen( self::IN_CONTENT_KEYWORD );
		$pos1 = strpos( $body, self::IN_CONTENT_KEYWORD );
		$pos2 = ( $pos1 === false ) ? false : strpos( $body, self::IN_CONTENT_KEYWORD, $pos1 + $keywordLength );

		// Check for the 2nd <H2> tag
		if ( $pos2 !== false ) {
			// The 2nd <H2> tag exists. Check for TOC.
			$posTOC = strpos( $body, self::TOC_KEYWORD );
			if ( $posTOC === false ) {
				// TOC not exist. Insert the ad above the 2nd <H2> tag.
				$body = substr_replace( $body, $monetizationUnits[self::SLOT_TYPE_IN_CONTENT], $pos2, 0 );
				wfProfileOut( __METHOD__ );
				return $body;
			} else {
				// TOC exists. Check for the 3rd <H2> tag.
				$pos3 = strpos( $body, self::IN_CONTENT_KEYWORD, $pos2 + $keywordLength );
				if ( $pos3 !== false ) {
					// The 3rd <H2> tag exists. Insert the ad above the 3rd <H2> tag.
					$body = substr_replace( $body, $monetizationUnits[self::SLOT_TYPE_IN_CONTENT], $pos3, 0 );
					wfProfileOut( __METHOD__ );
					return $body;
				}
			}
		}

		// Otherwise, append the ad at the end of content
		$body .= $monetizationUnits[self::SLOT_TYPE_IN_CONTENT];

		// Hide the below_category ad if append in_content ad.
		if ( array_key_exists( self::SLOT_TYPE_BELOW_CATEGORY, $monetizationUnits ) ) {
			$loggingParams = [
				'method' => __METHOD__,
				'adUnits' => $monetizationUnits,
				'removedSlot' => self::SLOT_TYPE_BELOW_CATEGORY,
			];
			unset( $monetizationUnits[self::SLOT_TYPE_BELOW_CATEGORY] );
			WikiaLogger::instance()->info( "MonetizationModule: remove below_category ad", $loggingParams );
		}

		wfProfileOut( __METHOD__ );

		return $body;
	}

}

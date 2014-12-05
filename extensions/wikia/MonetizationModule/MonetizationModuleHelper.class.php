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

	protected static $mapThemeSettings = [
		'data-color-bg'     => 'color-page',
		'data-color-border' => 'color-page',
		'data-color-link'   => 'color-links',
		'data-color-url'    => 'color-links',
		'data-color-text'   => 'color',
	];

	// list of verticals
	protected static $verticals = [
		WikiFactoryHub::HUB_ID_OTHER       => 'other',
		WikiFactoryHub::HUB_ID_TV          => 'tv',
		WikiFactoryHub::HUB_ID_VIDEO_GAMES => 'gaming',
		WikiFactoryHub::HUB_ID_BOOKS       => 'book',
		WikiFactoryHub::HUB_ID_COMICS      => 'comics',
		WikiFactoryHub::HUB_ID_LIFESTYLE   => 'lifestyle',
		WikiFactoryHub::HUB_ID_MUSIC       => 'music',
		WikiFactoryHub::HUB_ID_MOVIES      => 'movies',
	];

	/**
	 * Show the Module only on File pages, Article pages, and Main pages
	 * @return boolean
	 */
	public static function canShowModule() {
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$status = false;
		$showableNameSpaces = array_merge( $app->wg->ContentNamespaces, [ NS_FILE ] );
		if ( !WikiaPageType::isCorporatePage()
			&& $app->wg->Title->exists()
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
	 * Get wiki vertical
	 * @return string - wiki vertical
	 */
	public function getWikiVertical() {
		wfProfileIn( __METHOD__ );

		$verticalId = WikiFactoryHub::getInstance()->getVerticalId( $this->wg->CityId );
		if ( empty( self::$verticals[$verticalId] ) ) {
			$verticalId = WikiFactoryHub::HUB_ID_OTHER;
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

		$cacheKey = $this->getMemcKey( $params );
		$log->debug( "MonetizationModule: lookup with cache key: $cacheKey", $loggingParams );

		$json_results = $this->wg->Memc->get( $cacheKey );
		if ( !empty( $json_results ) ) {
			$log->info( "MonetizationModule: memcache hit.", $loggingParams );
			wfProfileOut( __METHOD__ );
			return $this->setThemeSettings( $json_results, $cacheKey );
		}

		$log->info( "MonetizationModule: memcache miss.", $loggingParams );

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
			$result = $this->setThemeSettings( $result, $cacheKey );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Set wiki theme setting to the ad units
	 * @param array $adUnits
	 * @param string $memcKey
	 * @return array
	 */
	public function setThemeSettings( $adUnits, $memcKey ) {
		wfProfileIn( __METHOD__ );

		$found = strpos( $adUnits, self::KEYWORD_PREFIX );
		$adUnits = json_decode( $adUnits, true );
		if ( $found !== false && is_array( $adUnits ) ) {
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
			foreach( self::$mapThemeSettings as $key => $value ) {
				if ( !empty( $theme[$value] ) ) {
					$adSettings .= $key.'="'.$theme[$value].'" ';
				}
			}

			$adUnits = str_replace( self::KEYWORD_THEME_SETTINGS, $adSettings, $adUnits );

			// set cache
			$cacheTtl = mt_rand( self::CACHE_TTL_MIN, self::CACHE_TTL_MAX );
			$this->wg->Memc->set( $memcKey, json_encode( $adUnits ), $cacheTtl );

			$loggingParams = [ 'method' => __METHOD__, 'memcKey' => $memcKey, 'cacheTtl' => $cacheTtl ];
			WikiaLogger::instance()->info( "MonetizationModule: memcache write.", $loggingParams );
		}

		wfProfileOut( __METHOD__ );

		return $adUnits;
	}

	/**
	 * Get memcache key
	 * @param array $params
	 * @return string
	 */
	public function getMemcKey( $params ) {
		$geo = empty( $params['geo'] ) ? 'ROW' : $params['geo'];
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

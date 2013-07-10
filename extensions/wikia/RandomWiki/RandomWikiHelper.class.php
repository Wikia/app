<?php

class RandomWikiHelper {
	const CACHE_KEY_TOKEN = 'wikicities:RandomWiki:list';
	const WF_VAR_NAME = 'wgRandomWikiRecommend';
	const COUNT_LIMIT = 200;
	const TRACK_LIMIT = 20;
	const CACHE_EXPIRY = 48; // hours

	static private $pageviewsLimits = array(
		'en' => 15000,
		'default' => 1000
	);

	static private $mData = null;
	static private $mLanguage = null;

	static public function getData( $forceRefresh = false, $forceLanguage = null ) {
		if ( empty( self::$mData ) || $forceRefresh || ( !empty( $forceLanguage ) && self::$mLanguage != $forceLanguage ) ) {
			self::loadData( $forceRefresh, $forceLanguage );
		}

		return self::$mData;
	}

	static public function loadData( $forceRefresh = false, $forceLanguage = null ) {
		global $wgMemc, $wgStatsDB, $wgContLang, $wgExternalSharedDB, $wgStatsDBEnabled;
		wfProfileIn( __METHOD__ );

		self::$mLanguage = ( !empty( $forceLanguage ) ) ? $forceLanguage : $wgContLang->getCode();
		$cacheKey = self::CACHE_KEY_TOKEN . ':' . strtoupper( self::$mLanguage );

		self::$mData = $wgMemc->get( $cacheKey );

		if ( empty( self::$mData ) || $forceRefresh ) {
			self::$mData = array( );

			$wikisIDs = array();

			// get all the active wikis selected by the sales team
			$wikiFactoryRecommended = WikiFactory::getVarByName( self::WF_VAR_NAME, null );
			self::$mData[ 'recommended' ] = array( );

			if ( !empty( $wikiFactoryRecommended ) && !empty( $wikiFactoryRecommended->cv_variable_id ) ) {
				$dbr = WikiFactory::db( DB_SLAVE );

				$res = $dbr->select(
					array(
						'city_list',
						'city_variables'
					),
					'city_id',
					array(
						'city_id = cv_city_id',
						'city_public' => 1,
						'city_lang' => self::$mLanguage,
						'cv_variable_id' => $wikiFactoryRecommended->cv_variable_id,
						'cv_value' => serialize( true )
					)
				);

				while ( $row = $dbr->fetchObject( $res ) ) {
					self::$mData[ 'recommended' ][] = $row->city_id;
				}

				$dbr->freeResult( $res );
			}

			$counter = 0;
			self::$mData[ 'hubs' ] = array();

			if ( !empty( $wgStatsDBEnabled ) ) {
				$langs = array(self::$mLanguage);
				$wikis = DataMartService::getTopWikisByPageviews( DataMartService::PERIOD_ID_MONTHLY, 200, $langs, null, 1 );
				$minPageViews = ( isset( self::$pageviewsLimits[ self::$mLanguage ] ) ) ? self::$pageviewsLimits[ self::$mLanguage ] : self::$pageviewsLimits[ 'default' ];

				foreach ( $wikis as $wikiID => $pvCount ) {
					if ( $pvCount >= $minPageViews ) {
						$hub = WikiFactory::getCategory( $wikiID );

						if ( !$hub ) {
							continue;
						}

						if ( !isset( self::$mData[ 'hubs' ][ $hub->cat_id ] ) ) {
							self::$mData[ 'hubs' ][ $hub->cat_id ] = array( );
						}

						self::$mData[ 'hubs' ][ $hub->cat_id ][ ] = $wikiID;
						$counter++;
					}
				}
			}

			// removing entries from hubs that have a match in recommended
			if ( !empty( self::$mData[ 'recommended' ] ) && !empty( self::$mData[ 'hubs' ] ) ) {
				$counter = 0;

				foreach ( self::$mData[ 'hubs' ] as $hubID => &$item ) {
					$item = array_diff( $item, self::$mData[ 'recommended' ] );
					$counter += count( $item );
				}
			}

			self::$mData[ 'total' ] = $counter;
			$wgMemc->set( $cacheKey, self::$mData, 3600 * self::CACHE_EXPIRY );
		}

		wfProfileOut( __METHOD__ );
	}
}

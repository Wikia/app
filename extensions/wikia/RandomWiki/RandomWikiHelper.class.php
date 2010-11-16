<?php

class RandomWikiHelper {
	const CACHE_KEY_TOKEN = 'wikicities:RandomWiki:list';
	const WF_VAR_NAME = 'wgRandomWikiRecommend';
	const COUNT_LIMIT = 200;
	const CACHE_EXPIRY = 48; // hours

	static private $pageviewsLimits = array(
		'en' => 15000,
		'de' => 8000,
		'es' => 5000,
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
		global $wgMemc, $wgStatsDB, $wgContLang, $wgExternalSharedDB;
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
				$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
				
				$res = $dbr->select(
					array(
						'city_list',
						'city_variables'
					),
					'city_id',
					array(
						'city_id = cv_city_id',
						'city_public' => true,
						'city_lang' => self::$mLanguage,
						'cv_variable_id' => $wikiFactoryRecommended,
						'cv_value' => true
					)
				);
				
				while ( $row = $dbr->fetchObject( $res ) ) {
					self::$mData[ 'recommended' ][] = $row->city_id;
				}
				
				$dbr->freeResult( $res );
			}
			
			$dbr = wfGetDB( DB_SLAVE, array( ), $wgStatsDB );
			
			$wikis = $dbr->select(
					array(
						'wikicities.city_list as cl',
						'specials.page_views_summary_tags as pv'//this table stores only the last 4 weeks worth of data
					),
					array(
						'cl.city_id AS city_id',
						'sum(pv.pv_views) as pageviews'
					),
					array(
						'cl.city_id = pv.city_id',
						'cl.city_lang' => self::$mLanguage,
						'cl.city_public' => true,
					),
					__METHOD__,
					array(
						'GROUP BY' => 'cl.city_id',
					)
			);
			
			$counter = 0;
			self::$mData[ 'hubs' ] = array();
			$minPageViews = ( isset( self::$pageviewsLimits[ self::$mLanguage ] ) ) ? self::$pageviewsLimits[ self::$mLanguage ] : self::$pageviewsLimits[ 'default' ];

			while ( ( $wiki = $dbr->fetchObject( $wikis ) ) && ( $counter < self::COUNT_LIMIT ) ) {
				if ( $wiki->pageviews >= $minPageViews ) {
					$hub = WikiFactory::getCategory( $wiki->city_id );

					if ( !$hub ) {
						continue;
					}

					if ( !isset( self::$mData[ 'hubs' ][ $hub->cat_id ] ) ) {
						self::$mData[ 'hubs' ][ $hub->cat_id ] = array( );
					}

					self::$mData[ 'hubs' ][ $hub->cat_id ][ ] = $wiki->city_id;
					$counter++;
				}
			}

			$dbr->freeResult( $wikis );

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

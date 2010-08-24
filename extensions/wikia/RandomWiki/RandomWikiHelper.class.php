<?php

class RandomWikiHelper {
	const CACHE_KEY_TOKEN = 'wikicities:RandomWiki:list';
	const WF_VAR_NAME = 'wgRandomWikiRecommend';
	const PAGEVIEWS_TIME_SPAN = 30; // days
	const COUNT_LIMIT = 200;
	const TRACK_LIMIT = 20;
	const CACHE_EXPIRY = 24; // hours

	static private $pageviewsLimits = array(
		'en' => 20000,
		'de' => 10000,
		'es' => 8000,
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

		wfProfileIn( __METHOD__ );

		global $wgMemc, $wgStatsDB, $wgContLang;

		self::$mLanguage = ( !empty( $forceLanguage ) ) ? $forceLanguage : $wgContLang->getCode();
		$cacheKey = self::CACHE_KEY_TOKEN . ':' . strtoupper( self::$mLanguage );

		self::$mData = $wgMemc->get( $cacheKey );

		if ( empty( self::$mData ) || $forceRefresh ) {
			self::$mData = array( );

			// get a list of existing wikis in the current language
			$wikiFactoryLang = WikiFactory::getVarByName( 'wgLanguageCode', null );
			$wikisIDs = array();

			if ( !empty( $wikiFactoryLang ) && !empty( $wikiFactoryLang->cv_variable_id ) ) {
				$wikisIDs = WikiFactory::getCityIDsFromVarValue( $wikiFactoryLang->cv_variable_id, self::$mLanguage, '=' );
			}

			// purging closed wikis
			$dbr = WikiFactory::db( DB_SLAVE );

			$res = $dbr->select(
				'city_list',
				'city_id',
				array(
					'city_public' => true,
					'city_id IN (' . implode( ',', $wikisIDs ) . ')'
				)
			);

			$wikisIDs = array();

			while ( $row = $dbr->fetchObject( $res ) ) {
				$wikisIDs[] = $row->city_id;
			}

			$dbr->freeResult( $res );

			// get all the wikis selected by the sales team
			$wikiFactoryRecommended = WikiFactory::getVarByName( self::WF_VAR_NAME, null );
			self::$mData[ 'recommended' ] = array( );

			if ( !empty( $wikiFactoryRecommended ) && !empty( $wikiFactoryRecommended->cv_variable_id ) ) {
				self::$mData[ 'recommended' ] = WikiFactory::getCityIDsFromVarValue( $wikiFactoryRecommended->cv_variable_id, true, '=' );
			}

			// filter the recommendation list, oly take what's intersecting the main list
			if ( !empty( self::$mData[ 'recommended' ] ) && !empty( $wikisIDs ) ) {
				self::$mData[ 'recommended' ] = array_intersect( self::$mData[ 'recommended' ], $wikisIDs );
			}

			// the list is clear, now filter by the total amount of pageviews in the specified span of time, it must be bigger then the predefined limit
			// and group the wikis by hub.
			// having filtered the list should make things faster
			$dbr = wfGetDB( DB_SLAVE, array( ), $wgStatsDB );

			$wikis = $dbr->select(
					'tags_pv',
					array(
						'city_id',
						'sum(pviews) as pageviews'
					),
					array(
						'city_id IN (' . implode( ',', $wikisIDs ) . ')',
						'ts > (NOW() - INTERVAL ' . self::PAGEVIEWS_TIME_SPAN . ' day)'
					),
					__METHOD__,
					array(
						'GROUP BY' => 'city_id',
					)
			);

			$counter = 0;
			self::$mData[ 'hubs' ] = array( );
			$minPageViews = ( isset( self::$pageviewsLimits[ self::$mLanguage ] ) ) ?
				self::$pageviewsLimits[ self::$mLanguage ] :
				self::$pageviewsLimits[ 'default' ];

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

			// cache it for 24h only, wiki can be closed at any time
			$wgMemc->set( $cacheKey, self::$mData, 3600 * self::CACHE_EXPIRY );
		}

		wfProfileOut( __METHOD__ );
	}
}

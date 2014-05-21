<?php

abstract class BaseRssModel {
	const GAMES_FEED = 'games';
	const TV_FEED = 'tv';
	const UNIQUE_URL_TTL_HOURS = 336;
	const FRESH_CONTENT_TTL_HOURS = 4;
	const ROWS_LIMIT = 15;
	public abstract function getFeedTitle();

	public abstract function getFeedLanguage();

	public abstract function getFeedDescription();

	public abstract function getFeedData();

	/**
	 * @param $feedName
	 * @return BaseRssModel
	 */
	public static function newFromName( $feedName ) {
		switch ( strtolower( $feedName ) ) {
			case self::GAMES_FEED:
				return new GamesRssModel();
			case self::TV_FEED:
				return new TvRssModel();
		}
	}

	protected function getLastShownFeeds( $feed, $hours = self::UNIQUE_URL_TTL_HOURS ) {

	}

	protected function getDb() {
		static $db = null;
		if ( $db === null ) {
			global $wgExternalDatawareDB;

			$db = wfGetDB( DB_SLAVE, null, $wgExternalDatawareDB );
		}
		return $db;
	}

	protected function addFeedsToDb( $rows, $feed ) {
		$date = date( 'c' );
		foreach ( $rows as $url => $item ) {
			( new WikiaSQL() )
				->INSERT( 'wikia_rss_feeds' )
				->SET( 'wrf_wikia_id', $item[ 'wikia_id' ] )
				->SET( 'wrf_page_id', $item[ 'page_id' ] )
				->SET( 'wrf_url', $url )
				->SET( 'wrf_feed', $feed )
				->SET( 'wrf_pub_date', $date )
				->SET( 'wrf_title', $item[ 'title' ] )
				->SET( 'wrf_description', $item[ 'description' ] )
				->SET( 'wrf_img_url', $item[ 'img' ][ 'url' ] )
				->SET( 'wrf_img_width', $item[ 'img' ][ 'width' ] )
				->SET( 'wrf_img_height', $item[ 'img' ][ 'height' ] )
				->run( $this->getDb() );
		}
	}

	protected function isFreshContentInDb( $feed, $hours = self::FRESH_CONTENT_TTL_HOURS ) {
		$startTime = date( 'Y-m-d H:i:s', strtotime( sprintf( 'now - %uhour', $hours ) ) );

		$links = ( new WikiaSQL() )
			->SELECT( "count(1)" )->AS_( 'c' )
			->FROM( 'wikia_rss_feeds' )
			->WHERE( 'wrf_pub_date' )
			->GREATER_THAN_OR_EQUAL( $startTime )
			->AND_('wrf_feed')->EQUAL_TO($feed)
			->LIMIT( 1 )
			->run( $this->getDb(), function ( $result ) {
				$row = $result->fetchObject( $result );
				if ( $row && isset( $row->c ) ) {
					return (int)$row->c;
				}

				return 0;
			} );

		return $links;
	}

	protected function getLastRecoredsFromDb($feed, $limit = self::ROWS_LIMIT){
		$wikisData = ( new WikiaSQL() )
			->SELECT(' * ')
			->FROM( 'wikia_rss_feeds' )
			->WHERE('wrf_feed')->EQUAL_TO($feed)
			->ORDER_BY('wrf_pub_date DESC')
			->LIMIT($limit)
			->runLoop( $this->getDb(), function (&$wikisData, $row )   {
				
				$wikisData[$row->wrf_url] = [
					'wikia_id' => $row->wrf_wikia_id,
					'page_id' => $row->wrf_page_id,
					'timestamp' =>strtotime($row->wrf_pub_date),
					'title'=>$row->wrf_title,
					'description'=>$row->wrf_description,
					'img'=>[
						'url'=>$row->wrf_img_url,
						'width'=>$row->wrf_img_width,
						'height'=>$row->wrf_img_height
					]
				];
				}
			 );

		return $wikisData;
	}
} 

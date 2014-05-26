<?php

/**
 * Created by PhpStorm.
 * User: krzychu
 * Date: 21.05.14
 * Time: 15:44
 */
class TvRssModel extends BaseRssModel {
	const FEED_NAME = 'tv';
	const TVRAGE_RSS_YESTERDAY = "http://www.tvrage.com/myrss.php?class=scripted&date=yesterday";
	const TVRAGE_RSS_TODAY = "http://www.tvrage.com/myrss.php?class=scripted&date=today";
	const MIN_ARTICLE_QUALITY = 30;
	const MAX_NUM_ITEMS_IN_FEED = 15;
	const MIN_NUM_ITEMS_IN_FEED = 5;
	const ADD_CONTENT_PERIOD = 86400;
	const TV_HUB_CITY_ID = 957447;
	const SOURCE_TVRAGE = 'tvrage';

	public function getFeedTitle() {
		return 'Wikia Tv Shows';
	}

	public function getFeedLanguage() {
		return 'en';
	}

	public function getFeedDescription() {
		return 'Wikia Tv Shows';
	}

	protected function shouldGenerateAdditionalContent() {
		$timeDiff = mktime() - $this->getLastInsertFeedTimestamp( self::FEED_NAME, self::SOURCE_GENERATOR ) ;
		return $timeDiff > self::ADD_CONTENT_PERIOD;
	}

	public function getFeedData() {

		/*
		 * If content in DB is fresh (BaseRssModel::FRESH_CONTENT_TTL_HOURS)
		 * don't do anything and return content from DB
		 */
		if ( $this->forceRegenerateFeed == false ) {
			if ( $this->isFreshContentInDb( self::FEED_NAME ) ) {
				return $this->getLastRecoredsFromDb( self::FEED_NAME, self::MAX_NUM_ITEMS_IN_FEED );
			}
		}

		$useWikisFromThePast = false;
		/*
		 * Get Wikia articles that match to premiere TV Episodes
		 * (TVRage data)
		 */
		$rawData = $this->getWikiaArticlesFromExtApi();
		$duplicates = $this->getLastDuplicatesFromDb( self::FEED_NAME );
		$timestamp = $this->getLastFeedTimestamp( self::FEED_NAME ) + 1;
		$hubData = $this->getDataFromHubs( self::TV_HUB_CITY_ID, $timestamp, $duplicates );

		$rawData = array_merge( $rawData, $hubData );
		if ( empty( $rawData ) ) {
			/*
			 * If we do not have match with TVRage for current day -
			 * lets propose articles from wikis that occured in the past
			 * on this channel
			 */
			$useWikisFromThePast = $this->shouldGenerateAdditionalContent();
		}
		/*
		 * Remove articles that already occurred in the DB
		 */

		$rawData = $this->removeDuplicates( $rawData, $duplicates );
		$externalDataCount = count( $rawData );
		if ( $externalDataCount < self::MIN_NUM_ITEMS_IN_FEED ) {
			$wikis = [ ];
			if ( !empty( $rawData ) ) {
				foreach ( $rawData as $item ) {
					$wikis[ $item[ 'wikia_id' ] ] = true;
				}
				$wikis = array_keys( $wikis );
			} elseif ( $useWikisFromThePast ) {
				$wikis = $this->getWikisFromPast();
			}
			/*
			 * This is needed only to reach MIN_NUM_ITEMS_IN_FEED number of rows
			 */
			if ( $externalDataCount < self::MIN_NUM_ITEMS_IN_FEED ) {
				$rawData = $this->getPopularContent( $rawData, $wikis, $duplicates, self::MIN_NUM_ITEMS_IN_FEED - $externalDataCount );
			}
		}

		$out = $this->finalizeRecords( $rawData, self::MAX_NUM_ITEMS_IN_FEED , self::FEED_NAME );
		return $out;
	}

	protected function getWikisFromPast() {
		//select distinct(wrf_wikia_id) from  wikia_rss_feeds  where wrf_feed='tv' order by wrf_pub_date desc limit 3
		$wikisData = ( new WikiaSQL() )
			->SELECT( ' distinct(wrf_wikia_id) wid ' )
			->FROM( 'wikia_rss_feeds' )
			->WHERE( 'wrf_feed' )->EQUAL_TO( self::FEED_NAME )
			->ORDER_BY( 'wrf_pub_date DESC' )
			->LIMIT( 3 )
			->runLoop( $this->getDbSlave(), function ( &$wikisData, $row ) {
					$wikisData[ ] = $row->wid;
				}
			);

		if ( count( $wikisData ) == 0 ) {
			$wikisData = [ 38969, 130814, 4428, 260417, 18068 ];
		}

		return $wikisData;
	}


	protected function getTVEpisodes() {
		$data = Http::get( self::TVRAGE_RSS_YESTERDAY );
		$data = simplexml_load_string( $data );

		if ( !$data ) {
			\Wikia\Logger\WikiaLogger::instance()->error( __METHOD_ . " : No content from TVRAGE !" );
			return [ ];
		}

		$items = $data->children();
		$episodes = [ ];
		foreach ( $items->children() as $elem ) {
			if ( !empty( $elem->title ) ) {
				$EData = $this->parseTitle( (string)$elem->title );
				$EData[ 'episode_title' ] = (string)$elem->description;
				if ( !empty( $EData[ 'episode_title' ] ) ) {
					$episodes[ ] = $EData;
				}
			}
		}
		return $episodes;
	}

	protected function getWikiaArticles( $episodes ) {
		global $wgStagingEnvironment, $wgDevelEnvironment;

		$data = [ ];
		foreach ( $episodes as $i => $episode ) {
			try {
				$response = $this->sendRequest( 'TvApiController', 'getEpisode', [
					'seriesName' => $episode[ 'title' ],
					'episodeName' => $episode[ 'episode_title' ],
					'minArticleQuality' => self::MIN_ARTICLE_QUALITY
				] );
				$item = $response->getData();
				$item[ 'wikia_id' ] = $item[ 'wikiId' ];
				$item[ 'page_id' ] = $item[ 'articleId' ];
				$item[ 'series_name' ] = $episode[ 'title' ];
				$item[ 'episode_name' ] = $episode[ 'episode_title' ];
				$item[ 'source' ] = self::SOURCE_TVRAGE;
				unset( $item[ 'wikiId' ], $item[ 'articleId' ] );
				if ( $wgStagingEnvironment || $wgDevelEnvironment ) {
					$url = WikiFactory::DBtoUrl( WikiFactory::IDtoDB( $item[ 'wikia_id' ] ) );
					if ( strpos( $item[ 'url' ], $url ) !== 0 ) {
						$item[ 'url' ] = preg_replace( '~http://[^\.]+\.~', 'http://', $item[ 'url' ] );
					}
				}
				$data[ ] = $item;
			} catch ( Exception $e ) {
				\Wikia\Logger\WikiaLogger::instance()->error( __METHOD_ . " : " . $e->getMessage() );
			}
		}

		return $data;
	}


	protected function parseTitle( $episodeRssTitle ) {
		$episodeRssTitle = str_replace( "- ", "", trim( $episodeRssTitle ) );
		$titleArr = explode( " (", $episodeRssTitle );
		$parsed = array(
			"title" => $titleArr[ 0 ],
			"series" => "",
			"episode" => ""
		);
		if ( count( $titleArr ) > 1 ) {
			$epData = explode( "x", trim( $titleArr[ 1 ], ")" ) );
			$parsed[ 'series' ] = $epData[ 0 ];
			$parsed[ 'episode' ] = $epData[ 1 ];
		}
		return $parsed;
	}

	protected function getWikiaArticlesFromExtApi() {
		$episodes = $this->getTVEpisodes();
		return $this->getWikiaArticles( $episodes );
	}

	protected function formatTitle( $item ) {
		switch ( $item[ 'source' ] ) {
			case self::SOURCE_TVRAGE:
				$item[ 'title' ] = sprintf( '%s, the new episode from %s', $item[ 'episode_name' ], $item[ 'series_name' ] );
				break;
			case self::SOURCE_HUB:
				$item = $this->makeBlogTitle( $item );
				break;
			case self::SOURCE_GENERATOR:
				$titles = [ 'Read more about %s from %s', 'More info about %s from %s', 'Recommended page: %s  from %s' ];
				$titleNum = rand( 0, count( $titles ) - 1 );

				if ( !array_key_exists( 'wikititle', $item ) || !$item[ 'wikititle' ] ) {
					$info = WikiFactory::getWikiByID( $item[ 'wikia_id' ] );
					$item[ 'wikititle' ] = $info->city_title;
				}
				$item[ 'title' ] = sprintf( $titles[ $titleNum ], $item[ 'title' ], $item[ 'wikititle' ] );
				break;

		}
		return $item;
	}
}
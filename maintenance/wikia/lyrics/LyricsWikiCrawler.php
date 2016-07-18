<?php
$dir = dirname( __FILE__ );

require_once( $dir . '/../../Maintenance.php' );
require_once( $dir . '/lyrics.setup.php' );

use Wikia\Logger\WikiaLogger;

/**
 * Class LyricsWikiCrawler
 *
 * @desc Maintenance script responsible for scribing Lyrics wikia articles
 */
class LyricsWikiCrawler extends Maintenance {

	const OPTION_ARTICLE_ID = 'articleId';
	const OPTION_ARTIST_ID = 'artistId';
	const OPTION_ARTICLE_ALL = 'all';
	const OPTION_ARTICLE_POOL = 'pool';
	const OPTION_ARTICLE_LANE = 'lane';

	private $articleId = 0;
	private $startTime = 0;
	private $processedArticlesCount = 0;
	private $logContext = [];

	/**
	 * @var DatabaseBase
	 */
	private $db;

	/**
	 * @var SolrAdapter
	 */
	private $solr;

	public function __construct() {
		parent::__construct();
		$this->startTime = microtime( true );
		$this->addOption( self::OPTION_ARTICLE_ID, 'Article ID which we will get data from' );
		$this->addOption( self::OPTION_ARTIST_ID, 'Artist article ID which we will get data from' );
		$this->addOption( self::OPTION_ARTICLE_ALL, 'If passed it pulls all articles on lyrics.wikia.com; otherwise it pulls edits from yesterday' );
		$this->addOption( self::OPTION_ARTICLE_POOL, 'If passed it pulls all articles on lyrics.wikia.com; Requires --lane option' );
		$this->addOption( self::OPTION_ARTICLE_LANE, 'Sets the lane, current process should work on' );

		$this->mDescription = "Crawls through LyricWiki, pulls data from its articles and puts it to our database";
	}

	public function execute() {
		$this->db = $this->getDB( DB_SLAVE );
		$this->solr = new SolrAdapter( $this->getConfig() );

		if( $this->hasOption( self::OPTION_ARTICLE_ALL ) ) {
			$this->doScrapeAllArticles();
			$this->addToLogContext( 'crawl_type', self::OPTION_ARTICLE_ALL );
		} elseif ( ( $poolSize = intval( $this->getOption( self::OPTION_ARTICLE_POOL, 0 ) ) ) && $poolSize > 0  &&
			( $laneNumber = intval( $this->getOption( self::OPTION_ARTICLE_LANE, 0 ) ) ) && $laneNumber > 0 ) {
			$this->doScrapeLane( $poolSize, $laneNumber );
			$this->addToLogContext( 'crawl_type', self::OPTION_ARTICLE_LANE );
			$this->addToLogContext( 'lane', $laneNumber );
			$this->addToLogContext( 'pool_size', $poolSize );
		} else if( ( $articleId = intval( $this->getOption( self::OPTION_ARTIST_ID, 0 ) ) ) && $articleId > 0 ) {
			$this->setArticleId( $articleId );
			$this->doScrapeArtist();
			$this->addToLogContext( 'crawl_type', self::OPTION_ARTICLE_LANE );
			$this->addToLogContext( 'artist_id', $articleId );
		} else {
			$this->doScrapeArticlesFromYesterday();
			$this->addToLogContext( 'crawl_type', 'yesterday' );
		}
		$this->logExecution();
	}

	private function logExecution() {
		$this->addToLogContext( 'execution_time', microtime( true ) - $this->startTime );
		$this->addToLogContext( 'processed_articles', $this->processedArticlesCount );
		WikiaLogger::instance()->info( 'LyricsWikiCrawler', $this->getLogContext() );
	}

	/**
	 * @desc Scrapes all Lyrics Wikia articles
	 */
	public function doScrapeAllArticles() {
		$artists = $this->getArtistPageIds();
		while ( $page = $this->db->fetchObject( $artists ) ) {
			$this->setArticleId( $page->cl_from );
			$this->doScrapeArtist();
		}
	}

	/**
	 * @desc Scraping only a partition of articles
	 *
	 * @param $poolSize
	 * @param $laneNumber
	 */
	function doScrapeLane( $poolSize, $laneNumber ) {
		$artistCount = $this->getArtistCount();
		$laneSize = ceil( $artistCount / $poolSize );
		$laneOffset = $laneSize * ( $laneNumber - 1 );
		$this->output(
			sprintf(
				'Scraping lane %d of %d size %d/%d artists' . PHP_EOL,
				$laneNumber,
				$poolSize,
				$laneSize,
				$artistCount
			)
		);
		$artists = $this->getArtistPageIds( $laneSize, $laneOffset );
		while ( $page = $this->db->fetchObject( $artists ) ) {
			$this->setArticleId( $page->cl_from );
			$this->doScrapeArtist();
		}
	}

	/**
	 * @desc Scrapes artists data from given article
	 */
	public function doScrapeArtist() {
		$this->output( 'Scraping artist #' . $this->getArticleId() . PHP_EOL );
		$article = Article::newFromID( $this->getArticleId() );
		$ls = new LyricsScraper( $this->solr );
		$ls->processArtistArticle( $article );
		$this->processedArticlesCount += $ls->getProcessedArticlesCount();
	}

	/**
	 * @desc Scrapes data from articles from yesterday
	 */
	public function doScrapeArticlesFromYesterday() {
		$yesterdayTs = strtotime( '-1 day' );
		$yesterday = date( "Y-m-d", $yesterdayTs );

		$this->output( 'Scraping articles from ' . $yesterday . PHP_EOL );

		$pages = $this->getRecentChangedPages( date( "Ymd", $yesterdayTs ) );
		$this->addToLogContext( 'user_updated_articles', count( $pages ) );

		if( !empty( $pages ) ) {
			$pages = $this->convertIntoArtistPages( $pages );
			$this->addToLogContext( 'updated_artists', count( $pages ) );

			$start = date( 'Y-m-d\TH:i:s.u\Z' );

			foreach( $pages as $pageId ) {
				$this->setArticleId( $pageId );
				$this->doScrapeArtist();
			}

			$artists = $this->getArtistTitlesFromIds( $pages );
			$this->solr->delDocsByArtistsAndDate( $artists, $start );
		}
	}

	/**
	 * @desc Creates instances of Title for given pages ids and returns array of titles' texts
	 *
	 * @param Array $pages
	 * @return array
	 */
	public function getArtistTitlesFromIds( $pages ) {
		$result = [];
		$artistsTitles = Title::newFromIDs( $pages );

		foreach( $artistsTitles as $artistTitle ) {
			$result[] = $artistTitle->getText();
		}

		return $result;
	}

	/**
	 * @desc Filters given array and returns only Artist-category pages
	 *
	 * @param array $pages
	 * @return array
	 */
	public function convertIntoArtistPages( Array $pages ) {
		$results = [];

		foreach( $pages as $page ) {
			$pageId = (int) $page->id;
			$category = strtolower( $page->category );

			if( $category === 'artist' ) {
				$results[] = $pageId;
			} else {
				$artistPageId = $this->getArtistPageId( $pageId );

				if( $artistPageId > 0 ) {
					wfDebugLog(
						__METHOD__,
						sprintf(
							'Found the artist article (id: %d) for %s (id: %d)',
							$artistPageId,
							$category,
							$pageId
						)
					);

					$results[] = $artistPageId;
				}
			}
		}

		return array_unique( $results );
	}

	/**
	 * @desc Based on album/song title creates an instance of Title for the artist and returns artist's page id
	 *
	 * @param Integer $pageId an instance of stdClass with two fields: id and category
	 *
	 * @return int Returns 0 if any of the articles couldn't be found
	 */
	public function getArtistPageId( $pageId ) {
		$articleId = 0;
		$article = Article::newFromID( $pageId );

		if( !is_null( $article) ) {
			$titleText = $article->getTitle()->getText();
			$titleExploded = explode( ':', $titleText );
			$artistTitleText = $titleExploded[0];
			$artistTitle = Title::newFromText( $artistTitleText );

			if( !is_null( $artistTitle ) ) {
				$articleId = $artistTitle->getArticleId();
			} else {
				wfDebugLog(
					__METHOD__,
					sprintf(
						'Found the article (id: %d) but could not create a Title for artist (%s extracted from %s)',
						$pageId,
						$artistTitleText,
						$titleText
					)
				);
			}
		} else {
			wfDebugLog(
				__METHOD__,
				sprintf(
					'Could not find the article (id: %d) for which an artist article should be found',
					$pageId
				)
			);
		}

		return (int) $articleId;
	}

	/**
	 * @desc Sets article id
	 *
	 * @param Integer $articleId article id
	 */
	public function setArticleId( $articleId ) {
		$this->articleId = $articleId;
	}

	/**
	 * @desc Getter - returns article id
	 *
	 * @return Integer
	 */
	public function getArticleId() {
		return $this->articleId;
	}

	/**
	 * Get total number of artists
	 *
	 * @return false|mixed
	 */
	private function getArtistCount() {
		return $this->db->selectField(
			'categorylinks',
			'count(1)',
			[
				'cl_to' => 'Artist'
			],
			__METHOD__
		);
	}

	/**
	 * @desc Gets page ids for artists
	 *
	 * @param int $limit Number of results
	 * @param int  $offset Result offset
	 *
	 * @return ResultWrapper
	 */
	private function getArtistPageIds( $limit = 0, $offset = 0 ) {
		$limitParams = [
			'ORDER BY' => 'cl_from'
		];
		
		if ( $limit ) {
			$limitParams['LIMIT'] = $limit;
			$limitParams['OFFSET'] = $offset;
		}

		return $this->db->select(
			'categorylinks',
			'cl_from',
			[
				'cl_to' => 'Artist'
			],
			__METHOD__,
			$limitParams
		);
	}

	/**
	 * @desc Gets page ids and their categories from recentchanges and categorylins tables
	 *
	 * @param String $date date in format Ymd
	 *
	 * @return Array
	 */
	private function getRecentChangedPages( $date ) {
		$betweenStart = $date . '000000';
		$betweenEnd = $date . '235959';

		$table = [ 'r' => 'recentchanges', 'c' => 'categorylinks' ];
		$fields = [ 'r.rc_cur_id as id', 'c.cl_to as category' ];
		$where = [
			'r.rc_cur_id > 0',
			'rc_namespace' => NS_MAIN,
			'rc_timestamp between ' . $betweenStart . ' and ' . $betweenEnd
		];
		$joins = [ 'c' => [
			'INNER JOIN',
			'r.rc_cur_id = c.cl_from AND c.cl_to IN ("Artist", "Album", "Song")'
		] ];
		$options = [
			'DISTINCT',
			'ORDER BY' => 'rc_timestamp desc',
			'USE INDEX' => [ 'r' => 'rc_timestamp' ],
		];

		$result = $this->db->select( $table, $fields, $where, __METHOD__, $options, $joins );

		$pages = [];
		if( $result->numRows() > 0 ) {
			while( $row = $result->fetchObject() ) {
				$pages[] = $row;
			}
		}

		return $pages;
	}

	/**
	 * @desc Gets the default configuration from $wgLyricsApiSolrariumConfig, modifies it and returns modified version
	 *
	 * @return Array
	 */
	public function getConfig() {
		$wg = F::app()->wg;

		$config = $wg->LyricsApiSolrariumConfig;
		$config['adapteroptions']['host'] = $wg->SolrMaster;
		$config['adapteroptions']['port'] = $wg->SolrDefaultPort;
		unset( $config['adapteroptions']['proxy'] );

		$this->output( 'Connecting to host: ' . $config['adapteroptions']['host'] . PHP_EOL );

		return $config;
	}

	/**
	 * Adds value to log context
	 *
	 * @param $name
	 * @param $value
	 */
	private function addToLogContext( $name, $value ) {
		$this->logContext[$name] = $value;
	}

	/**
	 * Returns logging context
	 *
	 * @return array
	 */
	public function getLogContext(){
		return $this->logContext;
	}

}

$maintClass = "LyricsWikiCrawler";
require_once( DO_MAINTENANCE );

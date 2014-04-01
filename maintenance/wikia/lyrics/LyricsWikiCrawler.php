<?php
$dir = dirname( __FILE__ );

require_once( $dir . '/../../Maintenance.php' );
require_once( $dir . '/../../../extensions/wikia/LyricsApi/LyricsApiBase.class.php' );

require_once( $dir . '/DataBaseAdapter.class.php' );
require_once( $dir . '/LyricsScraper.class.php' );

require_once( $dir . '/scrapers/BaseScraper.class.php' );
require_once( $dir . '/scrapers/ArtistScraper.class.php' );
require_once( $dir . '/scrapers/AlbumScraper.class.php' );
require_once( $dir . '/scrapers/SongScraper.class.php' );

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

	/**
	 * @var DataBase
	 */
	private $db;

	/**
	 * @var DataBaseAdapter
	 */
	private $dba;

	public function __construct() {
		parent::__construct();
		$this->addOption( self::OPTION_ARTICLE_ID, 'Article ID which we will get data from' );
		$this->addOption( self::OPTION_ARTIST_ID, 'Artist article ID which we will get data from' );
		$this->addOption( self::OPTION_ARTICLE_ALL, 'If passed it pulls all articles on lyrics.wikia.com; otherwise it pulls edits from yesterday' );
		$this->addOption( self::OPTION_ARTICLE_POOL, 'If passed it pulls all articles on lyrics.wikia.com; Requires --lane option' );
		$this->addOption( self::OPTION_ARTICLE_LANE, 'Sets the lane, current process should work on' );

		$this->mDescription = "Crawls through LyricWiki, pulls data from its articles and puts it to our database";
	}

	public function execute() {
		$this->db = $this->getDB( DB_SLAVE );

		$lyricsApiBase = new LyricsApiBase();
		$this->dba = newDatabaseAdapter( 'solr', $lyricsApiBase->getConfig() );

		if( $this->hasOption( self::OPTION_ARTICLE_ALL ) ) {
			$this->doScrapeAllArticles();
		} elseif ( ( $poolSize = intval( $this->getOption( self::OPTION_ARTICLE_POOL, 0 ) ) ) && $poolSize > 0  &&
			( $laneNumber = intval( $this->getOption( self::OPTION_ARTICLE_LANE, 0 ) ) ) && $laneNumber > 0 ) {
			$this->doScrapeLane( $poolSize, $laneNumber );
		} else if( ( $articleId = intval( $this->getOption( self::OPTION_ARTIST_ID, 0 ) ) ) && $articleId > 0 ) {
			$this->setArticleId( $articleId );
			$this->doScrapeArtist();
		} else if( ( $articleId = intval( $this->getOption( self::OPTION_ARTICLE_ID, 0 ) ) ) && $articleId > 0 ) {
			die('NOT IMPLEMENTED'.PHP_EOL);
			$this->setArticleId( $articleId );
			$this->doScrapeArticle();
		} else {
			$this->doScrapeArticlesFromYesterday();
		}
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
	 * @desc Scrapes given single article
	 */
	public function doScrapeArticle() {
		$start = microtime(true);
		$status = ' ';
		$this->output( 'Scraping article #' . $this->getArticleId() );
		$article = Article::newFromID( $this->getArticleId() );
		if ( !is_null($article) ) {
			$scraper = $this->scrapperFactory->newFromArticle( $article );
			if ( $scraper ) {
				$scraper->processArticle( $article );
			} else {
				$status .= 'Unknown article type ';
			}
		} else {
			$status .= 'Article not found ';
		}
		$this->output( $status . round( microtime( true ) - $start, 2) . 's' . PHP_EOL );
	}

	/**
	 * @desc Scrapes artists data from given article
	 */
	public function doScrapeArtist() {
		$this->output( 'Scraping artist #' . $this->getArticleId() . PHP_EOL );
		$article = Article::newFromID( $this->getArticleId() );
		$ls = new LyricsScraper( $this->dba );
		$ls->processArtistArticle( $article );
	}

	/**
	 * @desc Scrapes data from articles from yesterday
	 */
	public function doScrapeArticlesFromYesterday() {
		$yesterdayTs = strtotime( '-1 day' );
		$yesterday = date( "Y-m-d", $yesterdayTs );
		$this->output( 'Scraping articles from ' . $yesterday );
		$pages = $this->getRecentChangedPages( date( "Ymd", $yesterdayTs ) );
		$this->groupByType( $pages );
		// delete deleted pages from index
		// update new pages and edits
		echo PHP_EOL . PHP_EOL;
		print_r( $pages );
		echo PHP_EOL . PHP_EOL;
	}

	/**
	 * @desc Groups pages in two group: updates and delets
	 *
	 * @param Array $pages
	 * @return array
	 */
	public function groupByType( $pages ) {
		$updates = [];
		$deletes = [];

		foreach( $pages as $page ) {
			$pageId = $page['rc_cur_id'];
			if( $page['rc_deleted'] > 0 ) {
				$deletes[$pageId] = $page;
			} else {
				$updates[$pageId] = $page;
			}
		}

		return [ 'updates' => $updates, 'deletes' => $deletes ];
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
	 * @desc Gets page ids from recent changes
	 *
	 * @param String $date date in format Ymd
	 * @param int $limit Number of results
	 * @param int  $offset Result offset
	 *
	 * @return Array
	 */
	private function getRecentChangedPages( $date, $limit = 0, $offset = 0 ) {
		$betweenStart = $date . '000000';
		$betweenEnd = $date . '235959';

		$options = [ 'ORDER BY' => 'rc_timestamp desc' ];

		if ( $limit ) {
			$options['LIMIT'] = $limit;
			$options['OFFSET'] = $offset;
		}

		$result = $this->db->select(
			'recentchanges',
			[ 'rc_cur_id', 'rc_type', 'rc_log_action' ],
			[
				'rc_namespace' => NS_MAIN,
				'rc_timestamp between ' . $betweenStart . ' and ' . $betweenEnd
			],
			__METHOD__,
			$options
		);

		$pages = [];
		if( $result->numRows() > 0 ) {
			while( $row = $result->fetchRow() ) {
				$this->addIfNotExists( $pages, $row );
			}
		}

		return $pages;
	}

	/**
	 * @desc Adds an element to the results array if there is no element with the same rc_cur_id
	 *
	 * @param Array $results results array
	 * @param Array $row an array with elements and each of them has rc_cur_id field
	 */
	public function addIfNotExists( &$results, $row ) {
		if( isset( $row['rc_cur_id'] ) ) {
			$id = intval( $row['rc_cur_id'] );

			// there are rows with rc_cur_id === 0 in recentchanges
			// these are rows of deleted pages - we don't want them
			// in result array because deletes are handled differently
			if( $id > 0 && !isset( $results[ $id ] ) ) {
				$results[ $id ] = $row;
			}
		}
	}

}

$maintClass = "LyricsWikiCrawler";
require_once( DO_MAINTENANCE );


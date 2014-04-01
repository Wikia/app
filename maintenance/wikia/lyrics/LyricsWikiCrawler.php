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
	private $articleCategory = null;

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
		$category = $this->getArticleCategory();
		$this->output( 'Scraping article #' . $this->getArticleId() . ' (' . $category . ') ' );
		$article = Article::newFromID( $this->getArticleId() );
		if ( !is_null($article) ) {
			/** @var ArtistScraper | AlbumScraper | SongScraper $scraper | false */
			$scraper = $this->getScraperByArticleCategory();
			if ( $scraper ) {
				$data = $scraper->processArticle( $article );

				echo PHP_EOL;
				print_r( $data );

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
		$this->output( 'Scraping articles from ' . $yesterday . PHP_EOL );
		$pages = $this->getRecentChangedPages( date( "Ymd", $yesterdayTs ) );
		foreach( $pages as $page ) {
			$this->setArticleId( $page->id );
			$this->setArticleCategory( $page->category );
			$this->doScrapeArticle();
		}
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
	 * @desc Sets article category
	 *
	 * @param String $category article
	 */
	public function setArticleCategory( $category ) {
		$this->articleCategory = strtolower( $category );
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
	 * @desc Getter - returns article category
	 *
	 * @return String
	 */
	public function getArticleCategory() {
		return $this->articleCategory;
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
		$options = [ 'DISTINCT', 'ORDER BY' => 'rc_timestamp desc' ];

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
	 * @desc Gets correct scraper instance depending on article category
	 *
	 * @return AlbumScraper|ArtistScraper|false|SongScraper
	 */
	public function getScraperByArticleCategory() {
		$scraper = false;
		$category = $this->getArticleCategory();

		if( $category === 'artist' ) {
			$scraper = new ArtistScraper();
		} else if( $category === 'album' ) {
			$scraper = new AlbumScraper();
		} elseif( $category === 'song' ) {
			$scraper = new SongScraper();
		}

		return $scraper;
	}

}

$maintClass = "LyricsWikiCrawler";
require_once( DO_MAINTENANCE );

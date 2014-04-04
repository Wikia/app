<?php

require_once( dirname(__FILE__) . '/../../Maintenance.php' );
require_once( dirname(__FILE__) . '/../../../extensions/wikia/LyricsApi/LyricsApiConstants.php' );

require_once( dirname(__FILE__) . '/DataBaseAdapter.class.php' );
require_once( dirname(__FILE__) . '/LyricsScraper.class.php' );

require_once( dirname(__FILE__) . '/scrapers/BaseScraper.class.php' );
require_once( dirname(__FILE__) . '/scrapers/ArtistScraper.class.php' );
require_once( dirname(__FILE__) . '/scrapers/AlbumScraper.class.php' );
require_once( dirname(__FILE__) . '/scrapers/SongScraper.class.php' );

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
		global $wgLyricsSolrConfig;
		$this->db = $this->getDB( DB_SLAVE );

		$this->dba = newDatabaseAdapter( 'solr', [
			'adapteroptions' => [
				'host' => $wgLyricsSolrConfig['host'],
				'port' => $wgLyricsSolrConfig['port'],
				'path' => $wgLyricsSolrConfig['path'],
				'core' => $wgLyricsSolrConfig['core'],
			]
		] );

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
			die('NOT IMPLEMENTED'.PHP_EOL);
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
		$yesterday = date( "Y-m-d", strtotime( '-1 day' ) );
		$this->output( 'Scraping articles from ' . $yesterday );
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
}

$maintClass = "LyricsWikiCrawler";
require_once( DO_MAINTENANCE );


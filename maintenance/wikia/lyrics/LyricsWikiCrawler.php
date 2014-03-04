<?php

require_once( dirname(__FILE__) . '/../../Maintenance.php' );
require_once( dirname(__FILE__) . '/ScraperFactory.class.php' );
require_once( dirname(__FILE__) . '/LyricsScrapper.class.php' );

require_once( dirname(__FILE__) . '/scrapers/BaseScraper.class.php' );
require_once( dirname(__FILE__) . '/scrapers/ArtistScraper.class.php' );
require_once( dirname(__FILE__) . '/scrapers/AlbumScraper.class.php' );
require_once( dirname(__FILE__) . '/scrapers/SongScraper.class.php' );
require_once( dirname(__FILE__) . '/DataBaseAdapter.class.php' );

require_once( dirname(__FILE__) . '/classes/BaseLyricsEntity.class.php' );
require_once( dirname(__FILE__) . '/classes/Artist.class.php' );
require_once( dirname(__FILE__) . '/classes/Album.class.php' );
require_once( dirname(__FILE__) . '/classes/Song.class.php' );

class LyricsWikiCrawler extends Maintenance {
	const OPTION_ARTICLE_ID = 'articleId';
	const OPTION_ARTICLE_ALL = 'all';
	const OPTION_ARTICLE_POOL = 'pool';
	const OPTION_ARTICLE_LANE = 'lane';

	private $articleId = 0;
	private $scrapperFactory;
	/**
	 * @var DataBase
	 */
	private $db;

	public function __construct() {
		parent::__construct();
		$this->addOption( self::OPTION_ARTICLE_ID, 'Article ID which we will get data from' );
		$this->addOption( self::OPTION_ARTICLE_ALL, 'If passed it pulls all articles on lyrics.wikia.com; otherwise it pulls edits from yesterday' );
		$this->addOption( self::OPTION_ARTICLE_POOL, 'If passed it pulls all articles on lyrics.wikia.com; Requires --lane option' );
		$this->addOption( self::OPTION_ARTICLE_LANE, 'Sets the lane, current process should work on' );

		$this->mDescription = "Crawls through LyricWiki, pulls data from its articles and puts it to our database";
	}

	public function execute() {
		$params = [
			'hosts' => [
				'10.10.10.242:9200',
			]
		];
		$this->db = $this->getDB( DB_SLAVE );

		$this->dba = new DataBaseAdapter();

		$this->scrapperFactory = new ScraperFactory( $this->dba );

		if( $this->hasOption( self::OPTION_ARTICLE_ALL ) ) {
			$this->doScrapeAllArticles();
		} else if( ( $articleId = intval( $this->getOption( self::OPTION_ARTICLE_ID, 0 ) ) ) && $articleId > 0 ) {
			$this->setArticleId( $articleId );
			$this->doScrapeArticle();
		} elseif ( ( $poolSize = intval( $this->getOption( self::OPTION_ARTICLE_POOL, 0 ) ) ) && $poolSize > 0  &&
			( $laneNumber = intval( $this->getOption( self::OPTION_ARTICLE_LANE, 0 ) ) ) && $laneNumber > 0 ) {
			$this->doScrapeLane( $poolSize, $laneNumber );
		} else {
			$this->doScrapeArticlesFromYesterday();
		}
	}

	public function doScrapeAllArticles() {
		$this->output( 'Scraping all articles...' . PHP_EOL );

		$pagesResult = $this->db->select(
			'page',
			[
				'page_id',
				'page_title'
			],
			[
				'page_namespace' => 0,
				'page_is_redirect' => 0,
			],
			__METHOD__,
			[
				'ORDER BY' => 'page_id'
			]
		);

		while ( $page = $this->db->fetchObject( $pagesResult ) ) {
			$this->setArticleId( $page->page_id );
			$this->doScrapeArticle();
		};
	}

	function doScrapeLane( $poolSize, $laneNumber ) {
		$artistCount = $this->getArtistCount();
		$laneSize = ceil( $artistCount / $poolSize );
		$laneOffset = $laneSize * ( $laneNumber - 1 );
		$this->output( sprintf('Scraping lane %d of %d'.PHP_EOL, $laneNumber, $poolSize ) );
		$artists = $this->getArtistPageIds( $laneSize, $laneOffset );
		while ( $page = $this->db->fetchObject( $artists ) ) {
			$this->setArticleId( $page->cl_from );
			$this->doScrapeArtist();
		}
	}

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

	public function doScrapeArtist() {
		$article = Article::newFromID( $this->getArticleId() );
		$ls = new LyricsScrapper( $this->dba );
		$ls->processArtistArticle( $article );
	}

	public function doScrapeArticlesFromYesterday() {
		$yesterday = date( "Y-m-d", strtotime( '-1 day' ) );
		$this->output( 'Scraping articles from ' . $yesterday );
	}

	public function setArticleId( $articleId ) {
		$this->articleId = $articleId;
	}

	public function getArticleId() {
		return $this->articleId;
	}

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

	private function getArtistPageIds( $limit, $offset ) {
		if ( $limit ) {
			$limitParams = [
				'LIMIT' => $limit,
				'OFFSET' => $offset,
				'ORDER BY' => 'cl_from'
			];
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
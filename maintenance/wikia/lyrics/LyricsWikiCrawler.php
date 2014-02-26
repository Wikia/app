<?php

require_once( dirname(__FILE__) . '/../../Maintenance.php' );
require_once( dirname(__FILE__) . '/ScraperFactory.class.php' );

require_once( dirname(__FILE__) . '/scrapers/BaseScraper.class.php' );
require_once( dirname(__FILE__) . '/scrapers/ArtistScraper.class.php' );
require_once( dirname(__FILE__) . '/scrapers/AlbumScraper.class.php' );
require_once( dirname(__FILE__) . '/scrapers/SongScraper.class.php' );

require_once( dirname(__FILE__) . '/classes/BaseLyricsEntity.class.php' );
require_once( dirname(__FILE__) . '/classes/Artist.class.php' );
require_once( dirname(__FILE__) . '/classes/Album.class.php' );
require_once( dirname(__FILE__) . '/classes/Song.class.php' );

class LyricsWikiCrawler extends Maintenance {
	const OPTION_ARTICLE_ID = 'articleId';
	const OPTION_ARTICLE_ALL = 'all';

	private $articleId = 0;
	private $scrapperFactory;

	public function __construct() {
		parent::__construct();
		$this->addOption( self::OPTION_ARTICLE_ID, 'Article ID which we will get data from' );
		$this->addOption( self::OPTION_ARTICLE_ALL, 'If passed it pulls all articles on lyrics.wikia.com; otherwise it pulls edits from yesterday' );
		$this->mDescription = "Crawls through LyricWiki, pulls data from its articles and puts it to our database";
	}

	public function execute() {
		global $wgDWStatsDB;
		$db = $this->getDB( DB_SLAVE, array(), $wgDWStatsDB );
		$this->scrapperFactory = new ScraperFactory( $db );

		if( $this->hasOption( self::OPTION_ARTICLE_ALL ) ) {
			$this->doScrapeAllArticles();
		} else if( ( $articleId = intval( $this->getOption( self::OPTION_ARTICLE_ID, 0 ) ) ) && $articleId > 0 ) {
			$this->setArticleId( $articleId );
			$this->doScrapeArticle();
		} else {
			$this->doScrapeArticlesFromYesterday();
		}
	}

	public function doScrapeAllArticles() {
		$this->output( 'Scraping all articles...' );
	}

	public function doScrapeArticle() {
		$this->output( 'Scraping article #' . $this->getArticleId() . PHP_EOL );
		$article = Article::newFromID( $this->getArticleId() );
		if ( !is_null($article) ) {
			$scraper = $this->scrapperFactory->newFromArticle( $article );
			if ( $scraper ) {
				$scraper->processArticle( $article );
			} else {
				$this->output( 'Unknown article type #' . $this->getArticleId() . PHP_EOL );
			}
		} else {
			$this->output( 'Article not found #' . $this->getArticleId() . PHP_EOL );
		}
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

}

$maintClass = "LyricsWikiCrawler";
require_once( DO_MAINTENANCE );
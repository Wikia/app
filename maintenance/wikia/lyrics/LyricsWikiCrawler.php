<?php

// Composer
require_once( dirname(__FILE__) . '/vendor/autoload.php' );

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
		$params = [
			'hosts' => [
				'10.10.10.242:9200',
			]
		];

		$esClient = new Elasticsearch\Client( $params );

		$this->scrapperFactory = new ScraperFactory( $esClient );

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
		$this->output( 'Scraping all articles...' . PHP_EOL );
		$db = $this->getDB( DB_SLAVE );
		$pagesResult = $db->select(
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

		while ( $page = $db->fetchObject( $pagesResult ) ) {
			$this->setArticleId( $page->page_id );
			$this->doScrapeArticle();
		};
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
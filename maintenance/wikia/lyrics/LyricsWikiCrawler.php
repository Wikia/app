<?php

require_once( dirname(__FILE__) . '/../../Maintenance.php' );

class LyricsWikiCrawler extends Maintenance {
	const OPTION_ARTICLE_ID = 'articleId';
	const OPTION_ARTICLE_ALL = 'all';

	private $articleId = 0;

	public function __construct() {
		parent::__construct();
		$this->addOption( self::OPTION_ARTICLE_ID, 'Article ID which we will get data from' );
		$this->addOption( self::OPTION_ARTICLE_ALL, 'If passed it pulls all articles on lyrics.wikia.com; otherwise it pulls edits from yesterday' );
		$this->mDescription = "Crawls through LyricWiki, pulls data from its articles and puts it to our database";
	}

	public function execute() {
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
		$this->output( 'Scraping article #' . $this->getArticleId() );
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

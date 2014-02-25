<?php

require_once( dirname(__FILE__) . '/../../Maintenance.php' );

class LyricsWikiCrawler extends Maintenance {
	const DB_NAME = '';
	const DB_TABLE = '';

	public function __construct() {
		parent::__construct();
		$this->addOption( 'articleId', 'Article ID which we will get data from' );
		$this->mDescription = "Crawls through LyricWiki, pulls data from its articles and puts it to our database";
	}

	public function execute() {
		$this->output( 'Done.' );
	}

}

$maintClass = "LyricsWikiCrawler";
require_once( DO_MAINTENANCE );

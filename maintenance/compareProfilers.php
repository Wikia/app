<?php

require_once __DIR__ . '/Maintenance.php';

class CompareProfilers extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addOption( 'article', 'article whose content to test', true, true );
	}

	public function execute() {
		global $wgParser;

		$title = Title::newFromText( $this->getOption( 'article' ) );
		$page = WikiPage::factory( $title );

		$content = $page->getText();

		$start = microtime( true );
		$wgParser->preprocessToDom( $content );
		$domTotalMillis = intval( 1000 * ( microtime( true ) - $start ) );

		$wgParser->mPreprocessor = new Preprocessor_Hash( $wgParser );

		$start = microtime( true );
		$wgParser->preprocessToDom( $content );
		$hashTotalMillis = intval( 1000 * ( microtime( true ) - $start ) );

		$this->output( "DOM Preprocessor: $domTotalMillis ms\n" );
		$this->output( "Hash Preprocessor: $hashTotalMillis ms\n" );
	}
}

$maintClass = CompareProfilers::class;
require_once RUN_MAINTENANCE_IF_MAIN;

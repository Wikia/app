<?php

/**
 * Script that allows easy testing of ImageServing indexing feature
 *
 * Use --dry-run option to avoid storing results in database
 *
 * @author macbre
 * @file
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class ImageServingScript extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( "dry-run", "Do not mark any wikis, just list them" );
		$this->addOption( "title", "Title of the page to parse", true );
		$this->mDescription = 'Test ImageServing indexing';
	}

	public function execute() {
		$title = $this->getOption('title');
		$dryRun = $this->hasOption('dry-run');

		$this->output("Parsing '" . $title ."'...");
		$time = microtime(true);

		$title = Title::newFromText($title);
		$article = new Article($title);

		$images = ImageServingHelper::buildAndGetIndex($article, false, $dryRun);

		$time = microtime(true) - $time;
		$this->output(" done in " . round($time, 4) ." sec\n");

		$this->output("\nImages found: " . count($images) . "\n\n");
		$this->output(implode("\n", $images) . "\n");
	}
}

$maintClass = "ImageServingScript";
require_once( RUN_MAINTENANCE_IF_MAIN );

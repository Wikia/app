<?php

/**
 * Script that allows easy debugging of ImageServing indexing feature
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
		$this->addOption( "title", 'Title of the page to parse', true );
		$this->mDescription = 'Debugging script for ImageServing indexing. No results will be stored in database.';
	}

	public function execute() {
		$title = $this->getOption('title');
		$dryRun = true; # don't store results in database

		$this->output("Parsing '" . $title ."'...");
		$time = microtime(true);

		$title = Title::newFromText($title);
		if (!$title->exists()) {
			$this->error('Given title does not exist', 1);
		}

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

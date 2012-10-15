<?php

/**
 * create wiki tester as maintenance script
 */

include( '../../../maintenance/Maintenance.php' );
include( "CreateWiki.php" );


class TestCreateWiki extends Maintenance {

	/**
	 * public constructor
	 */
	public function __construct() {
		parent::__construct();

		$this->mDescription = "Create test wiki";
		$this->addOption( 'domain', 'Maximum number of jobs to run', false, true );
		$this->addOption( 'language', 'Type of job to run', false, true );
		$this->addOption( 'hub', 'Number of processes to use', false, true );
	}

	/**
	 * main entry point
	 */
	public function execute() {

		global $wgDebugLogGroups;

		// just for now for debugging
		$wgDebugLogGroups[ "createwiki" ] = "php://stdout";


		$languages = array( 'en', 'pl', 'de', 'pt-br' );
		shuffle( $languages );

		$types = array( false, "answers" );
		shuffle( $types );

		$createWiki = new CreateWiki(
			"Test Create Wiki", // sitename
			"test20110117", // domain
			array_shift( $languages ), // lang
			1, // hub
			array_shift( $types )
		);
		$createWiki->create( );
	}
}

$maintClass = "TestCreateWiki";
require_once( DO_MAINTENANCE );

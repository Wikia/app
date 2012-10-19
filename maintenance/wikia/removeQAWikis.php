<?php

/**
 * Script that removes QA wikis created by automated tests
 *
 * Use --quiet option when running on cron machines
 *
 * @author macbre
 * @file
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class RemoveQAWikis extends Maintenance {

	const REASON = 'Removed by RemoveQAWikis maintenance script';
	const WIKI_PREFIX = 'qa';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( "dry-run", "Do not remove any wikis, just list them" );
		$this->mDescription = "Remove QA wikis created by automated tests";
	}

	public function execute() {
		global $wgExternalSharedDB;
		$isDryRun = $this->hasOption('dry-run');

		$this->output("Looking for wikis matching '" . self::WIKI_PREFIX ."' prefix...");

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$res = $dbr->select(
			'city_list',
			array(
				'city_dbname',
				'city_url',
				'city_factory_timestamp',
			),
			array(
				'city_dbname ' . $dbr->buildLike( self::WIKI_PREFIX, $dbr->anyString() )
			),
			__METHOD__
		);

		$this->output("\n\n");

		while($wiki = $res->fetchObject()) {
			$this->output("* {$wiki->city_dbname} <{$wiki->city_url}>...");

			$this->output(" done\n");
			//var_dump($wiki);
		}

		$this->output("\nDone!\n");
	}
}

$maintClass = "RemoveQAWikis";
require_once( RUN_MAINTENANCE_IF_MAIN );

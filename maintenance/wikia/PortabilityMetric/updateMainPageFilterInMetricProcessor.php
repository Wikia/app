<?php

/**
 * @ingroup Maintenance
 *
 * @desc For current wiki, find an ID of it's Main Page
 * and push an event marking it as a main page (mainpage_b = true)
 * to MySqlMetricWorker
 * 
 * note: before running this script make sure column mainpage_b is
 * totally clean - it'll help us avoid a situation where Main Page
 * as been moved and we have two pages having mainpage_b = 1
 * on the same wikia
 */

require_once( dirname( __FILE__ ) . '../../../Maintenance.php' );

class updateMainPageFilterInMetricProcessor extends Maintenance {
	private $mySQLEventProducer;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'updateMainPageFilterInMetricProcessor';
	}

	public function execute() {
		$this->mySQLEventProducer = new \Wikia\IndexingPipeline\MySQLMetricEventProducer();
		$mainPageID = (new Wikia\Search\MediaWikiService)->getMainPageArticleId();
		$this->updateMainPageFilter( $mainPageID );
	}

	public function updateMainPageFilter( $mainPageID ) {
		global $wgCityId;

		$this->mySQLEventProducer->send( $mainPageID );

		$this->output( sprintf( "%sUpdating data for wiki_id: %d. Main Page ID: %d.%s", PHP_EOL, $wgCityId, $mainPageID, PHP_EOL ) );
		return true;
	}
}

$maintClass = 'updateMainPageFilterInMetricProcessor';
require_once( RUN_MAINTENANCE_IF_MAIN );

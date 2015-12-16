<?php

/**
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '../../Maintenance.php' );

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

		$this->mySQLEventProducer->send( $mainPageID, null, null );

		$this->output( "\nUpdating data for wiki_id: " . $wgCityId ." done!" );
		return true;
	}
}

$maintClass = 'updateMainPageFilterInMetricProcessor';
require_once( RUN_MAINTENANCE_IF_MAIN );

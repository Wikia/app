<?php

/**
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '../../Maintenance.php' );

class updateMainPageFilterInMetricProcessor extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'updateMainPageFilterInMetricProcessor';
	}

	public function execute() {
		$mainPageID = (new Wikia\Search\MediaWikiService)->getMainPageArticleId();
		$this->updateMainPageFilter( $mainPageID );
	}

	public function updateMainPageFilter( $mainPageID ) {
		global $wgCityId, $wgPortableMetricDB;

		$db = wfGetDB( DB_MASTER, [], $wgPortableMetricDB );
		$result = ( new \WikiaSQL() )
			->UPDATE( 'articlestats' )
			->SET('mainpagefilter_b', 1)
			->WHERE( 'wiki_id' )->EQUAL_TO( $wgCityId )
			->AND_('page_id')->EQUAL_TO( $mainPageID )
			->run( $db );

		$affectedRows = $db->affectedRows();

		if ( $affectedRows === 0 ) {
			print 'Operation failed for wiki_id: ' . $wgCityId;
			return false;
		}

		$this->output( "\nUpdating data for wiki_id: " . $wgCityId ." done!" );
		return true;
	}
}

$maintClass = 'updateMainPageFilterInMetricProcessor';
require_once( RUN_MAINTENANCE_IF_MAIN );

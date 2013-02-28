<?php
/**
 * clearEditCountLocalAllWikis
 * This script deletes records from wikia_user_properties table on all wikis that have property name like 'editcount'
 * After that it will refill during regular usage
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Kamil Koterba
 * 
  */
require_once( __DIR__ . '/../Maintenance.php' );
class clearEditCountLocalAllWikis extends Maintenance {

	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		global $wgExternalSharedDB;
		
		$dbr = wfGetDB (DB_SLAVE);
		$this->currentDB = $dbr->getWikiID();
	
		//get list of all wikis
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$resWiki = $dbr->select(
			array( 'city_list' ),
			array( '*' ),
			array(
				'city_public' => '1'
			),
			__METHOD__
		);

		echo "Number of wikis: ".$resWiki->numRows()."\n";
		$stepsCounter = 0;
		//process each wiki
		foreach ($resWiki as $rowWiki) {
			$DBName = $rowWiki->city_dbname;

			try {

				$dbw = wfGetDB( DB_MASTER, array(), $DBName );

				//clear the table
				$sql = "DELETE FROM wikia_user_properties WHERE wup_property = 'editcount'";
				$prepSql = $dbw->prepare( $sql );
				$res = $dbw->execute( $prepSql );
				$dbw->freePrepared( $prepSql );

				if ( $dbw->getWikiID() != $this->currentDB ) {
					$dbw->close();
				}
				$stepsCounter++;

		        } catch (Exception $e) {
		                echo $e->getMessage(), "\n";
                		continue;
		        }

		}
		echo $stepsCounter;

	}
	
}

$maintClass = "clearEditCountLocalAllWikis";
require_once( RUN_MAINTENANCE_IF_MAIN );

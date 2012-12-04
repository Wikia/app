<?php
/**
 * Purge the SOAPfailures from Special:Soapfailures on LyricWiki.
 *
 * This script is meant to be run approximately every 10 days.
 *
 * @author Sean Colombo
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class TruncateSoapFailures extends Maintenance {
	const TABLE_NAME = "lw_soap_failures";
	const DB_NAME = "lyricwiki";
	
	public function __construct() {
		parent::__construct();
		$this->addDescription("This script will completely truncate the ".$this->TABLE_NAME." table for ".$this->DB_NAME,
				      "It should be run every 10 days via cron to keep the table small enough that it can be ".
				      "used quickly. It can be run any time needed (but it helps us to have a few days of data ".
				      "in there).");
	}
	
	public function execute() {
		$dbw = $this->getDB(DB_MASTER, array(), $this->DB_NAME);
		$res = $dbw->query("TRUNCATE ".$this->TABLE_NAME);
		if(!$res) {
			$this->output("ERROR WHILE TRYING TO TRUNCATE ".$this->DB_NAME.".".$this->TABLE_NAME."\n");
		}
	}

	public function getDbType() {
		return Maintenance::DB_ADMIN;
	}
}

$maintClass = "TruncateSoapFailures";
require_once( RUN_MAINTENANCE_IF_MAIN );
?>
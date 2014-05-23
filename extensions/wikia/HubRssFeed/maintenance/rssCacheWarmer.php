<?php
/**
 * @ingroup Maintenance
 */

echo "Rss cache warmer start: ".date("Y-m-d H:i:s")."\n";

require_once( dirname( __FILE__ ) .'/../../../../maintenance/Maintenance.php' );

class MaintenanceRss extends Maintenance {
	function __construct() {
		parent::__construct();
	}

	function execute() {
		$this->warmTv();
		$this->warmGames();
	}

	function warmTv() {
		echo "| Warming tv cache...\n";
		$tv = new TvRssModel();
		$tv->setForceRegenerateFeed( true );
		$data = $tv->getFeedData();
		$row = reset($data);
		echo "| ". count($data) . " entries,  last from: " . date("Y-m-d H:i:s", $row['timestamp']) . "\n";
	}

	function warmGames() {
		echo "| NOT WARMING GAMES... :( \n";
	}
}

$maintClass = 'MaintenanceRss';
require_once( RUN_MAINTENANCE_IF_MAIN );


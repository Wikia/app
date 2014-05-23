<?php
/**
 * @ingroup Maintenance
 */

echo "Rss cache warmer start: ".date("Y-m-d H:i:s")."\n";

require_once( dirname( __FILE__ ) .'/../../../../maintenance/Maintenance.php' );

class MaintenanceRss extends Maintenance {
	const DATE_FORMAT = 'Y-m-d H:i:s';
	function __construct() {
		parent::__construct();
	}

	function execute() {
		$this->warmTv();
		$this->warmGames();
		$this->removeOldEntries();
	}

	function warmTv() {
		echo "| Warming TV cache...\n";
		$feed = new TvRssModel();
		$feed->setForceRegenerateFeed( true );
		$data = $feed->getFeedData();
		$row = reset($data);
		echo "| Got ". count($data) . " entries,  last from: " . date( self::DATE_FORMAT, $row['timestamp']) . "\n";
	}

	function warmGames() {
		echo "| Warming GAMES cache...\n";
		$feed = new GamesRssModel();
		$feed->setForceRegenerateFeed( true );
		$data = $feed->getFeedData();
		$row = reset($data);
		echo "| Got ". count($data) . " entries,  last from: " . date( self::DATE_FORMAT, $row['timestamp']) . "\n";
	}

	function removeOldEntries() {
		echo "| NOT REMOVING OLD ENTRIES... \n";
	}
}

$maintClass = 'MaintenanceRss';
require_once( RUN_MAINTENANCE_IF_MAIN );


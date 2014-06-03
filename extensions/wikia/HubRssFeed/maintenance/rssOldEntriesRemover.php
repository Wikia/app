<?php
/**
 * Removes all entries from the wikia_rss_feeds that are older than 4 weeks
 *
 * @ingroup Maintenance
 */

echo "Rss old entries remover start: ".date("Y-m-d H:i:s")."\n";

require_once( dirname( __FILE__ ) .'/../../../../maintenance/Maintenance.php' );

class MaintenanceRss extends Maintenance {
	const DAYS_TO_KEEP_OLD_FEED_ITEMS = 28;

	function __construct() {
		parent::__construct();
	}

	function execute() {
		$this->removeOldEntries();
		echo "Rss old entries remover end: ".date("Y-m-d H:i:s")."\n";
	}

	function removeOldEntries() {
		global $wgExternalDatawareDB, $wgHubRssFeeds;
		$prefix= BaseRssModel::getStagingPrefix();

		echo "| REMOVING OLD ENTRIES... \n";

		$db = wfGetDB( DB_MASTER, null, $wgExternalDatawareDB );

		$deleteQuery = "DELETE FROM wikia_rss_feeds "
			. " where wrf_feed IN ( '" .$prefix. implode( '\',\''.$prefix, $wgHubRssFeeds ) ."' ) "
			. " AND wrf_pub_date < (DATE_SUB(CURDATE(), INTERVAL " . self::DAYS_TO_KEEP_OLD_FEED_ITEMS . " DAY))";

		$db->query($deleteQuery);

		$affectedRows = $db->affectedRows();

		if($affectedRows) {
			echo "| " . $affectedRows . " OLD ENTRIES REMOVED \n";
		} else {
			echo "| NO OLD ENTRIES REMOVED \n";
		}
	}
}

$maintClass = 'MaintenanceRss';
require_once( RUN_MAINTENANCE_IF_MAIN );


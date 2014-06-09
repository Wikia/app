<?php
/**
 * @ingroup Maintenance
 */

echo "Rss cache warmer start: " . date("Y-m-d H:i:s") . PHP_EOL;

require_once( dirname( __FILE__ ) .'/../../../../maintenance/Maintenance.php' );

class MaintenanceRss extends Maintenance {
	const DATE_FORMAT = 'Y-m-d H:i:s';
	function __construct() {
		parent::__construct();
	}

	function execute() {
		$this->warm();
		$this->purgeVarnish();
	}

	protected function warm() {
		global $wgHubRssFeeds;

		foreach ( $wgHubRssFeeds as $feedName ) {
			echo "| Warming '$feedName' cache..." . PHP_EOL;
			$feed = BaseRssModel::newFromName( $feedName );
			if ( $feed instanceof BaseRssModel ) {
				$time = time();
				$numRows = $feed->generateFeedData();
				echo "| Got " . $numRows . " new entries " . PHP_EOL;
				\Wikia\Logger\WikiaLogger::instance()
					->info( __CLASS__ . ' '. $feedName . 'time (s): ' . ( time() - $time ) );
			} else {
				echo "| Feed not found: " . $feedName . PHP_EOL;
			}
		}

	}

	public function purgeVarnish() {
		global $wgHubRssFeeds, $wgServer;

		echo "| Purging varnishen..." . PHP_EOL;
		
		$urls = [];

		foreach($wgHubRssFeeds as $feedEndpoint) {
			$urls []= SpecialPage::getTitleFor( HubRssFeedSpecialController::SPECIAL_NAME )->getFullUrl() . '/' . $feedEndpoint;
			$urls []= implode( '/', [ $wgServer, 'rss', $feedEndpoint] );
		}

		$u = new SquidUpdate( $urls );
		$u->doUpdate();
	}
}

$maintClass = 'MaintenanceRss';
require_once( RUN_MAINTENANCE_IF_MAIN );


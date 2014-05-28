<?php
/**
 * @ingroup Maintenance
 */

echo "Rss cache warmer start: ".date("Y-m-d H:i:s")."" . PHP_EOL;

require_once( dirname( __FILE__ ) .'/../../../../maintenance/Maintenance.php' );

class MaintenanceRss extends Maintenance {
	const DATE_FORMAT = 'Y-m-d H:i:s';
	function __construct() {
		parent::__construct();
	}

	function execute() {
		$this->warmTv();
		$this->warmGames();
		$this->purgeVarnish();
	}

	function warmTv() {
		echo "| Warming TV cache..." . PHP_EOL;
		$feed = new TvRssModel();
		$feed->setForceRegenerateFeed( true );
		$data = $feed->getFeedData();
		$row = reset($data);
		echo "| Got ". count($data) . " entries,  last from: " . date( self::DATE_FORMAT, $row['timestamp']) . "" . PHP_EOL;
	}

	function warmGames() {
		echo "| Warming GAMES cache..." . PHP_EOL;
		$feed = new GamesRssModel();
		$feed->setForceRegenerateFeed( true );
		$data = $feed->getFeedData();
		$row = reset($data);
		echo "| Got ". count($data) . " entries,  last from: " . date( self::DATE_FORMAT, $row['timestamp']) . "" . PHP_EOL;
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


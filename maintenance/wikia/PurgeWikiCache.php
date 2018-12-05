<?php

require_once __DIR__ . '/../Maintenance.php';

class PurgeWikiCache extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Purges the WikiFactory and Fastly cache of a single wiki';
	}

	public function execute() {
		global $wgCityId;
		WikiFactory::clearCache( $wgCityId );

		Wikia::purgeSurrogateKey( Wikia::wikiSurrogateKey( $wgCityId ) );
		Wikia::purgeSurrogateKey( Wikia::wikiSurrogateKey( $wgCityId ), 'mercury' );

		$this->output( 'Cache purged!' );
	}
}

$maintClass = 'PurgeWikiCache';
require_once RUN_MAINTENANCE_IF_MAIN;

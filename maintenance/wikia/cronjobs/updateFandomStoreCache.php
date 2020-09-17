<?php

/**
 * Get data from intentX API and update memcache 
 *
 * @group cronjobs
 * @see phrase-alerts.yaml
 *
 * This script should be run for wiki_id 177 where $wgDiscussionAlertsQueries WikiFactory variable is defined
 */

require_once __DIR__ . '/../../Maintenance.php';

class updateFandomStoreCache extends Maintenance {

	public function execute() {
		global $wgFandomShopMap, $wgFandomShopUrl;

		$logger = \Wikia\Logger\WikiaLogger::instance();
        $logger->info( 'Updating Fandom Shop Cache' );
        
        
    }
}

$maintClass = 'updateFandomStoreCache';
require_once RUN_MAINTENANCE_IF_MAIN;

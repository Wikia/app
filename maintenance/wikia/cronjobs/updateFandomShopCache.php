<?php

/**
 * Get data from intentX API and update memcache 
 *
 * @group cronjobs
 * @see update-fandom-shop-cache.yaml
 *
 */

require_once __DIR__ . '/../../Maintenance.php';

class updateFandomStoreCache extends Maintenance {

    public function execute() {
        global $wgFandomShopMap;

        $logger = \Wikia\Logger\WikiaLogger::instance();
        $logger->info( 'Updating Fandom Shop Cache' );

        if ( Wikia::isDevEnv() ) {
            $url = "https://community.chris.fandom-dev.us/wikia.php?controller=DesignSystemApi&method=getFandomShopDataFromIntentX&id=$key";
        } else {
            $url = "https://community.fandom.com/wikia.php?controller=DesignSystemApi&method=getFandomShopDataFromIntentX&id=$key";
        }

        foreach ( $wgFandomShopMap as $key => $value) {
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($handle);
            $allCommunitiesUpdated = true;

            $responseCode   = curl_getinfo($handle, CURLINFO_HTTP_CODE);

            if ( curl_errno($handle) ) {
                print curl_error($handle);
                $logger->error( "There has been an error updating $value shop cache" );
                $allCommunitiesUpdated = false;
            } else {
             if ( $responseCode == "200") {
                echo "The $value community store has been updated.";
             } 
            
                curl_close($handle);
            }
        }

        if ( $allCommunitiesUpdated ) {
            $logger->info( 'All communities have been successfully updated' );
        } else {
            $logger->info( 'Check logs for community that has not been updated' );
        }
    }
}

$maintClass = 'updateFandomShopCache';
require_once RUN_MAINTENANCE_IF_MAIN;

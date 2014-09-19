<?php

/**
 * Maintenance script to cache video views (run every hour).  This script can be run
 * one of three different ways:
 *
 * - Via wikia-maintenance : This will call WikiaTask::work for every wiki in city_list.
 * - Via runOnCluster : This will call WikiTask::run for every wiki in the cluster currently set on runOnCluster
 * - For individual wikis by calling it in the usual way a maintenance script is called.
 *
 * The preferred method is to use runOnCluster when updating all wikis
 *
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 */

// See if we're being run directly or not
$script = preg_replace('!^.*/!', '', $argv[0]);
$file   = preg_replace('!^.*/!', '', __FILE__);

// If we're being run directly from the command line, do some setup
if ( $script == $file ) {
	ini_set( "include_path", dirname( __FILE__ )."/../../../../maintenance/" );
	ini_set('display_errors', 'stderr');

	require_once( "commandLine.inc" );

	if ( isset($options['help']) ) {
		die( "Usage: php maintenance.php [--help]\n".
			"\t--help	This help page\n\n" );
	}

	$dryRun = isset($options['dry-run']);
	$verbose = isset($options['verbose']);

	$app = F::app();
	if ( empty($app->wg->CityId) ) {
		die( "Error: Invalid wiki id." );
	}

	WikiaTask::work($app->wg->CityId, $dryRun, $verbose);
}

/**
 * Class WikiaTask
 *
 * This class is required by wikia-maintenance
 */
class WikiaTask {

	// Keep data for 2 hours
	const VIDEO_VIEW_TTL = 7200;

	/**
	 * This method is expected by the runOnCluster.php script
	 *
	 * @param DatabaseMysql $db Database connection for the current wiki
	 * @param bool $test Whether we are in test mode currently
	 * @param bool $verbose Whether to show verbose output
	 * @param array $params Additional parameters for this method
	 *
	 * @throws Exception
	 */
	public static function run( DatabaseMysql $db, $test = false, $verbose = false, $params ) {
		$dbname = $params['dbname'];

		// Make sure the calls to wfMemcKey() get the right prefix since runOnCluster does not initialize all
		// the wiki specific variables
		global $wgCachePrefix;
		$wgCachePrefix = $dbname;

		// Load the app context
		$app = F::app();
		if ( wfReadOnly() ) {
			throw new Exception( "Error: In read only mode." );
		}

		if ( $verbose ) {
			echo "Caching video views for wiki $dbname ... ";
		}

		$memKeyBase = MediaQueryService::getMemKeyTotalVideoViews();
		$videoListTotal = VideoInfoHelper::getTotalViewsFromDB( $db );
		foreach( $videoListTotal as $memKeyBucket => $list ) {
			if ( $test ) {
				echo "SET $memKeyBase.'-'.$memKeyBucket (".count($list).")\n";
			} else {
				$app->wg->Memc->set( $memKeyBase.'-'.$memKeyBucket, $list, self::VIDEO_VIEW_TTL );
			}
		}

		if ( $verbose ) {
			echo "DONE\n";
		}
	}

	/**
	 * This method is expected by the wikia-maintenance script
	 * @deprecated
	 *
	 * @param int $wiki_id
	 * @param bool $dryRun
	 * @param bool $verbose
	 * @throws Exception
	 */
	public static function work ( $wiki_id, $dryRun = false, $verbose = false ) {
		$app = F::app();
		if ( wfReadOnly() ) {
			throw new Exception( "Error: In read only mode." );
		}

		if ( $verbose ) {
			echo "Caching video views for wiki $wiki_id ... ";
		}

		$memKeyBase = MediaQueryService::getMemKeyTotalVideoViews();
		$videoListTotal = VideoInfoHelper::getTotalViewsFromDB();
		foreach( $videoListTotal as $memKeyBucket => $list ) {
			if ( $dryRun ) {
				echo "SET $memKeyBase.'-'.$memKeyBucket (".count($list).")\n";
			} else {
				$app->wg->Memc->set( $memKeyBase.'-'.$memKeyBucket, $list, self::VIDEO_VIEW_TTL );
			}
		}

		if ( $verbose ) {
			echo "DONE\n";
		}
	}
}

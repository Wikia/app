<?php

/**
 * Maintenance script to cache video views (run every hour).  This script is normally run
 * via wikia-maintenance which will call WikiaTask::work for every wiki in city_list.
 *
 * This script can also be run for an individual wiki by calling it in the usual way
 * a maintenance script is called.
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

	/**
	 * This method is expected by the wikia-maintenance script
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
				$app->wg->Memc->set( $memKeyBase.'-'.$memKeyBucket, $list, 60*60*2 );
			}
		}

		if ( $verbose ) {
			echo "DONE\n";
		}
	}
}

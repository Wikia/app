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
if ($script == $file) {
	ini_set( "include_path", dirname( __FILE__ )."/../../../../maintenance/" );
	ini_set('display_errors', 'stderr');

	require_once( "commandLine.inc" );

	if ( isset($options['help']) ) {
		die( "Usage: php maintenance.php [--help]\n".
			"\t--help	This help page\n\n" );
	}

	$app = F::app();
	if ( empty($app->wg->CityId) ) {
		die( "Error: Invalid wiki id." );
	}

	WikiaTask::work($app->wg->CityId);
}

/**
 * Class WikiaTask
 *
 * This class is required by wikia-maintenance
 */
class WikiaTask {

	/**
	 * Do the work of this script given a wiki ID
	 *
	 * @param int $wiki_id A wiki ID
	 */
	public static function work ( $wiki_id ) {
		$app = F::app();
		if ( wfReadOnly() ) {
			echo "Error: In read only mode.";
			return;
		}

		echo "Wiki $wiki_id\n";

		$db = wfGetDB( DB_MASTER );

		$tableExists = $db->tableExists( 'video_info' );
		if ( !$tableExists ) {
			echo "Error: Table does NOT exist.\n";
			return;
		}

		$memKeyBase = MediaQueryService::getMemKeyTotalVideoViews();
		$videoListTotal = VideoInfoHelper::getTotalViewsFromDB();
		foreach( $videoListTotal as $memKeyBucket => $list ) {
			$app->wg->Memc->set( $memKeyBase.'-'.$memKeyBucket, $list, 60*60*2 );
			//echo "\tCache Key: $memKeyBucket (".count($list).")\n";
		}

		echo "Cached video views....DONE\n";
	}
}

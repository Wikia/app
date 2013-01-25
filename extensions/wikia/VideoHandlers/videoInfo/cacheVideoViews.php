<?php

/**
* Maintenance script to cache video views (run every hour)
* @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
*/

ini_set( "include_path", dirname( __FILE__ )."/../../../../maintenance/" );

require_once( "commandLine.inc" );

if ( isset($options['help']) ) {
	die( "Usage: php maintenance.php [--help]
	--help				you are reading it right now\n\n" );
}

$app = F::app();
if ( empty($app->wg->CityId) ) {
	die( "Error: Invalid wiki id." );
}

if ( $app->wf->ReadOnly() ) {
	die( "Error: In read only mode." );
}

echo "Wiki $wgCityId:\n";

$db = $app->wf->GetDB( DB_MASTER );

$tableExists = $db->tableExists( 'video_info' );
if ( !$tableExists ) {
	die( "Error: Table NOT exist.\n" );
}

$memKeyBase = MediaQueryService::getMemKeyTotalVideoViews();
$videoListTotal = VideoInfoHelper::getTotalViewsFromDB();
foreach( $videoListTotal as $memKeyBucket => $list ) {
	$app->wg->Memc->set( $memKeyBase.'-'.$memKeyBucket, $list, 60*60*2 );
	echo "\tCache Key: $memKeyBucket (".count($list).")\n";
}

echo "Cached video views....DONE\n";
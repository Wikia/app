<?php

/**
* Maintenance script to add video from marketing toolbox
* @author Saipetch Kongkatong
*/

/**
 * get videos by module id
 * @param integer $moduleId
 * @return array $videos
 */
function getHubsV2VideosByModuleId( $moduleId ) {
	$dbr = wfGetDB( DB_SLAVE, array(), F::app()->wg->ExternalSharedDB );

	$result = $dbr->select(
		MarketingToolboxModel::HUBS_TABLE_NAME,
		array(
			'module_data',
			'last_editor_id'
		),
		array(
			'module_id' => $moduleId
		),
		__METHOD__
	);

	$videos = array();
	while ( $row = $dbr->fetchRow( $result ) ) {
		$videos[] = array(
			'lastEditorId' => $row['last_editor_id'],
			'data' => json_decode( $row['module_data'], true )
		);
	}

	return $videos;
}

/**
 * get featured videos
 * @global integer $failed
 * @return array $featuredVideos
 */
function getFeaturedVideos() {
	global $failed;

	$featuredVideos = array();

	$videos = getHubsV2VideosByModuleId( MarketingToolboxModuleFeaturedvideoService::MODULE_ID );
	foreach( $videos as $video ) {
		$title = Title::newFromText( $video['data']['video'], NS_FILE );
		if ( $title instanceof Title ) {
			$featuredVideos[] = array(
				'name' => $video['data']['video'],
				'videoUrl' => rtrim( F::app()->wg->WikiaVideoRepoPath, '/' ).$title->getLocalURL(),
			);
		} else {
			echo "\tVideo: ".$video['data']['video']." .... FAILED (NOT FOUND)\n";
			$failed++;
		}
	}

	return $featuredVideos;
}

/**
 * get popular videos
 * @return array $popularVideos
 */
function getPopularVideos() {
	$popularVideos = array();

	$videos = getHubsV2VideosByModuleId( MarketingToolboxModulePopularvideosService::MODULE_ID );
	foreach( $videos as $video ) {
		if ( !empty( $video['data']['videoUrl'] ) ) {
			$cnt = count( $video['data']['videoUrl'] );
			for( $i=0; $i<$cnt; $i++ ) {
				$popularVideos[] = array(
					'name' => $video['data']['video'][$i],
					'videoUrl' => $video['data']['videoUrl'][$i]
				);
			}
		}
	}
	return $popularVideos;
}

/**
 * add video to wikis
 * @global int $totalRequests
 * @global int $success
 * @global int $failed
 * @param array $videos
 * @param array $wikis
 */
function addVideoToWikis( $videos, $wikis ) {
	global $dryRun, $totalRequests, $success, $failed;

	if ( $dryRun ) {
		echo "\tDRY RUN .... DONE\n";
		return;
	}

	foreach( $videos as $video ) {
		echo "\tVideo: $video[name] ($video[videoUrl]):\n";

		$videoService = new VideoService();
		$response = $videoService->addVideoAcrossWikis( $video['videoUrl'], $wikis );

		foreach( $response as $id => $status ) {
			echo "\t\tWiki $id";
			if ( $status ) {
				echo " .... DONE\n";
				$success++;
			} else {
				echo " .... FAILED\n";
				$failed++;
			}
			$totalRequests++;
		}
	}
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );
ini_set('display_errors', 1);

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php addVIdeoFromMarketingToolbox.php [--help] [--dry-run] [--wikiId=123]
	--dry-run                      dry run
	--wikiId                       specific wiki
	--help                         you are reading it right now\n\n" );
}

if ( empty( $wgCityId ) ) {
	die( "Error: Invalid wiki id." );
}

$user = User::newFromName( 'WikiaBot' );

if ( !( $user instanceof User ) ) {
	die( "Error: Could not get bot user object." );
}

$user->load();
F::app()->wg->User = $user;

$dryRun = isset( $options['dry-run'] );

echo "Base wiki: ".$wgCityId."\n";

if ( isset( $options['wikiId'] ) ) {
	$wiki = WikiFactory::getWikiById( $options['wikiId'] );
	if ( !empty( $wiki ) ) {
		$wikis[$options['wikiId']] = array(
			'u' => $wiki->city_url,
			't' => $wiki->city_title,
			'p' => ( empty($wiki->city_public) ? false : true ),
			'd' => $wiki->city_dbname
		);
	}
} else {
	$wikis = WikiaHubsServicesHelper::getHubsV2Wikis();
}

echo "Hub v2 wikis: ".implode( ',', array_keys( $wikis ) )."\n";

if ( empty( $wikis ) ) {
	echo "NOT found Hub v2 wikis\n";
	exit();
}

$totalRequests = 0;
$success = 0;
$failed = 0;

echo "Hub v2 module id (Featured Videos): ".MarketingToolboxModuleFeaturedvideoService::MODULE_ID."\n";
$featuredVideos = getFeaturedVideos();
addVideoToWikis( $featuredVideos, $wikis );

echo "Hub v2 module id (Popular Videos): ".MarketingToolboxModulePopularvideosService::MODULE_ID."\n";
$popularVideos = getPopularVideos();
addVideoToWikis( $popularVideos, $wikis );

echo 'Total Videos: '.( count($featuredVideos) + count($popularVideos) )." (Featured Videos: ".count($featuredVideos).", Popular Videos: ".count($popularVideos).")\n";
echo "Total hub v2 wikis: ".count($wikis)."\n";
echo "Total requests sent: $totalRequests (Sucess: $success, Failed: $failed).\n\n";

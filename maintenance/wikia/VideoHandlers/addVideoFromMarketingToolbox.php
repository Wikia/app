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
 * add featured videos
 * @global int $failed
 * @param type $videos
 * @param type $wikis
 */
function addFeaturedVideos( $videos, $wikis ) {
	global $failed;

	// get url
	$url = WikiFactory::getVarValueByName( 'wgServer', F::app()->wg->CityId );
	if ( empty( $url ) ) {
		$url = rtrim( F::app()->wg->WikiaVideoRepoPath, '/' );
	}

	// add videos
	foreach( $videos as $video ) {
		$featuredVideos = array();

		$title = Title::newFromText( $video['data']['video'], NS_FILE );
		if ( $title instanceof Title ) {
			setUser( $video['lastEditorId'] );
			echo "\tUser: ".F::app()->wg->User->getId()." (".F::app()->wg->User->getName().")\n";

			$featuredVideos[] = array(
				'name' => $video['data']['video'],
				'videoUrl' => $url.$title->getLocalURL(),
			);

			addVideoToWikis( $featuredVideos, $wikis );
		} else {
			echo "\tUser: ".$video['lastEditorId']."\n";
			echo "\t\tVideo: ".$video['data']['video']." .... FAILED (NOT FOUND)\n";
			$failed++;
		}
	}
}

/**
 * add popular videos
 * @global int $failed
 * @global int $popVideos
 * @param type $videos
 * @param type $wikis
 */
function addPopularVideos( $videos, $wikis ) {
	global $failed, $popVideos;

	foreach( $videos as $video ) {
		if ( !empty( $video['data']['videoUrl'] ) ) {
			$popularVideos = array();

			setUser( $video['lastEditorId'] );
			echo "\tUser: ".F::app()->wg->User->getId()." (".F::app()->wg->User->getName().")\n";

			$cnt = count( $video['data']['videoUrl'] );
			for( $i=0; $i<$cnt; $i++ ) {
				$popularVideos[] = array(
					'name' => $video['data']['video'][$i],
					'videoUrl' => $video['data']['videoUrl'][$i]
				);

				$popVideos++;
			}

			addVideoToWikis( $popularVideos, $wikis );
		} else {
			echo "\tUser: ".$video['lastEditorId']."\n";
			echo "\t\tVideo: ".var_export( $video['data'], TRUE )." .... FAILED (EMPTY videoUrl)\n";
			$failed++;
			$popVideos++;
		}
	}
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
		$wikiIds = array_keys( $wikis );
		$response = array_fill_keys( $wikiIds, true );
	}

	$videoService = new VideoService();

	foreach( $videos as $video ) {
		echo "\t\tVideo: $video[name] ($video[videoUrl]):\n";

		if ( !$dryRun ) {
			$response = $videoService->addVideoAcrossWikis( $video['videoUrl'], $wikis );
		}

		foreach( $response as $id => $status ) {
			echo "\t\t\tWiki $id";
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

/**
 * set user by user Id
 * @param integer $userId
 */
function setUser( $userId ) {
	$user = User::newFromId( $userId );

	if ( !($user instanceof User) ) {
		echo ( "Error: Could not get user object ($userId).\n" );
		$user = User::newFromName( 'WikiaBot' );
		if ( !($user instanceof User) ) {
			die ( "Error: Could not get user object (WikiaBot).\n" );
		}
	}

	$user->load();
	F::app()->wg->User = $user;
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
	die( "Error: Hub v2 wikis NOT found.\n" );
}

$success = 0;
$failed = 0;
$popVideos = 0;

// add featured videos
echo "Hub v2 module id (Featured Videos): ".MarketingToolboxModuleFeaturedvideoService::MODULE_ID."\n";
$featuredVideos = getHubsV2VideosByModuleId( MarketingToolboxModuleFeaturedvideoService::MODULE_ID );
addFeaturedVideos( $featuredVideos, $wikis );
echo "Total requests sent (Featured Videos): ".( count( $featuredVideos ) * count( $wikis ) )." (Success: $success, Failed: $failed).\n\n";

// add popular videos
echo "\nHub v2 module id (Popular Videos): ".MarketingToolboxModulePopularvideosService::MODULE_ID."\n";
$popularVideos = getHubsV2VideosByModuleId( MarketingToolboxModulePopularvideosService::MODULE_ID );
addPopularVideos( $popularVideos, $wikis );

$totalVideos = count( $featuredVideos ) + $popVideos;
echo "Total hub v2 wikis: ".count($wikis)." (".implode( ',', array_keys( $wikis ) ).")"."\n";
echo "Total Videos: $totalVideos (Featured Videos: ".count( $featuredVideos ).", Popular Videos: $popVideos [".count( $popularVideos )." sets]).\n";
echo "Total requests sent: ".( $totalVideos * count( $wikis ) )." (Success: $success, Failed: $failed).\n\n";

<?php

/**
* Maintenance script to collect video data (local and premium videos) and insert into video_info table
* Note: video data come from embedded premium videos, local videos, and related videos (related videos list and global list)
* Default setting: create video_info table, remove deleted videos (local) and add videos
* @author Liz Lee, Saipetch Kongkatong
*/

function addVideo( &$videoList, $titleName ) {
	global $dryrun, $added, $invalid, $duplicate, $dupInDb;

	$videoInfoHelper = new VideoInfoHelper();
	$videoData = $videoInfoHelper->getVideoDataFromTitle( $titleName );
	if ( !empty($videoData) ) {
		printText( $videoData['videoTitle'] );
		$titleHash = md5( $videoData['videoTitle'] );
		if ( !in_array($titleHash, $videoList) ) {
			$status = true;
			if ( !$dryrun ) {
				$videoInfo = new VideoInfo( $videoData );
				$status = $videoInfo->addVideo();
			}

			if ( $status ) {
				$added++;
				printText( "..... ADDED.\n" );
			} else {
				$dupInDb++;
				printText( "..... ALREADY ADDED TO DB.\n" );
			}

			$videoList[] = $titleHash;
		} else {
			$duplicate++;
			printText( "..... ALREADY ADDED.\n" );
		}
	} else {
		$invalid++;
		printText( "$titleName..... INVALID.\n" );
	}
}

function printText( $text ) {
	global $quiet;

	if ( !$quiet ) {
		echo $text;
	}
}

// ------------------------------------------- Main -------------------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../../../maintenance/" );

require_once( "commandLine.inc" );

if ( isset($options['help']) ) {
	die( "Usage: php maintenance.php [--dry-run] [--help]
	--dry-run			dry run
	--quiet				show summary result only
	--createtable		create video_info table
	--altertablev1		update the video_info table to schema v1
	--altertable		update the video_info to schema the given schema version (default VideoInfo::SCHEMA_VERSION)
	--add				add videos
	--remove			remove deleted videos (local)
	--help				you are reading it right now\n\n" );
}

$app = F::app();
if ( empty($app->wg->CityId) ) {
	die( "Error: Invalid wiki id." );
}

if ( wfReadOnly() ) {
	die( "Error: In read only mode." );
}

$dryrun = isset($options['dry-run']);
$quiet = isset($options['quiet']);
$createTable = isset($options['createtable']);
$alterTableV1 = isset($options['altertablev1']);
$addVideos = isset($options['add']);
$removeVideos = isset($options['remove']);

// Set alterTable to 1 if we get the --altertablev1 option
if ( isset($alterTableV1) ) {
	$alterTable = 1;
}

// If we get the altertable option, see if a specific version is given.  If not use the default
if ( isset($options['altertable']) ) {
	$alterTable = is_numeric($options['altertable']) ? $options['altertable'] : VideoInfo::SCHEMA_VERSION;
}

// Default settings if no parameters are given
if ( !$createTable && !$alterTable && !$addVideos && !$removeVideos ) {
	$createTable = true;
	$addVideos = true;
	$removeVideos = true;
}

printText("Wiki $wgCityId:\n");

$db = wfGetDB( DB_MASTER );

$tableExists = $db->tableExists( 'video_info' );

// create table if not exists
if ( ( $removeVideos || $addVideos ) && !$tableExists ) {
	$createTable = true;
}

$total = 0;
$added = 0;
$invalid = 0;
$duplicate = 0;
$dupInDb = 0;
$removed = 0;
$videoList = array();

$video = new VideoInfo();

/**
 * Handle parameter --createtable
 *
 * Create the video_info table
 */
if ( $createTable ) {
	if ( !$dryrun ) {
		if ( !$video->createTableVideoInfo() ) {
			die("Unable to create the video_info table");
		}
	}
	printText("Created video_info table.\n");

	// Stop here if we don't
	if ( $dryrun ) {
		printText("[DRY RUN] The video_info table must exist before performing any other functions, exiting ...");
		exit(0);
	}
}

/**
 * Handle parameter --alterTable
 *
 * Update the schema to the most recent version
 */
if ( $alterTable ) {
	if ( !$dryrun ) {
		$video->alterTableVideoInfo($alterTable);
	}
	printText("Updated video_info table schema (v$alterTable).\n");
}

/**
 * Handle parameter --remove
 *
 * Remove local videos that have already been deleted
 */
if ( $removeVideos ) {
	$sql = <<<SQL
		SELECT video_title
		FROM video_info
		LEFT JOIN image ON video_info.video_title = image.img_name
		WHERE image.img_name is null AND video_info.premium = 0
SQL;

	$result = $db->query( $sql, __METHOD__ );

	while ( $row = $db->fetchObject($result) ) {
		printText( "Deleted video (local): $row->video_title" );
		if ( !$dryrun ) {
			$video->setVideoTitle( $row->video_title );
			$video->deleteVideo();
		}
		printText( "..... DELETED.\n" );
		$removed++;
	}

	echo "Total deleted videos removed: $removed\n";
}

/**
 * Handle parameter --add
 *
 * Add videos to the video_info table that are already on the wiki
 */
if ( $addVideos ) {
	// get embedded videos (premium)
	$excludeList = array( 'png', 'gif', 'bmp', 'jpg', 'jpeg', 'ogg', 'ico', 'svg', 'mp3', 'wav', 'midi' );
	$sqlWhere = implode( "','", $excludeList );

	$sql = <<<SQL
		SELECT  il_to as name
		FROM `imagelinks`
		WHERE NOT EXISTS ( SELECT 1 FROM image WHERE img_media_type = 'VIDEO' AND img_name = il_to )
			AND LOWER(il_to) != 'placeholder'
			AND LOWER(SUBSTRING_INDEX(il_to, '.', -1)) NOT IN ( '$sqlWhere' )
SQL;

	$result = $db->query( $sql, __METHOD__ );

	while ( $row = $db->fetchObject($result) ) {
		printText( "Embedded Video: " );
		addVideo( $videoList, $row->name );
		$total++;
	}

	// get local videos
	$result = $db->select(
		array( 'image' ),
		array( 'img_name as name' ),
		array( 'img_media_type' => 'VIDEO' ),
		__METHOD__
	);

	while ( $row = $db->fetchObject($result) ) {
		printText( "Local Video: " );
		addVideo( $videoList, $row->name );
		$total++;
	}

	// get related videos - RelatedVideos Articles
	$result = $db->select(
		array( 'page' ),
		array( 'page_title' ),
		array(
			'page_namespace' => NS_RELATED_VIDEOS
		),
		__METHOD__
	);

	while ( $row = $db->fetchObject($result) ) {
		printText( "RelatedVideos Article: $row->page_title\n" );

		$title = Title::newFromText( $row->page_title, NS_RELATED_VIDEOS );
		$relatedVideosNSData = RelatedVideosNamespaceData::newFromTitle( $title );
		$data = $relatedVideosNSData->getData();
		foreach ( $data['lists']['WHITELIST'] as $v ) {
			printText( 'NS'.NS_RELATED_VIDEOS.": " );

			addVideo( $videoList, $v['title'] );
			$total++;
		}
	}

	// get related videos - Global list
	$relatedVideosNSData = RelatedVideosNamespaceData::newFromGeneralMessage();
	printText( "MediaWiki:RelatedVideosGlobalList\n" );
	if ( !empty($relatedVideosNSData) ) {
		$data = $relatedVideosNSData->getData();
		foreach ( $data['lists']['WHITELIST'] as $v ) {
			printText( "GlobalList: " );

			addVideo( $videoList, $v['title'] );
			$total++;
		}
	}

	echo "Wiki $wgCityId: TOTAL: $total, ADDED: $added, DUPLICATE: $duplicate, DUPLICATE IN DB: $dupInDb, INVALID: $invalid\n";
}

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
	--altertablev1		alter video_info table v1
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

$dryrun = ( isset($options['dry-run']) );
$quiet = ( isset($options['quiet']) );
$createTable = ( isset($options['createtable']) );
$alterTableV1 = ( isset($options['altertablev1']) );
$addVideos = ( isset($options['add']) );
$removeVideos = ( isset($options['remove']) );

// default setting
if ( !$createTable && !$alterTableV1 && !$addVideos && !$removeVideos ) {
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

// create table or patch table schema
if ( $createTable ) {
	if ( !$dryrun ) {
		$video->createTableVideoInfo();
	}
	printText("Create video_info table.\n");
}

// update schema v1
if ( $alterTableV1 ) {
	if ( !$dryrun ) {
		$video->alterTableVideoInfoV1();
	}
	printText("Update video_info table schema (v1).\n");
}

// remove deleted local videos
if ( $removeVideos && $tableExists ) {
	$sql = <<<SQL
		SELECT video_title
		FROM video_info
		LEFT JOIN image ON video_info.video_title = image.img_name
		WHERE image.img_name is null AND video_info.premium = 0
SQL;

	$result = $db->query( $sql, __METHOD__ );

	while( $row = $db->fetchObject($result) ) {
		printText( "Deleted video (local): $row->video_title" );
		if ( !$dryrun ) {
			$video->setVideoTitle( $row->video_title );
			$video->deleteVideo();
		}
		printText( "..... DELETED.\n" );
		$removed++;
	}
}

// add videos
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

	while( $row = $db->fetchObject($result) ) {
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

	while( $row = $db->fetchObject($result) ) {
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

	while( $row = $db->fetchObject($result) ) {
		printText( "RelatedVideos Article: $row->page_title\n" );

		$title = Title::newFromText( $row->page_title, NS_RELATED_VIDEOS );
		$relatedVideosNSData = RelatedVideosNamespaceData::newFromTitle( $title );
		$data = $relatedVideosNSData->getData();
		foreach( $data['lists']['WHITELIST'] as $v ) {
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
		foreach( $data['lists']['WHITELIST'] as $v ) {
			printText( "GlobalList: " );

			addVideo( $videoList, $v['title'] );
			$total++;
		}
	}

	echo "Wiki $wgCityId: TOTAL: $total, ADDED: $added, DUPLICATE: $duplicate, DUPLICATE IN DB: $dupInDb, INVALID: $invalid\n";
}

if ( $removeVideos ) {
	echo "Total removed deleted videos: $removed\n";
}
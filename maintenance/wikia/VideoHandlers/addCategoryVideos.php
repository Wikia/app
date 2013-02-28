<?php

	/**
	* Maintenance script to add Category:Videos to file page for premium videos
	* This is one time use script
	* @author Saipetch Kongkatong
	*/

	ini_set( "include_path", dirname( __FILE__ )."/../../" );
	ini_set('display_errors', 1);

	require_once( "commandLine.inc" );

	if ( isset($options['help']) ) {
		die( "Usage: php maintenance.php [--help] [--dry-run]
		--dry-run                      dry run
		--help                         you are reading it right now\n\n" );
	}

	$dryRun = ( isset($options['dry-run']) );

	if ( empty($wgCityId) ) {
		die( "Error: Invalid wiki id." );
	}

	echo "Wiki: $wgCityId\n";

	try {
		$db = wfGetDB( DB_SLAVE );
	} catch (Exception $e) {
		die( "Error: Could not connect to database: ".$e->getMessage()."\n" );
	}

	if ( !$db->tableExists( 'video_info' ) ) {
		die( "Error: video_info table NOT found." );
	}

	$result = $db->select(
		array( 'video_info' ),
		array( 'video_title' ),
		array( 'premium' => 1 ),
		__METHOD__
	);

	$counter = 1;
	$success = 0;
	$total = $result->numRows();
	$botUser = User::newFromName( 'WikiaBot' );
	while ( $result && $row = $db->fetchRow( $result ) ) {
		echo "\t[$counter of $total] Title:".$row['video_title'];

		if ( $dryRun ) {
			$status = Status::newGood();
		} else {
			$videoHandlerHelper = new VideoHandlerHelper();
			$status = $videoHandlerHelper->addCategoryVideos( $row['video_title'], $botUser );
		}

		if ( !$status instanceof Status) {
			echo "...FAILED (Title not found or Category:Videos exists).\n";
		} else if ( $status->isOK() ) {
			$success++;
			echo "...DONE.\n";
		} else {
			echo "...FAILED (".$status->getMessage().").\n";
		}

		$counter++;
	}

	$db->freeResult($result);

	echo "Total videos: $total, Success: $success\n\n";

<?php

	/**
	* Maintenance script to get number of RelatedVideos (NS 1100) articles on the wiki with wgRelatedVideosPartialRelease = false
	* This is one time use script
	* @author Saipetch Kongkatong
	*/

	ini_set( "include_path", dirname( __FILE__ )."/../" );

	require_once( "commandLine.inc" );

	$getTotalRV = ( isset($options['getTotalRV']) );
	$setupVideoInfo = ( isset($options['setupVideoInfo']) );
	$dryRun = ( isset($options['dry-run']) );

	if ( isset($options['help']) ) {
		die( "Usage: php maintenance.php [--help] [--getTotalRV] [--setupVideoInfo]
		--getTotalRV             get total number of RelatedVideo articles
		--setupVideoInfo         set up video info table
		--dry-run                dry run
		--help                   you are reading it right now\n\n" );
	}

	$app = F::app();
	if ( empty($app->wg->CityId) ) {
		die( "Error: Invalid wiki id." );
	}

	echo "Base wiki: ".$app->wg->CityId."\n";

	// get var id
	$var = WikiFactory::getVarByName( 'wgRelatedVideosPartialRelease', $app->wg->CityId );
	echo "wgRelatedVideosPartialRelease ID: ".$var->cv_id."\n";

	// get list of wikis with wgRelatedVideosPartialRelease = false
	$wikis = WikiFactory::getListOfWikisWithVar( $var->cv_id, 'bool', '=' , false, true );
	$total = count( $wikis );
	echo "Total wikis (wgRelatedVideosPartialRelease = false): ".$total."\n";

	$counter = 0;
	$failed = 0;

	foreach( $wikis as $wikiId => $detail ) {
		echo "[$counter of $total] Wiki $wikiId ";
		$wiki = WikiFactory::getWikiById( $wikiId );
		if ( !empty($wiki) && $wiki->city_public == 1 ) {
			$dbname = $wiki->city_dbname;

			echo "($dbname): \n";

			// get number of RelatedVideos articles on the wiki
			if ( $getTotalRV ) {
				$db = $app->wf->GetDB( DB_SLAVE, array(), $dbname );

				$row = $db->selectRow(
					array( 'page' ),
					array( 'count(*) cnt' ),
					array(
						'page_namespace' => 1100
					),
					__METHOD__,
					array(
						'GROUP BY' => 'page_namespace'
					)
				);

				$cnt = ( $row ) ? $row->cnt : 0 ;
				echo "\tTotal RelatedVideos articles (NS1100): $cnt\n";
			}

			// set up video info
			if ( $setupVideoInfo ) {
				$file = dirname( __FILE__ ).'/../../extensions/wikia/VideoHandlers/videoInfo/maintenance.php';
				$cmd = "SERVER_ID={$wikiId} php {$file} --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php";
				if ( $dryRun ) {
					$cmd .= " --dry-run";
				}
				echo "\tCommand: $cmd\n";
				$result = wfShellExec( $cmd, $retval );
				if ( $retval ) {
					echo "Error code $retval: $result \n";
				} else {
					echo "$result \n";
				}
			}
		} else {
			echo "......... NOT FOUND or CLOSED\n";
			$failed++;
		}

		$counter++;
	}

	echo "Total Wikis: ".$counter.", Success: ".($counter-$failed).", Failed: $failed\n\n";
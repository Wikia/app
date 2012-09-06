<?php

	/**
	* Maintenance script to get number of RelatedVideos (NS 1100) articles on the wiki with wgRelatedVideosPartialRelease = false
	* This is one time use script
	* @author Saipetch Kongkatong
	*/

	ini_set( "include_path", dirname( __FILE__ )."/../" );

	require_once( "commandLine.inc" );

	if ( isset($options['help']) ) {
		die( "Usage: php maintenance.php [--help]
		--help				you are reading it right now\n\n" );
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

	// get number of RelatedVideos articles on the wiki
	foreach( $wikis as $wikiId => $detail ) {
		echo "[$counter of $total] Wiki $wikiId ";
		$wiki = WikiFactory::getWikiById( $wikiId );
		if ( !empty($wiki) && $wiki->city_public == 1 ) {
			$dbname = $wiki->city_dbname;

			echo "($dbname): ";

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
			echo "$cnt\n";
		} else {
			echo "......... NOT FOUND or CLOSED\n";
			$failed++;
		}

		$counter++;
	}

	echo "TOTAL: ".$counter.", SUCCESS: ".($counter-$failed).", FAILED: $failed\n\n";
<?php

	/**
	* Maintenance script to copy videos from RelatedVideos Articles (NS1100) to GlobalList
	* This is one time use script
	* @author Saipetch Kongkatong
	*/

	function printText( $text ) {
		global $quiet;

		if ( !$quiet ) {
			echo $text;
		}
	}

	// ----------------------------- Main ------------------------------------

	ini_set( "include_path", dirname( __FILE__ )."/../" );

	require_once( "commandLine.inc" );

	if ( isset($options['help']) ) {
		die( "Usage: php maintenance.php [--help] [--dry-run] [--quiet]
		--dry-run                      dry run
		--quiet                        show summary result only
		--help                         you are reading it right now\n\n" );
	}

	$dryRun = ( isset($options['dry-run']) );
	$quiet = ( isset($options['quiet']) );

	if ( empty($wgCityId) ) {
		die( "Error: Invalid wiki id." );
	}

	echo "Wiki: ".$wgCityId;

	$wiki = WikiFactory::getWikiById( $wgCityId );
	if ( !empty($wiki) && $wiki->city_public == 1 ) {
		$dbname = $wiki->city_dbname;

		echo " ($dbname): \n";

		$total = 0;
		$add = 0;
		$dup = 0;

		$user = User::newFromName('WikiaBot');
		$markers = array( RelatedVideosNamespaceData::WHITELIST_MARKER, RelatedVideosNamespaceData::BLACKLIST_MARKER );

		echo "GlobalList: \n";
		$globalList = RelatedVideosNamespaceData::newFromGeneralMessage();

		// get all global videos
		$globalVideos = array();
		if ( empty($globalList) && $globalList->exists() ) {
			$globalList = RelatedVideosNamespaceData::createGlobalList();
		} else {
			$globalData = $globalList->getData();

			foreach( $markers as $marker ) {
				foreach( $globalData['lists'][$marker] as $video ) {
					$globalVideos[] = $video['title'];
				}
				echo "\tTotal $marker videos: ".count($globalData['lists'][$marker])."\n";
			}
		}

		// get RelatedVideos articles
		$db = wfGetDB( DB_SLAVE, array(), $dbname );

		$result = $db->select(
			array( 'page' ),
			array( 'page_id', 'page_title' ),
			array(
				'page_namespace' => 1100
			),
			__METHOD__
		);

		while ( $row = $db->fetchObject($result) ) {
			echo "Article: $row->page_title\n";

			$title = Title::newFromText( $row->page_title, NS_RELATED_VIDEOS );
			$relatedVideoList = RelatedVideosNamespaceData::newFromTitle( $title );
			if ( !empty($relatedVideoList) && $relatedVideoList->exists() ) {
				$totalNewVideos = 0;
				$videoData = $relatedVideoList->getData();

				// get videos from RelatedVideos article
				foreach( $markers as $marker ) {
					echo "$marker: \n";

					$videoList = array();
					foreach( $videoData['lists'][$marker] as $video ) {
						// check if video is duplicate
						if ( !in_array($video['title'], $globalVideos) ) {
							printText( "\tNEW: $video[title]\n" );

							$videoList[] = $video;
							$globalVideos[] = $video['title'];
							$add++;
						} else {
							printText( "\tDUPLICATE: $video[title]\n" );
							$dup++;
						}

						$total++;
					}

					echo "\tTotal $marker: ".count( $videoData['lists'][$marker] ).", New: ".count( $videoList )."\n";

					if ( !empty($videoList) ) {
						if ( !empty($globalData['lists'][$marker]) ) {
							$globalData['lists'][$marker] = array_merge( $globalData['lists'][$marker], $videoList );
						} else {
							$globalData['lists'][$marker] = $videoList;
						}

						$totalNewVideos += count( $videoList );
					}
				}

				// edit GlobalList
				if ( !empty($totalNewVideos) ) {
					$content = '';
					if ( is_array($globalData['lists']) ) {
						foreach( $markers as $marker ) {
							if ( !empty($globalData['lists'][$marker]) ) {
								$content .= $marker."\n\n";
								$content .= $globalList->serializeList( $globalData['lists'][$marker] );
							}
						}
					}

					$summary = "Move related videos from {$title->getText()} to GlobalList";
					$title = Title::newFromText( RelatedVideosNamespaceData::GLOBAL_RV_LIST, NS_MEDIAWIKI );
					$article = new Article( $title );
					if ( !$dryRun ) {
						$status = $article->doEdit( $content, $summary, EDIT_UPDATE, false, $user );
						if ( is_object($status) && $status->ok ) {
							echo "\tTotal $totalNewVideos videos ..... ADDED.\n";
						} else {
							echo "\tERROR: ".$status->getMessage()."\n";
						}

						$globalList->purge();	// probably unnecessary b/c a hook does this, but can't hurt
					} else {
						echo "\tTotal $totalNewVideos videos ..... ADDED.\n";
					}
				}
			}
		}
	} else {
		echo " ..... INVALID.\n";
	}

	echo "Total Videos: ".$total.", Added: ".$add.", Duplicate: $dup\n\n";
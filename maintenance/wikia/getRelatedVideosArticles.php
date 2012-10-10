<?php

	/**
	* Maintenance script to get number of RelatedVideos (NS 1100) articles on the wiki with wgRelatedVideosPartialRelease = false
	* This is one time use script
	* @author Saipetch Kongkatong
	*/

	/**
	 * get number of RelatedVideos articles on the wiki
	 * @param string $dbname
	 */
	function getTotalRV( $dbname ) {
		$db = wfGetDB( DB_SLAVE, array(), $dbname );

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

	/**
	 * set up video info
	 * @global boolean $dryRun
	 * @global boolean $quiet
	 * @param integer $wikiId 
	 */
	function setupVideoInfo( $wikiId ) {
		global $dryRun, $quiet;

		$file = dirname( __FILE__ ).'/../../extensions/wikia/VideoHandlers/videoInfo/maintenance.php';
		$cmd = "SERVER_ID={$wikiId} php {$file} --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php";
		if ( $dryRun ) {
			$cmd .= " --dry-run";
		}
		if ( $quiet ) {
			$cmd .= " --quiet";
		}
		echo "\tCommand: $cmd\n";
		$result = wfShellExec( $cmd, $retval );
		if ( $retval ) {
			echo "Error code $retval: $result \n";
		} else {
			echo "$result \n";
		}
	}

	/**
	 * enable Special Video Ext
	 * @param integer $wikiId 
	 */
	function enableSpecialVideosExt( $wikiId ) {
		echo "Enable Special Videos Ext:\n";
		$feature = 'wgEnableSpecialVideosExt';
		$wgValue = WikiFactory::getVarByName( $feature, $wikiId );
		if ( empty($wgValue) ) {
			echo "\tError invalid params. \n";
		} else {
			WikiFactory::setVarByName( $feature, $wikiId, true, "enable Special Videos Ext for wikis that enable Related Videos" );
			WikiFactory::clearCache( $wikiId );
			echo "\tUpdate $feature from ".var_export( unserialize($wgValue->cv_value), true )." to true. \n";
		}
	}

	/**
	 * copy videos from RelatedVideos articles to GlobalList
	 * @param string $dbname
	 */
	function copyRVtoGlobalList( $dbname ) {
		global $dryRun;

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
						} else {
							printText( "\tDUPLICATE: $video[title]\n" );
						}
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

	}

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
		die( "Usage: php maintenance.php [--help] [--getTotalRV] [--setupVideoInfo] [--enableSpecialVideosExt] [--copyRVtoGlobalList]
		--getTotalRV                   get total number of RelatedVideo articles
		--setupVideoInfo               set up video info table
		--enableSpecialVideosExt       enable Special Video Ext
		--copyRVtoGlobalList           copy videos from RelatedVideo articles to GlabalList
		--dry-run                      dry run (for setupVideoInfo, copyRVtoGlobalList)
		--quiet                        show summary result only (for setupVideoInfo, copyRVtoGlobalList)
		--help                         you are reading it right now\n\n" );
	}

	$getTotalRV = ( isset($options['getTotalRV']) );
	$setupVideoInfo = ( isset($options['setupVideoInfo']) );
	$enableSpecialVideosExt = ( isset($options['enableSpecialVideosExt']) );
	$dryRun = ( isset($options['dry-run']) );
	$quiet = ( isset($options['quiet']) );
	$copyRVtoGlobalList = ( isset($options['copyRVtoGlobalList']) );

	if ( empty($wgCityId) ) {
		die( "Error: Invalid wiki id." );
	}

	echo "Base wiki: ".$wgCityId."\n";

	// get var id
	$var = WikiFactory::getVarByName( 'wgRelatedVideosPartialRelease', $wgCityId );
	echo "wgRelatedVideosPartialRelease ID: ".$var->cv_id."\n";

	// get list of wikis with wgRelatedVideosPartialRelease = false
	$wikis = WikiFactory::getListOfWikisWithVar( $var->cv_id, 'bool', '=' , false, true );
	$total = count( $wikis );
	echo "Total wikis (wgRelatedVideosPartialRelease = false): ".$total."\n";

	$counter = 0;
	$failed = 0;

	foreach( $wikis as $wikiId => $detail ) {
		$counter++;
		echo "[$counter of $total] Wiki $wikiId ";
		$wiki = WikiFactory::getWikiById( $wikiId );
		if ( !empty($wiki) && $wiki->city_public == 1 ) {
			$dbname = $wiki->city_dbname;

			echo "($dbname): \n";

			// get number of RelatedVideos articles on the wiki
			if ( $getTotalRV ) {
				getTotalRV( $dbname );
			}

			// set up video info
			if ( $setupVideoInfo ) {
				setupVideoInfo( $wikiId );
			}

			// enable Special Video Ext
			if ( $enableSpecialVideosExt ) {
				enableSpecialVideosExt( $wikiId );
			}

			// copy videos from RelatedVideos articles to GlobalList
			if ( $copyRVtoGlobalList ) {
				copyRVtoGlobalList( $dbname );
			}
		} else {
			echo "......... NOT FOUND or CLOSED\n";
			$failed++;
		}
	}

	echo "Total Wikis: ".$counter.", Success: ".($counter-$failed).", Failed: $failed\n\n";
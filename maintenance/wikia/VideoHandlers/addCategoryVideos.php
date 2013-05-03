<?php

/**
* Maintenance script to add video category to file page for premium videos
* This is one time use script
* @author Saipetch Kongkatong
*/

$script = preg_replace( '!^.*/!', '', $argv[0] );
$file   = preg_replace( '!^.*/!', '', __FILE__ );

if ( $script == $file ) {
	ini_set( "include_path", dirname( __FILE__ )."/../../" );
	ini_set( 'display_errors', 'stderr' );

	require_once( "commandLine.inc" );

	if ( isset($options['help']) ) {
		die( "Usage: php maintenance.php [--help] [--dry-run]
		--dry-run                      dry run
		--help                         you are reading it right now\n\n" );
	}

	$dryRun = ( isset($options['dry-run']) );

	$app = F::app();

	if ( empty($app->wg->CityId) ) {
		die( "Error: Invalid wiki id." );
	}

	WikiaTask::work( $app->wg->CityId, $dryRun );
}

class WikiaTask {

	public static function work ( $wiki_id, $dryRun ) {
		$app = F::app();

		echo "Wiki $wiki_id\n";

		if ( wfReadOnly() ) {
			die( "Error: In read only mode.\n" );
		}

		try {
			$db = wfGetDB( DB_SLAVE );
		} catch ( Exception $e ) {
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
		$categoryExists = 0;
		$failed = 0;
		$total = $result->numRows();
		if ( $total ) {
			$botUser = User::newFromName( 'WikiaBot' );
			$content = '[['.WikiaFileHelper::getVideosCategory().']]';
			while ( $result && $row = $db->fetchRow( $result ) ) {
				echo "\tWiki $wiki_id: [$counter of $total] Title:".$row['video_title'];

				$title = Title::newFromText( $row['video_title'], NS_FILE );
				if ( $title instanceof Title ) {
					$status = Status::newGood();
					if ( $title->exists() ) {
						$article = Article::newFromID( $title->getArticleID() );
						$oldContent = $article->getContent();
						if ( !strstr($oldContent, $content) ) {
							$content = $oldContent.$content;
							if ( !$dryRun ) {
								$status = $article->doEdit( $content, 'added video category', EDIT_UPDATE | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $botUser );
							}
						} else {
							$failed++;
							$categoryExists++;
							$status = null;
							echo "...FAILED (video category exists).\n";
						}
					} else {
						$article = new Article( $title );
						if ( !$dryRun ) {
							$status = $article->doEdit( $content, 'created video', EDIT_NEW | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $botUser );
						}
					}

					if ( $status instanceof Status ) {
						if ( $status->isOK() ) {
							$success++;
							echo "...DONE.\n";
						} else {
							$failed++;
							echo "...FAILED (".$status->getMessage().").\n";
						}
					}
				} else {
					$failed++;
					echo "...FAILED (Title not found).\n";
				}

				$counter++;
			}
		}

		$db->freeResult($result);

		echo "Wiki $wiki_id: Total videos: $total, Success: $success, Failed: $failed (Video category exists: $categoryExists)\n\n";
	}

}
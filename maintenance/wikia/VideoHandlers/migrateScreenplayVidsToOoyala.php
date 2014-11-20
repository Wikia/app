<?php

/**
 * migrateScreenplayVidsToOoyala
 *
 * This script migrates all Screenplay videos which are currently hosted on Screenplay's servers
 * onto Ooyala and updates the corresponding fields in our databases to mark the change.
 *
 * @author james@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );


/**
 * Class MigrateScreenplayVidsToOoyala
 */
class MigrateScreenplayVidsToOoyala extends Maintenance {

	const BATCH_SIZE = 10000;
	const OOOYALA_CAT = '[[Category:Ooyala]]';
	const EDIT_MESSAGE = 'Added category Ooyala';

	private $migratedVideos = 0;
	private $skippedVideos = 0;
	private $verbose = false;
	private $dryRun = false;
	private $limit;

	public function __construct() {

		parent::__construct();
		$this->mDescription = "Migrate Screenplay videos onto Ooyala";
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'dryRun', 'Do a test run of the script without making changes', false, false, 'd' );
		$this->addOption( 'limit', 'The number of videos to migrate', false, true, 'l' );
	}

	public function execute() {
		$this->verbose = $this->hasOption( "verbose" );
		$this->dryRun = $this->hasOption( "dryRun" );
		$this->limit =  $this->getOption( "limit", self::BATCH_SIZE );

		$titles = $this->getScreenplayTitles();
		$ooyalaAsset = new OoyalaAsset();

		if ( $this->dryRun ) {
			echo "Dry run...\n";
		}

		foreach ( $titles as $title ) {

			$videoFile = WikiaFileHelper::getVideoFileFromTitle( $title );
			if ( empty( $videoFile ) ) {
				$this->log( "Skipping video '$title' -- couldn't find video file" );
				$this->skippedVideos++;
				continue;
			}

			$ooyalaData = $this->prepForOoyala( $videoFile );
			if ( $this->dryRun ) {
				echo "Ready to migrate video " . $videoFile->getName() . " to Ooyala with the following data:\n";
				print_r( $ooyalaData );
				$success = true;
				$videoId = "TestID";
			} else {
				// $videoId gets set in addRemoteAsset()
				$success = $ooyalaAsset->addRemoteAsset( $ooyalaData, $videoId );
			}

			if ( !$success ) {
				$this->log( "Error uploading video {$ooyalaData['assetTitle']} onto Ooyala. Skipping update locally");
				$this->skippedVideos++;
				continue;
			}

			$localData = $this->prepForLocal( $videoFile, $ooyalaData, $videoId );
			if ( $this->dryRun ) {
				echo "Ready to update video " . $videoFile->getName() . " locally with the following new metadata\n";
				print_r( unserialize( $localData ) );
			} else {
				$this->updateVideoLocally( $videoFile, $localData, $videoId );
			}
			$this->migratedVideos++;
		}

		$this->printSummary();
	}

	/**
	 * Add the required information needed to have the screenplay uploaded on Ooyala.
	 * This adds missing information, and runs the metadata through generateRemoteAsset
	 * method of the screenplay ingester as if it were being ingested
	 * @param $videoFile File
	 * @return array
	 */
	private function prepForOoyala( $videoFile ) {

		$metadata = unserialize( $videoFile->getMetadata() );
		$metadata['thumbnail'] = $videoFile->getThumbUrl();
		$metadata['pageCategories'] = $this->getPageCategories( $videoFile->getTitle() );
		$metadata['destinationTitle'] = $videoFile->getTitle()->getText();
		$metadata['provider'] = 'screenplay';

		$screenPlayIngester = new ScreenplayFeedIngester();
		$metadata = $screenPlayIngester->prepareMetaDataForOoyala( $videoFile->getTitle()->getText(), $metadata );

		return $metadata;
	}

	/**
	 * Updated the metadata blob associated with the screenplay video. This normalizes
	 * the information there to replicate if the video had been ingested from Ooyala
	 * by adding, removing, and changing fields. Some of the data neede we've already
	 * collected as a part of ooyalaData, so pass that in so we can reuse those values.
	 * @param $videoFile
	 * @param $ooyalaData
	 * @param $videoId
	 * @return string
	 */
	private function prepForLocal( $videoFile, $ooyalaData, $videoId ) {

		$metadata = unserialize( $videoFile->getMetadata() );

		// Add missing fields
		$metadata['source'] = 'screenplay';
		$metadata['sourceId'] = $metadata['videoId'];
		$metadata['pageCategories'] = $ooyalaData['pageCategories'];

		// Removed unneeded fields
		unset( $metadata['streamUrl'] );
		unset( $metadata['streamHdUrl'] );
		unset( $metadata['stdBitrateCode'] );
		unset( $metadata['jpegBitrateCode'] );

		// Change existing fields
		$metadata['provider'] = 'ooyala/screenplay';
		$metadata['thumbnail'] = $ooyalaData['thumbnail'];
		$metadata['videoId'] = $videoId;

		return serialize( $metadata );
	}

	/**
	 * Get a list of screenplay titles to migrate to ooyala
	 * @return array
	 */
	private function getScreenplayTitles(){

		$db = wfGetDB( DB_SLAVE );
		$titles = ( new WikiaSQL() )->SELECT( "video_title" )
			->FROM("video_info")
			->WHERE( "provider" )->EQUAL_TO( "screenplay" )
			->LIMIT( $this->limit )
			->runLoop( $db, function ( &$titles, $row ) {
				$titles[] = $row->video_title;
			});

		return $titles;
	}

	/**
	 * Returns a string of categories associated with this video, separated by a comma
	 * and a space.
	 * @param $title Title
	 * @return string
	 */
	private function getPageCategories( $title ) {

		$pageCatgories = "";
		foreach ( $title->getParentCategories() as $category => $filePage ) {
			$pageCatgories .= preg_replace( '/^Category:/', '', $category ) . ", ";
		}
		$pageCatgories = preg_replace( '/, $/', '', $pageCatgories );

		return $pageCatgories;
	}

	/**
	 * Updates the video on video.wikia.com, making note of the new
	 * videoId, provider, and img_minor_mime. This will ensure that
	 * these videos will now be played through Ooyala as opposed to
	 * Screenplay.
	 * @param $videoFile File
	 * @param $metadata String
	 * @param $videoId String
	 */
	private function updateVideoLocally( $videoFile, $metadata, $videoId ) {

		$db = wfGetDB( DB_MASTER );
		$db->begin();
		$db->update( 'image',
			[ 'img_metadata' => $metadata, 'img_minor_mime' => 'ooyala' ],
			[ 'img_name' => $videoFile->getName() ] );
		$db->update( 'video_info',
			[ 'video_id' => $videoId, 'provider' => 'ooyala', ],
			[ 'video_title' => $videoFile->getName() ] );
		$db->commit();
		$this->updatePageCategory( $videoFile );

		$videoFile->purgeEverything();
	}

	/**
	 * Add the video to the Ooyala page category
	 * @param $videoFile File
	 */
	private function updatePageCategory( $videoFile ) {

		$article = Article::newFromID( $videoFile->getTitle()->getArticleID() );
		$content = $article->getContent();
		$content .= self::OOOYALA_CAT;
		$status = $article->doEdit( $content, self::EDIT_MESSAGE, EDIT_UPDATE | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false );
		if ( !$status->isOK() ) {
			$this->log( "Error adding Ooyala category to " . $videoFile->getName() );
			$this->log( $status->getMessage() );
		}
	}

	private function printSummary() {

		echo "Done\n";
		echo "Migrated " . $this->migratedVideos . " videos.\n";
		echo "Skipped " . $this->skippedVideos . " videos.\n";
	}

	private function log( $msg ) {

		if ( $this->verbose ) {
			echo $msg . "\n";
		}
	}

}

$maintClass = "MigrateScreenplayVidsToOoyala";
require_once( RUN_MAINTENANCE_IF_MAIN );

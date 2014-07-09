<?php

/**
 * Applies genre to page categories for Howdini ingested videos
 */

ini_set( "include_path", dirname( __FILE__ ) . "/../../" );
ini_set( 'display_errors', 1 );
set_time_limit( 0 );
error_reporting( E_ALL );

require_once( 'baseMaintVideoScript.php' );

class UpdateHowdiniAddGenreAsPageCat extends BaseMaintVideoScript {

	protected $failedWiki;
	protected $skippedWiki;
	public $limit;
	public $singleFile;

	function __construct() {
		parent::__construct();

		$this->failedWiki = 0;
		$this->skippedWiki = 0;
		$this->limit = self::BATCH_LIMIT_DEFAULT;
	}

	/**
	 * Entry point for the script
	 */
	public function run() {
		$startTimestamp = time();
		$startTime = $this->getCurrentTimestamp();
		$this->outputMessage( "Started ($startTime) ..." );

		// single-file option: discard all other videos
		if ( $this->singleFile ) {
			$video = $this->getVideoByTitle( $this->singleFile );

			if ( !$video ) {
				$this->outputError( "Provided single-file '$this->singleFile' not found!" );
				exit();
			}

			$videos = [$video];
			$total = 1;
		} else {
			$videos = $this->getVideosByProvider( 'ooyala/howdini', $this->limit );
			if ( !$videos ) {
				$this->outputError( "no video files found!" );
				exit();
			}
			$total = count( $videos );
		}

		foreach ( $videos as $video ) {
			$videoMetadata = $this->extractMetadata( $video );
			$this->outputMessage( "\tMetadata for {$videoMetadata['videoId']}: " );

			foreach ( explode( "\n", var_export( $videoMetadata, true ) ) as $line ) {
				$this->outputMessage( "\t\t:: $line" );
			}

			$this->addGenreToPageCategories( $video );
		}

		$this->report( $total );
		$finishTime = $this->getCurrentTimestamp();
		$elapsedTime = time() - $startTimestamp;
		$this->outputMessage( "Done at $finishTime. (time elapsed: {$elapsedTime}s)" );
	}

	/**
	 * Update metadata in the wiki
	 * @param $video
	 * @return bool
	 */
	protected function addGenreToPageCategories( $video ) {
		$name = $video['img_name'];
		$this->outputMessage( "\tUpdated (Wiki): $name" );

		$title = Title::newFromText( $name, NS_FILE );
		if ( !$title instanceof Title ) {
			++$this->failedWiki;
			$this->outputError( "Title NOT found.", '...FAILED! ' );
			return false;
		}

		$file = wfFindFile( $title );
		if ( empty( $file ) ) {
			++$this->failedWiki;
			$this->outputError( "File NOT found.", '...FAILED! ' );
			return false;
		}

		$metadata = unserialize( $video['img_metadata'] );
		if ( !$metadata ) {
			++$this->failedWiki;
			$this->outputError( "Cannot unserialized metadata.", '...FAILED! ' );
			return false;
		}

		// check for videoId
		if ( empty( $metadata['videoId'] ) ) {
			++$this->skippedWiki;
			$this->outputMessage( '...SKIPPED. (empty videoId in metadata)' );
			return false;
		}

		// check for title
		if ( empty( $metadata['title'] ) ) {
			++$this->skippedWiki;
			$this->outputMessage( '...SKIPPED. (empty title in metadata)' );
			return false;
		}

		if ( !isset( $metadata['canEmbed'] ) ) {
			++$this->skippedWiki;
			$this->outputMessage( '...SKIPPED. (canEmbed field not found in metadata)' );
			return false;
		}

		// update metadata
		if ( isset( $metadata['pageCategories'] ) && !empty( $metadata['genres'] ) ) {
			$pageCategories = explode( ', ', $metadata['pageCategories'] );
			$pageCategories = array_merge( $pageCategories, explode( ', ', $metadata['genres'] ) );
			$metadata['pageCategories'] = implode( ', ', array_unique( $pageCategories ) );
		}

		$serializedMeta = serialize( $metadata );

		if ( wfReadOnly() ) {
			$this->outputMessage( "Read only mode." );
			exit(0);
		}

		$dbw = wfGetDB( DB_MASTER );

		if ( !$this->isDryRun() ) {
			// update database
			$dbw->update(
				'image',
				['img_metadata' => $serializedMeta],
				['img_name' => $name],
				__METHOD__
			);

			// clear cache
			$file->purgeEverything();
		}

		$this->outputMessage( "...DONE!" );

		return true;
	}

	protected function report( $total ) {
		$this->outputMessage(
			"\nTotal videos: " . $total .
			", Success: " . ( $total - $this->failed - $this->skipped ) .
			", Failed: $this->failed, Skipped: $this->skipped\n"
		);

		$this->outputMessage(
			"Updated in Wiki: Total videos: " . $total .
			", Success: " . ( $total - $this->failedWiki - $this->skippedWiki ) .
			", Failed: $this->failedWiki, Skipped: $this->skippedWiki\n"
		);

	}

}


//------------------------ Main -------------------------
require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( 'Usage: php ' . __FILE__ . "[--help] [--dry-run] [--single-file]
	--limit            limit
	--dry-run          dry run
	--single-file      only modify a single file
	--help             you are reading it right now\n\n" );
}

$instance = new UpdateHowdiniAddGenreAsPageCat();

$instance->dryRun = isset( $options['dry-run'] );
$instance->limit = empty( $options['limit'] ) ? $instance::BATCH_LIMIT_DEFAULT : $options['limit'];
$instance->singleFile = isset( $options['single-file'] ) ? $options['single-file'] : false;

$instance->run();

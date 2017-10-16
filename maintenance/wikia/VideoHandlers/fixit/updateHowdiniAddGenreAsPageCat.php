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

		$this->outputMessage( "Title: $name" );
		$title = Title::newFromText( $name, NS_FILE );
		if ( $title instanceof Title && $title->exists() ) {
			$article = Article::newFromID( $title->getArticleID() );
			$content = $article->getContent();

			// set default value
			$status = Status::newGood();

			// add category
			$metadata = $this->extractMetadata( $video );
			if ( empty( $metadata['genres'] ) ) {
				$this->incSkipped();
				$this->outputMessage( "File remained indifferent. no category changes." );
				return false;
			}

			$categories = explode( ', ', $metadata['genres'] );
			$content = $this->addCategories( $content, $categories );
			$msg = 'Added: '.implode( ', ', $categories );

			if ( !$this->isDryRun() ) {
				$botUser = User::newFromName( Wikia::BOT_USER );
				$status = $article->doEdit( $content, 'Changing categories', EDIT_UPDATE | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $botUser );
			}

			if ( $status instanceof Status ) {
				if ( $status->isOK() ) {
					$this->outputMessage( "...DONE (".  $msg .")" );
				} else {
					++$this->failedWiki;
					echo "...FAILED (".$status->getMessage().").\n";
					return false;
				}
			}

			$this->outputMessage( "\tUpdated (Wiki): $name" );
		} else {
			$this->outputError( "(Title '$name' not found).", "...FAILED " );
			return false;
		}

		return true;
	}

	function getCategoryTag( $catgory ) {
		$cat = F::app()->wg->ContLang->getFormattedNsText( NS_CATEGORY );
		return '[['.ucfirst($cat).':'.$catgory.']]';
	}

	function addCategories( $content, $categories ) {
		foreach ( $categories as $category ) {
			$categoryTag = $this->getCategoryTag( $category );
			if ( stristr( $content, $categoryTag ) === false ) {
				$content .= $categoryTag;
			}
		}

		return $content;
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

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
	public $extra;
	public $limit;
	public $update1787;

	function __construct() {
		parent::__construct();

		$this->failedWiki = 0;
		$this->skippedWiki = 0;
		$this->extra = [];
		$this->limit = self::BATCH_LIMIT_DEFAULT;
		$this->update1787 = false;
	}

	/**
	 * Update Metadata (VID-1787)
	 * @param array $video
	 * @return array $newValues
	 */
	function updateMetadata1787( $video ) {
		$newValues = [];

		if ( $video['metadata']['provider'] != "ooyala/howdini" ) {
			return $newValues;
		}

		$videoIdString = "{$video['name']} (Id: {$video['embed_code']})";

		$newMetadata = $video['metadata'];

		if ( !empty( $video['metadata']['pagecategories'] ) && !empty( $video['metadata']['genres'] ) ) {
			$newMetadata['pagecategories'] = $video['metadata']['pagecategories'] . ', ' . $video['metadata']['genres'];
			$newValues['pagecategories'] = $newMetadata['pagecategories'];

			$resp = true;
			if ( !$this->isDryRun() ) {
				$resp = OoyalaAsset::updateMetadata( $video['embed_code'], $newMetadata );
				if ( !$resp ) {
					$newValues = [];
					$this->incFailed();
				}
			}

			if ( $resp ) {
				$this->outputMessage( "\tUPDATED: $videoIdString ...DONE - genre added to page categories." );
				$this->incSkipped();
			}
		} else {
			$this->outputMessage( "\tSKIP: $videoIdString - No changes." );
		}

		return $newValues;
	}

	/**
	 * Entry point for the script
	 */
	public function run() {
		$startTime = $this->getCurrentTimestamp();
		$this->outputMessage("Started ($startTime) ...");

		$nextPage = '';
		$page = 1;
		$total = 0;

		$apiPageSize = self::PAGE_SIZE_DEFAULT;
		if ( !empty( $this->limit ) && $this->limit < $apiPageSize ) {
			$apiPageSize = $this->limit;
		}

		do {
			// connect to provider API
			$url = OoyalaAsset::getApiUrlAssets( $apiPageSize, $nextPage, $this->extra );
			$this->outputMessage( "\nConnecting to $url..." );

			$response = OoyalaAsset::getApiContent( $url );
			if ( $response === false ) {
				$this->outputError("No Api response!");
				exit();
			}

			$videos = empty( $response['items'] ) ? [] : $response['items'] ;
			$nextPage = empty( $response['next_page'] ) ? '' : $response['next_page'] ;

			$total += count( $videos );

			$cnt = 0;
			foreach ( $videos as $video ) {
				if ( $video['metadata']['provider'] != "ooyala/howdini" ) {
					continue;
				}

				++$cnt;
				$title = trim( $video['name'] );
				$this->outputMessage( "[Page $page: $cnt of $total] Video: $title ({$video['embed_code']})" );
				$this->outputMessage( "\tMetadata for {$video['embed_code']}: " );

				foreach ( explode( "\n", var_export( $video['metadata'], true ) ) as $line ) {
					$this->outputMessage( "\t\t:: $line" );
				}

				if ( !empty( $this->update1787 ) ) {
					$newValues = $this->updateMetadata1787( $video );

					if ( empty( $newValues ) ) {
						++$this->skippedWiki;
						$this->outputMessage( "\tSKIP (WIKI): {$video['name']} (Id: {$video['embed_code']}) - No changes." );
					} else {
						$this->updateMetadataVideoWiki( $video['embed_code'], $newValues );
					}
				}
			}

			++$page;

		} while ( !empty( $nextPage ) && $total < $this->limit );

		$this->report( $total );
		$finishTime = $this->getCurrentTimestamp();
		$this->outputMessage("Done! ($finishTime)");
	}

	/**
	 * Update metadata in Video wiki
	 * @param string $videoId
	 * @param array $newValues
	 * @return boolean
	 */
	function updateMetadataVideoWiki( $videoId, array $newValues ) {

		$resp = false;

		$asset = OoyalaAsset::getAssetById( $videoId );

		if ( $asset['asset_type'] == 'remote_asset' ) {
			$isRemoteAsset = true;
			$provider = $asset['metadata']['source'];
		} else {
			$isRemoteAsset = false;
			$provider = 'ooyala';
		}

		$duplicates = WikiaFileHelper::findVideoDuplicates( $provider, $asset['embed_code'], $isRemoteAsset );
		if ( count( $duplicates ) > 0 ) {
			$resp = $this->updateMetadataWiki( $duplicates[0], $newValues );
		} else {
			$this->outputError("VideoId: $videoId - FILE not found.", "\t");
			++$this->failedWiki;
		}

		return $resp;
	}

	/**
	 * Update metadata in the wiki
	 * @param $video
	 * @param array $newValues
	 * @return bool
	 */
	protected function updateMetadataWiki( $video, array $newValues ) {
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
		$newMetadata = array_merge( $metadata, $newValues );

		// for debugging
		/*
		$this->outputMessage( "\n\tNEW Metadata (WIKI):" );
		$this->compareMetadata( $metadata, $newMetadata );
		echo "\n";
		*/

		if ( !$this->isDryRun() ) {
			$serializedMeta = serialize( $newMetadata );

			if ( wfReadOnly() ) {
				$this->outputMessage("Read only mode.");
				exit(0);
			}

			$dbw = wfGetDB( DB_MASTER );

			$dbw->begin();

			// update database
			$dbw->update(
				'image',
				['img_metadata' => $serializedMeta],
				['img_name' => $name],
				__METHOD__
			);

			$dbw->commit();

			// clear cache
			$file->purgeEverything();
		}

		$this->outputMessage("...DONE!");

		return true;
	}

	protected function report( $total ) {
		$this->outputMessage(
			"\nTotal videos: " . $total .
			", Success: " . ( $total - $this->failed - $this->skipped ) .
			", Failed: $this->failed, Skipped: $this->skipped\n"
		);

		if ( !empty( $this->update1787 ) ) {
			$this->outputMessage(
				"Updated in Wiki: Total videos: " . $total .
				", Success: " . ( $total - $this->failedWiki - $this->skippedWiki ) .
				", Failed: $this->failedWiki, Skipped: $this->skippedWiki\n"
			);
		}

	}

}


//------------------------ Main -------------------------
require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( 'Usage: php ' . __FILE__ . "[--help] [--dry-run] [extra=abc] [--update1787]
	--extra            extra conditions to get video assets from ooyala (use ' AND ' to separate each condition)
	--update1787       add genre to pageCategories
	--limit            limit
	--dry-run          dry run
	--help             you are reading it right now\n\n" );
}

$instance = new UpdateHowdiniAddGenreAsPageCat();

$instance->dryRun = isset( $options['dry-run'] );
$instance->extra = isset( $options['extra'] ) ? explode( ' AND ', $options['extra'] ) : [];
$instance->limit = empty( $options['limit'] ) ? $instance::BATCH_LIMIT_DEFAULT : $options['limit'];
$instance->update1787 = isset( $options['update1787'] );

$instance->run();

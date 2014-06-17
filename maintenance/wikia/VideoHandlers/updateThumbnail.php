<?php
/**
 * Update thumbnail
 * Maintenance script to update thumbnail
 * This is one time use script
 * @author Saipetch Kongkatong
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class UpdateThumbnail
 */
class UpdateThumbnail extends Maintenance {

	protected $test = false;
	protected $verbose = false;
	protected $opt = '';
	protected $startDate = '';
	protected $endDate = '';
	protected $provider = '';

	protected static $opts = array( 'reupload', 'data' );

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Update thumbnail";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'opt', 'Option [reupload or data]. (Reupload = reupload image for default image only. Data = update image data).', false, true, 'o' );
		$this->addOption( 'start', 'Start date (timestamp); required for reupload option', false, true, 's' );
		$this->addOption( 'end', 'End date (timestamp); required for reupload option', false, true, 'e' );
		$this->addOption( 'provider', 'Provider name', false, true, 'p' );
	}

	public function execute() {
		$this->test = $this->hasOption( 'test' );
		$this->verbose = $this->hasOption( 'verbose' );
		$this->opt = $this->getOption( 'opt' );
		$this->startDate = $this->getOption( 'start' );
		$this->endDate = $this->getOption( 'end' );
		$this->provider = $this->getOption( 'provider' );

		if ( empty( $this->opt ) || !in_array( $this->opt, self::$opts ) ) {
			die( "Error: invalid option. Please enter 'reupload' or 'data'.\n" );
		}

		if ( $this->opt == 'reupload' && ( empty( $this->startDate ) || empty( $this->endDate ) ) ) {
			die( "Error: Reuploading image requires start date and end date.\n" );
		}

		$app = F::app();
		echo "Wiki: {$app->wg->CityId} ({$app->wg->DBname})\n";

		if ( $this->test ) {
			echo "== TEST MODE ==\n";
		}

		$startTime = time();

		$cnt = 0;
		$success = 0;
		$failed = 0;
		$affected = 0;

		if ( $this->opt == 'reupload' ) {
			$videos = $this->getVideos();
		} else {
			$videos = VideoInfoHelper::getLocalVideoTitles();
		}

		$total = count( $videos );
		$helper = new VideoHandlerHelper();

		foreach ( $videos as $title ) {
			$cnt++;

			$this->debug( "Video [$cnt of $total]: $title " );

			$file = WikiaFileHelper::getVideoFileFromTitle( $title );

			// check if the file exists
			if ( empty( $file ) ) {
				echo " ... FAILED (File not found)\n";
				$failed++;
				continue;
			}

			// check for test mode
			if ( $this->test ) {
				$this->debug( "... DONE\n" );
				$success++;
				continue;
			}

			if ( $this->opt == 'reupload' ) {
				if ( $this->provider == 'screenplay' ) {
					$thumbUrl = ScreenplayApiWrapper::getThumbnailUrlFromAsset( $file->getVideoId() );
					if ( empty( $thumbUrl ) ) {
						echo " ... FAILED (Thumbnail URL not found)\n";
						$failed++;
						continue;
					}
				} else {
					$thumbUrl = null;
				}

				$status = $helper->resetVideoThumb( $file, $thumbUrl );
			} else if ( $this->opt == 'data' ) {
				if ( file_exists( $file->getLocalRefPath() ) ) {
					$status = $helper->updateThumbnailData( $file );
				} else {
					$status = Status::newFatal( 'Path not found' );
				}
			} else {
				$status = Status::newGood();
			}

			if ( $status->isGood() ) {
				if ( $this->opt == 'data' ) {
					$changed = $status->value;
				} else {
					$changed = 1;
				}
				$this->debug( "... DONE ($changed affected).\n" );
				$success++;

				if ( $changed > 0 ) {
					$affected++;
				}
			} else {
				$errorMsg = array();
				foreach ( $status->errors as $err ) {
					$errorMsg[] = $err['message'];
				}
				$this->debug( "... FAILED (".implode( ', ', $errorMsg ).")\n" );
				$failed++;
			}
		}

		$diff = $app->wg->lang->formatTimePeriod( time() - $startTime );
		echo "Wiki {$app->wg->CityId} ({$app->wg->DBname}): Total: $total, Success: $success ($affected affected), Failed: $failed. Finished after $diff\n";
	}

	/**
	 * Get the list of videos from this wiki
	 * @return array $titles
	 */
	private function getVideos() {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_SLAVE );

		$sqlWhere['img_media_type'] = 'video';
		if ( !empty( $this->startDate ) ) {
			$sqlWhere[] = "img_timestamp > '{$db->timestamp( $this->startDate )}'";
		}

		if ( !empty( $this->endDate ) ) {
			$sqlWhere[] = "img_timestamp <= '{$db->timestamp( $this->endDate )}'";
		}

		if ( !empty( $this->provider ) ) {
			$sqlWhere['img_minor_mime'] = $this->provider;
		}

		// size and hash from LegacyVideoApiWrapper::$THUMBNAIL_URL
		$sqlWhere['img_size'] = 66162;
		$sqlWhere['img_sha1'] = 'm03a6fnvxhk8oj5kgnt11t6j7phj5nh';

		$result = $db->select(
			array( 'image' ),
			array( 'img_name' ),
			$sqlWhere,
			__METHOD__
		);

		$titles = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$titles[] = $row->img_name;
		}

		$db->freeResult( $result );

		wfProfileOut( __METHOD__ );

		return $titles;
	}

	/**
	 * Print the message if verbose is enabled
	 * @param $msg - The message text to echo to STDOUT
	 */
	private function debug( $msg ) {
		if ( $this->verbose ) {
			echo $msg;
		}
	}

}

$maintClass = "UpdateThumbnail";
require_once( RUN_MAINTENANCE_IF_MAIN );

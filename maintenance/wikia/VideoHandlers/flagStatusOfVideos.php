<?php
/**
 * flagStatusOfVideos
 *
 * This script examines all videos on a wiki and determines the status of the video (working, deleted by provider,
 * private, or other). This status is flagged in the page_wikia_props table using the corresponding constant
 * value listed inside of the flagStatusOfVideos class
 *
 * @author james@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );
use \Wikia\Logger\WikiaLogger;

/**
 * Class flagStatusOfVideos
 */
class flagStatusOfVideos extends Maintenance {

	const STATUS_DELETED = 2;
	const STATUS_PRIVATE = 4;
	const STATUS_OTHER_ERROR = 8;

	protected $verbose = false;
	protected $test    = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Flag videos which are deleted on provider, private, or have some form of error returned from API";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
	}

	public function execute() {
		$this->test       = $this->hasOption( 'test' );
		$this->verbose    = $this->hasOption( 'verbose' );
		$workingVideos    = 0;
		$deletedVideos    = 0;
		$privateVideos    = 0;
		$otherErrorVideos = 0;
		$log = WikiaLogger::instance();
		// Only write to memcache, no reads. We want to make sure to always talk to each of the provider's API directly.
		// Since each time a request is made to these APIs the response is cached for 1 day, disallow memcache reads
		// so we can be sure to not be pulling stale data.
		F::app()->wg->AllowMemcacheReads = false;
		F::app()->wg->AllowMemcacheWrites = true;

		$this->debug( "(debugging output enabled)\n ");
		$allVideos = $this->getVideos();

		foreach( $allVideos as $provider => $videos ) {
			$class = ucfirst( $provider ) . "ApiWrapper";
			foreach( $videos as $video ) {
				try {
					// No need to assign this object to anything, we're just trying to catch exceptions during its creation
					new $class( $video['video_id'] );
					// If an exception isn't thrown by this point, we know the video is still good
					$this->debug( "Found working video: " . $video['video_title'] );
					$workingVideos++;
				} catch ( Exception $e ) {
					$removeVideo = true;
					$loggingParams = [
						"video_title" => $video["video_title"],
						"video_id" => $video["video_id"],
						"exception" => $e,
					];
					$log->error( "Video with error encountered", $loggingParams );
					if ( $e instanceof VideoNotFoundException ) {
						$this->debug( "Found deleted video: " . $video['video_title'] );
						$deletedVideos++;
						$status = self::STATUS_DELETED;
					} elseif ( $e instanceof VideoIsPrivateException ) {
						$this->debug( "Found private video: " . $video['video_title'] );
						$privateVideos++;
						$status = self::STATUS_PRIVATE;
					} else {
						$this->debug( "Found other video: " . $video['video_title'] );
						$this->debug( $e->getMessage() );
						$otherErrorVideos++;
						$status = self::STATUS_OTHER_ERROR;
						$removeVideo = false;
					}

					if ( !$this->test ) {
						wfSetWikiaPageProp( WPP_VIDEO_STATUS, $video['page_id'], $status );
						if ( $removeVideo ) {
							$this->setRemovedValue( $video, $removeVideo );
						}
					}
				}
			}
		}

		if ( !$this->test ) {
			$mediaService = new MediaQueryService();
			$mediaService->clearCacheTotalVideos();
			$memcKeyRecent = wfMemcKey( 'videomodule', 'local_videos', VideosModule::CACHE_VERSION, "recent" );
			F::app()->wg->Memc->delete( $memcKeyRecent );
		}

		echo "\n========SUMMARY========\n";
		echo "Found $workingVideos working videos\n";
		echo "Found $deletedVideos deleted videos\n";
		echo "Found $privateVideos private videos\n";
		echo "Found $otherErrorVideos other videos\n";

	}

	/**
	 * Get a list off all videos grouped by provider on the wiki
	 * @return bool|mixed
	 */
	public function getVideos() {
		$db = wfGetDB( DB_SLAVE );
		$videos = ( new WikiaSQL() )->SELECT( "img_name" )
			->FIELD( "img_metadata" )
			->FIELD( "img_minor_mime" )
			->FIELD( "page_id" )
			->FROM( "image" )
			->JOIN( "page" )
			->ON( "page_title", "img_name")
			->WHERE( "img_media_type" )->EQUAL_TO( "VIDEO" )
			->AND_( "page_namespace" )->EQUAL_TO( NS_FILE )
			->runLoop( $db, function ( &$videos, $row ) {
				$videoDetail = [
					"video_id" => unserialize( $row->img_metadata )['videoId'],
					"video_title" => $row->img_name,
					"page_id" => $row->page_id
				];
				// img_minor_mime is the video provider
				$videos[$row->img_minor_mime][] = $videoDetail;
			});

		return $videos;
	}

	/**
	 * @param $video - Video to flag in the video_info table
	 * @param $removeVideo - Boolean, whether the video should be deleted or not
	 * Flag removed status of video in the video_info table. All videos which have some sort of error
	 * (deleted, private, or other), are flagged as removed, all working videos are flagged as not removed.
	 */
	private function setRemovedValue ( $video, $removeVideo ) {
		$videoInfo = VideoInfo::newFromTitle( $video['video_title'] );
		if ( is_null( $videoInfo ) ) {
			$videoInfoHelper  = new VideoInfoHelper();
			$videoTitle = Title::newFromText( $video['video_title'], NS_FILE );
			$videoInfo = $videoInfoHelper->getVideoInfoFromTitle( $videoTitle );
			$videoInfo->addVideo();
		}

		if ( $removeVideo ) {
			if ( !$videoInfo->isRemoved() ) {
				$videoInfo->removeVideo();
			}
		} else {
			if ( $videoInfo->isRemoved() ) {
				$videoInfo->restoreVideo();
			}
		}
		$removedStatus = $removeVideo ? "removed" : "not removed";
		$this->debug( "Video set as $removedStatus: " . $video['video_title'] );
	}

	/**
	 * Print the message if verbose is enabled
	 * @param $msg - The message text to echo to STDOUT
	 */
	private function debug( $msg ) {
		if ( $this->verbose ) {
			echo $msg . "\n";
		}
	}

}

$maintClass = "flagStatusOfVideos";
require_once( RUN_MAINTENANCE_IF_MAIN );

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

/**
 * Class flagStatusOfVideos
 */
class flagStatusOfVideos extends Maintenance {

	const STATUS_WORKING = 1;
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
		$this->test       = $this->hasOption( 'test' ) ? true : false;
		$this->verbose    = $this->hasOption( 'verbose' ) ? true : false;
		$workingVideos    = array();
		$deletedVideos    = array();
		$privateVideos    = array();
		$otherErrorVideos = array();
		$videoInfoHelper = new VideoInfoHelper();

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
					$workingVideos[] = $video;
					if ( !$this->test ) {
						wfSetWikiaPageProp( WPP_VIDEO_STATUS, $video['page_id'], self::STATUS_WORKING );
					}
				} catch ( Exception $e ) {
					if ( $e instanceof VideoNotFoundException ) {
						$this->debug( "Found deleted video: " . $video['video_title'] );
						$deletedVideos[] = $video;
						if ( !$this->test ) {
							wfSetWikiaPageProp( WPP_VIDEO_STATUS, $video['page_id'], self::STATUS_DELETED );
						}
					} elseif ( $e instanceof VideoIsPrivateException ) {
						$this->debug( "Found private video: " . $video['video_title'] );
						$privateVideos[] = $video;
						if ( !$this->test ) {
							wfSetWikiaPageProp( WPP_VIDEO_STATUS, $video['page_id'], self::STATUS_PRIVATE);
						}
					} else {
						$this->debug( "Found other video: " . $video['video_title'] );
						$this->debug( $e->getMessage() );
						$otherErrorVideos[] = $video;
						if ( !$this->test ) {
							wfSetWikiaPageProp( WPP_VIDEO_STATUS, $video['page_id'], self::STATUS_OTHER_ERROR);
						}
					}
					if ( !$this->test ) {
						$this->setAsRemoved( $video, $videoInfoHelper );
					}
				}
			}
		}

		$mediaService = new MediaQueryService();
		$mediaService->clearCacheTotalVideos();

		echo "\n========SUMMARY========\n";
		echo "Found " . count( $workingVideos ) . " working videos\n";
		echo "Found " . count( $deletedVideos ) . " deleted videos\n";
		echo "Found " . count( $privateVideos ) . " private videos\n";
		echo "Found " . count( $otherErrorVideos ) . " other videos\n";

	}

	/**
	 * Get a list off all videos grouped by provider on the wiki
	 * @return bool|mixed
	 */
	public function getVideos() {
		$db = wfGetDB( DB_SLAVE );
		$unprocessedVideos = ( new WikiaSQL() )->SELECT( "img_name" )
			->FIELD( "img_metadata" )
			->FIELD( "img_minor_mime" )
			->FIELD( "page_id" )
			->FROM( "image" )
			->JOIN( "page" )
			->ON( "page_title", "img_name")
			->WHERE( "img_media_type" )->EQUAL_TO( "VIDEO" )
			->AND_( "page_namespace" )->EQUAL_TO( NS_FILE )
			->run( $db, function ( $result ) {
				while ( $row = $result->fetchObject( $result ) ) {
					$videos[] = $row;
				}
				return $videos;
			});

		$processedVideos = array();
		foreach( $unprocessedVideos as $video ) {
			$videoDetail = [
				"video_id" => unserialize( $video->img_metadata )['videoId'],
				"video_title" => $video->img_name,
				"page_id" => $video->page_id
			];
			// img_minor_mime is the video provider
			$processedVideos[$video->img_minor_mime][] = $videoDetail;
		}
		return $processedVideos;
	}

	/**
	 * @param $videos - Flag video as removed in the video_info table
	 */
	private function setAsRemoved ( $video, $videoInfoHelper ) {
		$videoInfo = VideoInfo::newFromTitle( $video['video_title'] );
		if ( is_null( $videoInfo ) ) {
			$videoTitle = Title::newFromText( $video['video_title'], NS_FILE );
			$videoInfo = $videoInfoHelper->getVideoInfoFromTitle( $videoTitle );
			$videoInfo->setRemoved();
			$videoInfo->addVideo();
			$this->debug("Video not found in video_info table, adding info for: " . $video['video_title'] );
		} else {
			$videoInfo->removeVideo();
		}
		$this->debug( "Setting video as removed: " . $video['video_title'] );
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

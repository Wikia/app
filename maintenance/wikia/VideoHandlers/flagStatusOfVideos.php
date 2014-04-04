<?php
/**
 * flagStatusOfVideos
 *
 * This script examines all videos on a wiki and determines the status of the video (working, deleted by provider,
 * private, or other). This status is flagged in the page_wikia_props table using the corresponding constant
 * value listed inside of the flafStatusOfVideos class
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
		$this->test     = $this->hasOption( 'test' ) ? true : false;
		$this->verbose  = $this->hasOption( 'verbose' ) ? true : false;
		$workingVideos    = array();
		$deletedVideos    = array();
		$privateVideos    = array();
		$otherErrorVideos      = array();

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
				} catch ( Exception $e ) {
					if ( $e instanceof VideoNotFoundException ) {
						$this->debug( "Found deleted video: " . $video['video_title'] );
						$deletedVideos[] = $video;
					} elseif ( $e instanceof VideoIsPrivateException ) {
						$this->debug( "Found private video: " . $video['video_title'] );
						$privateVideos[] = $video;
					} else {
						$this->debug( "Found other video: " . $video['video_title'] );
						$this->debug( $e->getMessage() );
						$otherErrorVideos[] = $video;
					}
				}
			}
		}

		echo "Found " . count( $workingVideos ) . " working videos\n";
		echo "Found " . count( $deletedVideos ) . " deleted videos\n";
		echo "Found " . count( $privateVideos ) . " private videos\n";
		echo "Found " . count( $otherErrorVideos ) . " other videos\n";

		if ( !$this->test ) {
			$this->setStatus( $workingVideos, self::STATUS_WORKING );
			$this->setStatus( $deletedVideos, self::STATUS_DELETED );
			$this->setStatus( $privateVideos, self::STATUS_PRIVATE );
			$this->setStatus( $otherErrorVideos, self::STATUS_OTHER_ERROR );
		}

	}

	/**
	 * Get a list off all videos, grouped by provider, on the wiki
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
			->WHERE( "img_major_mime" )->EQUAL_TO( "video" )
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
	 * Print the message if verbose is enabled
	 * @param $msg - The message text to echo to STDOUT
	 */
	private function debug( $msg ) {
		if ( $this->verbose ) {
			echo $msg . "\n";
		}
	}

	/**
	 * @param $videos - Videos to flag in page_wikia_props table
	 * @param $status - Status of videos (see constants above)
	 */
	private function setStatus( $videos, $status ) {
		$db = wfGetDB( DB_MASTER );
		foreach ( $videos as $video ) {
			$sql =  "REPLACE INTO page_wikia_props (page_id, propname, props) ";
			$sql .= "VALUES ($video[page_id], " . WPP_VIDEO_STATUS . ", $status)";
			( new WikiaSQL() )->RAW( $sql )->run( $db );
		}
	}
}

$maintClass = "flagStatusOfVideos";
require_once( RUN_MAINTENANCE_IF_MAIN );

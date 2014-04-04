<?php
/**
 * removeProviderDeletedVideos
 *
 * This script examines all videos on a wiki and determines if that video has been deleted by the provider.
 * If so, that video is deleted from the wiki.
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class RemoveProviderDeletedVideos
 */
class RemoveProviderDeletedVideos extends Maintenance {

	const STATUS_WORKING = 1;
	const STATUS_DELETED = 2;
	const STATUS_PRIVATE = 4;
	const STATUS_OTHER = 8;

	protected $verbose = false;
	protected $test    = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Remove provider deleted videos from wiki";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
	}

	public function execute() {
		$this->test     = $this->hasOption('test') ? true : false;
		$this->verbose  = $this->hasOption('verbose') ? true : false;
		$working_videos    = array();
		$deleted_videoss    = array();
		$private_videos    = array();
		$other_videos      = array();

		$this->debug("(debugging output enabled)\n");
		$videoproviders = $this->getVideos();

		foreach( $videoproviders as $provider => $videos ) {
			$class = ucfirst( $provider ) . "ApiWrapper";
			foreach( $videos as $video ) {
				try {
					// No need to assign this object to anything, we're
					// just trying to catch exceptions during its creation
					new $class( $video['video_id'] );
					// If an exception isn't thrown by this
					// point, we know the video is still good
					$this->debug("Found working video: " . $video['video_title'] . "\n" );
					$working_videos[] = $video;
				} catch ( Exception $e ) {
					if ( $e instanceof VideoNotFoundException ) {
						$this->debug("Found deleted video: " . $video['video_title'] . "\n" );
						$deleted_videoss[] = $video;
					} elseif ( $e instanceof VideoIsPrivateException ) {
						$this->debug("Found private video: " . $video['video_title']  . "\n" );
						$private_videos[] = $video;
					} else {
						$this->debug("Found other video: " . $video['video_title']  . "\n" );
						$other_videos[] = $video;
					}
				}
			}
		}

		echo "found " . count($working_videos) . " working videos\n";
		echo "found " . count($deleted_videoss) . " deleted videos\n";
		echo "found " . count($private_videos) . " private videos\n";
		echo "found " . count($other_videos) . " other videos\n";

		$this->setStatus($working_videos, self::STATUS_WORKING);
		$this->setStatus($deleted_videoss, self::STATUS_DELETED);
		$this->setStatus($private_videos, self::STATUS_PRIVATE);
		$this->setStatus($other_videos, self::STATUS_OTHER);

	}

	/**
	 * Get a list off all videos, grouped by provider, on the wiki
	 * @return bool|mixed
	 */
	public function getVideos() {
		$db = wfGetDB( DB_SLAVE );
		$providers = (new WikiaSQL())->SELECT("video_title")
			->FIELD("video_id")
			->FIELD("provider")
			->FIELD("page_id")
			->FROM("video_info")
			->JOIN("page")
			->ON("video_title", "page_title")
			->run($db, function ($result) {
				while ($row = $result->fetchObject($result)) {
					// Look into why there are null videos
					if ( is_null($row->provider) ) {
						continue;
					}
					$video_detail = [ "video_title" => $row->video_title, "video_id" => $row->video_id ,
						"page_id" => $row->page_id ];
					$providers[$row->provider][] = $video_detail;
				}
				return $providers;
			})
		;
		return $providers;
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

	/**
	 * @param $videos - Videos to flag in page_wikia_props table
	 * @param $status - Status of videos (see constants above)
	 */
	private function setStatus( $videos, $status ) {
		$db = wfGetDB( DB_MASTER );
		foreach ( $videos as $video ) {
			$sql =  "REPLACE INTO page_wikia_props (page_id, propname, props) ";
			$sql .= "VALUES ($video[page_id], " . WPP_VIDEO_STATUS . ", $status)";
			(new WikiaSQL())->RAW($sql)->run($db);
		}
	}
}

$maintClass = "removeProviderDeletedVideos";
require_once( RUN_MAINTENANCE_IF_MAIN );

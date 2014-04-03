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

	protected $verbose = false;
	protected $test    = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Remove provider deleted videos from wiki";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
	}

	public function execute() {
		$this->test          = $this->hasOption('test') ? true : false;
		$this->verbose       = $this->hasOption('verbose') ? true : false;
		$this->deletedVideos = 0;
		$wgUser = User::newFromName( 'WikiaBot' );
		$wgUser->load();

		$this->debug("(debugging output enabled)\n");
		$videoproviders = $this->getVideos();

		foreach( $videoproviders as $provider => $videos ) {

			$class = ucfirst( $provider ) . "ApiWrapper";

			foreach( $videos as $video ) {

				try {
					// No need to assign this object to anything, we're just trying to catch exceptions during its creation
					new $class( $video['video_id'] );
				} catch ( Exception $e ) {

					if ( $e instanceof VideoNotFoundException || $e instanceof VideoIsPrivateException ) {

						// Flag the videos in here

					}
				}
			}
		}
	}

	public function getVideos() {
		$db = wfGetDB( DB_SLAVE );
		$providers = (new WikiaSQL())->SELECT("video_title")
			->FIELD("video_id")
			->FIELD("provider")
			->FROM("video_info")
			->run($db, function ($result) {
				while ($row = $result->fetchObject($result)) {
					// Look into why there are null videos
					if ( is_null($row->provider) ) {
						continue;
					}
					$video_detail = [ "video_title" => $row->video_title, "video_id" => $row->video_id ];
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
}

$maintClass = "removeProviderDeletedVideos";
require_once( RUN_MAINTENANCE_IF_MAIN );

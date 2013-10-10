<?php
/**
 * fsckVideos
 *
 * This script examines all videos in a wiki to make sure the data is correct
 *
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class FSCKVideos
 */
class FSCKVideos extends Maintenance {

	protected $verbose = false;
	protected $test    = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Pre-populate LVS suggestions";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
	}

	public function execute() {
		$this->test    = $this->hasOption('test');
		$this->verbose = $this->hasOption('verbose');

		if ( $this->test ) {
			echo "== TEST MODE ==\n";
		}
		$this->debug("(debugging output enabled)\n");

		$startTime = time();

		$videos = VideoInfoHelper::getLocalVideoTitles();
		$this->debug("Found ".count($videos)." video(s)\n");

		$fix = $this->test ? false : true;

		$helper = new VideoHandlerHelper();

		foreach ( $videos as $title ) {
			$status = $helper->fcskVideoThumbnail( $title, $fix );
			if ( $status->isGood() ) {
				$result = $status->value;
				if ( $result['check']  == 'ok' ) {
					$this->debug("File '$title' ... ok\n");
				} else {
					echo "File '$title' ... failed\n";
					echo "\tACTION: ".$result['action']."\n";
				}
			} else {
				echo "File '$title' ... ERROR\n";
				foreach ( $status->errors as $err ) {
					echo "\tERR: ".$err['message']."\n";
				}
			}
		}

		$delta = F::app()->wg->lang->formatTimePeriod( time() - $startTime );
		echo "Finished after $delta\n";
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

$maintClass = "FSCKVideos";
require_once( RUN_MAINTENANCE_IF_MAIN );


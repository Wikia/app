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

		$helper = new VideoHandlerHelper();

		$videos = $helper->getLocalVideoTitles();
		$this->debug("Found ".count($videos)." video(s)\n");

		$fix = $this->test ? false : true;

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

		$delta = $this->formatDuration(time() - $startTime);
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

	/**
	 * Format a number in seconds into hours, minutes and seconds
	 * @param int $sec - A number in seconds
	 * @return string - A friendlier version of seconds expressed in hours, minutes and seconds
	 */
	private function formatDuration( $sec ) {
		$output = '';

		$min = $sec >= 60 ? $sec/60 : 0;
		$sec = $sec%60;

		$hour = $min >= 60 ? $min/60 : 0;
		$min = $min%60;

		if ( $hour ) {
			$output .= $this->addUnits($hour, 'hour');
		}
		if ( $hour || $min ) {
			$output .= (strlen($output) > 0 ? ' ' : '') . $this->addUnits($min, 'min');
		}
		$output .= (strlen($output) > 0 ? ' ' : '') . $this->addUnits($sec, 'sec');

		return $output;
	}

	/**
	 * Combine a number and a unit and pluralize when necessary
	 * @param $num - A number
	 * @param $unit - A unit for the number
	 * @return string - The combination of number and (possibly) pluralized unit
	 */
	private function addUnits( $num, $unit ) {
		$pl = $num == 1 ? '' : 's';
		return "$num $unit$pl";
	}
}

$maintClass = "FSCKVideos";
require_once( RUN_MAINTENANCE_IF_MAIN );


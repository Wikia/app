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
		$this->addOption( 'title', 'Fix a specific file', false, true, 'i' );
	}

	public function execute() {
		$this->test    = $this->hasOption('test');
		$this->verbose = $this->hasOption('verbose');
		$title         = $this->getOption('title', '');

		echo "Checking ".F::app()->wg->Server."\n";

		$stats = ['checked'     => 0,
				  'ok'          => 0,
				  'failed'      => 0,
				  'fail_action' => [],
				  'error'       => 0,
				 ];

		if ( $this->test ) {
			echo "== TEST MODE ==\n";
		}
		$this->debug( "(debugging output enabled)\n" );

		$startTime = time();

		if ( $title ) {
			$videos = [ $title ];
		} else {
			$videos = VideoInfoHelper::getLocalVideoTitles();
			$this->debug("Found ".count($videos)." video(s)\n");
		}

		$fix = $this->test ? false : true;

		$helper = new VideoHandlerHelper();

		foreach ( $videos as $title ) {
			$stats['checked']++;

			$status = $helper->fsckVideoThumbnail( $title, $fix );
			if ( $status->isGood() ) {
				$result = $status->value;
				if ( $result['check']  == 'ok' ) {
					$stats['ok']++;
					$this->debug("File '$title' ... ok\n");
				} else {
					$stats['failed']++;
					if ( empty ($stats['fail_action'][$result['action']]) ) {
						$stats['fail_action'][$result['action']] = 0;
					}
					$stats['fail_action'][$result['action']]++;
					echo "File '$title' ... failed\n";
					echo "\tACTION: ".$result['action']."\n";
				}
			} else {
				echo "File '$title' ... ERROR\n";
				$stats['error']++;
				foreach ( $status->errors as $err ) {
					echo "\tERR: ".$err['message']."\n";
				}
			}
		}

		printf("Checked %5d video(s)\n", $stats['checked']);
		printf("\t%5d ok\n", $stats['ok']);
		printf("\t%5d failed\n", $stats['failed']);
		foreach ( $stats['fail_action'] as $action => $count ) {
			printf("\t\t( %4d %s )\n", $count, $action);
		}
		printf("\t%5d error(s)\n", $stats['error']);
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


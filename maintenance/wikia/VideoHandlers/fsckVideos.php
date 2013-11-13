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
	protected $test = false;
	protected $reupload = false;
	protected $startDate = '';
	protected $endDate = '';

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Pre-populate LVS suggestions";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'reupload', 'Reupload image for default image only', false, false, 'r' );
		$this->addOption( 'start', 'Start date (timestamp); required for reupload option', false, true, 's' );
		$this->addOption( 'end', 'End date (timestamp); required for reupload option', false, true, 'e' );
	}

	public function execute() {
		$this->test    = $this->hasOption('test');
		$this->verbose = $this->hasOption('verbose');
		$this->reupload = $this->hasOption('reupload');
		$this->startDate = $this->getOption('start');
		$this->endDate = $this->getOption('end');

		if ( $this->reupload && ( empty( $this->startDate ) || empty( $this->endDate ) ) ) {
			die( "Error: Reuploading image requires start date and end date.\n" );
		}

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
		$this->debug("(debugging output enabled)\n");

		$startTime = time();

		$videos = $this->getVideos();
		$this->debug("Found ".count($videos)." video(s)\n");

		$fix = $this->test ? false : true;

		$helper = new VideoHandlerHelper();

		foreach ( $videos as $title ) {
			$stats['checked']++;

			$status = $helper->fcskVideoThumbnail( $title, $fix, $this->reupload );
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

		if ( $this->reupload ) {
			// size and hash from LegacyVideoApiWrapper::$THUMBNAIL_URL
			$sqlWhere['img_size'] = 66162;
			$sqlWhere['img_sha1'] = 'm03a6fnvxhk8oj5kgnt11t6j7phj5nh';
		} else {
			$sqlWhere['img_size'] = 0;
		}

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

$maintClass = "FSCKVideos";
require_once( RUN_MAINTENANCE_IF_MAIN );


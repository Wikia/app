<?php

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class FSCKVideos
 */
class MatchDailyMotion extends Maintenance {

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

		echo "Checking ".F::app()->wg->Server."\n";

		if ( $this->test ) {
			echo "== TEST MODE ==\n";
		}
		$this->debug("(debugging output enabled)\n");

		$startTime = time();

		$videos = VideoInfoHelper::getLocalVideoTitles();
		$this->debug("Found ".count($videos)." video(s)\n");

		foreach ( $videos as $title ) {
			$title = preg_replace('/_/', ' ', $title);
			$url = "https://api.dailymotion.com/videos?search=".urlencode( $title );

			$json = Http::request('GET', $url);
			if ( $json ) {
				$resp = json_decode($json, true);

				if ( isset($resp['list']) ) {
					// Reduce titles to just letters and numbers
					$normalTitle = preg_replace('/[^a-zA-Z0-9]+/', '', $title);

					$list = $resp['list'];
					foreach ( $list as $info ) {
						// Reduce the matched titles to just letters and numbers
						$normalMatch = preg_replace('/[^a-zA-Z0-9]+/', '', $info['title']);

						// See if the normalized versions match
						if ( $normalMatch == $normalTitle ) {
							echo "$title\n";
							// If the non normalized forms don't match,
							if ( $title != $info['title'] ) {
								echo "\t(DailyMotion: ".$info['title']."\n";
							}
						}
					}
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

$maintClass = "MatchDailyMotion";
require_once( RUN_MAINTENANCE_IF_MAIN );


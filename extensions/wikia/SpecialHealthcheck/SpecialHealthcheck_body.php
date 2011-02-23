<?php
/**
 * HealthCheck
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2009-11-10
 * @copyright Copyright © 2009 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named HealthCheck.\n";
	exit( 1 );
}

class HealthCheck extends UnlistedSpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'HealthCheck'/*class*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgRequest;

		// Set page title and other stuff
		$this->setHeaders();
		$wgOut->setPageTitle( 'Special:Healthcheck' );

		// for faster response
		$wgOut->setArticleBodyOnly( true );

		$statusCode = 200;
		$statusMsg = "Server status is: OK";
		$maxLoad = $wgRequest->getVal('maxload');
		$cpuCount = rtrim( shell_exec('cat /proc/cpuinfo | grep processor | wc -l') );
		$load = sys_getloadavg();


		if ( $cpuRatio = $wgRequest->getVal('cpuratio') ) {
		    $maxLoad = $cpuCount * $cpuRatio;
		}

		$wgRequest->response()->header("Cpu-Count: $cpuCount");
		$wgRequest->response()->header("Load: " . implode(", ", $load));
		$wgRequest->response()->header("Max-Load: $maxLoad");

		if ( $maxLoad ) {
		    if ( $load[0] > $maxLoad ||
			 $load[1] > $maxLoad ||
			 $load[2] > $maxLoad ) {
				$statusCode = 503;
				$statusMsg = "Server status is: NOT OK - load ($load[0] $load[1] $load[2]) > $maxLoad (cpu = $cpuCount)";
		    }
		}


		if ( file_exists( "/usr/wikia/conf/current/host_disabled" ) ) {
			# failure!
  			$statusCode = 503;
			$statusMsg  = 'Server status is: NOT OK - Disabled';
		}


		// Varnish should respond with a 200 for any request to any host with this path
		// The Http class takes care of the proxying through varnish for us.
		$content = Http::get("http://x/__varnish_nagios_check");
		if (!$content) {
			$statusCode = 503;
			$statusMsg  = 'Server status is: NOT OK - Varnish not responding';
		}

		// check for riak if riak is using as sessions provider
		// @author Krzysztof Krzyżaniak (eloy)
		global $wgSessionsInRiak, $wgRiakSessionNode, $wgRiakStorageNodes;
		if( $wgSessionsInRiak ) {
			// get data for connection
			$riakNode = $wgRiakStorageNodes[ $wgRiakSessionNode ];

			// build url
			$riakPing = sprintf( "http://%s:%s/ping", $riakNode[ "host"], $riakNode[ "port" ] );

			// set proxy if needed, for local riak we have to pass request directly
			$options = array();
			if( isset( $riakNode[ "proxy"] ) && $riakNode[ "proxy" ] ) {
				$options[ "proxy" ] = $riakNode[ "proxy" ];
			}
			else {
				$options[ "noProxy" ] = true;
			}

			$content = Http::get( $url, 'default', $options );
			if( $content === false ) {
				$statusCode = 503;
				$statusMsg = "Server status is: NOT OK - Riak is down";
			}
		}

		$wgOut->setStatusCode( $statusCode );
		$wgOut->addHTML( $statusMsg );
	}
}

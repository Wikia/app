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

		$wgOut->setStatusCode( $statusCode );
		$wgOut->addHTML( $statusMsg );
	}
}

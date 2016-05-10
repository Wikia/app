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

	const STATUS_MESSAGE_OK = "Server status is: OK";

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
		global $wgOut;

		// Set page title and other stuff
		$this->setHeaders();

		// for faster response
		$wgOut->setArticleBodyOnly( true );

		$statusCode = 200;
		$statusMsg = self::STATUS_MESSAGE_OK;

		if ( file_exists( "/usr/wikia/conf/current/host_disabled" ) ||
			 file_exists( "/etc/disabled/apache" ) ) {
			# failure!
  			$statusCode = 503;
			$statusMsg  = 'Server status is: NOT OK - Disabled';
		}

		$wgOut->setStatusCode( $statusCode );
		$wgOut->addHTML( $statusMsg . "\n" );
	}
}

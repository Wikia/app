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
		global $wgOut;

		// Set page title and other stuff
		$this->setHeaders();
		$wgOut->setPageTitle( 'Special:Healthcheck' );

		// for faster response
		$wgOut->setArticleBodyOnly( true );

		if ( file_exists( "/usr/wikia/conf/current/host_disabled" ) ) {
			# failure!
			$wgOut->setStatusCode( 503 );
			$wgOut->addHTML( 'Server status is: NOT OK' );
		} else {
			# success!
			$wgOut->setStatusCode( 200 );
			$wgOut->addHTML( 'Server status is: OK' );
		}
	}
}

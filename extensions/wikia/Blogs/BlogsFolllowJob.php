<?php

/**
 * BlogFollowJob -- send follow emails for certain conditions
 *
 * @file
 * @ingroup JobQueue
 *
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @date 2010-07-19
 * @version 1.0
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

/**
 * sometimes class Job is uknown in this point
 */
include_once( $GLOBALS[ "IP" ] . "/includes/JobQueue.php" );
$wgJobClasses[ "BlogsFollow" ] = "BlogsFolllowJob";

/**
 * rights and permissions -- will be moved to CommonSettings
 */
$wgAvailableRights[] = "autofollowblog";
$wgGroupPermissions[ "staff" ][ "autofollowblog" ] = true;

class BlogsFolllowJob extends Job {

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $title, $params, $id = 0 ) {
		parent::__construct( "BlogsFollow", $title, $params, $id );
		$this->mParams = $params;
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {
	}
};

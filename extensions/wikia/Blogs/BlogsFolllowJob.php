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

		wfProfileIn( __METHOD__ );

		/**
		 * get title of page, take main part from this title which will be
		 * main page for user blogs (listing)
		 */
		$ownerTitle = BlogArticle::getOwnerTitle( $this->title );

		/**
		 * check who watches this page
		 */
		$dbr = wfGetDB( DB_SLAVE );
		$sth = $dbr->select(
			array( "watchlist" ),
			array( "wl_user" ),
			array(
				"wl_namespace" => $ownerTitle->getNamespace(),
				"wl_title" => $ownerTitle->getDBKey()
			),
			__METHOD__
		);
		while( $row = $dbr->fetchObject( $sth ) ) {
			$watcher = User::newFromId( $row->wl_user );

			/**
			 * check if user want to be emailed
			 */


			/**
			 * send info about creating new post
			 */
		}


		wfProfileOut( __METHOD__ );

		return true;
	}
};

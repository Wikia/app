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
		global $wgUseEnotif;

		wfProfileIn( __METHOD__ );

		if ( ! $wgUseEnotif ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( $this->mParams['user_id'] ) {
			/* registered User */
			$editor = User::newFromID( $this->mParams['user_id'] );
		} elseif ( $this->mParams['user_name'] ) {
			/* anons */
			$editor = User::newFromName( $this->mParams['user_name'], false );
		} else {
			/* invalid user */
			wfProfileOut( __METHOD__ );
			return true;
		}

		
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
		
		while ($row = $dbw->fetchObject( $res ) ) {
			$watchers[] = intval( $row->wl_user );
		}		

		if ( !empty($watchers) ) {
			$enotif = new EmailNotification();
			$title = Title::makeTitle( $ownerTitle->getNamespace(), $ownerTitle->getDBKey() );
			$enotif->actuallyNotifyOnPageChange( 
				$editor, 
				$title, 
				$this->params['timestamp'],
				$this->params['comment'],
				$this->params['minor'],
				0,
				$watchers,
				$this->params['log_action'] 
			);
							
			/* Update wl_notificationtimestamp for all watching users except the editor */
			$dbw = wfGetDB( DB_MASTER );
			$dbw->begin();
			$dbw->update( 'watchlist',
				array( 'wl_notificationtimestamp' => $dbw->timestamp( $timestamp ) ), 
				array( 
					'wl_title' 		=> $ownerTitle->getDBkey(),
					'wl_namespace'	=> $ownerTitle->getNamespace(),
					'wl_user' 		=> $watchers
				), __METHOD__
			);
			$dbw->commit();			
		}

		wfProfileOut( __METHOD__ );

		return true;
	}
};

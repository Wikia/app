<?php
/**
 * WikiaStatus
 *
 * Shows various status information used by Wikia Staff
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2009-10-26
 * @copyright Copyright © 2009 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named WikiaStatus.\n";
	exit( 1 );
}

class WikiaStatus extends UnlistedSpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'WikiaStatus'/*class*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut;

		# Do not display skin, only page body as defined below
		$wgOut->setArticleBodyOnly( true );

		# Show a message if the database is in read-only mode
		$wgOut->addHTML( 'Databse write status: ' );
		if ( wfReadOnly() ) {
			$wgOut->addHTML( 'READ-ONLY' );
		} else {
			$wgOut->addHTML( 'READ-WRITE' );
		}
	}

}

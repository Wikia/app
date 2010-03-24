<?php

/**
 * NeueWebsiteJob -- actual work on new web site
 *
 * @file
 * @ingroup JobQueue
 *
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @date 2010-03-15
 * @version 1.0
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgJobClasses[ "NeueWebsite" ] = "NeueWebsiteJob";

class NeueWebsiteJob extends Job {

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $title, $params, $id = 0 ) {
		parent::__construct( "NeueWebsite", $title, $params, $id );
		$this->mParams = $params;
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {
		global $wgUser, $wgOut;
		wfProfileIn( __METHOD__ );

		wfProfileOut( __METHOD__ );
	}

}

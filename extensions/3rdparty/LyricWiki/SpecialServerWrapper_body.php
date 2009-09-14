<?php
/**
 * ServerWrapper
 *
 * This extension is used on lyrics.wikia.com
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2009-09-10
 * @copyright Copyright © 2009 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named DownloadTemplate.\n";
        exit( 1 );
}

class ServerWrapper extends UnlistedSpecialPage {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct( 'ServerWrapper' /*class*/ );
        }

        /**
         * Show the special page
         *
         * @param $par Mixed: parameter passed to the page or null
         */
        public function execute( $par ) {
		include( 'server.php' );
		exit;
	}
}

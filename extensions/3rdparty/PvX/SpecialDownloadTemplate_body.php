<?php
/**
 * DownloadTemplate
 *
 * This extension is used on pvx.wikia.com in conjunction with PvXcode
 * to download the character build template to disk
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-05-04
 * @copyright Copyright © 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named DownloadTemplate.\n";
        exit( 1 );
}

class DownloadTemplate extends UnlistedSpecialPage {

        /**
         * Constructor
         */
        public function __construct() {
                parent::__construct( 'DownloadTemplate' /*class*/ );
        }

        /**
         * Show the special page
         *
         * @param $par Mixed: parameter passed to the page or null
         */
        public function execute( $par ) {
		$name = $_GET["name"];
		$build = $_GET["build"];

		//Begin writing headers
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Content-Type: text/force-download');

		//Sending the content...
		header('Content-Disposition: attachment; filename="' . $name . '.txt"');
		if (strlen($build) < 100) echo $_GET["build"];
		exit;
	}
}

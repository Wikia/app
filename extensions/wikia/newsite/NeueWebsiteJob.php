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

	/**
	 * make related pages data using google related info
	 *
	 * @access private
	 */
	private function makeRelated( $dom, $domdom ) {
		global $exDomainList;

		$gourl = "http://www.google.de/ie?safe=off&q=related%3A$dom&hl=de&start=0&num=30&sa=N";
		$go = Http::get( $gourl );

		if( !strstr( $go, "keine mit Ihrer Suchanfrage" ) ) {
			$matches = array();
			$newmatches = array();
			preg_match_all( '|http://([^/]+)/|', $go, $matches );
			$matches = $matches[ 1 ];

			foreach( $matches as $match ) {
				$n = strtolower($match);
				if(!strncmp($n, "www.", 4)) {
					$n = substr($n, 4);
					if(ereg($exDomainList, $n) && stripos($n, "google") === false) {
						$newmatches[] = $n;
					}
				}

				$umatches = array_unique($newmatches);

				foreach($umatches as $match) {
					// echo "match: $dom $match ---";
					wfWaitForSlaves( 5 );
					$dbw = wfGetDB( DB_MASTER );
					$qr = $dbw->query("insert into related set name1='$domdom', name2='$match'");
					// hope it works
				}
			}
		}
	}
}

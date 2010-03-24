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

	private $mTest;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $title, $params, $id = 0 ) {
		parent::__construct( "NeueWebsite", $title, $params, $id );
		$this->mParams = $params;
		$this->mTest = isset( $params[ "test" ] ) ? (bool)$params[ "test" ] : false;
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {
		global $wgUser, $wgOut;
		wfProfileIn( __METHOD__ );

		$this->makeRelated( $this->mParams[ "domain"], $this->mParams[ "key"] );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * make related pages data using google related info
	 *
	 * @access private
	 *
	 * @param String $domain -- domain name we search google against
	 * @param String $key -- primary key used in table related
	 *
	 * @todo change to multiline insert
	 * @todo change to english google
	 * @todo check what is in $exDomainList
	 * @todo replace ereg with preg_match
	 */
	private function makeRelated( $domain, $key ) {
		global $exDomainList;

		$go = Http::get( sprintf( "http://www.google.de/ie?safe=off&q=related%3A{$domain}&hl=de&start=0&num=30&sa=N" ) );

		if( !strstr( $go, "keine mit Ihrer Suchanfrage" ) ) {
			$matches = array();
			$newmatches = array();
			preg_match_all( '|http://([^/]+)/|', $go, $matches );
			print_r( $matches );
			$matches = $matches[ 1 ];

			foreach( $matches as $match ) {
				$n = strtolower($match);
				if(!strncmp($n, "www.", 4)) {
					$n = substr($n, 4);
					if(ereg($exDomainList, $n) && stripos($n, "google") === false) {
						$newmatches[] = $n;
					}
				}

				$umatches = array_unique( $newmatches );

				$dbw = wfGetDB( DB_MASTER );
				foreach($umatches as $match) {
					wfWaitForSlaves( 5 );
					if( ! $this->mTest ) {
						$qr = $dbw->query("insert into related set name1='$key', name2='$match'");
					}
					else {
						echo "insert into related set name1='$key', name2='$match'\n";
					}
				}
			}
		}
	}
}

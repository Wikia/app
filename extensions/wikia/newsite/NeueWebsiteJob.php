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

		/**
		 * curl doesn't work, google is blocking somehow it
		 */
		//$go = Http::get(
		//	"http://www.google.de/ie?safe=off&q=related%3A{$domain}&hl=de&start=0&num=30&sa=N",
		//	"default",
		//	array( CURLOPT_USERAGENT => '' )
		//);
		$fp = @fopen( "http://www.google.de/ie?safe=off&q=related%3A{$domain}&hl=de&start=0&num=30&sa=N", "r");
		$go = @fread($fp, 10240);
		$go = $go.fread($fp, 10240);
		$go = $go.fread($fp, 10240);
		$go = $go.fread($fp, 10240);
		$go = $go.fread($fp, 10240);
		fclose($fp);

		if( !strstr( $go, "keine mit Ihrer Suchanfrage" ) ) {
			$matches = array();
			$newmatches = array();
			preg_match_all( '|http://([^/]+)/|', $go, $matches );
			$matches = $matches[ 1 ];

			foreach( $matches as $match ) {
				/**
				 * only valid domain names
				 */
				if( !preg_match( "/[\d\w\.\-]+/", $match ) ) {
					continue;
				}
				$n = strtolower($match);
				if( !strncmp( $n, "www.", 4 ) ) {
					$n = substr($n, 4);
					if( preg_match( "/{$exDomainList}/", $n ) && stripos($n, "google") === false ) {
						$newmatches[] = $n;
					}
				}

				$newmatches = array_unique( $newmatches );
				$sites = array();

			}
			$dbw = wfGetDB( DB_MASTER );
			foreach( $newmatches as $match ) {
				$sites[] = array( "name1" => $key, "name2" => $match );
			}

			if( !$this->mTest ) {
				wfWaitForSlaves( 5 );
				$dbw->insert( "related", $sites, __METHOD__ );
			}
		}
		else {
			echo "0 related sites\n";
		}
	}
}

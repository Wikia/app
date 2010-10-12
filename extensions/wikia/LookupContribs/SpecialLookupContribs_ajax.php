<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n";
	exit( 1 ) ;
}

############################## Ajax ##################################
class LookupContribsAjax {	
	function __construct() { /* not used */ }

	function axData() {
		global $wgRequest, $wgUser;
		
		//$dbname, $username, $mode, $limit = 25, $offset = 0, $nspace = -1
		
		if ( empty($wgUser) ) { return ""; }
		if ( $wgUser->isBlocked() ) { return ""; }
		if ( !$wgUser->isLoggedIn() ) { return ""; }
		if ( !$wgUser->isAllowed( 'lookupcontribs' ) ) {
			return ""; #--- later change to something reasonable
		}
	
		$oLC = new LookupContribsCore($username);
		$aResponse = array();
		if ( $oLC->checkUser() ) {
			$data = $oLC->fetchContribs($dbname, $mode, $nspace);
			/* order by timestamp desc */
			$nbr_records = 0;
			$result = array();
			$res = array();
			if ( !empty($data) && is_array($data) ) {
				$result = array_slice($data, $offset*$limit, $limit, true);
				$loop = 0;
				foreach ($result as $date => $row) {
					$res[$loop] = $oLC->produceLine($row, $username, $mode);
					$loop++;
				}
				$nbr_records = $oLC->getNumRecords();
			}
			
			$aResponse = array(
				"nbr_records" => intval($nbr_records), 
				"limit" => $limit, 
				"offset" => $offset, 
				"nspace" => $nspace,
				"res" => $res
			);
		}
		return Wikia::json_encode($aResponse);
	}
}

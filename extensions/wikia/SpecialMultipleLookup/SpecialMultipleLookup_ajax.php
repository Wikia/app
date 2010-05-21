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

# ############################# Ajax ##################################

function axWMultiLookupUserActivityDetails( $dbname, $ip, $limit = 25, $offset = 0 )
{
	global $wgRequest, $wgUser;
	if ( empty( $wgUser ) ) { return ""; }
	if ( $wgUser->isBlocked() ) { return ""; }
	if ( !$wgUser->isLoggedIn() ) { return ""; }
	if ( !$wgUser->isAllowed( 'lookupcontribs' ) ) {
		return ""; # --- later change to something reasonable
	}

	$mLCCore = new MultipleLookupCore( $ip );
	$aResponse = array();
	if ( $mLCCore->checkIp() ) {
		$data = $mLCCore->fetchContribs ( $dbname );
  		/* order by timestamp desc */
  		$nbr_records = 0;
  		$result = array();
		$res = array();
		if ( !empty( $data ) && is_array( $data ) ) {
			ksort( $data );
			$result = array_slice( $data, $offset * $limit, $limit, true );
			$loop = 0;
			foreach ( $result as $date => $row ) {
				$res[$loop] = $mLCCore->produceLine( $row, $ip );
				$loop++;
			}
			$nbr_records = count( $data );
		}
		$aResponse = array( "nbr_records" => intval( $nbr_records ), "limit" => $limit, "offset" => $offset, "res" => $res );
	}

	if ( !function_exists( 'json_encode' ) ) {
		$oJson = new Services_JSON();
		return $oJson->encode( $aResponse );
	} else {
		return json_encode( $aResponse );
	}
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "axWMultiLookupUserActivityDetails";

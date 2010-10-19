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
############################## Ajax ##################################
class MultiLookupAjax {	
	function __construct() { /* not used */ }

	function axData() {
		global $wgRequest, $wgUser,	$wgCityId, $wgDBname, $wgLang;
		
        wfProfileIn( __METHOD__ );
	
		$username 	= $wgRequest->getVal('username');
		$dbname		= $wgRequest->getVal('wiki');
		$limit		= $wgRequest->getVal('limit');
		$offset		= $wgRequest->getVal('offset');
		$loop		= $wgRequest->getVal('loop');
		$order		= $wgRequest->getVal('order');
		$numOrder	= $wgRequest->getVal('numOrder');

		$result = array(
			'sEcho' => intval($loop), 
			'iTotalRecords' => 0, 
			'iTotalDisplayRecords' => 0, 
			'sColumns' => '',
			'aaData' => array()
		);
				
		//$dbname, $username, $mode, $limit = 25, $offset = 0, $nspace = -1
		
		if ( empty($wgUser) ) { return ""; }
		if ( $wgUser->isBlocked() ) { return ""; }
		if ( !$wgUser->isLoggedIn() ) { return ""; }
		if ( !$wgUser->isAllowed( 'lookupcontribs' ) ) {
			wfProfileOut( __METHOD__ );			
			return Wikia::json_encode($result); 
		}

		$oML = new MultipleLookupCore($username);
		if ( empty($dbname) ) {
			$oML->setLimit($limit);
			$oML->setOffset($offset);
			$activity = $oML->checkUserActivity();
			if ( !empty($activity) ) {
				$result['iTotalRecords'] = intval($limit); #( isset( $records['cnt'] ) ) ?  intval( $records['cnt'] ) : 0;
				$result['iTotalDisplayRecords'] = count($activity);
				$result['sColumns'] = 'id,dbname,title,url,options';
				$rows = array();			
				$data = array_slice($activity, $offset, $limit);
				$loop = 1;
				foreach ( $data as $row ) {
					$rows[] = array(
						$loop + $offset, // wiki Id
						$row[0], // wiki dbname
						$row[1], //wiki title
						$row[2], // wiki url 
						'' //options
					);			
					$loop++;				
				}
				$result['aaData'] = $rows;
			}
		} else {
			$oML->setDBname($dbname);
			$oML->setLimit($limit);
			$oML->setOffset($offset);
			$data = $oML->fetchContribs();
			/* order by timestamp desc */
			$nbr_records = 0;
			if ( !empty($data) && is_array($data) ) {
				$result['iTotalRecords'] = intval($limit); #( isset( $records['cnt'] ) ) ?  intval( $records['cnt'] ) : 0;
				$result['iTotalDisplayRecords'] = $oML->getNumRecords();
				$result['sColumns'] = 'id,dbname,title,edit';
				$rows = array();
				if ( isset($data) ) {
					$loop = 1;
					foreach ($data as $user_name => $row) {
						list ($link, $last_edit) = array_values($oML->produceLine( $row ));
						$rows[] = array(
							$loop + $offset, // id
							$dbname,
							$link, // title 
							$last_edit
						);
						$loop++;
					}
				}
				$result['aaData'] = $rows;					
			}
		}
		
		wfProfileOut( __METHOD__ );			
		return Wikia::json_encode($result); 
	}
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "MultiLookupAjax::axData";

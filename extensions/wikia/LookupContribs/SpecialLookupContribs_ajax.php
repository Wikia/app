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
		global $wgRequest, $wgUser,	$wgCityId, $wgDBname, $wgLang;
		
        wfProfileIn( __METHOD__ );
	
		$username 	= $wgRequest->getVal('username');
		$dbname		= $wgRequest->getVal('wiki');
		$mode 		= $wgRequest->getVal('mode');
		$nspace		= $wgRequest->getVal('ns', -1);
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
	
		$oLC = new LookupContribsCore($username);
		if ( $oLC->checkUser() ) {		
			if ( empty($mode) ) {
				$oLC->setLimit($limit);
				$oLC->setOffset($offset);
				$activity = $oLC->checkUserActivity();
				if ( !empty($activity) ) {
					$result['iTotalRecords'] = intval($limit); #( isset( $records['cnt'] ) ) ?  intval( $records['cnt'] ) : 0;
					$result['iTotalDisplayRecords'] = intval($activity['cnt']);
					$result['sColumns'] = 'id,dbname,title,url,lastedit,options';
					$rows = array();					
					foreach ( $activity['data'] as $row ) {
						$rows[] = array(
							$row['id'], // wiki Id
							$row['dbname'], // wiki dbname
							$row['title'], //wiki title
							$row['url'], // wiki url 
							$wgLang->timeanddate( wfTimestamp( TS_MW, $row['last_edit'] ), true ), //last edited
							'' //options
						);							
					}
					$result['aaData'] = $rows;
				}
			} else {
				$oLC->setDBname($dbname);
				$oLC->setMode($mode);
				$oLC->setNamespaces($nspace);
				$oLC->setLimit($limit);
				$oLC->setOffset($offset);
				$data = $oLC->fetchContribs();
				/* order by timestamp desc */
				$nbr_records = 0;
				$result = array();
				$res = array();
				if ( !empty($data) && is_array($data) ) {
					$result['iTotalRecords'] = intval($limit); #( isset( $records['cnt'] ) ) ?  intval( $records['cnt'] ) : 0;
					$result['iTotalDisplayRecords'] = intval($data['cnt']);
					$result['sColumns'] = 'id,title,diff,history,contribution,edit';
					$rows = array();					
					if ( isset($data['data']) ) {
						$loop = 1;
						foreach ($data['data'] as $id => $row) {
							list ($link, $diff, $hist, $contrib, $edit, $removed) = array_values($oLC->produceLine( $row ));
							$rows[] = array(
								$loop + $offset, // id
								$link, // title 
								$diff, // diff 
								$hist, // history
								$contrib, //user contribution (link to special page)
								$edit
							);
							$loop++;
						}
					}
					$result['aaData'] = $rows;					
				}
			}
		}
		
		wfProfileOut( __METHOD__ );			
		return Wikia::json_encode($result); 
	}
}

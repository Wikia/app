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
		$lookupUser = $wgRequest->getBool('lookupUser');

		$result = array(
			'sEcho' => intval($loop), 
			'iTotalRecords' => 0, 
			'iTotalDisplayRecords' => 0, 
			'sColumns' => '',
			'aaData' => array()
		);
				
		//$dbname, $username, $mode, $limit = 25, $offset = 0, $nspace = -1
		
		if ( empty($wgUser) ) {
			wfProfileOut(__METHOD__);
			return "";
		}
		if ( $wgUser->isBlocked() ) {
			wfProfileOut(__METHOD__);
			return "";
		}
		if ( !$wgUser->isLoggedIn() ) {
			wfProfileOut(__METHOD__);
			return "";
		}
		if ( !$wgUser->isAllowed( 'lookupcontribs' ) ) {
			wfProfileOut( __METHOD__ );			
			return json_encode($result); 
		}
	
		$oLC = new LookupContribsCore($username);
		if ( $oLC->checkUser() ) {
			if ( empty($mode) ) {
				$oLC->setLimit($limit);
				$oLC->setOffset($offset);
				$activity = $oLC->checkUserActivity($lookupUser, $order); 
				if ( !empty($activity) ) {
					$result['iTotalRecords'] = intval($limit); #( isset( $records['cnt'] ) ) ?  intval( $records['cnt'] ) : 0;
					$result['iTotalDisplayRecords'] = intval($activity['cnt']);
					
					if( $lookupUser === true ) {
						$result['sColumns'] = 'id,title,url,lastedit,edits,userrights,blocked';
						$result['aaData'] = LookupContribsAjax::prepareLookupUserData($activity['data'], $username);
					} else {
						$result['sColumns'] = 'id,dbname,title,url,lastedit,options';
						$result['aaData'] = LookupContribsAjax::prepareLookupContribsData($activity['data']);
					}
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
		return json_encode($result); 
	}
	
	/**
	 * @brief Generates row data for user if ajax call was sent from Special:LookupContribs
	 * 
	 * @param array $activityData data retrieved from LookupContribsCore::checkUserActivity()
	 * 
	 * @return array
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public static function prepareLookupContribsData($activityData) {
		global $wgLang;
		
		$rows = array();
		foreach( $activityData as $row ) {
			$rows[] = array(
				$row['id'], // wiki Id
				$row['dbname'], // wiki dbname
				$row['title'], //wiki title
				$row['url'], // wiki url 
				$wgLang->timeanddate( wfTimestamp( TS_MW, $row['last_edit'] ), true ), //last edited
				'' //options
			);
		}
		
		return $rows;
	}
	
	/**
	 * @brief Generates row data for user if ajax call was sent from Special:LookupUser
	 * 
	 * @param array $activityData data retrieved from LookupContribsCore::checkUserActivity()
	 * 
	 * @return array
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public static function prepareLookupUserData($activityData, $username) {
		global $wgLang, $wgContLang;
		
		$rows = array();
		foreach( $activityData as $row ) {
			$rows[] = array(
				$row['id'], // wiki Id
				$row['title'], //wiki title
				$row['url'], // wiki url 
				$wgLang->timeanddate( wfTimestamp( TS_MW, $row['last_edit'] ), true ), //last edited
				$wgContLang->formatNum($row['editcount']),
				LookupUserPage::getUserData($username, $row['id'], $row['url']), //user rights
				LookupUserPage::getUserData($username, $row['id'], $row['url'], true), //blocked
			);
		}
		
		return $rows;
	}
}

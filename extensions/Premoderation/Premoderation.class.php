<?php
class Premoderation {
	public static function initialize() {
		global $wgPremoderationType, $wgPremoderationLockPages;
		global $wgHooks, $wgAbuseFilterCustomActionsHandlers;
		
		switch( $wgPremoderationType ) {
			case 'all':
				$wgHooks['ArticleSave'][] = 'Premoderation::processEditRequest';
				break;
			
			case 'abusefilter':
				if( !class_exists( 'AbuseFilter' ) ) {
					exit( 'You must install AbuseFilter extension before using option $wgPremoderationType = \'abusefilter\'.' );
				}
				$wgAbuseFilterAvailableActions[] = 'moderation';
				$wgAbuseFilterCustomActionsHandlers['moderation'] = 'Premoderation::handleAFAction';
				break;
		}
		
		if( $wgPremoderationLockPages ) {
			$wgHooks['getUserPermissionsErrorsExpensive'][] = 'Premoderation::checkQueue';
		}
		
		$wgHooks['ArticleEditUpdatesDeleteFromRecentchanges'][] = 'Premoderation::deleteOldQueueEntries';
		$wgHooks['LoadExtensionSchemaUpdates'][] = 'Premoderation::updateDBSchema';
		
		return true;
	}
	
	public static function processEditRequest( &$article, &$user, &$text, &$summary, $minor, $watchthis,
		$sectionanchor, &$flags, &$status )
	{
		$userIP = wfGetIP();
		if( $user->isAllowed( 'skipmoderation' ) || self::checkWhitelist( $userIP ) ) {
			return true;
		}
		
		$title = $article->mTitle;
		
		$dbw = wfGetDB( DB_MASTER );
		$dbQuery = array(
			'pmq_id' => '',
			'pmq_page_last_id' => $title->getLatestRevID(),
			'pmq_page_ns' => $title->getNamespace(),
			'pmq_page_title' => $title->getDBkey(),
			'pmq_user' => $user->getID(),
			'pmq_user_text' => $user->getName(),
			'pmq_timestamp' => $dbw->timestamp( wfTimestampNow() ),
			'pmq_minor' => $minor,
			'pmq_summary' => $summary,
			'pmq_len' => $title->getLength(),
			'pmq_text' => $text,
			'pmq_flags' => $flags,
			'pmq_ip' => $userIP,
			'pmq_status' => 'new'
		);
		$dbw->insert( 'pm_queue', $dbQuery, __METHOD__ );
		$dbw->commit();
		
		throw new ErrorPageError( 'premoderation-success', 'premoderation-added-success-text' );
		return true;
	}
	
	public static function handleAFAction( $action, $parameters, $title, $vars, $rule_desc ) {
		global $wgUser;
		
		$dbw = wfGetDB( DB_MASTER );
		$dbQuery = array(
			'pmq_id' => '',
			'pmq_page_last_id' => $title->getLatestRevID(),
			'pmq_page_ns' => $title->getNamespace(),
			'pmq_page_title' => $title->getDBkey(),
			'pmq_user' => $wgUser->getID(),
			'pmq_user_text' => $wgUser->getName(),
			'pmq_timestamp' => $dbw->timestamp( wfTimestampNow() ),
			'pmq_minor' => $vars->getVar( 'minor_edit' )->toInt(),
			'pmq_summary' => $vars->getVar( 'summary' )->toString(),
			'pmq_len' => $title->getLength(),
			'pmq_text' => $vars->getVar( 'new_wikitext' )->toString(),
			'pmq_flags' => false,
			'pmq_ip' => wfGetIP(),
			'pmq_status' => 'new'
		);
		$dbw->insert( 'pm_queue', $dbQuery, __METHOD__ );
		$dbw->commit();
		
		return true;
	}
	
	public static function loadWhitelist() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'pm_whitelist', '*', '', array( 'LIMIT' => 500 ) );
		
		$test = $dbr->fetchRow( $res );
		if( !$test ) {
			return true;
		}
		
		$returnArray = array( $test['pmw_ip'] );
		while( $row = $dbr->fetchRow( $res ) ) {
			$returnArray[] = $row['pmw_ip'];
		}
		
		return $returnArray;
	}
	
	public static function checkWhitelist( $ip ) {
		global $wgMemc;
		
		$whitelist = self::loadWhitelist();
		
		$memcKey = wfMemcKey( 'whitelisted', $ip );
		$data = $wgMemc->get( $memcKey );
		
		if( $data != '' ) {
			return ( $data === 'ok' ) ? true : false;
		}
		
		if( is_array( $whitelist ) ) {
			foreach( $whitelist as $entry ) {
				if( IP::isInRange( $ip, $entry ) ) {
					$wgMemc->set( $memcKey, 'ok', 86400 );
					return true;
				}
			}
		}
		
		$wgMemc->set( $memcKey, 'not', 86400 );
		return false;
	}
	
	public static function formatParams( $params ) {
		$result = array();
		while( count( $params ) > 1 ) {
			$key = array_shift( &$params );
			$value = array_shift( &$params );
			$result[$key] = $value;		
		}
		
		return $result;		
	}
	
	public static function checkQueue( $title, $user, $action, &$result ) {
		if( $action == 'edit' ) {
			$dbr = wfGetDB( DB_SLAVE );
			
			$conds = 'pmq_page_ns = ' . $dbr->addQuotes( $title->getNamespace() ) . ' AND pmq_page_title = ' .
				$dbr->addQuotes( $title->getDBkey() ) . ' AND pmq_status != "approved"';
			$res = $dbr->select( 'pm_queue', '*', $conds, __METHOD__ );
			
			$test = $dbr->fetchRow( $res );
			
			if( $test ) {
				$result[] = array( 'premoderation-edit-conflict' );
				return false;
			}
		}
		return true;
	}
	
	public static function deleteOldQueueEntries() {
		global $wgPremoderationDeclinedPurge, $wgPremoderationNewPurge;
		
		if( mt_rand( 0, 49 ) == 0 ) {
			$dbw = wfGetDB( DB_MASTER );
			
			$conds = '( pmq_status = \'new\' AND pmq_timestamp < \'' . intval( $dbw->timestamp( time() -
				$wgPremoderationNewPurge ) ) . '\' ) OR ( pmq_status = \'declined\' AND pmq_timestamp < \'' .
				intval( $dbw->timestamp( time() - $wgPremoderationDeclinedPurge ) ) . '\' ) OR ' .
				'pmq_status = \'approved\'';
			$dbw->delete( 'pm_queue', array( $conds ), __METHOD__ );
		}
		return true;
	}
	
	public static function updateDBSchema( $updater ) {
		$updater->addExtensionUpdate( array( 'addTable', 'pm_queue',
			dirname( __FILE__ ) . '/db_queue.sql', true ) );
		$updater->addExtensionUpdate( array( 'addTable', 'pm_whitelist',
			dirname( __FILE__ ) . '/db_whitelist.sql', true ) );
		return true;
	}
}
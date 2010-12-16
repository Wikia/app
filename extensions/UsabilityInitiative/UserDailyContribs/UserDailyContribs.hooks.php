<?php

/**
 * Hooks for Usability Initiative UserDailyContribs extension
 *
 * @file
 * @ingroup Extensions
 */

class UserDailyContribsHooks {
	
	public static function schema() {
		global $wgExtNewTables;

		$wgExtNewTables[] = array(
			'user_daily_contribs',
			dirname( __FILE__ ) . '/UserDailyContribs.sql'
		);

		return true;
	}
	
	/**
	 * Hook for making sure parser tests pass
	 * @param $tables
	 * @return unknown_type
	 */
	public static function parserTestTables( &$tables ) {
		$tables[] = 'user_daily_contribs';
		return true;
	}
	
	/**
	 * Stores a new contribution
	 * @return true
	 */
	public static function storeNewContrib(){
		global $wgUser;
		$today = gmdate( 'Ymd', time() );
		$dbw = wfGetDB( DB_MASTER );
		
		$dbw->update( 'user_daily_contribs', array( 'contribs=contribs+1' ), 
    				   array( 'day' => $today, 'user_id' => $wgUser->getId() ),
  					   __METHOD__ );
		
		if($dbw->affectedRows() == 0){
			$dbw->insert("user_daily_contribs", array("user_id" => $wgUser->getId(), "day" => $today, "contribs" => 1), __METHOD__);	
		}
	
		return true;
	}
	
}
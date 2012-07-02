<?php
/**
 * Hooks for UserDailyContribs extension
 *
 * @file
 * @ingroup Extensions
 */

class UserDailyContribsHooks {
	
	/* Static Methods */
	
	/**
	 * LoadExtensionSchemaUpdates hook
	 */
	public static function loadExtensionSchemaUpdates( $updater = null ) {
		if ( $updater === null ) {
			global $wgExtNewTables;
			$wgExtNewTables[] = array( 'user_daily_contribs', dirname( __FILE__ ) . '/patches/UserDailyContribs.sql' );
		} else {
			$updater->addExtensionUpdate( array( 'addTable', 'user_daily_contribs',
				dirname( __FILE__ ) . '/patches/UserDailyContribs.sql', true ) );
		}
		return true;
	}
	
	/**
	 * ParserTestTables hook
	 * 
	 * @param $tables
	 * @return unknown_type
	 */
	public static function parserTestTables( &$tables ) {
		$tables[] = 'user_daily_contribs';
		return true;
	}
	
	/**
	 * ArticleSaveComplete hook
	 * 
	 * Stores a new contribution
	 * 
	 * @return true
	 */
	public static function articleSaveComplete( $article, $user ){
		$today = gmdate( 'Ymd', time() );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'user_daily_contribs',
			array( 'contribs=contribs+1' ), 
			array( 'day' => $today, 'user_id' => $user->getId() ),
  			__METHOD__
  		);
		if ( $dbw->affectedRows() == 0 ){
			$dbw->insert(
				'user_daily_contribs',
				array( 'user_id' => $user->getId(), 'day' => $today, 'contribs' => 1 ),
				__METHOD__
			);	
		}
		return true;
	}
}

<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

/** Provides hooks for the CollabWatchlist extension
 * @author fhackenberger
 */
class CollabWatchlistHooks {
	/** Provide info for the DB schem upgrade framework */
	public static function onLoadExtensionSchemaUpdates( $updater ) {
		$sqlDir = dirname(__FILE__) . '/sql/';
		$updater->addExtensionUpdate( array ( 'addTable', 'collabwatchlist',
			$sqlDir . 'collabwatchlist.sql', true ) );
		$updater->addExtensionUpdate( array ( 'addTable', 'collabwatchlistuser',
			$sqlDir . 'collabwatchlistuser.sql', true ) );
		$updater->addExtensionUpdate( array ( 'addTable', 'collabwatchlistcategory',
			$sqlDir . 'collabwatchlistcategory.sql', true ) );
		$updater->addExtensionUpdate( array ( 'addTable', 'collabwatchlistrevisiontag',
			$sqlDir . 'collabwatchlistrevisiontag.sql', true ) );
		$updater->addExtensionUpdate( array ( 'addTable', 'collabwatchlisttag',
			$sqlDir . 'collabwatchlisttag.sql', true ) );
		$updater->addExtensionUpdate( array( 'addField', 'collabwatchlistrevisiontag', 'ct_rc_id',
			$sqlDir . 'patch-collabwatchlist_noctid.sql', true ) );
		$updater->addExtensionUpdate( array( 'addField', 'collabwatchlist', 'cw_id',
			$sqlDir . 'patch-collabwatchlist_rename_fields.sql', true ) );
		$updater->addExtensionUpdate( array( 'addField', 'collabwatchlistuser', 'rlu_type',
			$sqlDir . 'patch-collabwatchlist_remove_enum.sql', true ) );
		$updater->addExtensionUpdate( array( 'modifyField', 'collabwatchlisttag', 'rt_id',
			$sqlDir . 'patch-collabwatchlist_remove_primary_keys.sql', true ) );
		return true;
	}

	public static function onGetPreferences( $user, &$preferences ) {
		$preferences['collabwatchlisthidelistuser'] = array(
			'type' => 'toggle',
			'label-message' => 'tog-collabwatchlisthidelistusers',
			'section' => 'watchlist/advancedwatchlist',
		);
		return true;
	}
	
	public static function onUnitTestsList( &$files ) {
		$files[] = dirname( __FILE__ ) . '/tests/CollabWatchlistTest.php';
		return true;
	}
}

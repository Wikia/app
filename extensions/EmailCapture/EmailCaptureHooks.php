<?php
/**
 * Hooks for EmailCapture extension
 */
class EmailCaptureHooks {
	/**
	 * LoadExtensionSchemaUpdates hook
	 *
	 * @param $updater DatabaseUpdater
	 * @return bool
	 */
	public static function loadExtensionSchemaUpdates( $updater ) {
		$db = $updater->getDB();
		if ( !$db->tableExists( 'email_capture' ) ) {
			// Initial install tables
			$updater->addExtensionUpdate( array(
				'addTable',
				'email_capture',
				dirname( __FILE__ ) . '/sql/CreateEmailCaptureTable.sql',
				true
			) );
		}
		return true;
	}

	/**
	 * ParserTestTables hook
	 */
	public static function parserTestTables( &$tables ) {
		$tables[] = 'email_capture';
		return true;
	}
}

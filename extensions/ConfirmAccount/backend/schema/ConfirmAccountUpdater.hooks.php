<?php
/**
 * Class containing updater functions for a ConfirmAccount environment
 */
class ConfirmAccountUpdaterHooks {

	/**
	 * @param DatabaseUpdater $updater
	 * @return bool
	 */
	public static function addSchemaUpdates( DatabaseUpdater $updater ) {
		$base = dirname( __FILE__ );
		if ( $updater->getDB()->getType() == 'mysql' ) {
			$base = "$base/mysql";

			$updater->addExtensionTable( 'account_requests', "$base/ConfirmAccount.sql" );
			$updater->addExtensionField( 'account_requests', 'acr_filename', "$base/patch-acr_filename.sql" );
			$updater->addExtensionTable( 'account_credentials', "$base/patch-account_credentials.sql" );
			$updater->addExtensionField( 'account_requests', 'acr_areas', "$base/patch-acr_areas.sql" );
			$updater->addExtensionIndex( 'account_requests', 'acr_email', "$base/patch-email-index.sql" );
		} elseif ( $updater->getDB()->getType() == 'postgres' ) {
			$base = "$base/postgres";

			$updater->addExtensionUpdate( array( 'addTable', 'account_requests', "$base/ConfirmAccount.pg.sql", true ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'account_requests', 'acr_held', "TIMESTAMPTZ" ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'account_requests', 'acr_filename', "TEXT" ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'account_requests', 'acr_storage_key', "TEXT" ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'account_requests', 'acr_comment', "TEXT NOT NULL DEFAULT ''" ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'account_requests', 'acr_type', "INTEGER NOT NULL DEFAULT 0" ) );
			$updater->addExtensionUpdate( array( 'addTable', 'account_credentials', "$base/patch-account_credentials.sql", true ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'account_requests', 'acr_areas', "TEXT" ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'account_credentials', 'acd_areas', "TEXT" ) );
			$updater->addExtensionUpdate( array( 'addIndex', 'account_requests', 'acr_email', "$base/patch-email-index.sql", true ) );
		}
		return true;
	}
}

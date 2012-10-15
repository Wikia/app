<?php
/**
 * Schema generation and such
 */
class WikimaniaSchema {
	/**
	 * Hook for LoadExtensionSchemaUpdates
	 * @param $updater DatabaseUpdater object
	 * @return bool
	 */
	public static function hook( $updater = null ) {
		if( !$updater ) {
			$updater->output( "Wikimania Extension requires MW 1.17+" );
		} else {

		}
		return true;
	}
}

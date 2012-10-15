<?php

class InterfaceConcurrencyHooks {
	/**
	 * Runs InterfaceConcurrency schema updates#
	 *
	 * @param $updater DatabaseUpdater
	 */
	public static function onLoadExtensionSchemaUpdates( $updater = null ) {
		$dir = dirname( __FILE__ ) . '/sql';

		$updater->addExtensionTable( 'concurrencycheck', "$dir/concurrencycheck.sql" );

		return true;
	}
}

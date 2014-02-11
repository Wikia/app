<?php

ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( 'commandLine.inc' );

/**
 * Class CollectRestrictedWikis
 *
 * Collects restricted wikis and saves the list in the global_registry database;
 *
 * @author Evgeniy (aquilax)
 */
class CollectRestrictedWikis {

	/**
	 * Checks if wiki is restricted for all users (*)
	 *
	 * @param $value string wgGroupPermissionsLocalId content
	 * @return bool True if wiki is restricted
	 */
	private static function isRestrictedWiki( $value ) {
		$permissions = WikiFactoryLoader::parsePermissionsSettings( $value );
		if (
			isset( $permissions['*'] ) &&
			is_array( $permissions['*'] ) &&
			isset( $permissions['*']['read'] ) &&
			$permissions['*']['read'] === false
		) {
			return true;
		}
		return false;
	}

	/**
	 * Collect restricted wiki ids
	 */
	public static function collectAndSave() {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$res = $dbr->select( 'city_variables',
			array(
				'cv_city_id',
				'cv_value'
			),
			array(
				'cv_variable_id' => WikiFactory::getVarIdByName( 'wgGroupPermissionsLocal' )
			),
			__FUNCTION__
		);

		$count = $dbr->numRows ( $res );
		$restrictedWikis = array();
		$i = 0;
		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( self::isRestrictedWiki( $row['cv_value'] ) ) {
				$restrictedWikis[] = (int)$row['cv_city_id'];
			}
			if ( $i % 1000 == 0 ) {
				echo $i.'/'.$count.PHP_EOL;
			}
			$i++;
		}
		UserProfilePageHelper::saveRestrictedWikisDB( $restrictedWikis );
	}
}

CollectRestrictedWikis::collectAndSave();

<?php

ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( 'commandLine.inc' );

class CollectHiddenWikias {

	private static function isHiddenWiki( $value ) {
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

	public static function collect() {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$wgGroupPermissionsLocalId = 535;

		$sql = 'SELECT cv_city_id, cv_value
				FROM city_variables
				WHERE cv_variable_id = ' . $wgGroupPermissionsLocalId .';';

		$res = $dbr->query( $sql, __FUNCTION__ );
		$count = $dbr->numRows ( $res );
		$hiddenWikis = array();
		$i = 0;
		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( self::isHiddenWiki( $row['cv_value'] ) ) {
				$hiddenWikis[] = (int)$row['cv_city_id'];
			}
			if ($i % 1000 == 0) {
				echo $i.'/'.$count.PHP_EOL;
			}
			$i++;
		}
		UserProfilePageHelper::saveRestrictedWikisDB( $hiddenWikis );
	}
}
CollectHiddenWikias::collect();

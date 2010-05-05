<?php
/*
 * Copyright © 2010 Garrett Brown <http://www.mediawiki.org/wiki/User:Gbruin>
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 */


/*
 * Not a valid entry point, skip unless MEDIAWIKI is defined.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}


/**
 * Class FBConnectDB
 * 
 * This class abstracts the manipulation of the custom table used by this
 * extension. If $wgDBprefix is set, this class will pull from the translated
 * tables. If the table 'users_fbconnect' does not exist in your database
 * you will receive errors like this:
 * 
 * Database error from within function "FBConnectDB::getUser". Database
 * returned error "Table 'user_fbconnect' doesn't exist".
 * 
 * In this case, you will need to fix this by running the MW updater:
 * >php maintenance/update.php
 */
class FBConnectDB {
	/**
	 * Find the Facebook IDs of the given user, if any.
	 */
	public static function getFacebookIDs( $user ) {
		$fbid = array();
		if ( $user instanceof User && $user->getId() != 0 ) {
			$prefix = self::getPrefix();
			
			// NOTE: Do not just pass this dbr into getFacebookIDsFromDB since that function prevents
			// rewriting of the database name for shared tables.
			$dbr = wfGetDB( DB_SLAVE, array(), self::sharedDB() );
			$res = $dbr->select(
				array( "{$prefix}user_fbconnect" ),
				array( 'user_fbid' ),
				array( 'user_id' => $user->getId() ),
				__METHOD__
			);
			foreach( $res as $row ) {
				$fbid[] = $row->user_fbid;
			}
			$res->free();
		}
		return $fbid;
	}
	
	/**
	 * Find the Facebook IDs of the given user, if any, using the database connection provided.
	 *
	 * This function will use the dbr provided and will use grave-accents around the table-name
	 * which will prevent the DB class from rewriting the database name.
	 */
	public static function getFacebookIDsFromDB( $user, $dbr ){
		$fbid = array();
		if ( $user instanceof User && $user->getId() != 0 ) {
			$prefix = self::getPrefix();
			$res = $dbr->select(
				array( "`{$prefix}user_fbconnect`" ),
				array( 'user_fbid' ),
				array( 'user_id' => $user->getId() ),
				__METHOD__
			);
			foreach( $res as $row ) {
				$fbid[] = $row->user_fbid;
			}
			$res->free();
		}
		return $fbid;
	}

	/**
	 * Find the user by their Facebook ID.
	 */
	public static function getUser( $fbid ) {
		$prefix = self::getPrefix();
		$dbr = wfGetDB( DB_SLAVE, array(), self::sharedDB() );
		$id = $dbr->selectField(
			"{$prefix}user_fbconnect",
			'user_id',
			array( 'user_fbid' => $fbid ),
			__METHOD__
		);
		if ( $id ) {
			return User::newFromId( $id );
		} else {
			return null;
		}
	}
	
	/**
	 * Add a User <-> Facebook ID association to the database.
	 */
	public static function addFacebookID( $user, $fbid ) {
		wfProfileIn(__METHOD__);
		if( !wfRunHooks( 'FBConnectDB::addFacebookID', array( $user, $fbid ) ) ){
			return;
		}

		$prefix = self::getPrefix();
		$dbw = wfGetDB( DB_MASTER, array(), self::sharedDB() );
		$dbw->insert(
			"{$prefix}user_fbconnect",
			array(
				'user_id' => $user->getId(),
				'user_fbid' => $fbid
			),
			__METHOD__
		);
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Remove a User <-> Facebook ID association from the database.
	 */
	public static function removeFacebookID( $user, $fbid ) {
		$prefix = self::getPrefix();
		$dbw = wfGetDB( DB_MASTER, array(), self::sharedDB() );
		$dbw->delete(
			"{$prefix}user_fbconnect",
			array(
				'user_id' => $user->getId(),
				'user_fbid' => $fbid
			),
			__METHOD__
		);
		return (bool) $dbw->affectedRows();
	}
	
	/**
	 * Estimates the total number of User <-> Facebook ID associations in the
	 * database. If there are no users, then the estimate will probably be 1.
	 */
	public static function countUsers() {
		$prefix = self::getPrefix();
		$dbr = wfGetDB( DB_SLAVE, array(), self::sharedDB() );
		// An estimate is good enough for choosing a unique nickname
		$count = $dbr->estimateRowCount("{$prefix}user_fbconnect");
		// Avoid returning 0 or -1
		return $count >= 1 ? $count : 1;
	}
	
	/**
	 * Returns the name of the shared database, if one is in use for the Facebook
	 * Connect users table. Note that 'user_fbconnect' (without respecting
	 * $wgSharedPrefix) is added to $wgSharedTables in FBConnect::init by default.
	 * This function can also be used as a test for whether a shared database for
	 * Facebook Connect users is in use.
	 * 
	 * See also: <http://www.mediawiki.org/wiki/Manual:Shared_database>
	 */
	private static function sharedDB() {
		global $wgSharedDB;
		// If a shared DB is not configured, return false
		if (!empty($wgSharedDB)) {
			// Test to see if the table 'user_fbconnect' is shared
			global $wgSharedTables, $wgSharedPrefix;
			// Include 'user_fbconnect' in case someone forgot to set the shared prefix
			if (in_array('user_fbconnect', $wgSharedTables) ||
			    in_array("{$wgSharedPrefix}user_fbconnect", $wgSharedTables)) {
				return $wgSharedDB;
			}
		}
		return false;
	}
	
	/**
	 * Returns the table prefix name, either $wgDBprefix, $wgSharedPrefix
	 * depending on whether a shared database is in use.
	 */
	private static function getPrefix() {
		global $wgDBprefix, $wgSharedPrefix;
		return self::sharedDB() ? $wgSharedPrefix : $wgDBprefix;
	}
}

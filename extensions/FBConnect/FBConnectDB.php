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
	 * Find the Facebook IDs of the given user, if any, using the database connection provided.
	 *
	 */
	public static function getFacebookIDs( $user, $db = DB_SLAVE  ) {
		global $wgMemc;
		
		$dbr = wfGetDB( $db, array(), self::sharedDB() );
		$fbid = array();
		if ( $user instanceof User && $user->getId() != 0 ) {
			$memkey = wfMemcKey( "fb_user_id", $user->getId() );
			$val = $wgMemc->get($memkey);
			if ( ( is_array($val) ) &&  ( $db == DB_SLAVE ) ){
				return $val;
			}
			
			$prefix = self::getPrefix();
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
			$wgMemc->set($memkey,$fbid);
		}
		return $fbid;
	}

	/**
	 * Find the user by their Facebook ID.
	 * If there is no user found for the given id, returns null.
	 */
	public static function getUser( $fbid ) {
		$prefix = self::getPrefix();

		// NOTE: Do not just pass this dbr into getUserByDB since that function prevents
		// rewriting of the database name for shared tables.
		$dbr = wfGetDB( DB_SLAVE, array(), self::sharedDB() );

		$id = $dbr->selectField(
			array( "{$prefix}user_fbconnect" ),
			array( 'user_id' ),
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
	 * Given a facebook id and database connection with read permission,
	 * finds the Facebook user by their id.
	 * If there is no user found for the given id, returns null.
	 */
	public static function getUserByDB( $fbid, $dbr ){
		$prefix = self::getPrefix();
		$id = $dbr->selectField(
			"`{$prefix}user_fbconnect`",
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
		global $wgMemc;
		wfProfileIn(__METHOD__);
		
		$memkey = wfMemcKey( "fb_user_id", $user->getId() );
			
		if($user->getId() == 0){
			wfDebug("FBConnect: tried to store a mapping from fbid \"$fbid\" to a user with no id (ie: not logged in).\n");
		} else {
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
		}
		
		$dbw->commit();
		$wgMemc->set($memkey, self::getFacebookIDs($user, DB_MASTER )  );
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Remove a User <-> Facebook ID association from the database.
	 */
	public static function removeFacebookID( $user ) {
		global $wgMemc; 
		$prefix = self::getPrefix();
		if ( $user instanceof User && $user->getId() != 0 ) {
			$dbw = wfGetDB( DB_MASTER, array(), self::sharedDB() );
			$memkey = wfMemcKey( "fb_user_id", $user->getId() );
			$dbw->delete(
				"{$prefix}user_fbconnect",
				array(
					'user_id' => $user->getId()
				),
				__METHOD__
			); 
			$dbw->commit();
	 		$wgMemc->set($memkey, self::getFacebookIDs($user, DB_MASTER )  );
		}

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
	public static function sharedDB() {
		global $wgExternalSharedDB;
		if (!empty($wgExternalSharedDB)) {
			return $wgExternalSharedDB;	
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

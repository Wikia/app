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
		global $wgDBprefix, $wgSharedDB;
		$fbid = array();
		if ( $user instanceof User && $user->getId() != 0 ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgSharedDB );
			$res = $dbr->select(
				array( "{$wgDBprefix}user_fbconnect" ),
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
		global $wgDBprefix, $wgSharedDB;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgSharedDB );
		$id = $dbr->selectField(
			"{$wgDBprefix}user_fbconnect",
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
		global $wgDBprefix, $wgSharedDB;
		$dbw = wfGetDB( DB_MASTER, array(), $wgSharedDB );
		$dbw->insert(
			"{$wgDBprefix}user_fbconnect",
			array(
				'user_id' => $user->getId(),
				'user_fbid' => $fbid
			),
			__METHOD__
		);
	}
	
	/**
	 * Remove a User <-> Facebook ID association from the database.
	 */
	public static function removeFacebookID( $user, $fbid ) {
		global $wgDBprefix, $wgSharedDB;
		$dbw = wfGetDB( DB_MASTER, array(), $wgSharedDB );
		$dbw->delete(
			"{$wgDBprefix}user_fbconnect",
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
		global $wgDBprefix, $wgSharedDB;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgSharedDB );
		// An estimate is good enough for choosing a unique nickname
		$count = $dbr->estimateRowCount("{$wgDBprefix}user_fbconnect");
		// Avoid returning 0 or -1
		return $count >= 1 ? $count : 1;
	}
}

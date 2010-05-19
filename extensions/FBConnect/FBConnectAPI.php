<?php
/*
 * Copyright © 2008-2010 Garrett Brown <http://www.mediawiki.org/wiki/User:Gbruin>
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
 * Class FBConnectAPI
 * 
 * This class contains the code used to interface with Facebook via the
 * Facebook Platform API. 
 */
class FBConnectAPI {
	// Holds a static reference to our Facebook object
	private static $__Facebook = null;
	
	// Caches information about users to reduce the number of Facebook hits
	private static $userinfo = array(array());
	
	// Constructor
	public function __construct() {
	}
	
	/**
	 * Get the Facebook client object for easy access.
	 */
	public function Facebook() {
		global $fbAppId, $fbAppSecret;
		// Construct a new Facebook object on first time access
		if ( is_null(self::$__Facebook) && self::isConfigSetup() ) {
			self::$__Facebook = new Facebook( $fbAppId, $fbAppSecret );
			if (!self::$__Facebook) {
				error_log('Could not create facebook client.');
			}
		}
		return self::$__Facebook;
	}
	
	/**
	 * Check to make sure config.sample.php was properly renamed to config.php
	 * and the instructions to fill out the first two important variables were
	 * followed correctly.
	 */
	public static function isConfigSetup() {
		global $fbAppId, $fbAppSecret;
		$isSetup = isset($fbAppId) && $fbAppId != 'YOUR_APP_KEY' &&
		           isset($fbAppSecret) && $fbAppSecret != 'YOUR_SECRET';
		if(!$isSetup) {
			// Check to see if they are using the old variables
			global $fbApiKey, $fbApiSecret;
			if (isset($fbApiKey) && isset($fbApiSecret)) {
				$fbAppId = $fbApiKey;
				$fbAppSecret= $fbApiSecret;
				$isSetup = true;
			} else {
				error_log('Please update the $fbAppId in config.php');
			}
		}
		return $isSetup;
	}
	
	/**
	 * Retrieves the ID of the current logged-in user. If no user is logged in,
	 * then an ID of 0 is returned.
	 */
	public function user() {
//		return $this->Facebook()->get_loggedin_user();
	}
	
	/**
	 * Calls users.getInfo. Requests information about the user from Facebook.
	 */
	public function getUserInfo( $user = 0 ) {
		if ($user == 0) {
			$user = $this->user();
		}
		if ($user != 0 && !isset($userinfo[$user]))
		{
			try {
				$fields = array('first_name', 'name', 'sex', 'timezone', 'locale',
				                /*'profile_url',*/
				                'username', 'proxied_email', 'contact_email');
				// Query the Facebook API with the users.getInfo method
				$user_details = $this->Facebook()->api_client->users_getInfo($user, $fields);
				// Cache the data in the $userinfo array
				$userinfo[$user] = $user_details[0];
			} catch( Exception $e ) {
				error_log( 'Failure in the api when requesting ' . join(',', $fields) .
				           " on uid $user: " . $e->getMessage());
			}
		}
		return isset($userinfo[$user]) ? $userinfo[$user] : null;
	}
	
	/**
	 * Returns the full name of the Facebook user.
	 */
	public function userName( $user = 0 ) {
		$userinfo = $this->getUserInfo($user);
		return $userinfo['name'];
	}
	
	/**
	 * Returns the name of the group specified by $fbUserRightsFromGroup, or
	 * null if it is false.
	 * 
	 * groups.get
	 */
	public function groupInfo() {
		global $fbUserRightsFromGroup;
		// If $fbUserRightsFromGroup is false instead of a group id, return null
		if (!$fbUserRightsFromGroup) {
			return null;
		}
		// Cache the info returned from Facebook about this group
		static $info;
		if (!isset($info)) {
			$info = array();
			$group = $this->Facebook()->api_client->groups_get(null, $fbUserRightsFromGroup);
			if ( is_array( $group ) && is_array( $group[0] )) {
				$info['name'] = $group[0]['name'];
				$info['creator'] = $group[0]['creator'];
				$info['picture'] = $group[0]['pic'];
			}
		}
		return $info;
	}
	
	/**
	 * Retrieves group membership data from Facebook.
	 */
	public function getGroupRights( $user = null ) {
		global $fbUserRightsFromGroup;
		
		// Groupies can be members, officers or admins (the latter two infer the former)
		$rights = array('member'  => false,
		                'officer' => false,
		                'admin'   => false);
		
		// If no group ID is specified, then there's no group to belong to
		$gid = $fbUserRightsFromGroup;
		if( !$gid ) {
			return $rights;
		}
		
		// Translate $user into a Facebook ID
		if (!$user) {
			$user = $this->user();
		} else if ($user instanceof User) {
			$users = FBConnectDB::getFacebookIDs($user);
			if (count($users)) {
				$user = $users[0];
			} else {
				// Not a Connected user, can't be in a group
				return $rights;
			}
		}
		
		// Cache the rights for an individual user to prevent hitting Facebook for duplicate info
		static $rights_cache = array();
		if ( array_key_exists( $user, $rights_cache )) {
			// Retrieve the rights from the cache
			return $rights_cache[$user];
		}
		
		// This can contain up to 500 IDs, avoid requesting this info twice
		static $members = false;
		// Get a random 500 group members, along with officers, admins and not_replied's
		if ($members === false) {
			try {
				// Check to make sure our session is still valid
				$members = $this->Facebook()->api_client->groups_getMembers($gid);
			} catch (FacebookRestClientException $e) {
				// Invalid session; we're not going to be able to get the rights
				$rights_cache[$user] = $rights;
				return $rights;
			}
		}
		
		if ( $members ) {
			// Check to see if the user is an officer
			if (array_key_exists('officers', $members) && in_array($user, $members['officers'])) {
				$rights['member'] = $rights['officer'] = true;
			}
			// Check to see if the user is an admin of the group
			if (array_key_exists('admins', $members) && in_array($user, $members['admins'])) {
				$rights['member'] = $rights['admin'] = true;
			}
			// Because the latter two rights infer the former, this step isn't always necessary
			if( !$rights['member'] ) {
				// Check to see if we are one of the (up to 500) random users
				if ((array_key_exists('not_replied', $members) && is_array($members['not_replied']) &&
					in_array($user, $members['not_replied'])) || in_array($user, $members['members'])) {
					$rights['member'] = true;
				} else {
					// For groups of over 500ish, we must use this extra API call
					// Notice that it occurs last, because we can hopefully avoid having to call it
					$group = $this->Facebook()->api_client->groups_get(intval($user), $gid);
					if (is_array($group) && is_array($group[0]) && $group[0]['gid'] == "$gid") {
						$rights['member'] = true;
					}
				}
			}
		}
		// Cache the rights
		$rights_cache[$user] = $rights;
		return $rights;
	}
	
	/**
	 * Returns the "public" hash of the email address (i.e., the one Facebook
	 * gives out via their API). The hash is of the form crc32($email)_md5($email).
	 * 
	 * @Unused (for now)
	 */
	public function hashEmail($email) {
		if ($email == null)
			return '';
		$email = trim(strtolower($email));
		return crc32($email) . '_' . md5($email);
	}
}

<?php

/*
 * A plugin to authenticate against a libnss-mysql database
 *
 * Copyright 2008 - Bryan Tong Minh / Delft Aerospace Rocket Engineering
 * Licensed under the terms of the GNU General Public License, version 2
 * or any later version.
 *
 */

class NssMySQLAuthPlugin extends AuthPlugin {
	static function initialize() {
		global $wgAuth, $wgHooks;
		global $wgNssMySQLAuthDB;
		$wgAuth = new self( $wgNssMySQLAuthDB );

		$wgHooks['UserEffectiveGroups'][]	= array( $wgAuth, 'onUserEffectiveGroups' );
		$wgHooks['UserGetEmail'][]		= array( $wgAuth, 'onUserGetEmail' );
		$wgHooks['UserSetEmail'][]		= array( $wgAuth, 'onUserSetEmail' );
		$wgHooks['UserRights'][]		= array( $wgAuth, 'onUserRights' );

		
		wfLoadExtensionMessages( 'nssmysqlauth' );
	}

	function __construct( $wikiName = false ) {
		$this->wikiName = $wikiName;
		$this->users = array();
	}

	function getDB( $db = DB_LAST ) {
		return wfGetDB( $db, array(), $this->wikiName );
	}

	function userExists( $username ) {
		$this->loadUser( $username );
		return $this->users[$username] !== false; 
	}
	function getUid( $username ) {
		$this->loadUser( $username );
		return $this->users[$username];		
	}
	
	function loadUser( $username ) {
		if ( isset( $this->users[$username] ) )
			return;
		$dbr = $this->getDB( DB_READ );
		$row = $dbr->selectRow( 
				'passwd', 'pwd_uid', array( 'pwd_name' => $username ),
				__METHOD__
			);
		$this->users[$username] = ($row === false ? false : $row->pwd_uid); 	
	}

	function authenticate( $username, $password ) {
		$dbr = $this->getDB( DB_READ );
		$res = $dbr->selectRow(
			'passwd',
			array( 'pwd_name', 'pwd_password' ),
			array( 'pwd_name' => $username ),
			__METHOD__
		);
		if( $res === false ) return false;

		return Md5crypt::encryptPassword( $password, $res->pwd_password )
			== $res->pwd_password;
	}

	function updateUser( &$user ) {
		$dbr = $this->getDB( DB_READ );
		$res = $dbr->selectRow(
			'passwd',
			array( 'pwd_email' ),
			array( 'pwd_name' => $user->getName() ),
			__METHOD__
		);

		if( $res === false ) return true;

		$user->setEmail( $res->pwd_email );
		return true;
	}

	function autoCreate() {
		return true;
	}
	function setPassword( $user, $password ) {
		$encryptedPassword = Md5crypt::encryptPassword( $password );
		$dbw = $this->getDB( DB_WRITE );
		return true == $dbw->update(
			'passwd',
			array(
				'pwd_password' => $encryptedPassword,
				'pwd_password_lastchange' => wfTimestamp( TS_UNIX ),
			),
			array( 'pwd_name' => $user->getName() ),
			__METHOD__
		);
	}

	function updateExternalDB( $user ) {
		// Email updated via hook
		return true;
	}

	function canCreateAccounts() {
		return false;
	}

	function addUser( $user, $password, $email='', $realname='' ) {
		return false;
	}

	function strict() {
		return false;
	}

	function onUserEffectiveGroups( &$user, &$groups ) {
		if( !$this->userExists( $user->getName() ) )
			return true;

		$dbr = $this->getDB( DB_READ );
		$res = $dbr->select(
			array( 'passwd', 'group_membership' ),
			array( 'gm_group' ),
			array( 'pwd_uid = gm_user', 'pwd_name' => $user->getName() ),
			__METHOD__
		);
		while( $row = $res->fetchObject() )
			$groups[] = $row->gm_group;

		return true;
	}

	function onUserGetEmail( $user, &$address ) {
		if( !$this->userExists( $user->getName() ) )
			return true;

		$dbr = $this->getDB( DB_READ );
		$row = $dbr->selectRow( 'passwd' , 'pwd_email',
			array( 'pwd_name' => $user->getName() ) );
		if( $row ) $address = $row->pwd_email;
		return true;

	}

	function onUserSetEmail( $user, &$address ) {
		if( !$this->userExists( $user->getName() ) )
			return true;

		$dbw = $this->getDB( DB_WRITE );
		return true == $dbw->update(
			'passwd',
			array( 'pwd_email' => $address ),
			array( 'pwd_name' => $user->getName() ),
			__METHOD__
		);
	}

	function onUserRights( &$user, $addgroup, $removegroup ) {
		$uid = $this->getUid( $user->getName() );
		if( $uid === false ) 
			return true;
		
		$dbr = $this->getDB( DB_READ );
		$res = $dbr->select( 'groups', 'grp_name', array(), __METHOD__ );
		$groups = array();
		while ( $row = $res->fetchObject() ) 
			$groups[] = $row->grp_name;
		$res->free();
		
		$addgroup = array_intersect( $groups, $addgroup );
		$removegroup = array_intersect( $groups, $removegroup );
		
		$dbw = $this->getDB( DB_WRITE );
		foreach ( $addgroup as $group )
			$dbw->insert( 'group_membership', array( 
				'gm_user' => $uid,
				'gm_group' => $group,
				), __METHOD__, 'IGNORE' );
		foreach ( $removegroup as $group )
			$dbw->delete( 'group_membership', array( 
				'gm_user' => $uid,
				'gm_group' => $group,
				), __METHOD__ );
		return true;
	}
	
	/**
	* Create an account, returning a random password
	*/
	function createAccount( $username, $options ) {
		global $wgDefaultGid, $wgHomeDirectory;
		$password = User::randomPassword();

		$insert = array(
			'pwd_name' => strtolower( $username ),
			'pwd_password' => Md5crypt::encryptPassword( $password ),
			'pwd_password_lastchange' => wfTimestamp( TS_UNIX ),
			'pwd_gid' => $wgDefaultGid,
			'pwd_home' => str_replace( '$1', strtolower( $username ), $wgHomeDirectory )
		);

		// $options is something that is passed to user_props
		$insert['pwd_email'] = $options['email'];
		$insert['pwd_active'] = $options['active'];

		// Guess a nice uid. We actually need a lock here
		$dbw = $this->getDB( DB_MASTER );
		$row = $dbw->selectRow( 'passwd', 'MAX(pwd_uid) + 1 AS uid', array(), __METHOD__ );
		$uid = $row->uid;
		if ( function_exists( 'posix_getpwuid' ) ) {
			while( posix_getpwuid( $uid ) )
				$uid++;
		}

		$insert['pwd_uid'] = $uid;

		$dbw->insert( 'passwd', $insert, __METHOD__ );

		return $password;
	}
}

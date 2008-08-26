<?php
/**
 * @package Extensions
 */
# Copyright (C) 2004 Brion Vibber <brion@pobox.com>
# Copyright (C) 2005 Jens Frank <jf@mormo.org>
# http://www.mediawiki.org/
# 
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or 
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
# http://www.gnu.org/copyleft/gpl.html

/**
 * Authentication plugin interface
 * Requires:
 *   a global users table (see sql file)
 *    **TODO**
 *   settings in LocalSettings.php
 *    **TODO**
 *
 * @package Extensions
 */
class GlobalAuth {
	var $tablename, $thiswiki;

	/**
	 * Initialise a new object
	 * 
	 * @param string $globaldb	Name of the DB that holds the user table
	 * @param string $globaltable	Name of the global user table
	 * @param string $thiswiki	Name of this wiki
	 */
	function GlobalAuth( $globaldb, $globaltable, $thiswiki ) {
		$this->tablename = $globaldb . '.' . $globaltable;
		$this->thiswiki = $thiswiki;
	}
	/**
	 * Check whether there exists a user account with the given name.
	 * The user must either exist for 'this wiki' or for all wikis ('*').
	 *
	 * @param string $username
	 * @return bool
	 * @access public
	 */
	function userExists( $username ) {
		$fname='GlobalAuth::userExists';

		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select( $this->tablename, 'user_wiki',
			array( 'user_name' => $username ),
			$fname );
		while( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->user_wiki == $this->thiswiki || $row->user_wiki == '*' ) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Check if a username+password pair is a valid login.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * @param string $username
	 * @param string $password
	 * @return bool
	 * @access public
	 */
	function authenticate( $username, $password ) {
		$fname='GlobalAuth::userExists';

		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select( $this->tablename, array( 'user_wiki',
				'user_name','user_password',
				'user_email', 'user_email_authenticated',
				'user_real_name','user_options',
				'user_token' ),
			array( 'user_name' => $username ),
			$fname );
		while( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->user_wiki == $this->thiswiki || $row->user_wiki == '*' ) {
				if ( $row->user_password == wfEncryptPassword( $row->user_id, $password ) ) {
					$this->data =& $row;
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * When a user logs in, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external user database.
	 *
	 * The User object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param User $user
	 * @access public
	 */
	function updateUser( &$user ) {
		$s =& $this->data;
		$user->decodeOptions( $s->user_options );
		$user->mEmail = $s->user_email;
		$user->mEmailAuthenticated = wfTimestampOrNull( TS_MW, $s->user_email_authenticated );
		$user->mRealName = $s->user_real_name;
		$user->mToken = $s->user_token;

		return true;
	}


	/**
	 * Return true if the wiki should create a new local account automatically
	 * when asked to login a user who doesn't exist locally but does in the
	 * external auth database.
	 *
	 * If you don't automatically create accounts, you must still create
	 * accounts in some way. It's not possible to authenticate without
	 * a local account.
	 *
	 * This is just a question, and shouldn't perform any actions.
	 *
	 * @return bool
	 * @access public
	 */
	function autoCreate() {
		return true;
	}
	
	/**
	 * Set the given password in the authentication database.
	 * Return true if successful.
	 *
	 * @param string $password
	 * @return bool
	 * @access public
	 */
	function setPassword( $password ) {
		$dbw =& wfGetDB( DB_MASTER );
		$success = $dbw->update( $this->tablename,
				array( 'user_password' => wfEncryptPassword( $this->data->user_id, $password ) ),
				array( 'user_id' => $this->data->user_id,
					'user_wiki' => $this->data->user_wiki ),
				'GlobalAuth::setPassword' );
		return $success;
	}

	/**
	 * Update user information in the external authentication database.
	 * Return true if successful.
	 *
	 * @param User $user
	 * @return bool
	 * @access public
	 */
	function updateExternalDB( $user ) {
		$dbw =& wfGetDB( DB_MASTER );
		$success = $dbw->update( $this->tablename,
				array( /*SET*/
					//'user_password' =>,
					'user_email' => $user->getEmail(),
					'user_email_authenticated' => $dbw->timestampOrNull( $user->getEmailAuthenticationTimestamp() ),
					'user_real_name' => $user->getRealName(),
					'user_options' => $user->encodeOptions(),
					'user_token' => $user->mToken ),
				array( /*WHERE*/ 'user_id' => $this->data->user_id,
					'user_wiki' => $this->data->user_wiki ),
				'GlobalAuth::updateExternalDB' );
					
		return $success;
	}

	/**
	 * Check to see if external accounts can be created.
	 * Return true if external accounts can be created.
	 * @return bool
	 * @access public
	 */
	function canCreateAccounts() {
		return true;
	}

	/**
	 * Add a user to the external authentication database.
	 * Return true if successful.
	 *
	 * @param User $user
	 * @param string $password
	 * @return bool
	 * @access public
	 */
	function addUser( $user, $password ) {
		$fname = 'GlobalAuth::addUser';

		$dbw =& wfGetDB( DB_MASTER );
		$res = $dbw->select( $this->tablename, 
				array( 'user_id', 'user_wiki', 'user_password' ),
				array( 'user_name' => $user->getName() ),
				'GlobalAuth::addUser' );
		$create = true;
		$first = true;
		while( $row = $dbr->fetchObject( $res ) ) {
			if ( $first ) {
				# Set create to false for now. We've found entries for
				# this username. Now we have to check whether we allow
				# the creation of parallel accounts
				$first = $create = false;
			}
			# There is already an account. Don't create a new account
			if ( $row->user_wiki == '*' || $row->user_wiki == $this->thiswiki )
				return false;
			# The password matches one of the already existing accounts.
			# Allow creation of an account.
			if ( $row->user_password == wfEncryptPassword( $row->user_id, $password ) ) {
				$create = true;
			}
		}
		if ( !$create ) {
			return false;
		}
		# We don't conflict with an already existing account. Now set up the new account.
		# If $first is still true, there's no user in any wiki yet with this name. We can
		# create a global account ('*') for it. Otherwise, we just create an account for
		# $this->thiswiki.

		$seqVal = $dbw->nextSequenceValue( 'user_user_id_seq' );
		$wiki = ( $first ? '*' : $this->thiswiki );
		$dbw->insert( $this->tablename, array( 
				'user_id' => $seqVal,
				'user_name' => $user->getName(),
				'user_password' => '',
				'user_email' => $user->getEmail(),
				'user_email_authenticated' => $dbw->timestampOrNull( 
					$user->getEmailAuthenticationTimestamp() ),           
				'user_real_name' => $user->getRealName(),
				'user_options' => $user->encodeOptions(),
				'user_token' => $user->mToken,
				'user_wiki' => $wiki ),
				$fname );
				
		# Query back to get the user_id

		$row = $dbr->selectRow( $this->tablename, array( 'user_wiki',
				'user_name','user_password',
				'user_email', 'user_email_authenticated',
				'user_real_name','user_options',
				'user_token' ),
			array( 'user_name' => $user->getName(),
				'user_wiki' => $wiki ),
			$fname );
		$this->data = $row;

		# Now that we know the ID, we can change the password
		$this->setPassword( $password );

		return true;
	}


	/**
	 * Return true to prevent logins that don't authenticate here from being
	 * checked against the local database's password fields.
	 *
	 * This is just a question, and shouldn't perform any actions.
	 *
	 * @return bool
	 * @access public
	 */
	function strict() {
		return true;
	}
	
	/**
	 * When creating a user account, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external user database.
	 *
	 * The User object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param User $user
	 * @access public
	 */
	function initUser( &$user ) {
		# I don't think I need this, do I?
	}
	
}

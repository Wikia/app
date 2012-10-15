<?php

class OpenStackNovaRole {

	var $rolename;
	var $roleDN;
	var $roleInfo;
	var $project;
	var $global;

	/**
	 * @param  $rolename
	 * @param null $project
	 */
	function __construct( $rolename, $project=null ) {
		$this->rolename = $rolename;
		$this->project = $project;
		if ( $this->project ) {
			$this->global = false;
		} else {
			$this->global = true;
		}
		OpenStackNovaLdapConnection::connect();
		$this->fetchRoleInfo();
	}

	/**
	 * @return void
	 */
	function fetchRoleInfo() {
		global $wgAuth;
		global $wgOpenStackManagerLDAPGlobalRoles;

		$query = '';

		if ( $this->global ) {
			if ( isset ( $wgOpenStackManagerLDAPGlobalRoles["$this->rolename"] ) ) {
				$dn = $wgOpenStackManagerLDAPGlobalRoles["$this->rolename"];
				$query = '(objectclass=groupofnames)';
			} else {
				# This condition would be a bug...
				$dn = '';
			}
		} else {
			$dn = $this->project->projectDN;
			$query = '(cn=' . $this->rolename . ')';
		}
		$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $dn, $query );
		$this->roleInfo = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
		if ( $this->roleInfo['count'] != "0" ) {
			$this->roleDN = $this->roleInfo[0]['dn'];
		}
	}

	/**
	 * @return string
	 */
	function getRoleName() {
		return $this->rolename;
	}

	/**
	 * @return array
	 */
	function getMembers() {
		global $wgAuth;

		$members = array();
		if ( isset( $this->roleInfo[0]['member'] ) ) {
			$memberdns = $this->roleInfo[0]['member'];
			array_shift( $memberdns );
			foreach ( $memberdns as $memberdn ) {
				$searchattr = $wgAuth->getConf( 'SearchAttribute' );
				if ( $searchattr ) {
					// We need to look up the search attr from the user entry
					// this is expensive, but must be done.
					// TODO: memcache this
					$userInfo = $wgAuth->getUserInfoStateless( $memberdn );
					$members[] = $userInfo[0][$searchattr][0];
				} else {
					$member = explode( '=', $memberdn );
					$member = explode( ',', $member[1] );
					$member = $member[0];
					$members[] = $member;
				}
			}
		}

		return $members;
	}

	/**
	 * @param  $username
	 * @return bool
	 */
	function deleteMember( $username ) {
		global $wgAuth;

		if ( isset( $this->roleInfo[0]['member'] ) ) {
			$members = $this->roleInfo[0]['member'];
			array_shift( $members );
			$user = new OpenStackNovaUser( $username );
			if ( ! $user->userDN ) {
				$wgAuth->printDebug( "Failed to find userDN in deleteMember", NONSENSITIVE );
				return false;
			}
			$index = array_search( $user->userDN, $members );
			if ( $index === false ) {
				$wgAuth->printDebug( "Failed to find userDN in member list", NONSENSITIVE );
				return false;
			}
			unset( $members[$index] );
			$values = array();
			$values['member'] = array();
			foreach ( $members as $member ) {
				$values['member'][] = $member;
			}
			$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->roleDN, $values );
			if ( $success ) {
				$this->fetchRoleInfo();
				$wgAuth->printDebug( "Successfully removed $user->userDN from $this->roleDN", NONSENSITIVE );
				return true;
			} else {
				$wgAuth->printDebug( "Failed to remove $user->userDN from $this->roleDN", NONSENSITIVE );
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * @param  $username
	 * @return bool
	 */
	function addMember( $username ) {
		global $wgAuth;

		$members = array();
		if ( isset( $this->roleInfo[0]['member'] ) ) {
			$members = $this->roleInfo[0]['member'];
			array_shift( $members );
		}
		$user = new OpenStackNovaUser( $username );
		if ( ! $user->userDN ) {
			$wgAuth->printDebug( "Failed to find userDN in addMember", NONSENSITIVE );
			return false;
		}
		$members[] = $user->userDN;
		$values = array();
		$values['member'] = $members;
		$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->roleDN, $values );
		if ( $success ) {
			$this->fetchRoleInfo();
			$wgAuth->printDebug( "Successfully added $user->userDN to $this->roleDN", NONSENSITIVE );
			return true;
		} else {
			$wgAuth->printDebug( "Failed to add $user->userDN to $this->roleDN", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * @static
	 * @param  $rolename
	 * @param  $project
	 * @return null|OpenStackNovaRole
	 */
	static function getProjectRoleByName( $rolename, $project ) {
		$role = new OpenStackNovaRole( $rolename, $project );
		if ( $role->roleInfo ) {
			return $role;
		} else {
			return null;
		}
	}

	/**
	 * @static
	 * @param  $rolename
	 * @return null|OpenStackNovaRole
	 */
	static function getGlobalRoleByName( $rolename ) {
		$role = new OpenStackNovaRole( $rolename );
		if ( $role->roleInfo ) {
			return $role;
		} else {
			return null;
		}
	}

	/**
	 * @static
	 * @return array
	 */
	static function getAllGlobalRoles() {
		global $wgOpenStackManagerLDAPGlobalRoles;

		OpenStackNovaLdapConnection::connect();

		$roles = array();
		foreach ( array_keys( $wgOpenStackManagerLDAPGlobalRoles ) as $rolename ) {
			$role = new OpenStackNovaRole( $rolename );
			array_push( $roles, $role );
		}

		return $roles;
	}

	/**
	 * @static
	 * @param  $rolename
	 * @param  $project OpenStackNovaProject
	 * @return bool
	 */
	static function createRole( $rolename, $project ) {
		global $wgAuth;

		OpenStackNovaLdapConnection::connect();

		$role = array();
		$role['objectclass'][] = 'groupofnames';
		$role['cn'] = $rolename;
		$roledn = 'cn=' . $rolename . ',' . $project->projectDN;
		$success = LdapAuthenticationPlugin::ldap_add( $wgAuth->ldapconn, $roledn, $role );
		# TODO: If role addition fails, find a way to fail gracefully
		# Though, if the project was added successfully, it is unlikely
		# that role addition will fail.
		if ( $success ) {
			$wgAuth->printDebug( "Successfully added role $rolename", NONSENSITIVE );
			return true;
		} else {
			$wgAuth->printDebug( "Failed to add role $rolename", NONSENSITIVE );
			return false;
		}
	}

}

<?php

class OpenStackNovaUser {

	var $username;
	var $userDN;
	var $userInfo;

	/**
	 * @param string $username
	 */
	function __construct( $username = '' ) {
		$this->username = $username;
		OpenStackNovaLdapConnection::connect();
		$this->fetchUserInfo();
	}

	/**
	 * @return void
	 */
	function fetchUserInfo() {
		global $wgAuth, $wgUser;

		if ( $this->username ) {
			$this->userDN = $wgAuth->getUserDN( strtolower( $this->username ) );
			$wgAuth->printDebug( "Fetching userdn using username: $this->userDN ", NONSENSITIVE );
		} else {
			$this->userDN = $wgAuth->getUserDN( strtolower( $wgUser->getName() ) );
			$wgAuth->printDebug( "Fetching userdn using wiki name: " . $wgUser->getName(), NONSENSITIVE );
		}
		$this->userInfo = $wgAuth->userInfo;
	}

	/**
	 * @param string $project
	 * @return array
	 */
	function getCredentials() {
		if ( isset( $this->userInfo[0]['accesskey'] ) ) {
			$accessKey = $this->userInfo[0]['accesskey'][0];
		} else {
			$accessKey = '';
		}
		if ( isset( $this->userInfo[0]['secretkey'] ) ) {
			$secretKey = $this->userInfo[0]['secretkey'][0];
		} else {
			$secretKey = '';
		}
		return array( 'accessKey' => $accessKey, 'secretKey' => $secretKey );
	}

	/**
	 * @return array
	 */
	function getKeypairs() {
		global $wgAuth;

		$this->fetchUserInfo();
		if ( isset( $this->userInfo[0]['sshpublickey'] ) ) {
			$keys = $this->userInfo[0]['sshpublickey'];
			$keypairs = array();
			array_shift( $keys );
			foreach ( $keys as $key ) {
				$hash = md5( $key );
				$keypairs["$hash"] = $key;
			}
			return $keypairs;
		} else {
			$wgAuth->printDebug( "No keypairs found", NONSENSITIVE );
			return array();
		}
	}

	/**
	 * @return bool
	 */
	function isAdmin() {
		if ( isset( $this->userInfo[0]['isnovaadmin'] ) ) {
			$isAdmin = $this->userInfo[0]['isnovaadmin'][0];
			if ( strtolower( $isAdmin ) == "true" ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @return bool
	 */
	function exists() {
		$credentials = $this->getCredentials();
		if ( $credentials['accessKey'] && $credentials['secretKey'] ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @return array
	 */
	function getProjects() {
		global $wgAuth;
		global $wgOpenStackManagerLDAPProjectBaseDN;

		# All projects have a owner attribute, project
		# roles do not
		$projects = array();
		$filter = "(&(owner=*)(member=$this->userDN))";
		$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $wgOpenStackManagerLDAPProjectBaseDN, $filter );
		if ( $result ) {
			$entries = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
			if ( $entries ) {
				# First entry is always a count
				array_shift( $entries );
				foreach ( $entries as $entry ) {
					array_push( $projects, $entry['cn'][0] );
				}
			}
		} else {
			$wgAuth->printDebug( "No result found when searching for user's projects", NONSENSITIVE );
		}
		return $projects;
	}

	/**
	 * @param string $project
	 * @return array
	 */
	function getRoles( $project = '' ) {
		# Currently unsupported
		return array();
	}

	/**
	 * @param  $project
	 * @return bool
	 */
	function inProject( $project ) {
		global $wgAuth;
		global $wgOpenStackManagerLDAPProjectBaseDN;

		$filter = "(&(cn=$project)(member=$this->userDN)(owner=*))";
		$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $wgOpenStackManagerLDAPProjectBaseDN, $filter );
		if ( $result ) {
			$entries = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
			if ( $entries ) {
				if ( $entries['count'] == "0" ) {
					$wgAuth->printDebug( "Couldn't find the user in project: $project", NONSENSITIVE );
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * @param  $role
	 * @param string $projectname
	 * @return bool
	 */
	function inRole( $role, $projectname='', $strict=false ) {
		global $wgAuth;
		global $wgOpenStackManagerLDAPRolesIntersect;

		if ( $this->inGlobalRole( $role ) ) {
			# If roles intersect, or we wish to explicitly check
			# project role, we can't return here.
			if ( !$wgOpenStackManagerLDAPRolesIntersect && !$strict ) {
				return true;
			}
		} else {
			if ( $wgOpenStackManagerLDAPRolesIntersect ) {
				return false;
			}
		}

		if ( $projectname ) {
			# Check project specific role
			$project = OpenStackNovaProject::getProjectByName( $projectname );
			if ( ! $project ) {
				return false;
			}
			$filter = "(&(cn=$role)(member=$this->userDN))";
			$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $project->projectDN, $filter );
			if ( $result ) {
				$entries = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
				if ( $entries ) {
					if ( $entries['count'] == "0" ) {
						$wgAuth->printDebug( "Couldn't find the user in role: $role", NONSENSITIVE );
						return false;
					} else {
						return true;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		return false;
	}

	/**
	 * Check if user is in global role
	 *
	 * @param  $role
	 * @return bool
	 */
	function inGlobalRole( $role ) {
		global $wgAuth;
		global $wgOpenStackManagerLDAPGlobalRoles;

		if ( ! array_key_exists( $role, $wgOpenStackManagerLDAPGlobalRoles ) ) {
			$wgAuth->printDebug( "Requested global role does not exist: $role", NONSENSITIVE );
			return false;
		}

		if ( $wgOpenStackManagerLDAPGlobalRoles["$role"] ) {
			# Check global role
			$roledn = $wgOpenStackManagerLDAPGlobalRoles["$role"];
			$filter = "(objectclass=*)";
			$result = LdapAuthenticationPlugin::ldap_read( $wgAuth->ldapconn, $roledn, $filter );
			if ( $result ) {
				$entries = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
				return ( in_array( $this->userDN, $entries[0]['member'] ) );
			}
		}
		return false;
	}

	/**
	 * @param  $key
	 * @return bool
	 */
	function importKeypair( $key ) {
		global $wgAuth;

		$keypairs = array();
		if ( isset( $this->userInfo[0]['sshpublickey'] ) ) {
			$keypairs = $this->userInfo[0]['sshpublickey'];
			array_shift( $keypairs );
		}
		$keypairs[] = $key;
		$values = array();
		$values['sshpublickey'] = $keypairs;
		$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->userDN, $values );
		if ( $success ) {
			$wgAuth->printDebug( "Successfully imported the user's sshpublickey", NONSENSITIVE );
			$this->fetchUserInfo();
			return true;
		} else {
			$wgAuth->printDebug( "Failed to import the user's sshpublickey", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * @param  $key
	 * @return bool
	 */
	function deleteKeypair( $key ) {
		global $wgAuth;

		if ( isset( $this->userInfo[0]['sshpublickey'] ) ) {
			$keypairs = $this->userInfo[0]['sshpublickey'];
			array_shift( $keypairs );
			$index = array_search( $key, $keypairs );
			if ( $index === false ) {
				$wgAuth->printDebug( "Unable to find the sshpublickey to be deleted", NONSENSITIVE );
				return false;
			}
			unset( $keypairs[$index] );
			$values = array();
			$values['sshpublickey'] = array();
			foreach ( $keypairs as $keypair ) {
				$values['sshpublickey'][] = $keypair;
			}
			$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->userDN, $values );
			if ( $success ) {
				$wgAuth->printDebug( "Successfully deleted the user's sshpublickey", NONSENSITIVE );
				$this->fetchUserInfo();
				return true;
			} else {
				$wgAuth->printDebug( "Failed to delete the user's sshpublickey", NONSENSITIVE );
				return false;
			}
		} else {
			$wgAuth->printDebug( "User does not have a sshpublickey attribute", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * @static
	 * @return string
	 */
	static function uuid4() {
		$uuid = '';
		uuid_create( &$uuid );
		uuid_make( $uuid, UUID_MAKE_V4 );
		$uuidExport = '';
		uuid_export( $uuid, UUID_FMT_STR, &$uuidExport );
		return trim( $uuidExport );
	}

	/**
	 * Does not ensure uniqueness during concurrent use!
	 * Also does not work when resource limits are set for
	 * LDAP queries by the client or the server.
	 *
	 * TODO: write a better and more efficient version of this.
	 *
	 * @static
	 * @param  $auth
	 * @param  $attr
	 * @return mixed|string
	 */
	static function getNextIdNumber( $auth, $attr ) {
		$highest = '';
		if ( $attr == 'gidnumber' ) {
			$filter = "(objectclass=posixgroup)";
			$base = GROUPDN;
		} else {
			$filter = "(objectclass=posixaccount)";
			$base = USERDN;
		}
		$result = LdapAuthenticationPlugin::ldap_search( $auth->ldapconn, $auth->getBaseDN( $base ), $filter );
		if ( $result ) {
			$entries = LdapAuthenticationPlugin::ldap_get_entries( $auth->ldapconn, $result );
			if ( $entries ) {
				if ( $entries['count'] == "0" ) {
					$highest = '500';
				} else {
					array_shift( $entries );
					$uids = array();
					foreach ( $entries as $entry ) {
						array_push( $uids, $entry[$attr][0] );
					}
					sort( $uids, SORT_NUMERIC );
					$highest = array_pop( $uids ) + 1;
					if ( $attr == 'gidnumber' && $highest % 2 ) {
						# Ensure groups are always even, since they'll
						# be used for namespaces as well.
						$highest = $highest + 1;
					}
				}
			} else {
				$auth->printDebug( "Failed to find any entries when searching for next $attr", NONSENSITIVE );
			}
		} else {
			$auth->printDebug( "Failed to get a result searching for next $attr", NONSENSITIVE );
		}
		$auth->printDebug( "id returned: $highest", NONSENSITIVE );
		return $highest;
	}

	/**
	 * Hook to add objectclasses and attributes for users being created.
	 *
	 * @static
	 * @param  $auth
	 * @param  $username
	 * @param  $values
	 * @param  $writeloc
	 * @param  $userdn
	 * @param  $result
	 * @return bool
	 */
	static function LDAPSetCreationValues( $auth, $username, &$values, $writeloc, &$userdn, &$result ) {
		global $wgOpenStackManagerLDAPDefaultGid;
		global $wgOpenStackManagerLDAPDefaultShell;
		global $wgOpenStackManagerLDAPUseUidAsNamingAttribute;
		global $wgRequest;

		$values['objectclass'][] = 'person';
		$values['objectclass'][] = 'novauser';
		$values['objectclass'][] = 'ldappublickey';
		$values['objectclass'][] = 'posixaccount';
		$values['objectclass'][] = 'shadowaccount';
		$values['accesskey'] = OpenStackNovaUser::uuid4();
		$values['secretkey'] = OpenStackNovaUser::uuid4();
		$values['isnovaadmin'] = 'FALSE';
		$uidnumber = OpenStackNovaUser::getNextIdNumber( $auth, 'uidnumber' );
		if ( ! $uidnumber ) {
			$result = false;
			return false;
		}
		$values['cn'] = $username;
		if ( '' != $auth->realname ) {
			$values['displayname'] = $auth->realname;
		}
		$username = $wgRequest->getText( 'shellaccountname' );
		if ( ! preg_match( "/^[a-z][a-z0-9\-_]*$/", $username ) ) {
			$result = false;
			return false;
		}
		$values['uid'] = $username;
		$base = $auth->getBaseDN( USERDN );
		# Though the LDAP plugin checks to see if the user account exists,
		# it does not check to see if the uid attribute is already used.
		$result = LdapAuthenticationPlugin::ldap_search( $auth->ldapconn, $base, "(uid=$username)" );
		if ( $result ) {
			$entries = LdapAuthenticationPlugin::ldap_get_entries( $auth->ldapconn, $result );
			if ( (int)$entries['count'] > 0 ) {
				$auth->printDebug( "User $username already exists.", NONSENSITIVE );
				# uid attribute is already in use, fail.
				$result = false;
				return false;
			}
		}
		$values['uidnumber'] = $uidnumber;
		$values['gidnumber'] = $wgOpenStackManagerLDAPDefaultGid;
		$values['homedirectory'] = '/home/' . $username;
		$values['loginshell'] = $wgOpenStackManagerLDAPDefaultShell;

		if ( $wgOpenStackManagerLDAPUseUidAsNamingAttribute ) {
			if ( $writeloc == '' ) {
				$auth->printDebug( "Trying to set the userdn, but write location isn't set.", NONSENSITIVE );
				return false;
			} else {
				$userdn = 'uid=' . $username . ',' . $writeloc;
				$auth->printDebug( "Using uid as the naming attribute, dn is: $userdn", NONSENSITIVE );
			}
		}
		$auth->printDebug( "User account's objectclasses: ", NONSENSITIVE, $values['objectclass'] );
		$auth->printDebug( "User account's attributes: ", HIGHLYSENSITIVE, $values );

		return true;
	}

	/**
	 * Hook to add objectclasses and attributes for users that already exist, but have
	 * missing information.
	 *
	 * @static
	 * @param  $auth
	 * @return bool
	 */
	static function LDAPSetNovaInfo( $auth ) {
		global $wgMemc;

		OpenStackNovaLdapConnection::connect();
		$result = LdapAuthenticationPlugin::ldap_read( $auth->ldapconn, $auth->userInfo[0]['dn'], '(objectclass=*)', array( 'secretkey', 'accesskey', 'objectclass' ) );
		$userInfo = LdapAuthenticationPlugin::ldap_get_entries( $auth->ldapconn, $result );
		if ( !isset( $userInfo[0]['accesskey'] ) or !isset( $userInfo[0]['secretkey'] ) ) {
			$objectclasses = $userInfo[0]['objectclass'];
			# First entry is a count
			array_shift( $objectclasses );
			if ( !in_array( 'novauser', $objectclasses ) ) {
				$values['objectclass'] = array();
				# ldap_modify for objectclasses requires the array indexes be sequential.
				# It is stupid, yes.
				foreach ( $objectclasses as $objectclass ) {
					$values['objectclass'][] = $objectclass;
				}
				$values['objectclass'][] = 'novauser';
			}
			$values['accesskey'] = OpenStackNovaUser::uuid4();
			$values['secretkey'] = OpenStackNovaUser::uuid4();
			$values['isnovaadmin'] = 'FALSE';

			$success = LdapAuthenticationPlugin::ldap_modify( $auth->ldapconn, $auth->userdn, $values );
			if ( $success ) {
				$key = wfMemcKey( 'ldapauthentication', 'userinfo', $auth->userdn );
				$wgMemc->delete( $key );
				$auth->printDebug( "Successfully modified the user's nova attributes", NONSENSITIVE );
				return true;
			} else {
				$auth->printDebug( "Failed to modify the user's nova attributes.", NONSENSITIVE );
				# Always return true, other hooks should still run, even if this fails
				return true;
			}
		} else {
			$auth->printDebug( "User has accesskey and secretkey set.", NONSENSITIVE );
			return true;
		}
	}

	/**
	 * @static
	 * @param $template
	 * @return bool
	 */
	static function LDAPModifyUITemplate( &$template ) {
		$input = array( 'msg' => 'openstackmanager-shellaccountname', 'type' => 'text', 'name' => 'shellaccountname', 'value' => '', 'helptext' => 'openstackmanager-shellaccountnamehelp' );
		$template->set( 'extraInput', array( $input ) );

		return true;
	}

}

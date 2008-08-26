<?php
# Copyright (C) 2004 Ryan Lane <http://www.mediawiki.org/wiki/User:Ryan_lane>
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
 * LdapAuthentication plugin.
 *
 * Password authentication, and Smartcard Authentication support are currently
 * available. All forms of authentication, current and future, should support
 * group, and attribute based restrictions; preference pulling; and group
 * syncronization. All forms of authentication should have basic support for 
 * adding users, changing passwords, and updating preferences in LDAP.
 *
 * Password authentication has a number of configurations, including straight binds,
 * proxy based authentication, and anonymous-search based authentication.
 *
 * @package MediaWiki
 */

#
# LdapAuthentication.php
#
# Info available at http://www.mediawiki.org/wiki/Extension:LDAP_Authentication
# and at http://www.mediawiki.org/wiki/Extension:LDAP_Authentication/Configuration_Examples
# and at http://www.mediawiki.org/wiki/Extension:LDAP_Authentication/Smartcard_Configuration_Examples
#
# Support is available at http://www.mediawiki.org/wiki/Extension_talk:LDAP_Authentication 
#

//constants for search base
define("GROUPDN", 0);
define("USERDN", 1);
define("DEFAULTDN", 2);

//constants for error reporting
define("NONSENSITIVE", 1);
define("SENSITIVE", 2);
define("HIGHLYSENSITIVE", 3);

class LdapAuthenticationPlugin extends AuthPlugin {

	//preferences
	var $email, $lang, $realname, $nickname, $externalid;

	//username pulled from ldap
	var $LDAPUsername;

	//groups pulled from ldap
	var $userLDAPGroups, $foundUserLDAPGroups;
	var $allLDAPGroups;

	//boolean to test for failed auth
	var $authFailed;

	function LdapAuthenticationPlugin() {
	}

	/**
	 * Check whether there exists a user account with the given name.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * @param string $username
	 * @return bool
	 * @access public
	 */
	function userExists( $username ) {
		global $wgLDAPAddLDAPUsers;

		$this->printDebug( "Entering userExists", NONSENSITIVE );

		//If we can't add LDAP users, we don't really need to check
		//if the user exists, the authenticate method will do this for
		//us. This will decrease hits to the LDAP server.
		//We do however, need to use this if we are using smartcard authentication.
		if ( ( !isset( $wgLDAPAddLDAPUsers[$_SESSION['wsDomain']] ) || !$wgLDAPAddLDAPUsers[$_SESSION['wsDomain']]) && !$this->useSmartcardAuth() ) {
			return true;
		}

		$ldapconn = $this->connect();
		if ( $ldapconn ) {
			$this->printDebug( "Successfully connected", NONSENSITIVE );

			$searchstring = $this->getSearchString( $ldapconn, $username );

			//If we are using smartcard authentication, and we got
			//anything back, then the user exists.
			if ( $this->useSmartcardAuth() && $searchstring != '' ) {
				//getSearchString is going to bind, but will not unbind
				//Let's clean up
				@ldap_unbind();
				return true;
			}

			//Search for the entry.
			$entry = @ldap_read( $ldapconn, $searchstring, "objectclass=*" );

			//getSearchString is going to bind, but will not unbind
			//Let's clean up
			@ldap_unbind();
			if ( !$entry ) {
				$this->printDebug( "Did not find a matching user in LDAP", NONSENSITIVE );
				return false;
			} else {
				$this->printDebug( "Found a matching user in LDAP", NONSENSITIVE );
				return true;
			}
		} else {
			$this->printDebug( "Failed to connect", NONSENSITIVE );
			return false;
		}
		
	}

	/**
	 * Connect to LDAP
	 *
	 * @return resource
	 * @access private
	 */
	function connect() {
		global $wgLDAPServerNames;
		global $wgLDAPEncryptionType;
		global $wgLDAPOptions;

		$this->printDebug( "Entering Connect", NONSENSITIVE );

                if ( !extension_loaded( 'ldap' ) ) {
			$this->printDebug( "It looks like you are issing LDAP support; please ensure you have either compiled LDAP support in, or have enabled the module. If the authentication is working for you, the plugin isn't properly detecting the LDAP module, and you can safely ignore this message.", NONSENSITIVE );
                }

		//If the admin didn't set an encryption type, we default to tls
		if ( isset( $wgLDAPEncryptionType[$_SESSION['wsDomain']] ) ) {
			$encryptionType = $wgLDAPEncryptionType[$_SESSION['wsDomain']];
		} else {
			$encryptionType = "tls";
		}

		//Set the server string depending on whether we use ssl or not
		switch( $encryptionType ) {
			case "ssl":
				$this->printDebug( "Using SSL", SENSITIVE );
				$serverpre = "ldaps://";
				break;
			default:
				$this->printDebug( "Using TLS or not using encryption.", SENSITIVE );
				$serverpre = "ldap://";
		}

		//Make a space seperated list of server strings with the ldap:// or ldaps://
		//string added.
		$servers = "";
		$tmpservers = $wgLDAPServerNames[$_SESSION['wsDomain']];
		$tok = strtok( $tmpservers, " " );
		while ( $tok ) {
			$servers = $servers . " " . $serverpre . $tok;
			$tok = strtok( " " );
		}
		$servers = rtrim($servers);

		$this->printDebug( "Using servers: $servers", SENSITIVE );

		//Connect and set options
		$ldapconn = @ldap_connect( $servers );
		ldap_set_option( $ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option( $ldapconn, LDAP_OPT_REFERRALS, 0);

		if ( isset( $wgLDAPOptions[$_SESSION['wsDomain']] ) ) {
			$options = $wgLDAPOptions[$_SESSION['wsDomain']];
			foreach ( $options as $key => $value ) {
				if ( !ldap_set_option( $ldapconn, constant( $key ), $value ) ) {
					$this->printDebug( "Can't set option to LDAP! Option code and value: " . $key . "=" . $value, 1 );
				}
			}
		}

		//TLS needs to be started after the connection is made
		if ( $encryptionType == "tls" ) {
			$this->printDebug( "Using TLS", SENSITIVE );
			if ( !ldap_start_tls( $ldapconn ) ) {
				$this->printDebug( "Failed to start TLS.", SENSITIVE );
				return;
			}
		}

		return $ldapconn;
	}

	/**
	 * Check if a username+password pair is a valid login, or if the username
	 * is allowed access to the wiki.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * @param string $username
	 * @param string $password
	 * @return bool
	 * @access public
	 */
	function authenticate( $username, $password='' ) {
		global $wgLDAPRetrievePrefs;
		global $wgLDAPGroupDN, $wgLDAPRequiredGroups;
		global $wgLDAPGroupUseFullDN, $wgLDAPGroupUseRetrievedUsername;
		global $wgLDAPUseLDAPGroups;
		global $wgLDAPRequireAuthAttribute, $wgLDAPAuthAttribute;
		global $wgLDAPSSLUsername;
		global $wgLDAPLowerCaseUsername;
		global $wgLDAPSearchStrings;
		global $wgLDAPUniqueAttribute, $wgLDAPUniqueBlockLogin, $wgLDAPUniqueRenameUser;
		global $wgLDAPGroupsPrevail;

		$this->printDebug( "Entering authenticate", NONSENSITIVE );

		//We don't handle local authentication
		if ( 'local' == $_SESSION['wsDomain'] ) {
			$this->printDebug( "User is using a local domain", SENSITIVE );
			$this->cleanupFailedAuth();
			return false;
		}

		//If the user is using smartcard authentication, we need to ensure
		//that he/she isn't trying to fool us by sending a username other
		//than the one the web server got from the smartcard.
		if ( $this->useSmartcardAuth() && $wgLDAPSSLUsername != $username ) {
			$this->printDebug( "The username provided doesn't match the username on the smartcard. The user is probably trying to log in to the smartcard domain with password authentication. Denying access.", SENSITIVE );
			$this->cleanupFailedAuth();
			return false;
		}

		//We need to ensure that if we require a password, that it is
		//not blank. We don't allow blank passwords, so we are being
		//tricked if someone is supplying one when using password auth.
		//Smartcard authentication uses a pin, and does not require
		//a password to be given; a blank password here is wanted.
		if ( '' == $password && !$this->useSmartcardAuth() ) {
			$this->printDebug( "User used a blank password", NONSENSITIVE );
			$this->cleanupFailedAuth();
			return false;
		}

		$ldapconn = $this->connect();
		if ( $ldapconn ) {
			$this->printDebug( "Connected successfully", NONSENSITIVE );

			//Mediawiki munges the username before authenticate is called,
			//this can mess with authentication, group pulling/restriction,
			//preference pulling, etc. Let's allow the admin to use
			//a lowercased username if needed.
			if ( isset( $wgLDAPLowerCaseUsername[$_SESSION['wsDomain']] ) && $wgLDAPLowerCaseUsername[$_SESSION['wsDomain']] ) {
				$this->printDebug( "Lowercasing the username: $username", NONSENSITIVE );
				$username = strtolower( $username );
			}

			$userdn = $this->getSearchString( $ldapconn, $username );

			//It is possible that getSearchString will return an
			//empty string; if this happens, the bind will ALWAYS
			//return true, and will let anyone in!
			if ( '' == $userdn ) {
				$this->printDebug( "User DN is blank", NONSENSITIVE );
				// Lets clean up.
				@ldap_unbind();
				$this->cleanupFailedAuth();
				return false;
			}

			//If we are using password authentication, we need to bind as the
			//user to make sure the password is correct.
			if ( !$this->useSmartcardAuth() ) {
				$this->printDebug( "Binding as the user", NONSENSITIVE );

				//Let's see if the user can authenticate.
				$bind = $this->bindAs( $ldapconn, $userdn, $password );
				if ( !$bind ) {
					// Lets clean up.
					@ldap_unbind();
					$this->cleanupFailedAuth();
					return false;
				}
				$this->printDebug( "Bound successfully", NONSENSITIVE );

				if ( isset( $wgLDAPSearchStrings[$_SESSION['wsDomain']] ) ) { 
					$ss = $wgLDAPSearchStrings[$_SESSION['wsDomain']];
					if ( strstr( $ss, "@" ) || strstr( $ss, '\\' ) ) {
						//We are most likely configured using USER-NAME@DOMAIN, or
						//DOMAIN\\USER-NAME.
						//Get the user's full DN so we can search for groups and such.
						$userdn = $this->getUserDN( $ldapconn, $username );
						$this->printDebug( "Pulled the user's DN: $userdn", NONSENSITIVE );
					}
				}

				if ( ( isset( $wgLDAPRequireAuthAttribute[$_SESSION['wsDomain']] )
					&& $wgLDAPRequireAuthAttribute[$_SESSION['wsDomain']] ) ) {

					$this->printDebug( "Checking for auth attributes", NONSENSITIVE );

					$filter = "(" . $wgLDAPAuthAttribute[$_SESSION['wsDomain']] . ")";
					$attributes = array( "dn" );

					$entry = ldap_read( $ldapconn, $userdn, $filter, $attributes );
					$info = ldap_get_entries( $ldapconn, $entry );

					if ( $info["count"] < 1 ) {
						$this->printDebug( "Failed auth attribute check", NONSENSITIVE );
						// Lets clean up.
						@ldap_unbind();
						$this->cleanupFailedAuth();
						return false;
					}
				}
			}

			//Old style groups, non-nestable and fairly limited on group type (full DN
			//versus username). DEPRECATED
			if ( $wgLDAPGroupDN ) {
				$this->printDebug( "Checking for (old style) group membership", NONSENSITIVE );
				if ( !$this->isMemberOfLdapGroup( $ldapconn, $userdn, $wgLDAPGroupDN ) ) {
					$this->printDebug( "Failed (old style) group membership check", NONSENSITIVE );

					//No point in going on if the user isn't in the required group
					// Lets clean up.
					@ldap_unbind();
					$this->cleanupFailedAuth();
					return false;
				}
			}

			//New style group checking
			if ( isset( $wgLDAPRequiredGroups[$_SESSION['wsDomain']] ) ) {
				$this->printDebug( "Checking for (new style) group membership", NONSENSITIVE );

				if ( isset( $wgLDAPGroupUseFullDN[$_SESSION['wsDomain']] ) && $wgLDAPGroupUseFullDN[$_SESSION['wsDomain']] ) {
					$inGroup = $this->isMemberOfRequiredLdapGroup( $ldapconn, $userdn );
				} else {
					if ( ( isset( $wgLDAPGroupUseRetrievedUsername[$_SESSION['wsDomain']] ) 
						&& $wgLDAPGroupUseRetrievedUsername[$_SESSION['wsDomain']] )
						&& $this->LDAPUsername != '' ) {

						$this->printDebug( "Using the username retrieved from the user's entry.", NONSENSITIVE );
						$inGroup = $this->isMemberOfRequiredLdapGroup( $ldapconn, $this->LDAPUsername );
					} else {
						$inGroup = $this->isMemberOfRequiredLdapGroup( $ldapconn, $username );
					}
				}

				if ( !$inGroup ) {
					// Lets clean up.
					@ldap_unbind();
					$this->cleanupFailedAuth();
					return false;
				}

			}

			//Synch LDAP groups with MediaWiki groups
			if ( isset( $wgLDAPUseLDAPGroups[$_SESSION['wsDomain']] ) && $wgLDAPUseLDAPGroups[$_SESSION['wsDomain']] ) {
				$this->printDebug( "Retrieving LDAP group membership", NONSENSITIVE );

				//Let's get the user's LDAP groups
				if ( isset( $wgLDAPGroupUseFullDN[$_SESSION['wsDomain']] ) && $wgLDAPGroupUseFullDN[$_SESSION['wsDomain']] ) {
					$this->userLDAPGroups = $this->getUserGroups( $ldapconn, $userdn, true );
				} else {
					if ( ( isset( $wgLDAPGroupUseRetrievedUsername[$_SESSION['wsDomain']] ) && $wgLDAPGroupUseRetrievedUsername[$_SESSION['wsDomain']] )
						&& $this->LDAPUsername != '' ) {

						$this->userLDAPGroups = $this->getUserGroups( $ldapconn, $this->LDAPUsername, true );
					} else {
						$this->userLDAPGroups = $this->getUserGroups( $ldapconn, $username, true );
					}
				}

				//Only find all groups if the user has any groups; otherwise, we are
				//just wasting a search.
				if ( $this->foundUserLDAPGroups && ( isset( $wgLDAPGroupsPrevail[$_SESSION['wsDomain']] ) && $wgLDAPGroupsPrevail[$_SESSION['wsDomain']] ) ) {
					$this->allLDAPGroups = $this->getAllGroups( $ldapconn, true );
				}
			}

			//Retrieve preferences
			if ( isset( $wgLDAPRetrievePrefs[$_SESSION['wsDomain']] ) && $wgLDAPRetrievePrefs[$_SESSION['wsDomain']] ) {
				$this->printDebug( "Retrieving preferences", NONSENSITIVE );

				$entry = @ldap_read( $ldapconn, $userdn, "objectclass=*" );
				$info = @ldap_get_entries( $ldapconn, $entry );
                                if (isset($info[0]["mail"])) {
        				$this->email = $info[0]["mail"][0];
                                }
                                if (isset($info[0]["preferredlanguage"])) {
				        $this->lang = $info[0]["preferredlanguage"][0];
                                }
                                if (isset($info[0]["displayname"])) {
				        $this->nickname = $info[0]["displayname"][0];
                                }
                                if (isset($info[0]["cn"])) {
				        $this->realname = $info[0]["cn"][0];
                                }

				$this->printDebug( "Retrieved: $this->email, $this->lang, $this->nickname, $this->realname", SENSITIVE );
			}

			// Are we blocking login/renaming users on unique external ID mismatches?
			//     *** WARNING ***
			//     This needs to be fixed before use! This probably does not work correctly
			//     with all options. It is probably a good idea to refactor the username stuff
			//     in general (as it is currently somewhat of a kludge). Also, MediaWiki does
			//     not currently have support for this.
			//     *** WARNING ***
			if ( ( isset( $wgLDAPUniqueBlockLogin[$_SESSION['wsDomain']] ) && $wgLDAPUniqueBlockLogin[$_SESSION['wsDomain']] )
				|| ( isset( $wgLDAPUniqueRenameUser[$_SESSION['wsDomain']] ) && $wgLDAPUniqueRenameUser[$_SESSION['wsDomain']] ) ) {

				$this->printDebug( "Checking for username change in LDAP.", SENSITIVE );

				//Get the user's unique attribute from LDAP
				if ( isset( $wgLDAPUniqueAttribute[$_SESSION['wsDomain']] ) ) {
					$ldapuniqueattr = $wgLDAPUniqueAttribute[$_SESSION['wsDomain']];
					$this->externalid = $info[0][$ldapuniqueattr][0];
				}

				$this->printDebug( "Retrieved external id: $this->externalid", SENSITIVE );

				$retrievedusername = User::whoIsExternalID( "$this->externalid" );

				$this->printDebug( "Username (in MediaWiki database) of fetched external id: $retrievedusername", SENSITIVE );

				// See if the username returned from the database matches the username given
				if ( $retrievedusername != '' && ( $username != $retrievedusername ) ) {
					if ( isset( $wgLDAPUniqueBlockLogin[$_SESSION['wsDomain']] )
						&& $wgLDAPUniqueBlockLogin[$_SESSION['wsDomain']] ) {

						$this->printDebug( "Usernames do not match, blocking login.", SENSITIVE );
						return false;
					} else if ( isset( $wgLDAPUniqueRenameUser[$_SESSION['wsDomain']] )
						&& $wgLDAPUniqueRenameUser[$_SESSION['wsDomain']] ) {

						$this->printDebug( "Usernames do not match, renaming user in database.", SENSITIVE );

						global $wgVersion;
						if ( version_compare( $wgVersion, '1.7.0', '<' ) ) {
							$this->printDebug( "Renaming users is only supported in MediaWiki 1.7+, please upgrade.", SENSITIVE );
							$this->cleanupFailedAuth();
							return false;
						}

						$olduser = User::newFromName( $retrievedusername );
						$uid = $olduser->idForName();

						// Ensure we don't require the same class twice
						if ( !class_exists( 'RenameuserSQL' ) ) {
							require( 'Renameuser/SpecialRenameuser_body.php' );
						}

						// Make a new rename user object with: from, to, uid of from	
						$rename = new RenameuserSQL( $retrievedusername, $username, $uid );
						$rename->rename();

						// For the time being we can't just allow the user to log in
						// as MediaWiki will try to create the user account after we
						// do a rename. If we don't return false, the user will get
						// a database error
						$this->cleanupFailedAuth();
						return false;
					}
				}

				$this->printDebug( "Usernames matched or the user doesn't exist in the database yet.", SENSITIVE );
			}

			// Lets clean up.
			@ldap_unbind();
		} else {
			$this->printDebug( "Failed to connect", NONSENSITIVE );
			$this->cleanupFailedAuth();
			return false;
		}
		$this->printDebug( "Authentication passed", NONSENSITIVE );

		//We made it this far; the user authenticated and didn't fail any checks, so he/she gets in.
		return true;
	}

	function cleanupFailedAuth() {
		$this->authFailed = true;
	}

	/**
	 * Modify options in the login template.
	 *
	 * @param UserLoginTemplate $template
	 * @access public
	 */
	function modifyUITemplate( &$template ) {
		global $wgLDAPDomainNames, $wgLDAPUseLocal;
		global $wgLDAPAddLDAPUsers;
		global $wgLDAPUseSmartcardAuth, $wgLDAPSmartcardDomain;

		$this->printDebug( "Entering modifyUITemplate", NONSENSITIVE );

		if ( !isset( $wgLDAPAddLDAPUsers[$_SESSION['wsDomain']] ) || !$wgLDAPAddLDAPUsers[$_SESSION['wsDomain']] ) {
			$template->set( 'create', false );
		}

		$template->set( 'usedomain', true );
		$template->set( 'useemail', false );

		$tempDomArr = $wgLDAPDomainNames;
		if ( $wgLDAPUseLocal ) {
			$this->printDebug( "Allowing the local domain, adding it to the list.", NONSENSITIVE );
			array_push( $tempDomArr, 'local' );
		}

		if ( $wgLDAPUseSmartcardAuth ) {
			$this->printDebug( "Allowing smartcard login, removing the domain from the list.", NONSENSITIVE );

			//There is no reason for people to log in directly to the wiki if the are using a
			//smartcard. If they try to, they are probably up to something fishy.
			unset( $tempDomArr[array_search( $wgLDAPSmartcardDomain, $tempDomArr )] );
		}

		$template->set( 'domainnames', $tempDomArr );
	}

	/**
	 * Return true if the wiki should create a new local account automatically
	 * when asked to login a user who doesn't exist locally but does in the
	 * external auth database.
	 *
	 * This is just a question, and shouldn't perform any actions.
	 *
	 * @return bool
	 * @access public
	 */
	function autoCreate() {
		global $wgLDAPDisableAutoCreate;

		if ( isset( $wgLDAPDisableAutoCreate[$_SESSION['wsDomain']] ) && $wgLDAPDisableAutoCreate[$_SESSION['wsDomain']] ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Set the given password in LDAP.
	 * Return true if successful.
	 *
	 * @param User $user
	 * @param string $password
	 * @return bool
	 * @access public
	 */
	function setPassword( $user, &$password ) {
		global $wgLDAPUpdateLDAP, $wgLDAPWriterDN, $wgLDAPWriterPassword;

		$this->printDebug( "Entering setPassword", NONSENSITIVE );

		if ( $_SESSION['wsDomain'] == 'local' ) {
			$this->printDebug( "User is using a local domain", NONSENSITIVE );

			//We don't set local passwords, but we don't want the wiki
			//to send the user a failure.		
			return true;
		} else if ( !isset( $wgLDAPUpdateLDAP[$_SESSION['wsDomain']] ) || !$wgLDAPUpdateLDAP[$_SESSION['wsDomain']] ) {
			$this->printDebug( "Wiki is set to not allow updates", NONSENSITIVE );

			//We aren't allowing the user to change his/her own password
			return false;
		}

		if ( !isset( $wgLDAPWriterDN[$_SESSION['wsDomain']] ) ) {
			$this->printDebug( "Wiki doesn't have wgLDAPWriterDN set", NONSENSITIVE );

			//We can't change a user's password without an account that is
			//allowed to do it.
			return false;
		}

		$pass = $this->getPasswordHash( $password );

		$ldapconn = $this->connect();
		if ( $ldapconn ) {
			$this->printDebug( "Connected successfully", NONSENSITIVE );
			$userdn = $this->getSearchString( $ldapconn, $user->getName() );

			$this->printDebug( "Binding as the writerDN", NONSENSITIVE );
			$bind = $this->bindAs( $ldapconn, $wgLDAPWriterDN[$_SESSION['wsDomain']], $wgLDAPWriterPassword[$_SESSION['wsDomain']] );
			if ( !$bind ) {
				return false;
			}

			$values["userpassword"] = $pass;

			//Blank out the password in the database. We don't want to save
			//domain credentials for security reasons.
			$password = '';

			$success = ldap_modify( $ldapconn, $userdn, $values );

			//Let's clean up
			@ldap_unbind();
			if ( $success ) {
				$this->printDebug( "Successfully modified the user's password", NONSENSITIVE );
				return true;
			} else {
				$this->printDebug( "Failed to modify the user's password", NONSENSITIVE );
				return false;
			}
		} else {
			$this->printDebug( "Failed to connect", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Update user information in LDAP
	 * Return true if successful.
	 *
	 * @param User $user
	 * @return bool
	 * @access public
	 */	
	function updateExternalDB( $user ) {
		global $wgLDAPUpdateLDAP;
		global $wgLDAPWriterDN, $wgLDAPWriterPassword;

		$this->printDebug( "Entering updateExternalDB", NONSENSITIVE );

		if ( ( !isset( $wgLDAPUpdateLDAP[$_SESSION['wsDomain']] ) || !$wgLDAPUpdateLDAP[$_SESSION['wsDomain']] ) ||
			$_SESSION['wsDomain'] == 'local' ) {
			$this->printDebug( "Either the user is using a local domain, or the wiki isn't allowing updates", NONSENSITIVE );

			//We don't handle local preferences, but we don't want the
			//wiki to return an error.
			return true;
		}

		if ( !isset( $wgLDAPWriterDN[$_SESSION['wsDomain']] ) ) {
			$this->printDebug( "The wiki doesn't have wgLDAPWriterDN set", NONSENSITIVE );

			//We can't modify LDAP preferences if we don't have a user
			//capable of editing LDAP attributes.
			return false;
		}

		$this->email = $user->getEmail();
		$this->realname = $user->getRealName();
		$this->nickname = $user->getOption( 'nickname' );
		$this->language = $user->getOption( 'language' );

		$ldapconn = $this->connect();
		if ( $ldapconn ) {
			$this->printDebug( "Connected successfully", NONSENSITIVE );
			$userdn = $this->getSearchString( $ldapconn, $user->getName() );

			$this->printDebug( "Binding as the writerDN", NONSENSITIVE );
			$bind = $this->bindAs( $ldapconn, $wgLDAPWriterDN[$_SESSION['wsDomain']], $wgLDAPWriterPassword[$_SESSION['wsDomain']] );
			if ( !$bind ) {
				return false;
			}

			if ( '' != $this->email ) { $values["mail"] = $this->email; }
			if ( '' != $this->nickname ) { $values["displayname"] = $this->nickname; }
			if ( '' != $this->realname ) { $values["cn"] = $this->realname; }
			if ( '' != $this->language ) { $values["preferredlanguage"] = $this->language; }

			if ( 0 != sizeof( $values ) && ldap_modify( $ldapconn, $userdn, $values ) ) {
				$this->printDebug( "Successfully modified the user's attributes", NONSENSITIVE );
				@ldap_unbind();
				return true;
			} else {
				$this->printDebug( "Failed to modify the user's attributes", NONSENSITIVE );
				@ldap_unbind();
				return false;
			}
		} else {
			$this->printDebug( "Failed to Connect", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Can the wiki create accounts in LDAP?
	 * Return true if yes.
	 *
	 * @return bool
	 * @access public
	 */	
	function canCreateAccounts() {
		global $wgLDAPAddLDAPUsers;

		if ( isset( $wgLDAPAddLDAPUsers[$_SESSION['wsDomain']] ) && $wgLDAPAddLDAPUsers[$_SESSION['wsDomain']] ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Can the wiki change passwords in LDAP, or can the user
	 * change passwords locally?
	 * Return true if yes.
	 *
	 * @return bool
	 * @access public
	 */	
	function allowPasswordChange() {
		global $wgLDAPUpdateLDAP, $wgLDAPMailPassword;
		global $wgLDAPUseLocal;

		$retval = false;

		// Local domains need to be able to change passwords
		if ( (isset($wgLDAPUseLocal) && $wgLDAPUseLocal) && 'local' == $_SESSION['wsDomain'] ) {
			$retval = true;
		}

		if ( isset( $wgLDAPUpdateLDAP[$_SESSION['wsDomain']] ) && $wgLDAPUpdateLDAP[$_SESSION['wsDomain']] ) {
			$retval = true;
		}

		if ( isset( $wgLDAPMailPassword[$_SESSION['wsDomain']] ) && $wgLDAPMailPassword[$_SESSION['wsDomain']] ) {
			$retval = true;
		}

		return $retval;
	}

	/**
	 * Add a user to LDAP.
	 * Return true if successful.
	 *
	 * @param User $user
	 * @param string $password
	 * @return bool
	 * @access public
	 */
	function addUser( $user, $password ) {
		global $wgLDAPAddLDAPUsers, $wgLDAPWriterDN, $wgLDAPWriterPassword;
		global $wgLDAPSearchAttributes;
		global $wgLDAPWriteLocation;
		global $wgLDAPRequiredGroups, $wgLDAPGroupDN;
		global $wgLDAPRequireAuthAttribute, $wgLDAPAuthAttribute;

		$this->printDebug( "Entering addUser", NONSENSITIVE );

		if ( ( !isset( $wgLDAPAddLDAPUsers[$_SESSION['wsDomain']] ) || !$wgLDAPAddLDAPUsers[$_SESSION['wsDomain']] ) ||
			'local' == $_SESSION['wsDomain'] ) {
			$this->printDebug( "Either the user is using a local domain, or the wiki isn't allowing users to be added to LDAP", NONSENSITIVE );

			//Tell the wiki not to return an error.
			return true;
		}

		if ( $wgLDAPRequiredGroups || $wgLDAPGroupDN ) {
			$this->printDebug( "The wiki is requiring users to be in specific groups, and cannot add users as this would be a security hole.", NONSENSITIVE );
			//It is possible that later we can add users into
			//groups, but since we don't support it, we don't want
			//to open holes!
			return false;
		}

		if ( !isset( $wgLDAPWriterDN[$_SESSION['wsDomain']] ) ) {
			$this->printDebug( "The wiki doesn't have wgLDAPWriterDN set", NONSENSITIVE );

			//We can't add users without an LDAP account capable of doing so.
			return false;
		}

		$this->email = $user->getEmail();
		$this->realname = $user->getRealName();
		$username = $user->getName();

		$pass = $this->getPasswordHash( $password );

		$ldapconn = $this->connect();
		if ( $ldapconn ) {
			$this->printDebug( "Successfully connected", NONSENSITIVE );

			$userdn = $this->getSearchString( $ldapconn, $username );
			if ( '' == $userdn ) {
				$this->printDebug( "userdn is blank, attempting to use wgLDAPWriteLocation", NONSENSITIVE );
				if ( isset( $wgLDAPWriteLocation[$_SESSION['wsDomain']] ) ) {
					$this->printDebug( "wgLDAPWriteLocation is set, using that", NONSENSITIVE );
					$userdn = $wgLDAPSearchAttributes[$_SESSION['wsDomain']] . "=" .
						$username . $wgLDAPWriteLocation[$_SESSION['wsDomain']];
				} else {
					$this->printDebug( "wgLDAPWriteLocation is not set, failing", NONSENSITIVE );
					//getSearchString will bind, but will not unbind
					@ldap_unbind();
					return false;
				}
			}

			$this->printDebug( "Binding as the writerDN", NONSENSITIVE );

			$bind = $this->bindAs( $ldapconn, $wgLDAPWriterDN[$_SESSION['wsDomain']], $wgLDAPWriterPassword[$_SESSION['wsDomain']] );
			if ( !$bind ) {
				$this->printDebug( "Failed to bind as the writerDN; add failed", NONSENSITIVE );
				return false;
			}

			//Set up LDAP attributes
			$values["uid"] = $username;
			//sn is required for objectclass inetorgperson
			$values["sn"] = $username;
			if ( '' != $this->email ) { $values["mail"] = $this->email; }
			if ( '' != $this->realname ) {$values["cn"] = $this->realname; }
				else { $values["cn"] = $username; }
			$values["userpassword"] = $pass;
			$values["objectclass"] = "inetorgperson";

			if ( $wgLDAPRequireAuthAttribute ) {
				$values[$wgLDAPAuthAttribute[$_SESSION['wsDomain']]] = "true";
			}

			$this->printDebug( "Adding user", NONSENSITIVE );
			if ( @ldap_add( $ldapconn, $userdn, $values ) ) {
				$this->printDebug( "Successfully added user", NONSENSITIVE );
				@ldap_unbind();
				return true;
			} else {
				$this->printDebug( "Failed to add user", NONSENSITIVE );
				@ldap_unbind();
				return false;
			}
		} else {
			$this->printDebug( "Failed to connect; add failed", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Set the domain this plugin is supposed to use when authenticating.
	 *
	 * @param string $domain
	 * @access public	
	 */
	function setDomain( $domain ) {
		$this->printDebug( "Setting domain as: $domain", NONSENSITIVE );
		$_SESSION['wsDomain'] = $domain;
	}

	/**
	 * Check to see if the specific domain is a valid domain.
	 * Return true if the domain is valid.
	 *
	 * @param string $domain
	 * @return bool
	 * @access public
	 */
	function validDomain( $domain ) {
		global $wgLDAPDomainNames, $wgLDAPUseLocal;

		$this->printDebug( "Entering validDomain", NONSENSITIVE );

		if ( in_array( $domain, $wgLDAPDomainNames ) || ( $wgLDAPUseLocal && 'local' == $domain ) ) {
			$this->printDebug( "User is using a valid domain.", NONSENSITIVE );
			return true;
		} else {
			$this->printDebug( "User is not using a valid domain.", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * When a user logs in, update user with information from LDAP.
	 *
	 * @param User $user
	 * @access public
	 * TODO: fix the setExternalID stuff
	 */
	function updateUser( &$user ) {
		global $wgLDAPRetrievePrefs;
		global $wgLDAPUseLDAPGroups;
		global $wgLDAPUniqueBlockLogin, $wgLDAPUniqueRenameUser;

		$this->printDebug( "Entering updateUser", NONSENSITIVE );

		if ($this->authFailed) {
			$this->printDebug( "User didn't successfully authenticate, exiting.", NONSENSITIVE );
			return;
		}

		$saveSettings = false;

		//If we aren't pulling preferences, we don't want to accidentally
		//overwrite anything.
		if ( isset( $wgLDAPRetrievePrefs[$_SESSION['wsDomain']] ) && $wgLDAPRetrievePrefs[$_SESSION['wsDomain']] ) {
			$this->printDebug( "Setting user preferences.", NONSENSITIVE );

			if ( '' != $this->lang ) {
				$user->setOption( 'language', $this->lang );
			}
			if ( '' != $this->nickname ) {
				$user->setOption( 'nickname', $this->nickname );
			}
			if ( '' != $this->realname ) {
				$user->setRealName( $this->realname );
			}
			if ( '' != $this->email ) {
				$user->setEmail( $this->email );
			}
			if ( ( isset( $wgLDAPUniqueBlockLogin[$_SESSION['wsDomain']] ) && $wgLDAPUniqueBlockLogin[$_SESSION['wsDomain']] )
				|| ( isset( $wgLDAPUniqueRenameUser[$_SESSION['wsDomain']] ) && $wgLDAPUniqueRenameUser[$_SESSION['wsDomain']] ) ) {

				if ( '' != $this->externalid ) {
					$user->setExternalID( $this->externalid );
				}
			}

			$saveSettings = true;
		}

		if ( isset( $wgLDAPUseLDAPGroups[$_SESSION['wsDomain']] ) && $wgLDAPUseLDAPGroups[$_SESSION['wsDomain']] ) {
			$this->printDebug( "Setting user groups.", NONSENSITIVE );
			$this->setGroups( $user );

			$saveSettings = true;
		}

		if ( $saveSettings ) {
			$this->printDebug( "Saving user settings.", NONSENSITIVE );
			$user->saveSettings();
		}
	}

	/**
	 * When creating a user account, initialize user with information from LDAP.
	 *
	 * @param User $user
	 * @access public
	 * TODO: fix setExternalID stuff
	 */
	function initUser( &$user ) {
		global $wgLDAPUseLDAPGroups;

		$this->printDebug( "Entering initUser", NONSENSITIVE );

		if ($this->authFailed) {
			$this->printDebug( "User didn't successfully authenticate, exiting.", NONSENSITIVE );
			return;
		}

		if ( 'local' == $_SESSION['wsDomain'] ) {
			$this->printDebug( "User is using a local domain", NONSENSITIVE );
			return;
		}

		//We are creating an LDAP user, it is very important that we do
		//NOT set a local password because it could compromise the
		//security of our domain.
		$user->mPassword = '';

		//The update user function does everything else we need done.
		$this->updateUser($user);

		//updateUser() won't definately save the user's settings
		$user->saveSettings();
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
		global $wgLDAPUseLocal, $wgLDAPMailPassword;

		$this->printDebug( "Entering strict.", NONSENSITIVE );

		if ( $wgLDAPUseLocal || $wgLDAPMailPassword ) {
			$this->printDebug( "Returning false in strict().", NONSENSITIVE );
			return false;
		} else {
			$this->printDebug( "Returning true in strict().", NONSENSITIVE );
			return true;
		}
	}

	/**
	 * Munge the username to always have a form of uppercase for the first letter,
	 * and lowercase for the rest of the letters.
	 *
	 * @param string $username
	 * @return string
	 * @access public
	 */
	function getCanonicalName( $username ) {
		global $wgLDAPUseLocal;
		$this->printDebug( "Entering getCanonicalName", NONSENSITIVE );

		if ( $username != '' ) {
			$this->printDebug( "Username isn't empty.", NONSENSITIVE );

			//We want to use the username returned by LDAP
			//if it exists
			if ( $this->LDAPUsername != '' ) {
				$this->printDebug( "Using LDAPUsername.", NONSENSITIVE );
				$username = $this->LDAPUsername;
			}

			if ( isset($_SESSION['wsDomain']) && 'local' != $_SESSION['wsDomain']) {
				//Change username to lowercase so that multiple user accounts
				//won't be created for the same user.
				//But don't do it for the local domain!
				$username = strtolower( $username );
			}

			//The wiki considers an all lowercase name to be invalid; need to
			//uppercase the first letter
			$username[0] = strtoupper( $username[0] );
		}

		$this->printDebug( "Munged username: $username", NONSENSITIVE );

		return $username;
	}

	/**
	 * Configures the authentication plugin for use with auto-authentication
	 * plugins.
	 *
	 * @access public
	 */
	function autoAuthSetup() {
		global $wgLDAPUseSmartcardAuth;
		global $wgLDAPSmartcardDomain;

		$wgLDAPUseSmartcardAuth = true;
		$this->setDomain( $wgLDAPSmartcardDomain );
	}

	/**
	 * Gets the searchstring for a user based upon settings for the domain.
	 * Returns a full DN for a user.
	 *
	 * @param resource $ldapconn
	 * @param string $username
	 * @return string
	 * @access private
	 */
	function getSearchString( $ldapconn, $username ) {
		global $wgLDAPSearchStrings;
		global $wgLDAPProxyAgent, $wgLDAPProxyAgentPassword;

		$this->printDebug( "Entering getSearchString", NONSENSITIVE );

		if ( isset( $wgLDAPSearchStrings[$_SESSION['wsDomain']] ) ) {
			//This is a straight bind
			$this->printDebug( "Doing a straight bind", NONSENSITIVE );

			$tmpuserdn = $wgLDAPSearchStrings[$_SESSION['wsDomain']];
			$userdn = str_replace( "USER-NAME", $username, $tmpuserdn );
		} else {
			//This is a proxy bind, or an anonymous bind with a search
			if ( isset( $wgLDAPProxyAgent[$_SESSION['wsDomain']] ) ) {
				//This is a proxy bind
				$this->printDebug( "Doing a proxy bind", NONSENSITIVE );
				$bind = $this->bindAs( $ldapconn, $wgLDAPProxyAgent[$_SESSION['wsDomain']], $wgLDAPProxyAgentPassword[$_SESSION['wsDomain']] );
			} else {
				//This is an anonymous bind
				$this->printDebug( "Doing an anonymous bind", NONSENSITIVE );
				$bind = $this->bindAs( $ldapconn );
			}
	
			if ( !$bind ) {
				$this->printDebug( "Failed to bind", NONSENSITIVE );
				return '';
			}

			$userdn = $this->getUserDN( $ldapconn, $username );
		}
		$this->printDebug( "userdn is: $userdn", SENSITIVE );
		return $userdn;
	}

	/**
	 * Gets the DN of a user based upon settings for the domain.
	 * This function will set $this->LDAPUsername
	 * You must bind to the server before calling this.
	 *
	 * @param resource $ldapconn
	 * @param string $username
	 * @return string
	 * @access private
	 */
	function getUserDN( $ldapconn, $username ) {
		global $wgLDAPSearchAttributes;
		global $wgLDAPRequireAuthAttribute, $wgLDAPAuthAttribute;

		$this->printDebug("Entering getUserDN", NONSENSITIVE);

		//we need to do a subbase search for the entry

		//Smartcard auth needs to check LDAP for required attributes.
		if ( ( isset( $wgLDAPRequireAuthAttribute[$_SESSION['wsDomain']] ) && $wgLDAPRequireAuthAttribute[$_SESSION['wsDomain']] )
			&& $this->useSmartcardAuth() ) {
			$auth_filter = "(" . $wgLDAPAuthAttribute[$_SESSION['wsDomain']] . ")";
			$srch_filter = "(" . $wgLDAPSearchAttributes[$_SESSION['wsDomain']] . "=" . $this->getLdapEscapedString( $username ) . ")";
			$filter = "(&" . $srch_filter . $auth_filter . ")";
			$this->printDebug( "Created an auth attribute filter: $filter", SENSITIVE );
		} else {
			$filter = "(" . $wgLDAPSearchAttributes[$_SESSION['wsDomain']] . "=" . $this->getLdapEscapedString( $username ) . ")";
			$this->printDebug( "Created a regular filter: $filter", SENSITIVE );
		}

		$attributes = array( "*" );
		$base = $this->getBaseDN( USERDN );

		$this->printDebug( "Using base: $base", SENSITIVE );

		$entry = @ldap_search( $ldapconn, $base, $filter, $attributes );
		if ( !$entry ) {
			$this->printDebug( "Couldn't find an entry", NONSENSITIVE );
			return '';
		}

		$info = @ldap_get_entries( $ldapconn, $entry );

		//This is a pretty useful thing to have for smartcard authentication,
		//group checking, and pulling preferences.
		wfRunHooks( 'SetUsernameAttributeFromLDAP', array( &$this->LDAPUsername, $info ) );
		if ( !is_string( $this->LDAPUsername ) ) {
			$this->printDebug( "Fetched username is not a string (check your hook code...). This message can be safely ignored if you do not have the SetUsernameAttributeFromLDAP hook defined.", NONSENSITIVE );
			$this->LDAPUsername = '';
		}

		$userdn = $info[0]["dn"];
		return $userdn;
	}

	//DEPRECATED
	function isMemberOfLdapGroup( $ldapconn, $userDN, $groupDN ) {
		$this->printDebug( "Entering isMemberOfLdapGroup (DEPRECATED)", NONSENSITIVE );

		//we need to do a subbase search for the entry
		$filter = "(member=" . $this->getLdapEscapedString( $userDN ) . ")";
		$info = ldap_get_entries( $ldapconn, @ldap_search( $ldapconn, $groupDN, $filter ) );

		return ( $info["count"] >= 1 );
	}

	/**
	 * Determines whether a user is a member of a group, or a nested group.
	 *
	 * @param resource $ldapconn
	 * @param string $userDN
	 * @return bool
	 * @access private
	 */
	function isMemberOfRequiredLdapGroup( $ldapconn, $userDN ) {
		global $wgLDAPRequiredGroups;
		global $wgLDAPGroupSearchNestedGroups;

		$this->printDebug( "Entering isMemberOfRequiredLdapGroup", NONSENSITIVE );

		$reqgroups = $wgLDAPRequiredGroups[$_SESSION['wsDomain']];
		for ( $i = 0; $i < count( $reqgroups ); $i++ ) {
			$reqgroups[$i] = strtolower( $reqgroups[$i] );
		}

		$searchnested = $wgLDAPGroupSearchNestedGroups[$_SESSION['wsDomain']];

		$this->printDebug( "Required groups:" . implode( ",",$reqgroups ) . "", NONSENSITIVE );

		$groups = $this->getUserGroups( $ldapconn, $userDN );

		//TODO: using variables for this kind of thing is dirty, let's think of a new way
		//      to handle this need.
		if ( !$this->foundUserLDAPGroups ) {
			$this->printDebug( "Couldn't find the user in any groups (1).", NONSENSITIVE );

			//User isn't in any groups, so he/she obviously can't be in
			//a required one
			return false;
		} else {
			//User is in groups, let's see if a required group is one of them
			foreach ( $groups as $group ) {
				if ( in_array( $group, $reqgroups ) ) {
					$this->printDebug( "Found user in a group.", NONSENSITIVE );
					return true;
				}
			}

			//We didn't find the user in the group, lets check nested groups
			if ( $searchnested ) {
				if ( $this->searchNestedGroups( $ldapconn, $groups ) ) {
					return true;
				}
			}

			$this->printDebug("Couldn't find the user in any groups (2).", NONSENSITIVE );

			return false;
		}
	}

	/**
	 * Helper function for isMemberOfRequiredLdapGroup.
	 * $checkedgroups is used for tail recursion and shouldn't be provided
	 * when called externally.
	 *
	 * @param resource $ldapconn
	 * @param string $userDN
	 * @param array $checkedgroups
	 * @return bool
	 * @access private
	 */
	function searchNestedGroups( $ldapconn, $groups, $checkedgroups = array() ) {
		global $wgLDAPRequiredGroups;

		$this->printDebug( "Entering searchNestedGroups", NONSENSITIVE );

		//base case, no more groups left to check
		if ( !$groups ) {
			$this->printDebug( "Couldn't find user in any nested groups.", NONSENSITIVE );
			return false;
		}

		$this->printDebug( "Checking groups:" . implode( ",", $groups ) . "", SENSITIVE );

		$reqgroups = $wgLDAPRequiredGroups[$_SESSION['wsDomain']];
		for ( $i = 0; $i < count( $reqgroups ); $i++ ) {
			$reqgroups[$i] = strtolower( $reqgroups[$i] );
		}

		$groupstocheck = array();
		foreach ( $groups as $group ) {
			$returnedgroups = $this->getUserGroups( $ldapconn, $group, false, false );
			$this->printDebug( "Group $group is in the following groups:" . implode( ",", $returnedgroups ) . "", SENSITIVE );
			foreach ( $returnedgroups as $checkme ) {
				if ( in_array( $checkme, $checkedgroups ) ) {
					//We already checked this, move on
					continue;
				}
				$this->printDebug( "Checking membership for: $checkme", SENSITIVE );
                                if ( in_array( $checkme, $reqgroups ) ) {
					$this->printDebug( "Found user in a nested group.", NONSENSITIVE );
					//Woohoo
					return true;
				} else {
					//We'll need to check this group's members now
					array_push( $groupstocheck, $checkme );
				}
			}
		}

		$checkedgroups = array_unique( array_merge( $groups, $checkedgroups ) );

		//Mmmmmm. Tail recursion. Tasty.
		return $this->searchNestedGroups( $ldapconn, $groupstocheck, $checkedgroups ); 
	}

	/**
	 * Helper function for isMemberOfRequiredLdapGroup and searchNestedGroups. Returns
	 * a list of groups the user is in, all munged to lowercase.
	 * Sets $this->foundUserLDAPGroups
	 *
	 * @param resource $ldapconn
	 * @param string $dn
	 * @return array
	 * @access private
	 */
	function getUserGroups( $ldapconn, $dn, $getShortnames = false, $returncache = true ) {
		$this->printDebug( "Entering getUserGroups", NONSENSITIVE );

		//Let's return the saved groups if they are available
		if ( $getShortnames ) {
			if ( $returncache && isset( $this->userLDAPShortnameGroupCache ) ) {
				$this->printDebug( "Returning short name group cache.", NONSENSITIVE );
				return $this->userLDAPShortnameGroupCache;
			}
		} else {
			if ( $returncache && isset( $this->userLDAPGroupCache ) ) {
				$this->printDebug( "Returning long name group cache.", NONSENSITIVE );
				return $this->userLDAPGroupCache;
			}
		}

		//We haven't done a search yet, lets do it now
		list( $groups, $shortnamegroups ) = $this->getGroups( $ldapconn, $dn );

		//Save the groups for next time we are called
		//Merge groups if a set of groups already exist for
		//nested group searching (half assed) support
		if ( isset( $this->userLDAPGroupCache ) ) {
			array_unique( array_merge( $groups, $this->userLDAPGroupCache ) );
		} else {
			$this->userLDAPGroupCache = $groups;
		}
		if ( isset( $this->userLDAPShortnameGroupCache ) ) {
			array_unique( array_merge( $shortnamegroups, $this->userLDAPShortnameGroupCache ) );
		} else {
			$this->userLDAPShortnameGroupCache = $shortnamegroups;
		}

		//We only need to check one of the two arrays, as they should be
		//identical from a member standpoint.
		if ( count( $groups ) == 0 ) {
			$this->foundUserLDAPGroups = false;
		} else {
			$this->foundUserLDAPGroups = true;
		}

		if ( $getShortnames ) {
			return $shortnamegroups;
		} else {
			return $groups;
		}
	}

	/**
	 * Helper function for retrieving all LDAP groups. Returns
	 * a list of all groups in the LDAP server, that match available groups
	 * the user is already joined to in MediaWiki, under the appropriate
	 * basedn, all munged to lowercase.
	 * Sets $this->foundAllLDAPGroups
	 *
	 * @param resource $ldapconn
	 * @param string $dn
	 * @return array
	 * @access private
	 */
	function getAllGroups( $ldapconn, $getShortnames = false ) {
		$this->printDebug( "Entering getAllGroups", NONSENSITIVE );

		//Let's return the saved groups if they are available
		if ( $getShortnames ) {
			if ( isset( $this->allLDAPShortnameGroupCache ) ) {
				return $this->allLDAPShortnameGroupCache;
			}
		} else {
			if ( isset( $this->allLDAPGroupCache ) ) {
				return $this->allLDAPGroupCache;
			}
		}

		//We haven't done a search yet, lets do it now
		list( $groups, $shortnamegroups ) = $this->getGroups( $ldapconn, '*' );

		//Save the groups for next time we are called
		$this->allLDAPGroupCache = $groups;
		$this->allLDAPShortnameGroupCache = $shortnamegroups;

		//We only need to check one of the two arrays, as they should be
		//identical from a member standpoint.
		if ( count( $groups ) == 0 ) {
			$this->foundAllLDAPGroups = false;
		} else {
			$this->foundAllLDAPGroups = true;
		}

		if ( $getShortnames ) {
			return $shortnamegroups;
		} else {
			return $groups;
		}
	}

	/**
	 * Helper function for getUserGroups and getAllGroups. You shouldn't
	 * call this directly.
	 *
	 * @param resource $ldapconn
	 * @param string $dn
	 * @return array
	 * @access private
	 */
	function getGroups( $ldapconn, $dn ) {
		global $wgLDAPGroupObjectclass, $wgLDAPGroupAttribute, $wgLDAPGroupNameAttribute;
		global $wgLDAPProxyAgent, $wgLDAPProxyAgentPassword;
		global $wgUser;

		$this->printDebug( "Entering getGroups", NONSENSITIVE );

		$base = $this->getBaseDN( GROUPDN );

		$objectclass = $wgLDAPGroupObjectclass[$_SESSION['wsDomain']];
		$attribute = $wgLDAPGroupAttribute[$_SESSION['wsDomain']];
		$nameattribute = $wgLDAPGroupNameAttribute[$_SESSION['wsDomain']];

                // We actually want to search for * not \2a
                $value = $dn;
                if ( $value != "*" )
                        $value = $this->getLdapEscapedString( $value );

		$filter = "(&($attribute=$value)(objectclass=$objectclass))";

		$this->printDebug( "Search string: $filter", SENSITIVE );

		if ( isset( $wgLDAPProxyAgent[$_SESSION['wsDomain']] ) ) {
			//We'll try to bind as the proxyagent as the proxyagent should normally have more
			//rights than the user. If the proxyagent fails to bind, we will still be able
			//to search as the normal user (which is why we don't return on fail).
			$this->printDebug( "Binding as the proxyagentDN", NONSENSITIVE );
			$bind = $this->bindAs( $ldapconn, $wgLDAPProxyAgent[$_SESSION['wsDomain']], $wgLDAPProxyAgentPassword[$_SESSION['wsDomain']] );
		}

		$info = @ldap_search( $ldapconn, $base, $filter );
		if ( !$info ) {
			$this->printDebug( "No entries returned from search.", SENSITIVE );

			//Return an array with two empty arrays so that other functions
			//don't error out.
			return array( array(), array() );
		}

		$entries = @ldap_get_entries( $ldapconn,$info );

		//We need to shift because the first entry will be a count
		array_shift( $entries );

		//Let's get a list of both full dn groups and shortname groups
		$groups = array();
		$shortnamegroups = array();
		foreach ( $entries as $entry ) {
			$mem = strtolower( $entry['dn'] );
			$shortnamemem = strtolower( $entry[$nameattribute][0] );

			array_push( $groups, $mem );
			array_push( $shortnamegroups, $shortnamemem );
		}

		$both_groups = array();
		array_push( $both_groups, $groups );
		array_push( $both_groups, $shortnamegroups );

		$this->printDebug( "Returned groups:" . implode( ",", $groups ) . "", SENSITIVE );
		$this->printDebug( "Returned groups:" . implode( ",", $shortnamegroups ) . "", SENSITIVE );

		return $both_groups;
	}

	/**
	 * Returns true if this group is in the list of the currently authenticated
	 * user's groups, else false.
	 *
	 * @param string $group
	 * @return bool
	 * @access private
	 */
	function hasLDAPGroup( $group ) {
		$this->printDebug( "Entering hasLDAPGroup", NONSENSITIVE );

		return in_array( strtolower( $group ), $this->userLDAPGroups );
	}

	/**
	 * Returns true if an LDAP group with this name exists, else false.
	 *
	 * @param string $group
	 * @return bool
	 * @access private
	 */
	function isLDAPGroup( $group ) {
		$this->printDebug( "Entering isLDAPGroup", NONSENSITIVE );

		return in_array( strtolower( $group ), $this->allLDAPGroups );
	}

	/**
	 * Helper function for updateUser() and initUser(). Adds users into MediaWiki security groups
	 * based upon groups retreived from LDAP.
	 *
	 * @param User $user
	 * @access private
	 */
	function setGroups( &$user ) {
                global $wgLDAPGroupsPrevail, $wgGroupPermissions;
		global $wgLDAPLocallyManagedGroups;

		$this->printDebug( "Entering setGroups.", NONSENSITIVE );

		# add groups permissions
		$localAvailGrps = $user->getAllGroups();
		$localUserGrps = $user->getEffectiveGroups();
		
		$defaultLocallyManagedGrps = array( 'bot', 'sysop', 'bureaucrat' );

		if ( isset( $wgLDAPLocallyManagedGroups[$_SESSION['wsDomain']] ) ) {
			$locallyManagedGrps = $wgLDAPLocallyManagedGroups[$_SESSION['wsDomain']];
			$locallyManagedGrps = array_unique( array_merge( $defaultLocallyManagedGrps, $locallyManagedGrps ) );		
			$this->printDebug( "Locally managed groups: " . implode( ",", $locallyManagedGrps ) . "", SENSITIVE );
		} else {
			$locallyManagedGrps = $defaultLocallyManagedGrps;
			$this->printDebug( "Locally managed groups is unset, using defaults: " . implode( ",", $locallyManagedGrps ) . "", SENSITIVE );
		}
			

                # Add ldap groups as local groups
                if ( isset( $wgLDAPGroupsPrevail[$_SESSION['wsDomain']] ) && $wgLDAPGroupsPrevail[$_SESSION['wsDomain']] ) {
			$this->printDebug( "Adding all groups to wgGroupPermissions: " . implode( ",", $this->allLDAPGroups ) . "", SENSITIVE );
                        foreach ( $this->allLDAPGroups as $ldapgroup )
                                if ( !array_key_exists( $ldapgroup, $wgGroupPermissions ) )
                                        $wgGroupPermissions[$ldapgroup] = array();
		}

		$this->printDebug( "Available groups are: " . implode( ",", $localAvailGrps ) . "", NONSENSITIVE );
		$this->printDebug( "Effective groups are: " . implode( ",", $localUserGrps ) . "", NONSENSITIVE );

		# note: $localUserGrps does not need to be updated with $cGroup added,
		#       as $localAvailGrps contains $cGroup only once.
		foreach ( $localAvailGrps as $cGroup ) {
			# did we once add the user to the group?
			if ( in_array( $cGroup,$localUserGrps ) ) {
				$this->printDebug( "Checking to see if we need to remove user from: $cGroup", NONSENSITIVE );
				if ( ( !$this->hasLDAPGroup( $cGroup ) ) && ( !in_array( $cGroup, $locallyManagedGrps ) ) ) {
					$this->printDebug( "Removing user from: $cGroup", NONSENSITIVE );
					# the ldap group overrides the local group
					# so as the user is currently not a member of the ldap group, he shall be removed from the local group
					$user->removeGroup( $cGroup );
				}
			} else { # no, but maybe the user has recently been added to the ldap group?
				$this->printDebug( "Checking to see if user is in: $cGroup", NONSENSITIVE );
				if ( $this->hasLDAPGroup( $cGroup ) ) {
					$this->printDebug( "Adding user to: $cGroup", NONSENSITIVE );
					# so use the addGroup function
					$user->addGroup( $cGroup );
					# completed for $cGroup.
				}
			}
		}
	}

	/**
	 * Returns a password that is created via the configured hash settings.
	 *
	 * @param string $password
	 * @return string
	 * @access private
	 */
	function getPasswordHash( $password ) {
		global $wgLDAPPasswordHash;

		$this->printDebug( "Entering getPasswordHash", NONSENSITIVE );

		if ( isset( $wgLDAPPasswordHash[$_SESSION['wsDomain']] ) ) {
			$hashtouse = $wgLDAPPasswordHash[$_SESSION['wsDomain']];
		} else {
			$hashtouse = '';
		}

		//Set the password hashing based upon admin preference
		switch ( $hashtouse ) {
			case 'crypt':
				$pass = '{CRYPT}' . crypt( $password );
				break;
			case 'clear':
				$pass = $password;
				break;
			default:
				$pwd_sha = base64_encode( pack( 'H*',sha1( $password ) ) );
				$pass = "{SHA}".$pwd_sha;
				break;
		}

		$this->printDebug( "Password is $pass", HIGHLYSENSITIVE );
		return $pass;
	}

	/**
	 * Prints debugging information. $debugText is what you want to print, $debugVal
	 * is the level at which you want to print the information.
	 *
	 * @param string $debugText
	 * @param string $debugVal
	 * @access private
	 */
	function printDebug( $debugText, $debugVal ) {
		global $wgLDAPDebug;

		if ( $wgLDAPDebug > $debugVal ) {
			echo $debugText . "<br />";
		}
	}

	/**
	 * Binds as $userdn with $password. This can be called with only the ldap
	 * connection resource for an anonymous bind.
	 *
	 * @param resourse $ldapconn
	 * @param string $userdn
	 * @param string $password
	 * @return bool
	 * @access private
	 */
	function bindAs( $ldapconn, $userdn=null, $password=null ) {
		//Let's see if the user can authenticate.
		if ( $userdn == null || $password == null ) {
			$bind = @ldap_bind( $ldapconn );
		} else {
			$bind = @ldap_bind( $ldapconn, $userdn, $password );
		}
		if ( !$bind ) {
			$this->printDebug( "Failed to bind as $userdn", NONSENSITIVE );
			$this->printDebug( "with password: $password", HIGHLYSENSITIVE );
			return false;
		}
		return true;
	}

	/**
	 * Returns true if smartcard authentication is allowed, and the user is
	 * authenticating using the smartcard domain.
	 *
	 * @return bool
	 * @access private
	 */
	function useSmartcardAuth() {
		global $wgLDAPUseSmartcardAuth, $wgLDAPSmartcardDomain;

		return $wgLDAPUseSmartcardAuth && $_SESSION['wsDomain'] == $wgLDAPSmartcardDomain;
	}

	/**
	 * Returns a string which has the chars *, (, ), \ & NUL escaped to LDAP compliant
	 * syntax as per RFC 2254
	 * Thanks and credit to Iain Colledge for the research and function.
	 * 
	 * @param string $string
	 * @return string
	 * @access private
	 */
	function getLdapEscapedString ( $string ) {
		// Make the string LDAP compliant by escaping *, (, ) , \ & NUL
		return str_replace(
			array( "*", "(", ")", "\\", "\x00" ), //replace this
			array( "\\2a", "\\28", "\\29", "\\5c", "\\00" ), //with this
			$string //in this
			);
	}

	/**
	 * Returns a basedn by the type of entry we are searching for.
	 * 
	 * @param int $type
	 * @return string
	 * @access private
	 */
	function getBaseDN ( $type ) {
		global $wgLDAPBaseDNs, $wgLDAPGroupBaseDNs, $wgLDAPUserBaseDNs;

		$this->printDebug( "Entering getBaseDN", NONSENSITIVE );

		$ret = '';
		switch( $type ) {
			case USERDN:
				if ( isset( $wgLDAPUserBaseDNs[$_SESSION['wsDomain']] ) ) {
					$ret = $wgLDAPUserBaseDNs[$_SESSION['wsDomain']];
				}
				break;
			case GROUPDN:
				if ( isset( $wgLDAPGroupBaseDNs[$_SESSION['wsDomain']] ) ) {
					$ret =  $wgLDAPGroupBaseDNs[$_SESSION['wsDomain']];
				}
				break;
			case DEFAULTDN:
				if ( isset( $wgLDAPBaseDNs[$_SESSION['wsDomain']] ) ) {
					$ret = $wgLDAPBaseDNs[$_SESSION['wsDomain']];
					$this->printDebug( "basedn is $ret", NONSENSITIVE );
					return $ret;
				} else {
					$this->printDebug( "basedn is not set.", NONSENSITIVE );
					return '';
				}
				break;
		}

		if ( $ret == '' ) {
			$this->printDebug( "basedn is not set for this type of entry, trying to get the default basedn.", NONSENSITIVE );
			// We will never reach here if $type is self::DEFAULTDN, so to avoid code
			// code duplication, we'll get the default by re-calling the function.
			return $this->getBaseDN( DEFAULTDN );
		} else {
			$this->printDebug( "basedn is $ret", NONSENSITIVE );
			return $ret;
		}
	}

}

/**
 * Add extension information to Special:Version
 */
$wgExtensionCredits['other'][] = array(
	'name' => 'LDAP Authentication Plugin',
	'version' => '1.1g',
	'author' => 'Ryan Lane',
	'description' => 'LDAP Authentication plugin with support for multiple LDAP authentication methods',
	'url' => 'http://www.mediawiki.org/wiki/Extension:LDAP_Authentication',
	);

// The following was derived from the SSL Authentication plugin
// http://www.mediawiki.org/wiki/SSL_authentication

/**
 * Sets up the SSL authentication piece of the LDAP plugin.
 *
 * @access public
 */
function AutoAuthSetup() {
	global $wgLDAPSSLUsername;
	global $wgHooks;
	global $wgAuth;
	global $wgLDAPAutoAuthMethod;

	$wgAuth = new LdapAuthenticationPlugin();

	$wgAuth->printDebug( "Entering AutoAuthSetup.", NONSENSITIVE );

	//We may add quite a few different auto authenticate methods in the
	//future, let's make it easy to support.
	switch( $wgLDAPAutoAuthMethod ) {
		case "smartcard":
			$wgAuth->printDebug( "Allowing smartcard authentication.", NONSENSITIVE );
			$wgAuth->printDebug( "wgLDAPSSLUsername = $wgLDAPSSLUsername", SENSITIVE );

			if( $wgLDAPSSLUsername != null ) {
				$wgAuth->printDebug( "wgLDAPSSLUsername is not null, adding hooks.", NONSENSITIVE );
				$wgHooks['AutoAuthenticate'][] = 'SSLAuth'; /* Hook for magical authN */
				$wgHooks['PersonalUrls'][] = 'NoLogout'; /* Disallow logout link */
			}
			break;
		default:
			$wgAuth->printDebug( "Not using any AutoAuthentication methods.", NONSENSITIVE );
	}
}

/* No logout link in MW */
function NoLogout( &$personal_urls, $title ) {
	$personal_urls['logout'] = null;
}

/**
 * Does the SSL authentication piece of the LDAP plugin.
 *
 * @access public
 */
function SSLAuth( &$user ) {
	global $wgLDAPSSLUsername;
	global $wgUser;
	global $wgAuth;

	$wgAuth->printDebug( "Entering SSLAuth.", NONSENSITIVE );

	//Give us a user, see if we're around
	$tmpuser = User::LoadFromSession();

	//They already with us?  If so, quit this function.
	if( $tmpuser->isLoggedIn() ) {
		$wgAuth->printDebug( "User is already logged in.", NONSENSITIVE );
		return true;
	}

	//Let regular authentication plugins configure themselves for auto
	//authentication chaining
	$wgAuth->autoAuthSetup();

	//The user hasn't already been authenticated, let's check them
	$wgAuth->printDebug( "User is not logged in, we need to authenticate", NONSENSITIVE );
	$authenticated = $wgAuth->authenticate( $wgLDAPSSLUsername );
	if ( !$authenticated ) {
		//If the user doesn't exist in LDAP, there isn't much reason to
		//go any further.
		$wgAuth->printDebug("User wasn't found in LDAP, exiting.", NONSENSITIVE );
		return false;
	}

	//We need the username that MediaWiki will always use, *not* the one we
	//get from LDAP.
	$mungedUsername = $wgAuth->getCanonicalName( $wgLDAPSSLUsername );

	$wgAuth->printDebug( "User exists in LDAP; finding the user by name in MediaWiki.", NONSENSITIVE );

	//Is the user already in the database?
	$tmpuser = User::newFromName( $mungedUsername );

	if ( $tmpuser == null ) {
		$wgAuth->printDebug( "Username is not a valid MediaWiki username.", NONSENSITIVE );
		return false;
	}

	//If exists, log them in
	if( $tmpuser->getID() != 0 ) {
		$wgAuth->printDebug( "User exists in local database, logging in.", NONSENSITIVE );
		$wgUser = &$tmpuser;
		$wgAuth->updateUser( $wgUser );
		$wgUser->setCookies();
		$wgUser->setupSession();
		return true;
	}
	$wgAuth->printDebug( "User does not exist in local database; creating.", NONSENSITIVE );

	//This section contains a silly hack for MW
	global $wgLang;
	global $wgContLang;
	global $wgRequest;
	if( !isset( $wgLang ) )
	{
		$wgLang = $wgContLang;
		$wgLangUnset = true;
	}

	$wgAuth->printDebug( "Creating LoginForm.", NONSENSITIVE );

	//This creates our form that'll let us create a new user in the database
	$lf = new LoginForm( $wgRequest );

	//The user we'll be creating...
	$wgUser = &$tmpuser;
	$wgUser->setName( $wgContLang->ucfirst( $mungedUsername ) );

	$wgAuth->printDebug( "Creating User.", NONSENSITIVE );

	//Create the user
	$lf->initUser( $wgUser );

	//Initialize the user
	$wgUser->setupSession();
	$wgUser->setCookies();

	return true;
}


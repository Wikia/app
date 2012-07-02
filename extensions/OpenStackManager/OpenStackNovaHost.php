<?php

class OpenStackNovaHost {

	/**
	 * @var string
	 */
	var $searchvalue;

	/**
	 * @var string
	 */
	var $hostDN;

	/**
	 * @var mixed
	 */
	var $hostInfo;

	/**
	 * @var OpenStackNovaDomain
	 */
	var $domain;

	/**
	 * @param  $hostname
	 * @param  $domain
	 */
	function __construct( $hostname, $domain ) {
		$this->searchvalue = $hostname;
		$this->domain = $domain;
		OpenStackNovaLdapConnection::connect();
		$this->fetchHostInfo();
	}

	/**
	 * Fetch the host from LDAP and initialize the object
	 *
	 * @return void
	 */
	function fetchHostInfo() {
		global $wgAuth;

		$this->searchvalue = $wgAuth->getLdapEscapedString( $this->searchvalue );
		$fqdn = $this->searchvalue . '.' . $this->domain->getFullyQualifiedDomainName();
		$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $this->domain->domainDN, '(|(associateddomain=' . $fqdn . ')(cnamerecord=' . $fqdn . ')(dc=' . $this->searchvalue . '))' );
		$this->hostInfo = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
		if ( $this->hostInfo["count"] == "0" ) {
			$this->hostInfo = null;
		} else {
			$this->hostDN = $this->hostInfo[0]['dn'];
		}
	}

	/**
	 * Return the host's short name
	 *
	 * @return
	 */
	function getHostName() {
		return $this->hostInfo[0]['dc'][0];
	}

	/**
	 * Return the domain associated with this host
	 *
	 * @return OpenStackNovaDomain
	 */
	function getDomain() {
		return $this->domain;
	}

	/**
	 * Return the host's fully qualified domain name
	 *
	 * @return string
	 */
	function getFullyQualifiedHostName() {
		return $this->getHostName() . '.' . $this->domain->getFullyQualifiedDomainName();
	}

	/**
	 * Return the puppet classes and variables assigned to this host
	 *
	 * @return array
	 */
	function getPuppetConfiguration() {
		$puppetinfo = array( 'puppetclass' => array(), 'puppetvar' => array() );
		if ( isset( $this->hostInfo[0]['puppetclass'] ) ) {
			array_shift( $this->hostInfo[0]['puppetclass'] );
			foreach ( $this->hostInfo[0]['puppetclass'] as $class ) {
				$puppetinfo['puppetclass'][] = $class;
			}
		}
		if ( isset( $this->hostInfo[0]['puppetvar'] ) ) {
			array_shift( $this->hostInfo[0]['puppetvar'] );
			foreach ( $this->hostInfo[0]['puppetvar'] as $variable ) {
				$vararr = explode( '=', $variable );
				$varname = trim( $vararr[0] );
				$var = trim( $vararr[1] );
				$puppetinfo['puppetvar']["$varname"] = $var;
			}
		}
		return $puppetinfo;
	}

	/**
	 * Return all arecords associated with this host. Return an empty
	 * array if the arecord attribute is not set.
	 *
	 * @return array
	 */
	function getARecords() {
		$arecords = array();
		if ( isset( $this->hostInfo[0]['arecord'] ) ) {
			$arecords = $this->hostInfo[0]['arecord'];
			array_shift( $arecords );
		}

		return $arecords;
	}

	/**
	 * Return all associateddomain records associated with this host.
	 * Return an empty array if the arecord attribute is not set.
	 *
	 * @return array
	 */
	function getAssociatedDomains() {
		$associateddomain = array();
		if ( isset( $this->hostInfo[0]['associateddomain'] ) ) {
			$associateddomain = $this->hostInfo[0]['associateddomain'];
			array_shift( $associateddomain );
		}

		return $associateddomain;
	}

	/**
	 * Return all cname records associated with this host.
	 * Return an empty array if the arecord attribute is not set.
	 *
	 * @return array
	 */
	function getCNAMERecords() {
		$cnamerecords = array();
		if ( isset( $this->hostInfo[0]['cnamerecord'] ) ) {
			$cnamerecords = $this->hostInfo[0]['cnamearecord'];
			array_shift( $cnamerecords );
		}

		return $cnamerecords;
	}

	/**
	 * Update puppet classes and variables for this host.
	 *
	 * @param  $puppetinfo
	 * @return bool
	 */
	function modifyPuppetConfiguration( $puppetinfo ) {
		global $wgAuth;
		global $wgOpenStackManagerPuppetOptions;

		$hostEntry = array();
		if ( $wgOpenStackManagerPuppetOptions['enabled'] ) {
			foreach ( $wgOpenStackManagerPuppetOptions['defaultclasses'] as $class ) {
				$hostEntry['puppetclass'][] = $class;
			}
			foreach ( $wgOpenStackManagerPuppetOptions['defaultvariables'] as $variable => $value ) {
				$hostEntry['puppetvar'][] = $variable . '=' . $value;
			}
			if ( isset( $puppetinfo['classes'] ) ) {
				foreach ( $puppetinfo['classes'] as $class ) {
					$hostEntry['puppetclass'][] = $class;
				}
			}
			if ( isset( $puppetinfo['variables'] ) ) {
				foreach ( $puppetinfo['variables'] as $variable => $value ) {
					$hostEntry['puppetvar'][] = $variable . '=' . $value;
				}
			}
			$oldpuppetinfo = $this->getPuppetConfiguration();
			if ( isset( $oldpuppetinfo['puppetvar'] ) ) {
				$wgAuth->printDebug( "Checking for preexisting variables", NONSENSITIVE );
				foreach ( $oldpuppetinfo['puppetvar'] as $variable => $value ) {
					$wgAuth->printDebug( "Found $variable", NONSENSITIVE );
					if ( $variable == "instancecreator_email" || $variable == "instancecreator_username"
						|| $variable == "instancecreator_lang" || $variable == "instanceproject" || $variable == "instancename" ) {
						$hostEntry['puppetvar'][] = $variable . '=' . $value;
					}
				}
			}
			if ( $hostEntry ) {
				$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->hostDN, $hostEntry );
				if ( $success ) {
					$this->fetchHostInfo();
					$wgAuth->printDebug( "Successfully modified puppet configuration for host", NONSENSITIVE );
					return true;
				} else {
					$wgAuth->printDebug( "Failed to modify puppet configuration for host", NONSENSITIVE );
					return false;
				}
			} else {
				$wgAuth->printDebug( "No hostEntry when trying to modify puppet configuration", NONSENSITIVE );
				return false;
			}
		}
		return false;
	}

	/**
	 * Remove an associated domain record from this entry.
	 *
	 * @param  $fqdn
	 * @return bool
	 */
	function deleteAssociatedDomain( $fqdn ) {
		global $wgAuth;

		if ( isset( $this->hostInfo[0]['associateddomain'] ) ) {
			$associateddomains = $this->hostInfo[0]['associateddomain'];
			array_shift( $associateddomains );
			$index = array_search( $fqdn, $associateddomains );
			if ( $index === false ) {
				$wgAuth->printDebug( "Failed to find ip address in arecords list", NONSENSITIVE );
				return false;
			}
			unset( $associateddomains[$index] );
			$values = array();
			$values['associateddomain'] = array();
			foreach ( $associateddomains as $associateddomain ) {
				$values['associateddomain'][] = $associateddomain;
			}
			$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->hostDN, $values );
			if ( $success ) {
				$wgAuth->printDebug( "Successfully removed $fqdn from $this->hostDN", NONSENSITIVE );
				$this->domain->updateSOA();
				$this->fetchHostInfo();
				return true;
			} else {
				$wgAuth->printDebug( "Failed to remove $fqdn from $this->hostDN", NONSENSITIVE );
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * Remove an arecord from the host.
	 *
	 * @param  $ip
	 * @return bool
	 */
	function deleteARecord( $ip ) {
		global $wgAuth;

		if ( isset( $this->hostInfo[0]['arecord'] ) ) {
			$arecords = $this->hostInfo[0]['arecord'];
			array_shift( $arecords );
			$index = array_search( $ip, $arecords );
			if ( $index === false ) {
				$wgAuth->printDebug( "Failed to find ip address in arecords list", NONSENSITIVE );
				return false;
			}
			unset( $arecords[$index] );
			$values = array();
			$values['arecord'] = array();
			foreach ( $arecords as $arecord ) {
				$values['arecord'][] = $arecord;
			}
			$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->hostDN, $values );
			if ( $success ) {
				$wgAuth->printDebug( "Successfully removed $ip from $this->hostDN", NONSENSITIVE );
				$this->domain->updateSOA();
				$this->fetchHostInfo();
				return true;
			} else {
				$wgAuth->printDebug( "Failed to remove $ip from $this->hostDN", NONSENSITIVE );
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * Add an associated domain record to this host.
	 *
	 * @param  $fqdn
	 * @return bool
	 */
	function addAssociatedDomain( $fqdn ) {
		global $wgAuth;

		$associatedomains = array();
		if ( isset( $this->hostInfo[0]['associateddomain'] ) ) {
			$associatedomains = $this->hostInfo[0]['associateddomain'];
			array_shift( $associatedomains );
		}
		$associatedomains[] = $fqdn;
		$values = array();
		$values['associateddomain'] = $associatedomains;
		$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->hostDN, $values );
		if ( $success ) {
			$wgAuth->printDebug( "Successfully added $fqdn to $this->hostDN", NONSENSITIVE );
			$this->domain->updateSOA();
			$this->fetchHostInfo();
			return true;
		} else {
			$wgAuth->printDebug( "Failed to add $fqdn to $this->hostDN", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Add an arecord entry to this host.
	 *
	 * @param  $ip
	 * @return bool
	 */
	function addARecord( $ip ) {
		global $wgAuth;

		$arecords = array();
		if ( isset( $this->hostInfo[0]['arecord'] ) ) {
			$arecords = $this->hostInfo[0]['arecord'];
			array_shift( $arecords );
		}
		$arecords[] = $ip;
		$values = array();
		$values['arecord'] = $arecords;
		$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->hostDN, $values );
		if ( $success ) {
			$wgAuth->printDebug( "Successfully added $ip to $this->hostDN", NONSENSITIVE );
			$this->domain->updateSOA();
			$this->fetchHostInfo();
			return true;
		} else {
			$wgAuth->printDebug( "Failed to add $ip to $this->hostDN", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Replace all arecords on this host with $ip.
	 *
	 * @param  $ip
	 * @return bool
	 */
	function setARecord( $ip ) {
		global $wgAuth;

		$values = array( 'arecord' => array( $ip ) );
		$success = LdapAuthenticationPlugin::ldap_modify( $wgAuth->ldapconn, $this->hostDN, $values );
		if ( $success ) {
			$wgAuth->printDebug( "Successfully set $ip on $this->hostDN", NONSENSITIVE );
			$this->domain->updateSOA();
			$this->fetchHostInfo();
			return true;
		} else {
			$wgAuth->printDebug( "Failed to set $ip on $this->hostDN", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Get a host by the host's short name, and a OpenStackNovaDomain object. Returns
	 * null if the entry does not exist.
	 *
	 * @static
	 * @param  $hostname
	 * @param  $domain
	 * @return OpenStackNovaHost
	 */
	static function getHostByName( $hostname, $domain ) {
		$host = new OpenStackNovaHost( $hostname, $domain );
		if ( $host->hostInfo ) {
			return $host;
		} else {
			return null;
		}
	}

	/**
	 * Get a host by an instance ID. Returns null if the entry does not exist.
	 *
	 * @static
	 * @param  $instanceid
	 * @return OpenStackNovaHost
	 */
	static function getHostByInstanceId( $instanceid ) {
		$domain = OpenStackNovaDomain::getDomainByInstanceId( $instanceid );
		if ( $domain ) {
			return self::getHostByName( $instanceid, $domain );
		} else {
			return null;
		}
	}

	/**
	 * Get a host by ip address and an OpenStackNovaDomain. Returns null if
	 * the entry does not exist.
	 *
	 * @static
	 * @param  $ip
	 * @return null|OpenStackNovaHost
	 */
	static function getHostByIP( $ip ) {
		global $wgAuth;
		global $wgOpenStackManagerLDAPInstanceBaseDN;

		$domain = OpenStackNovaDomain::getDomainByHostIP( $ip );
		if ( ! $domain ) {
			return null;
		}
		$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $wgOpenStackManagerLDAPInstanceBaseDN, '(arecord=' . $ip . ')' );
		$hostInfo = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
		if ( $hostInfo["count"] == "0" ) {
			return null;
		} else {
			array_shift( $hostInfo );
			$hostname = $hostInfo[0]['dc'][0];
			$host = OpenStackNovaHost::getHostByName( $hostname, $domain );
			return $host;
		}
	}

	/**
	 * Get all host entries that have the specified IP address assigned. Returns
	 * an empty array if none are found.
	 *
	 * @static
	 * @param  $ip
	 * @return array
	 */
	static function getHostsByIP( $ip ) {
		global $wgAuth;
		global $wgOpenStackManagerLDAPInstanceBaseDN;

		$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $wgOpenStackManagerLDAPInstanceBaseDN, '(arecord=' . $ip . ')' );
		$hostsInfo = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
		if ( $hostsInfo["count"] == "0" ) {
			return array();
		} else {
			$hosts = array();
			array_shift( $hostsInfo );
			foreach ( $hostsInfo as $host ) {
				$hostname = $host['dc'][0];
				$domainname = explode( '.', $host['associateddomain'][0] );
				$domainname = $domainname[1];
				$domain = OpenStackNovaDomain::getDomainByName( $domainname );
				$hostObject = OpenStackNovaHost::getHostByName( $hostname, $domain );
				if ( $hostObject ) {
					$hosts[] = $hostObject;
				}
			}
			return $hosts;
		}
	}

	/**
	 * Get all host entries in the specified domain. Returns an empty array
	 * if no entries are found.
	 *
	 * @static
	 * @param  $domain OpenStackNovaDomain
	 * @return array
	 */
	static function getAllHosts( $domain ) {
		global $wgAuth;

		OpenStackNovaLdapConnection::connect();

		$hosts = array();
		$result = LdapAuthenticationPlugin::ldap_search( $wgAuth->ldapconn, $domain->domainDN, '(dc=*)' );
		if ( $result ) {
			$entries = LdapAuthenticationPlugin::ldap_get_entries( $wgAuth->ldapconn, $result );
			if ( $entries ) {
				# First entry is always a count
				array_shift( $entries );
				foreach ( $entries as $entry ) {
					$hosts[] = new OpenStackNovaHost( $entry['dc'][0], $domain );
				}
			}
		}

		return $hosts;
	}

	/**
	 * Delete a host based on the host's shortname, and its domain.
	 *
	 * @static
	 * @param  $hostname String
	 * @param  $domain OpenStackNovaDomain
	 * @return bool
	 */
	static function deleteHost( $hostname, $domain ) {
		global $wgAuth;

		OpenStackNovaLdapConnection::connect();

		$host = OpenStackNovaHost::getHostByName( $hostname, $domain );
		if ( ! $host ) {
			$wgAuth->printDebug( "Failed to delete host $hostname as the DNS entry does not exist", NONSENSITIVE );
			return false;
		}
		$dn = $host->hostDN;

		$success = LdapAuthenticationPlugin::ldap_delete( $wgAuth->ldapconn, $dn );
		if ( $success ) {
			$domain->updateSOA();
			$wgAuth->printDebug( "Successfully deleted host $hostname", NONSENSITIVE );
			return true;
		} else {
			$wgAuth->printDebug( "Failed to delete host $hostname", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Deletes a host based on its instanceid.
	 *
	 * @static
	 * @param  $instanceid
	 * @return bool
	 */
	static function deleteHostByInstanceId( $instanceid ) {
		global $wgAuth;

		OpenStackNovaLdapConnection::connect();

		$host = OpenStackNovaHost::getHostByInstanceId( $instanceid );
		if ( ! $host ) {
			$wgAuth->printDebug( "Failed to delete host $instanceid as the DNS entry does not exist", NONSENSITIVE );
			return false;
		}
		$dn = $host->hostDN;
		$domain = $host->getDomain();

		$success = LdapAuthenticationPlugin::ldap_delete( $wgAuth->ldapconn, $dn );
		if ( $success ) {
			$domain->updateSOA();
			$wgAuth->printDebug( "Successfully deleted host $instanceid", NONSENSITIVE );
			return true;
		} else {
			$wgAuth->printDebug( "Failed to delete host $instanceid", NONSENSITIVE );
			return false;
		}
	}

	/**
	 * Add a new host entry from an OpenStackNovaInstance object, an OpenStackNovaDomain object,
	 * and optional puppet information. Returns null if a host already exists, or if
	 * if the host additional fails. This function should be used for adding host entries
	 * for instances (private DNS).
	 *
	 * @static
	 * @param  $instance OpenStackNovaInstance
	 * @param  $domain OpenStackNovaDomain
	 * @param  $puppetinfo
	 * @return OpenStackNovaHost
	 */
	static function addHost( $instance, $domain, $puppetinfo = array() ) {
		global $wgUser, $wgLang;
		global $wgAuth;
		global $wgOpenStackManagerLDAPInstanceBaseDN, $wgOpenStackManagerPuppetOptions;

		OpenStackNovaLdapConnection::connect();

		$hostname = $instance->getInstanceName();
		$instanceid = $instance->getInstanceId();
		$project = $instance->getOwner();
		$ip = $instance->getInstancePrivateIP();
		$domainname = $domain->getFullyQualifiedDomainName();
		$host = OpenStackNovaHost::getHostByName( $hostname, $domain );
		if ( $host ) {
			$wgAuth->printDebug( "Failed to add host $hostname as the DNS entry already exists", NONSENSITIVE );
			return null;
		}
		$hostEntry = array();
		$hostEntry['objectclass'][] = 'dcobject';
		$hostEntry['objectclass'][] = 'dnsdomain';
		$hostEntry['objectclass'][] = 'domainrelatedobject';
		$hostEntry['dc'] = $instanceid;
		# $hostEntry['l'] = $instance->getInstanceAvailabilityZone();
		$hostEntry['arecord'] = $ip;
		$hostEntry['associateddomain'][] = $instanceid . '.' . $domainname;
		$hostEntry['associateddomain'][] = $hostname . '.' . $domainname;
		$hostEntry['l'] = $domain->getLocation();
		if ( $wgOpenStackManagerPuppetOptions['enabled'] ) {
			$hostEntry['objectclass'][] = 'puppetclient';
			foreach ( $wgOpenStackManagerPuppetOptions['defaultclasses'] as $class ) {
				$hostEntry['puppetclass'][] = $class;
			}
			foreach ( $wgOpenStackManagerPuppetOptions['defaultvariables'] as $variable => $value ) {
				$hostEntry['puppetvar'][] = $variable . '=' . $value;
			}
			if ( $puppetinfo ) {
				if ( isset( $puppetinfo['classes'] ) ) {
					foreach ( $puppetinfo['classes'] as $class ) {
						$hostEntry['puppetclass'][] = $class;
					}
				}
				if ( isset( $puppetinfo['variables'] ) ) {
					foreach ( $puppetinfo['variables'] as $variable => $value ) {
						if ( $value ) {
							$hostEntry['puppetvar'][] = $variable . '=' . $value;
						}
					}
				}
			}
			if ( $wgUser->getEmail() ) {
				$hostEntry['puppetvar'][] = 'instancecreator_email=' . $wgUser->getEmail();
			}
			$hostEntry['puppetvar'][] = 'instancecreator_username=' . $wgUser->getName();
			$hostEntry['puppetvar'][] = 'instancecreator_lang=' . $wgLang->getCode();
			$hostEntry['puppetvar'][] = 'instanceproject=' . $project;
			$hostEntry['puppetvar'][] = 'instancename=' . $hostname;
		}
		$dn = 'dc=' . $instanceid . ',dc=' . $domain->getDomainName() . ',' . $wgOpenStackManagerLDAPInstanceBaseDN;

		$success = LdapAuthenticationPlugin::ldap_add( $wgAuth->ldapconn, $dn, $hostEntry );
		if ( $success ) {
			$domain->updateSOA();
			$wgAuth->printDebug( "Successfully added host $hostname", NONSENSITIVE );
			return new OpenStackNovaHost( $hostname, $domain );
		} else {
			$wgAuth->printDebug( "Failed to add host $hostname", NONSENSITIVE );
			return null;
		}
	}

	/**
	 * Adds a host entry based on the hostname, IP addrss, and a domain. Returns null
	 * if the entry already exists, or if the additional fails. This function should be used
	 * for adding public DNS entries.
	 *
	 * @static
	 * @param  $hostname
	 * @param  $ip
	 * @param  $domain OpenStackNovaDomain
	 * @return bool|null|OpenStackNovaHost
	 */
	static function addPublicHost( $hostname, $ip, $domain ) {
		global $wgAuth;
		global $wgOpenStackManagerLDAPInstanceBaseDN;

		OpenStackNovaLdapConnection::connect();

		$domainname = $domain->getFullyQualifiedDomainName();
		$host = OpenStackNovaHost::getHostByName( $hostname, $domain );
		if ( $host ) {
			$wgAuth->printDebug( "Failed to add public host $hostname as the DNS entry already exists", NONSENSITIVE );
			return null;
		}
		$hostEntry = array();
		$hostEntry['objectclass'][] = 'dcobject';
		$hostEntry['objectclass'][] = 'dnsdomain';
		$hostEntry['objectclass'][] = 'domainrelatedobject';
		$hostEntry['dc'] = $hostname;
		$hostEntry['arecord'] = $ip;
		$hostEntry['associateddomain'][] = $hostname . '.' . $domainname;
		$dn = 'dc=' . $hostname . ',dc=' . $domain->getDomainName() . ',' . $wgOpenStackManagerLDAPInstanceBaseDN;

		$success = LdapAuthenticationPlugin::ldap_add( $wgAuth->ldapconn, $dn, $hostEntry );
		if ( $success ) {
			$domain->updateSOA();
			$wgAuth->printDebug( "Successfully added public host $hostname", NONSENSITIVE );
			return new OpenStackNovaHost( $hostname, $domain );
		} else {
			$wgAuth->printDebug( "Failed to add public host $hostname", NONSENSITIVE );
			return null;
		}
	}

}

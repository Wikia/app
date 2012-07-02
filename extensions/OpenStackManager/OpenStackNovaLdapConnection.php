<?php

class OpenStackNovaLdapConnection {

	/**
	 * Connect to LDAP as the open stack manager account using wgAuth
	 */
	static function connect() {
		global $wgAuth;
		global $wgOpenStackManagerLDAPUser, $wgOpenStackManagerLDAPUserPassword;
		global $wgOpenStackManagerLDAPDomain;

		// Only reconnect/rebind if we aren't alredy bound
		if ( $wgAuth->boundAs != $wgOpenStackManagerLDAPUser ) {
			$wgAuth->connect( $wgOpenStackManagerLDAPDomain );
			$wgAuth->bindAs( $wgOpenStackManagerLDAPUser, $wgOpenStackManagerLDAPUserPassword );
		}
	}

}

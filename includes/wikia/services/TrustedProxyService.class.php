<?php

class TrustedProxyService extends WikiaObject {

	/**
	 * check if $ip is in given $cidr range
	 *
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 *
	 * @param string $cidr address range in CIDR notation
	 * @param string $ip ip string
	 *
	 * @return boolean true if in range, false otherwise
	 */
	private static function inRange( $cidr, $ip  ) {
		list ( $net, $mask ) = explode ( '/', $cidr );
		return ( ip2long ($ip) & ~(( 1 << ( 32 - $mask ) ) - 1 ) ) == ip2long ( $net );
	}

	/**
	 * hook entry
	 *
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 *
	 * @param string $ip ip address we want to check
	 * @param bool $trusted should ip be trusted or not
	 *
	 * @see ProxyTools.php
	 *
	 * @return true always since hook
	 */
	public static function onIsTrustedProxy( &$ip, &$trusted ) {
		wfProfileIn( __METHOD__ );
		$wg = F::app()->wg;
		$ranges = $wg->SquidServersNoPurge;
		if( is_array( $ranges ) ) {
			foreach( $ranges as $range ) {
				if( strpos( $range, '/' ) !== false ) {
					#
					# stop if match is true
					#
					if( self::inRange( $range, $ip ) === true ) {
						wfDebug( __METHOD__ . ": $ip is in range $range.\n" );
						$trusted = true;
						wfProfileOut( __METHOD__ );
						return true;
					}
				}
			}
		}
		wfDebug( __METHOD__ . ": no ranges for $ip.\n" );
		wfProfileOut( __METHOD__ );
		return true;
	}
}

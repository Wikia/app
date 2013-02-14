<?php

class TrustedProxyService extends WikiaObject {

	private function inRange( $cidr, $ip  ) {
		list ( $net, $mask ) = explode ( '/', $cidr );
		return ( ip2long ($ip) & ~(( 1 << ( 32 - $mask ) ) - 1 ) ) == ip2long ( $net );
	}

	/**
	 * hook entry
	 *
	 * @see ProxyTools.php
	 */
	public function onIsTrustedProxy( &$ip, &$trusted ) {
		$ranges = $this->wg->SquidServersNoPurge;
		if( is_array( $ranges ) ) {
			foreach( $ranges as $range ) {
				if( strpos( $range, '/' ) !== false ) {
					#
					# stop if match is true
					#
					if( $this->inRange( $range, $ip ) === true ) {
						$trusted = true;
						return true;
					}
				}
			}
		}

		return true;
	}
}

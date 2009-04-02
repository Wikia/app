<?php
/**
 * Allow programs to request this object from WebRequest::response()
 * and handle all outputting (or lack of outputting) via it.
 * @ingroup HTTP
 */
class WebResponse {

	/** 
	 * Output a HTTP header, wrapper for PHP's
	 * header()
	 * @param $string String: header to output
	 * @param $replace Bool: replace current similar header
	 */
	public function header($string, $replace=true) {
		if( headers_sent( $filename, $linenum ) ) {
			error_log( $_SERVER['HTTP_HOST'] . '-' . $_SERVER['REQUEST_URI']." - Headers already sent in $filename on line $linenum. Cant send another header - $string" );
		}
		header($string,$replace);
	}

	/** Set the browser cookie
	 * @param $name String: name of cookie
	 * @param $value String: value to give cookie
	 * @param $expire Int: number of seconds til cookie expires
	 */
	public function setcookie( $name, $value, $expire = 0 ) {
		global $wgCookiePath, $wgCookiePrefix, $wgCookieDomain;
		global $wgCookieSecure,$wgCookieExpiration, $wgCookieHttpOnly;
		if ( $expire == 0 ) {
			$expire = time() + $wgCookieExpiration;
		}
		$httpOnlySafe = wfHttpOnlySafe();
		wfDebugLog( 'cookie',
			'setcookie: "' . implode( '", "',
				array(
					$wgCookiePrefix . $name,
					$value,
					$expire,
					$wgCookiePath,
					$wgCookieDomain,
					$wgCookieSecure,
					$httpOnlySafe && $wgCookieHttpOnly ) ) . '"' );
		if( $httpOnlySafe && isset( $wgCookieHttpOnly ) ) {
			setcookie( $wgCookiePrefix . $name,
				$value,
				$expire,
				$wgCookiePath,
				$wgCookieDomain,
				$wgCookieSecure,
				$wgCookieHttpOnly );
		} else {
			// setcookie() fails on PHP 5.1 if you give it future-compat paramters.
			// stab stab!
			setcookie( $wgCookiePrefix . $name,
				$value,
				$expire,
				$wgCookiePath,
				$wgCookieDomain,
				$wgCookieSecure );
		}
	}
}

<?php

/**
 * A simple parallel CURL client helper class
 * @TODO: name this ParsoidCurlMultiClient or move to core
 */
class CurlMultiClient {

	/**
	 * Get the default CURL options used for each request
	 *
	 * @static
	 * @returns array default options
	 */
	public static function getDefaultOptions() {
		globla $wgHTTPProxy;
		$options = array(
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1
		);
		if ( $wgHTTPProxy ) {
			$options[CURLOPT_PROXY] = $wgHTTPProxy;
		}
		return $options;
	}

	/**
	 * Peform several CURL requests in parallel, and return the combined
	 * results.
	 *
	 * @static
	 * @param $requests array requests, each with an url and an optional
	 * 	'headers' member:
	 * 		  array(
	 * 			'url' => 'http://server.com/foo',
	 * 			'headers' => array( 'X-Foo: Bar' )
	 * 		  )
	 * @param $options array curl options used for each request, default
	 * {CurlMultiClient::getDefaultOptions}.
	 * @returns array An array of arrays containing 'error' and 'data'
	 * members. If there are errors, data will be null. If there are no
	 * errors, the error member will be null and data will contain the
	 * response data as a string.
	 */
	public static function request( $requests, array $options = null ) {
		if ( !count( $requests ) ) {
			return array();
		}

		$handles = array();

		if ( $options === null ) { // add default options
			$options = CurlMultiClient::getDefaultOptions();
		}

		// add curl options to each handle
		foreach ( $requests as $k => $row ) {
			$handle = curl_init();
			$reqOptions = array(
				CURLOPT_URL => $row['url'],
				// https://github.com/guzzle/guzzle/issues/349
				CURLOPT_FORBID_REUSE => true
			) + $options;
			wfDebug( "adding url: " . $row['url'] );
			if ( isset( $row['headers'] ) ) {
				$reqOptions[CURLOPT_HTTPHEADER] = $row['headers'];
			}
			curl_setopt_array( $handle, $reqOptions );

			$handles[$k] = $handle;
		}

		$mh = curl_multi_init();

		foreach ( $handles as $handle ) {
			curl_multi_add_handle( $mh, $handle );
		}

		$active = null; // handles still being processed
		//execute the handles
		do {
			do {
				// perform work as long as there is any
				$status_cme = curl_multi_exec( $mh, $active );
			} while ( $status_cme == CURLM_CALL_MULTI_PERFORM );
			if ( $active > 0 && $status_cme === CURLM_OK ) {
				// wait for more work to become available
				if ( curl_multi_select( $mh, 10 ) ) {
					// Wait for 5 ms, somewhat similar to the suggestion at
					// http://curl.haxx.se/libcurl/c/curl_multi_fdset.html
					// We pick a smaller value as we are typically hitting
					// fast internal services so status changes are more
					// likely.
					usleep(5000);
				}
			}
		} while ( $active && $status_cme == CURLM_OK );

		$res = array();
		foreach ( $requests as $k => $row ) {
			$res[$k] = array();
			$res[$k]['error'] = curl_error( $handles[$k] );
			if ( strlen( $res[$k]['error'] ) ) {
				$res[$k]['data'] = null;
			} else {
				$res[$k]['error'] = null;
				$res[$k]['data'] = curl_multi_getcontent( $handles[$k] );  // get results
			}

			// close current handler
			curl_multi_remove_handle( $mh, $handles[$k] );
		}
		curl_multi_close( $mh );

		#wfDebug(serialize($res));
		return $res; // return response
	}

}

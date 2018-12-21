<?php

/**
 * redirect-canonical.php
 *
 * It handles URLs that miss the /wiki/ prefix. Instead of just adding /wiki/ in front
 * of the URLs, the full canonical URL is constructed (using $title->getFullURL).
 * This limits number of redirects and redirects to the best possible URL in one run.
 *
 * This is a simple replacement for Our404Handler and should be configured as follows in
 * Apache config:
 *
 * ErrorDocument 404 /redirect-canonical.php
 */

use \Wikia\Logger\WikiaLogger;

require_once( dirname( __FILE__ ) . '/includes/WebStart.php' );


/**
 * Try to construct the MW title out of the given URL path.
 *
 * If unsuccessful return the title for the main page.
 *
 * @param $path
 * @return Title
 */
function guessTitle( $path ) {
	global $wgScriptPath;
	$path = trim( rawurldecode( $path ), '/ _' );

	$scriptPath = ltrim( $wgScriptPath, '/' ) . '/';
	// Strip the language path if there is one
	if ( !empty( $wgScriptPath ) && startsWith( $path, $scriptPath ) ) {
		$path = substr( $path, strlen( $scriptPath ) );
	}

	// SUS-6051 | /w/Foo and /wiki/index.php/Foo URLs need to be handled by PHP logic
	// in order to use a proper wiki domain on sandboxes
	if ( startsWith( $path, 'w/' ) ) {
		$path = substr( $path, 2 );
	}
	if ( startsWith( $path, 'wiki/index.php/' ) ) {
		$path = substr( $path, 15 );
	}

	// Hack to better recover Mercury modular home pages URLs
	// (they have double-encoded URLs for some reason)
	if ( startsWith( $path, 'main/' ) ) {
		$path = rawurldecode( $path );
	}

	$logContext = [
		'ex' => new Exception(),
		// To verify if Kibana trims the strings:
		'uri' => $_SERVER['REQUEST_URI'],
		'uriLen' => strlen( $_SERVER['REQUEST_URI'] ),
	];

	if ( !$path ) {
		WikiaLogger::instance()->warning( '404 redirector: malformed URI', $logContext );
	}

	$path = str_replace( [ '%', '<', '>', '[', ']', '{', '}' ], '_', $path, $count );
	if ( $count ) {
		WikiaLogger::instance()->warning( '404 redirector: forbidden char in URI', $logContext );
	}

	$title = Title::newFromText( $path );

	if ( !$title ) {
		WikiaLogger::instance()->warning( '404 redirector: not a valid title in URI', $logContext );
		$title = Title::newMainPage();
	}

	return $title;
}


/**
 * Read superglobal variables and return the URL to redirect to
 *
 * @return string
 */
function getTargetUrl() {
	// Extract the URL path from the REQUEST_URI
	$requestUri = $_SERVER['REQUEST_URI'];
	if ( filter_var( $requestUri, FILTER_VALIDATE_URL ) ) {
		// Possible when using proxies, like curl -x
		$path = parse_url( $requestUri, PHP_URL_PATH );
	} else {
		// Upgrade the URI to a full URL to prevent URIs like Foo:111 being interpreted as host:port
		$path = parse_url( 'http://wikia.com/' . $requestUri, PHP_URL_PATH );
	}

	// Strip the leading slashes
	$path = ltrim( $path, '/' );

	// Decide which URL to redirect to
	if ( stripos( $path, '%2F' ) !== false ) {
		// Called by Apache because there was "%2F" (an encoded slash) in the URL.
		// @see http://httpd.apache.org/docs/2.2/mod/core.html#allowencodedslashes
		$localUrl = '/' . str_ireplace( [ '%2F', '%3A' ], [ '/', ':' ], $path );
		$url = wfExpandUrl( $localUrl, PROTO_CANONICAL );
		header( 'X-Redirected-By: redirect-canonical.php (encoded slash)' );
	} else {
		// Called by Apache because the URL matched no rewrite rules
		$title = guessTitle( $path );
		$url = $title->getFullURL();
		header( 'X-Redirected-By: redirect-canonical.php' );
	}

	// SUS-5838 | Preserve the query string
	$qs = parse_url( $requestUri, PHP_URL_QUERY );

	$url = wfAppendQuery( $url, $qs );

	return $url;
}


// Issue the redirect
$url = getTargetUrl();

header( 'Location: ' . $url, true, 301 );
header ('X-Served-By: '. wfHostname() );

echo sprintf( 'Moved to <a href="%s">%s</a>', htmlspecialchars( $url ), htmlspecialchars( $url ) );

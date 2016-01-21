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

// Parse_url can technically parse just REQUEST_URI, but it doesn't work well
// for URIs like Foo:100 which it understands as host: Foo, port: 100, no path
// That's why we upgrade the URI to a full URL but prepending 'http://wikia.com/'
// in front of it.
$path = parse_url( 'http://wikia.com/' . $_SERVER['REQUEST_URI'], PHP_URL_PATH );
$path = trim( rawurldecode( $path ), '/ _' );

// Hack to better recover Mercury modular home pages URLs
// (they are have double-encoded URLs for some reason)
if ( startsWith( $path, 'main/' ) ) {
	$path = rawurldecode( $path );
}

if ( isset( $_SERVER['REDIRECT_QUERY_STRING'] ) ) {
	// Called from Apache's ErrorHandler
	$qs = $_SERVER['REDIRECT_QUERY_STRING'];
} else {
	// Called directly
	$qs = $_SERVER['QUERY_STRING'];
}

$logContext = [
	'ex' => new Exception(),
	// To verify if Kibana trims the strings:
	'uri' => $_SERVER['REQUEST_URI'],
	'uriLen' => count( $_SERVER['REQUEST_URI'] ),
];

if ( !$path ) {
	WikiaLogger::instance()->warning( '404 redirector: malformed URI', $logContext );
}

if ( in_string( '%', $path ) || in_string( '<', $path ) || in_string( '>', $path ) ) {
	WikiaLogger::instance()->warning( '404 redirector: forbidden char in URI', $logContext );
	$path = str_replace( ['%', '<', '>'], '_', $path );
}

$title = Title::newFromText( $path );

if ( !$title ) {
	WikiaLogger::instance()->warning( '404 redirector: not a valid title in URI', $logContext );
	$title = Title::newMainPage();
}

$url = $title->getFullURL( $qs );

header( 'Location: ' . $url, 302 );
echo sprintf( 'Moved to <a href="%s">%s</a>', htmlspecialchars( $url ), htmlspecialchars( $url ) );

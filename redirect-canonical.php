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

require_once( dirname( __FILE__ ) . '/includes/WebStart.php' );

$path = ltrim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );

if ( isset( $_SERVER['REDIRECT_QUERY_STRING'] ) ) {
	// Called from Apache's ErrorHandler
	$qs = $_SERVER['REDIRECT_QUERY_STRING'];
} else {
	// Called directly
	$qs = $_SERVER['QUERY_STRING'];
}

$title = Title::newFromText( rawurldecode( $path ) );
$url = $title->getFullURL( $qs );

header( 'Location: ' . $url, 302 );
echo sprintf( 'Moved to <a href="%s">%s</a>', htmlspecialchars( $url ), htmlspecialchars( $url ) );

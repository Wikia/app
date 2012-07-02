<?php

/**
 * Quick and dirty extension to hook into FirePHP for debugging messages.
 * Some messages don't make it through because they're too early for initialization
 * or too late for HTTP header output.
 *
 * FirePHP is a plugin for Firebug which adds debugging info from HTTP headers
 * into the console output, which some will find handier than tailing a log file
 * or such forth.
 *
 * There's not a lot of fancy integration; everything's just output as a 'log' line.
 * You can use $wgFirePHP global (or call FirePHP::getInstance() yourself) to get
 * direct access to FirePHP's fancier features in test code.
 *
 * lib/FirePHP.class.php holds the accessor library, under new BSD license.
 *
 * Blah blah GPLv2 blah blah for this code.
 * @author Brion Vibber <brion@pobox.com>
 */

$wgAutoloadClasses['FirePHP'] = dirname( __FILE__ ) . '/lib/FirePHP.class.php';

$wgExtensionFunctions[] = 'efFirePHPSetup';

$wgHooks['Debug'][] = 'efFirePHPDebug';

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'FirePHP',
	'url' => 'https://www.mediawiki.org/wiki/Extension:FirePHP',
	'author' => 'Brion Vibber',
	'description' => 'Allows the Firebug Extension for AJAX Development to work with MediaWiki',
);

global $wgFirePHP;
$wgFirePHP = null;

function efFirePHPSetup() {
	global $wgFirePHP;
	$wgFirePHP = FirePHP::init();
}

function efFirePHPDebug( $text, $group=null ) {
	global $wgFirePHP;
	if ( empty( $wgFirePHP ) ) {
		// A few items will go through before we reach initialization, like
		// loading up the cache classes.
	} elseif ( headers_sent() ) {
		// It's too late, we can't send anything else to FirePHP.
	} else {
		$wgFirePHP->log( $text );
	}
	return true;
}

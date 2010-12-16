<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @file
 * @ingroup Extensions
 * @author Roan Kattouw <roan.kattouw@gmail.com>
 * @copyright Copyright © 2009 Roan Kattouw
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the ApiSVGProxy extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/ApiSVGProxy/ApiSVGProxy.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ApiSVGProxy',
	'author' => 'Roan Kattouw',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ApiSVGProxy',
	'version' => '1.0',
	'description' => 'Proxies SVG files from a (possibly remote) file repository to the local domain',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ApiSVGProxy'] = $dir . 'ApiSVGProxy.body.php';
$wgAPIModules['svgproxy'] = 'ApiSVGProxy';
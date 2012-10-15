<?php

/**
 * Experimental next-gen timezone picker
 * http://www.mediawiki.org/wiki/Extension:TimeZonePicker
 *
 * @copyright 2011 Brion Vibber <brion@pobox.com>
 *
 * MediaWiki-side code is GPL v2 or later.
 *
 * World map image based on http://commons.wikimedia.org/wiki/File:Mercator-projection.jpg
 * Source image is from NASA's Earth Observatory "Blue Marble" series. (Public domain)
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'TimeZonePicker',
	'author'         => array( 'Brion Vibber' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:TimeZonePicker',
);

$wgHooks['BeforePageDisplay'][] = 'TimeZonePickerHooks::beforePageDisplay';

$wgAutoloadClasses['TimeZonePickerHooks'] = dirname( __FILE__ ) . '/TimeZonePicker.hooks.php';

$myResourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/resources',
	'remoteExtPath' => 'TimeZonePicker/resources',
	'group' => 'ext.tzpicker',
);
$wgResourceModules['ext.tzpicker'] = $myResourceTemplate + array(
	'scripts' => array(
		'ext.tzpicker.js',
	),
	'styles' => array(
		'ext.tzpicker.css',
	),
	'dependencies' => array(
		'mediawiki.special.preferences'
	)
);

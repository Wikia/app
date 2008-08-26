<?php

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['PNGHandler'] = $dir . 'PNGHandler_body.php';
$wgExtensionMessagesFiles['PNGHandler'] = $dir . 'PNGHandler.i18n.php';

$wgExtensionCredits['PNGHandler'][] = array(
	'name' => 'PNGHandler',
	'author' => 'Bryan Tong Minh', 
	'url' => 'http://www.mediawiki.org/wiki/Extension:PNGHandler', 
	'description' => 'Resize PNGs using pngds',
	'descriptionmsg' => 'pnghandler-desc',
);

/*
 * Path to the pngds executable. Download the source from 
 * <http://svn.wikimedia.org/svnroot/mediawiki/trunk/pngds> or binaries from
 * <http://toolserver.org/~bryan/pngds/>
 */
$egPngdsPath = '';
/*
 * If true tries to resize using the default media handler.
 * Handy as pngds not support upscaling or palette images
 */
$egPngdsFallback = true;
/*
 * Minimum size in pixels for an image to be handled using PNGHandler. 
 * Smaller files will be handled using the default media handler.
 */
$egPngdsMinSize = 2000000;

$wgMediaHandlers['image/png'] = 'PNGHandler';

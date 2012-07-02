<?php
/**
 * EmbedVideo.php - Adds a parser function embedding video from popular sources.
 * See README for details. For licensing information, see LICENSE. For a
 * complete list of contributors, see CREDITS
 *
 * @file
 * @ingroup Extensions
 */

# Confirm MW environment
if (!defined('MEDIAWIKI')) {
       echo <<<EOT
To install EmbedVideo, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/EmbedVideo/EmbedVideo.php" );
EOT;
    exit( 1 );
}

# Credits
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'EmbedVideo',
	'author'         => array( 'Jim R. Wilson', 'Andrew Whitworth' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:EmbedVideo',
	'descriptionmsg' => 'embedvideo-desc',
	'version'        => '1.1'
);

$dir = dirname(__FILE__) . '/';
require_once($dir . "EmbedVideo.hooks.php"); // @todo FIXME: Use autoloader to load classes.
require_once($dir . "EmbedVideo.Services.php");
$wgExtensionMessagesFiles['EmbedVideo'] = $dir . 'EmbedVideo.i18n.php';
$wgExtensionMessagesFiles['EmbedVideoMagic'] = $dir . 'EmbedVideo.i18n.magic.php';

$wgHooks['ParserFirstCallInit'][] = "EmbedVideo::setup";

<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is the OggHandler extension. Please see the README file for installation instructions.\n";
	exit( 1 );
}

$oggDir = dirname(__FILE__);
$wgAutoloadClasses['OggHandler'] = "$oggDir/OggHandler_body.php";

$wgMediaHandlers['application/ogg'] = 'OggHandler';
if ( !in_array( 'ogg', $wgFileExtensions ) ) {
	$wgFileExtensions[] = 'ogg';
}
if ( !in_array( 'ogv', $wgFileExtensions ) ) {
	$wgFileExtensions[] = 'ogv';
}
if ( !in_array( 'oga', $wgFileExtensions ) ) {
	$wgFileExtensions[] = 'oga';
}
ini_set( 'include_path',
	"$oggDir/PEAR/File_Ogg" .
	PATH_SEPARATOR .
	ini_get( 'include_path' ) );

// Bump this when updating OggPlayer.js to help update caches
$wgOggScriptVersion = '12';

$wgExtensionMessagesFiles['OggHandler'] = "$oggDir/OggHandler.i18n.php";
$wgExtensionMessagesFiles['OggHandlerMagic'] = "$oggDir/OggHandler.i18n.magic.php";
$wgParserOutputHooks['OggHandler'] = array( 'OggHandler', 'outputHook' );

$wgExtensionCredits['media'][] = array(
	'path'           => __FILE__,
	'name'           => 'OggHandler',
	'author'         => 'Tim Starling',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:OggHandler',
	'descriptionmsg' => 'ogg-desc',
);

/******************* CONFIGURATION STARTS HERE **********************/

/**
 * The names of the supported video types, as they appear in the PEAR module.
 */
$wgOggVideoTypes = array( 'Theora' );

/**
 * The names of the supported audio types, as they appear in the PEAR module.
 * These types will be described as audio, but only Vorbis is widely supported
 * by the client-side plugins.
 */
$wgOggAudioTypes = array( 'Vorbis', 'Speex', 'FLAC' );

/**
 * Location of the FFmpeg binary, or false to use oggThumb. See the notes
 * about thumbnailer choices in the README file.
 */
$wgFFmpegLocation = '/usr/bin/ffmpeg';

/**
 * Location of the oggThumb binary, or false to use FFmpeg. Note that only
 * version 0.9 (expected release in May 2010) or later is supported. See the
 * README file for more details.
 */
$wgOggThumbLocation = false;


/**
 * Filename or URL path to the Cortado Java player applet.
 *
 * If no path is included, the path to this extension's
 * directory will be used by default -- this should work
 * on most local installations.
 *
 * You may need to include a full URL here if $wgUploadPath
 * specifies a host different from where the wiki pages are
 * served -- the applet .jar file must come from the same host
 * as the uploaded media files or Java security rules will
 * prevent the applet from loading them.
 */
$wgCortadoJarFile = "cortado-ovt-stripped-0.5.1.jar";

/******************* CONFIGURATION ENDS HERE **********************/


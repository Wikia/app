<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is the TimedMediaHandler extension. Please see the README file for installation instructions.\n";
	exit( 1 );
}

if( !class_exists( 'MwEmbedResourceManager' ) ) {
	echo "TimedMediaHandler requires the MwEmbedSupport extension.\n";
	exit( 1 );
}

// Set up the timed media handler dir:
$timedMediaDir = dirname( __FILE__ );
// Include WebVideoTranscode (prior to config so that its defined transcode keys can be used in configuration)
$wgAutoloadClasses['WebVideoTranscode'] = "$timedMediaDir/WebVideoTranscode/WebVideoTranscode.php";

// Add the rest transcode right:
$wgAvailableRights[] = 'transcode-reset';

/******************* CONFIGURATION STARTS HERE **********************/

/*** MwEmbed module configuration: *********************************/
// Show a warning to the user if they are not using an html5 browser with high quality ogg support
$wgMwEmbedModuleConfig['EmbedPlayer.DirectFileLinkWarning'] = true;

// The text interface should always be shown
// ( even if there are no text tracks for that asset at render time )
$wgMwEmbedModuleConfig['TimedText.ShowInterface'] = 'always';

// Which users can restart failed or expired transcode jobs:
$wgGroupPermissions['sysop']['transcode-reset'] = true;

// How long you have to wait between transcode resets for non-error transcodes
$wgWaitTimeForTranscodeReset = 3600;

// The minimum size for an embed video player ( smaller than this size uses a pop-up player )
$wgMinimumVideoPlayerSize = 200;

// Set the supported ogg codecs:
$wgMediaVideoTypes = array( 'Theora', 'VP8' );
$wgMediaAudioTypes = array( 'Vorbis', 'Speex', 'FLAC' );

// Default skin for mwEmbed player (class attribute of video tag)
$wgVideoPlayerSkin = 'kskin';

// Support iframe for remote embedding
$wgEnableIframeEmbed = true;

// If transcoding is enabled for this wiki (if disabled, no transcode jobs are added and no
// transcode status is displayed). Note if remote embedding an asset we will still check if
// the remote repo has transcoding enabled and associated flavors for that media embed.
$wgEnableTranscode = true;

// If the job runner should run transcode commands in a background thread and monitor the
// transcoding progress. This enables more fine grain control of the transcoding process, wraps
// encoding commands in a lower priority 'nice' call, and kills long running transcodes that are
// not making any progress. If set to false, the job runner will use the more compatible
// php blocking shell exec command.
$wgEnableNiceBackgroundTranscodeJobs = true;

// The priority to be used with the nice transcode commands.
$wgTranscodeBackgroundPriority = 19;

// The total amout of time a transcoding shell command can take:
$wgTranscodeBackgroundTimeLimit = 3600 * 4;

// The location of ffmpeg2theora (transcoding)
$wgFFmpeg2theoraLocation = '/usr/bin/ffmpeg2theora';

// Location of the FFmpeg binary (used to encode WebM and for thumbnails)
$wgFFmpegLocation = '/usr/bin/ffmpeg';

// The NS for TimedText (registered on MediaWiki.org)
// http://www.mediawiki.org/wiki/Extension_namespace_registration
// Note commons pre-dates TimedMediaHandler and should set $wgTimedTextNS = 102 in LocalSettings.php
$wgTimedTextNS = 710;

/**
 * Default enabled transcodes
 *
 * -If set to empty array, no derivatives will be created
 * -Derivative keys encode settings are defined in WebVideoTranscode.php
 *
 * -These transcodes are *in addition to* the source file.
 * -Only derivatives with smaller width than the source asset size will be created
 * -Regardless of source size at least one WebM and Ogg source will be created from the $wgEnabledTranscodeSet
 * -Derivative jobs are added to the MediaWiki JobQueue the first time the asset is displayed
 * -Derivative should be listed min to max
 */
$wgEnabledTranscodeSet = array(
	// Cover accessibility for low bandwidth / low resources clients:
	WebVideoTranscode::ENC_OGV_160P,

	// A high end web streamable ogg video
	WebVideoTranscode::ENC_OGV_480P,

	// A web streamable WebM video
	WebVideoTranscode::ENC_WEBM_480P,

	// A high quality WebM stream
	WebVideoTranscode::ENC_WEBM_720P,
);
/******************* CONFIGURATION ENDS HERE **********************/


// List of extensions handled by Timed Media Handler since its referenced in a few places.
// you should not modify this variable
$wgTmhFileExtensions = array( 'ogg', 'ogv', 'oga', 'webm');

$wgFileExtensions = array_merge( $wgFileExtensions, $wgTmhFileExtensions );

// Timed Media Handler AutoLoad Classes:
$wgAutoloadClasses['TimedMediaHandler'] = "$timedMediaDir/TimedMediaHandler_body.php";
$wgAutoloadClasses['TimedMediaHandlerHooks'] = "$timedMediaDir/TimedMediaHandler.hooks.php";
$wgAutoloadClasses['TimedMediaTransformOutput'] = "$timedMediaDir/TimedMediaTransformOutput.php";
$wgAutoloadClasses['TimedMediaIframeOutput'] = "$timedMediaDir/TimedMediaIframeOutput.php";
$wgAutoloadClasses['TimedMediaThumbnail'] = "$timedMediaDir/TimedMediaThumbnail.php";
// Transcode Page
$wgAutoloadClasses['TranscodeStatusTable'] = "$timedMediaDir/TranscodeStatusTable.php";

// Testing:
$wgAutoloadClasses['ApiTestCaseVideoUpload'] = "$timedMediaDir/tests/phpunit/ApiTestCaseVideoUpload.php";

// Ogg Handler
$wgAutoloadClasses['OggHandler'] = "$timedMediaDir/handlers/OggHandler/OggHandler.php";
ini_set( 'include_path',
	"$timedMediaDir/handlers/OggHandler/PEAR/File_Ogg" .
	PATH_SEPARATOR .
	ini_get( 'include_path' ) );

// WebM Handler
$wgAutoloadClasses['WebMHandler'] = "$timedMediaDir/handlers/WebMHandler/WebMHandler.php";
$wgAutoloadClasses['getID3'] = "$timedMediaDir/handlers/WebMHandler/getid3/getid3.php";

// Text handler
$wgAutoloadClasses['TextHandler'] = "$timedMediaDir/handlers/TextHandler/TextHandler.php";
$wgAutoloadClasses['TimedTextPage'] = "$timedMediaDir/TimedTextPage.php";

// Transcode support
$wgAutoloadClasses['WebVideoTranscodeJob'] = "$timedMediaDir/WebVideoTranscode/WebVideoTranscodeJob.php";

// API modules:
$wgAutoloadClasses['ApiQueryVideoInfo'] = "$timedMediaDir/ApiQueryVideoInfo.php";
$wgAPIPropModules['videoinfo'] = 'ApiQueryVideoInfo';

$wgAutoloadClasses['ApiTranscodeStatus'] = "$timedMediaDir/ApiTranscodeStatus.php";
$wgAPIPropModules['transcodestatus'] = 'ApiTranscodeStatus';

$wgAutoloadClasses['ApiTranscodeReset'] = "$timedMediaDir/ApiTranscodeReset.php";
$wgAPIModules['transcodereset'] = 'ApiTranscodeReset';

// Localization
$wgExtensionMessagesFiles['TimedMediaHandler'] = "$timedMediaDir/TimedMediaHandler.i18n.php";
$wgExtensionMessagesFiles['TimedMediaHandlerMagic'] = "$timedMediaDir/TimedMediaHandler.i18n.magic.php";

// Register all Timed Media Handler hooks right after the cache check.
// This way if you set a variable like $wgTimedTextNS in LocalSettings.php after you include TimedMediaHandler
// we can still read the variable values
$wgHooks['SetupAfterCache'][] = 'TimedMediaHandlerHooks::register';

// Extension Credits
$wgExtensionCredits['media'][] = array(
	'path'           => __FILE__,
	'name'           => 'TimedMediaHandler',
	'author'         => array( 'Michael Dale', 'Tim Starling', 'James Heinrich' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:TimedMediaHandler',
	'descriptionmsg' => 'timedmedia-desc',
	'version'		 => '0.2',
);


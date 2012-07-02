<?php
/**
 * MediaWiki extension: LilyPond
 * =============================
 *
 * To activate, edit your LocalSettings.php, add
 * require_once("$IP/extensions/LilyPond.php");
 * and make sure that the images/ directory is writable.
 *
 * Example wiki code: <lilypond>\relative c' { c d e f g }</lilypond>
 * If you want to typeset a fragment with clickable midi, use
 * <lilymidi>...</lilymidi>
 * If you want write a complete lilypond file, use
 * <lilybook>...</lilybook>
 *
 * Tested with Lilypond version 2.12.2.
 *
 * @file
 * @ingroup Extensions
 * @version 0.01
 * @author Johannes E. Schindelin
 * @link http://www.mediawiki.org/wiki/Extension:LilyPond
 */

# User Settings

# The following variables can be set in LocalSettings.php
# before the line:
# require_once("$IP/extensions/LilyPond.php");

# You can set the variable $wgLilypond if you want/need to override the
# path to the Lilypond executable. For example:

# Add a text link to prompt user to listen to midi, before and/or after
# the image. Remember line breaks
# $wgLilypondPreMidi  = "Listen<br>";
# $wgLilypondPostMidi = "<br>Listen";

# If you want to avoid trimming the resulting image, set $wgLilypondTrim
# to false.
# $wgLilypondTrim = false;

# You can put a white border around the image if you like.
# $wgLilypondBorderX = 10;
# $wgLilypondBorderY = 0;

# End User Settings

# Defaulting of user settings
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

$wgExtensionCredits['parserhooks'][] = array(
	'path' => __FILE__,
	'name' => 'LilyPond',
	'version' => 0.01,
	'author' => 'Johannes E. Schindelin',
	'url' => 'https://www.mediawiki.org/wiki/Extension:LilyPond',
	'descriptionmsg' => 'lilypond-desc',
);

$wgLilypond = "/usr/local/bin/lilypond";
$wgLilypondPreMidi = "";
$wgLilypondPostMidi = "";
$wgLilypondTrim = true;
$wgLilypondBorderX = 0;
$wgLilypondBorderY = 0;

$wgHooks['ParserFirstCallInit'][] = 'wfLilyPondExtension';
$wgAutoloadClasses['LilyPond'] = dirname( __FILE__ ) . '/LilyPond.class.php';

/**
 * @param $parser Parser
 */
function wfLilyPondExtension( &$parser ) {
	$parser->setHook( "lilypond", "LilyPond::renderFragment" );
	$parser->setHook( "lilymidi", "LilyPond::renderMidiFragment" );
	$parser->setHook( "lilybook", "LilyPond::render" );
}

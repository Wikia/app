<?php
/**
 * GoogleDocs4MW parser extension - adds <googlespreadsheet> tag for displaying
 * Google Docs' spreadsheets
 *
 * @file
 * @ingroup Extensions
 * @version 1.1
 * @author Jack Phoenix <jack@shoutwiki.com>
 * @copyright © 2008-2011 Jack Phoenix
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is an extension to the MediaWiki software and is not a valid access point.\n" );
}

// Add extension credits that show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'GoogleDocs4MW',
	'version' => '1.1',
	'author' => 'Jack Phoenix',
	'description' => 'Adds <tt>&lt;googlespreadsheet&gt;</tt> tag for Google Docs\' spreadsheets display',
	'url' => 'https://www.mediawiki.org/wiki/Extension:GoogleDocs4MW'
);

// Set up the parser hook
$wgHooks['ParserFirstCallInit'][] = 'wfGoogleDocs';
function wfGoogleDocs( &$parser ) {
	$parser->setHook( 'googlespreadsheet', 'renderGoogleSpreadsheet' );
	return true;
}

// The callback function for converting the input to HTML output
function renderGoogleSpreadsheet( $input, $argv ) {
	$width = isset( $argv['width'] ) ? $argv['width'] : 500;
	$height = isset( $argv['height'] ) ? $argv['height'] : 300;
	$style = isset( $argv['style'] ) ? $argv['style'] : 'width:100%';
	$key = htmlspecialchars( $input );

	$output = '<iframe class="googlespreadsheetframe" width="' .
				intval( $width ) . '" height="' .
				intval( $height ) . '" style="' .
				htmlspecialchars( $style ) .
				'" src="http://spreadsheets.google.com/pub?key=' . $key .
				'&output=html&widget=true"></iframe>';

	return $output;
}
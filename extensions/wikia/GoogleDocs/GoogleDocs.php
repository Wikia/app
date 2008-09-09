<?php
/**
 * GoogleDocs4MW - a simple GoogleDocs Extension for MediaWiki
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Lucas 'TOR' Garczewski <tor@wikia.com>
 * @copyright Copyright (C) 2007 Lucas 'TOR' Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

if (!defined('MEDIAWIKI')){
    echo ('THIS IS NOT VALID ENTRY POINT.'); exit (1);
}

$wgExtensionFunctions[] = "wfGoogleDocs";

$wgExtensionCredits['parserhook'][] = array(
	'name' => "[http://help.wikia.com/wiki/Help:Google_spreadsheets GoogleDocs4MW]",
	'description' => "adds &lt;googlespreadsheet&gt; tag for Google Docs' spreadsheets display",
	'author' => "[http://www.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]"
);

function wfGoogleDocs() {
        global $wgParser;
        $wgParser->setHook( "googlespreadsheet", "renderGoogleSpreadsheet" );
}

function renderGoogleSpreadsheet( $input, $argv ) {

	#Set default width and height
	if (empty($argv['height'])) $argv['height'] = 300;
	if (empty($argv['width'])) $argv['width'] = 500;

	$output = "<iframe class='googlespreadsheetframe' width='".
		htmlspecialchars($argv['width']).
		"' height='".
		htmlspecialchars($argv['height']).
		"' ";
	if (!empty($argv['style'])) $output .= "style='". htmlspecialchars($argv['style']). "' ";
	$output .= "src='http://spreadsheets.google.com/pub?key=". htmlspecialchars($input). "&output=html&widget=true'></iframe>";

	return $output;
}

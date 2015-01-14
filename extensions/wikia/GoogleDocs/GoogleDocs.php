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

$wgHooks['ParserFirstCallInit'][] = "wfGoogleDocs";

$wgExtensionCredits['parserhook'][] = array(
	'name' => "GoogleDocs4MW",
	'descriptionmsg' => "googledocs-desc",
	'author' => "[http://www.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]",
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GoogleDocs'
);

//i18n
$wgExtensionMessagesFiles['GoogleDocs4MW'] = __DIR__ . '/GoogleDocs.i18n.php';

function wfGoogleDocs( Parser $parser ) {
	$parser->setHook( "googlespreadsheet", "renderGoogleSpreadsheet" );
	return true;
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


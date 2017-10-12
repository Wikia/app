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

if ( !defined( 'MEDIAWIKI' ) ) {
    echo 'THIS IS NOT VALID ENTRY POINT.';
    exit (1);
}

$wgHooks['ParserFirstCallInit'][] = 'wfGoogleDocs';

$wgExtensionCredits['parserhook'][] = [
	'name' => 'GoogleDocs4MW',
	'descriptionmsg' => 'googledocs-desc',
	'author' => "[http://www.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]",
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GoogleDocs'
];

//i18n

function wfGoogleDocs( Parser $parser ) {
	$parser->setHook( 'googlespreadsheet', 'renderGoogleSpreadsheet' );
	return true;
}

function renderGoogleSpreadsheet( $input, $argv ) {
	$height = 300;
	$width = 500;
	if ( !empty( $argv['height'] ) && is_numeric( $argv['height'] ) ) {
		$height = intval( $argv['height'] );
	}
	if ( !empty( $argv['width'] ) && is_numeric( $argv['width'] ) ) {
		$width = intval( $argv['width'] );
	}

	return Html::element(
		'iframe',
		[
			'width' => $width,
			'height' => $height,
			'src' => 'https://docs.google.com/spreadsheets/d/' . urlencode( $input ) . '/htmlembed?widget=true',
		]
	);
}

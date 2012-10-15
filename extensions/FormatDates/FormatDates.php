<?php

/**
 * Parser hook in which free dates will be refactored to meet the
 * user's date formatting preference
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * Please see the LICENCE file for terms of use and redistribution
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

$wgAutoloadClasses['DateParser'] = dirname( __FILE__ ) . '/DateParser.php';
$wgAutoloadClasses['FormattableDate'] = dirname( __FILE__ ) . '/FormattableDate.php';
$wgHooks['ParserFirstCallInit'][] = 'efFormatDatesSetHook';

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Date Formatter',
	'author' => 'Rob Church',
	'description' => 'Supports refactoring of unlinked dates through the <code><nowiki><date></nowiki></code> tag',
);

function efFormatDatesSetHook( $parser ) {
	$parser->setHook( 'date', 'efFormatDate' );
	return true;
}

function efFormatDate( $text, $args, &$parser ) {
	global $wgUseDynamicDates, $wgContLang;
	if( $wgUseDynamicDates ) {
		$dp = new DateParser( $wgContLang, DateParser::convertPref( $parser->getOptions()->getDateFormat() ) );
		return $dp->reformat( $text );
	} else {
		return $text;
	}
}



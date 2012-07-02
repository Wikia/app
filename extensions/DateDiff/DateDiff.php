<?php
/**
 * DateDiff extension.
 *
 * @file DateDiff.php
 *
 * @author David Raison
 * @author Jeroen De Dauw
 * 
 * @licence http://creativecommons.org/licenses/by-sa/3.0/
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'Datediff_VERSION', '0.2.0' );

$wgExtensionMessagesFiles['DateDiff'] = dirname( __FILE__ ) . '/DateDiff.i18n.php';
$wgExtensionMessagesFiles['DateDiffMagic'] = dirname( __FILE__ ) . '/DateDiff.i18n.magic.php';

// Extension credits that show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'DateDiff',
	'author' => array(
		'[http://david.raison.lu David Raison]',
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]'
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:DateDiff',
	'descriptionmsg' => 'datediff-desc',
	'version' => Datediff_VERSION,
);

$wgHooks['ParserFirstCallInit'][] = 'efDDDateDiff';

function efDDDateDiff( Parser &$parser ) {
	$parser->setFunctionHook( 'dates', 'efDDCalcDates' );
	return true;
}

function efDDCalcDates( &$parser ) {
	$params = func_get_args();
	
	// We already know the $parser ...
	array_shift( $params ); 

	while ( empty( $params[0] ) ) {
		array_shift( $params );
	}

	$dates = array();
	
	foreach ( $params as $pair ) {
		// We currently ignore the label of the date.
		$dates[] = substr( $pair, strpos( $pair, '=' ) + 1 );
	}

	$time1 = strtotime( $dates[0] );
	$time2 = strtotime( $dates[1] );

	$a = ( $time2 > $time1 ) ? $time2 : $time1;       // higher
	$b = ( $a == $time1 ) ? $time2 : $time1;          // lower
	$datediff = $a - $b;

	$oneday = 86400;
	$days = array();
	
	for ( $i = 0; $i <= $datediff; $i += $oneday ) {
		$days[] = date( 'c', strtotime( $dates[0] ) + $i );
	}
	
	return implode( ',', $days );
}

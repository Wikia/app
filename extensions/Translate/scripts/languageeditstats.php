<?php
/**
 * Shows a top list of language codes with edits in a given time period
 *
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2008 Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$optionsWithArgs = array( 'top', 'days', 'bots', 'ns' );
require( dirname( __FILE__ ) . '/cli.inc' );

function showUsage() {
	STDERR( <<<EOT
Language statistics.
Shows number of edits per language for all message groups.

Usage: php languageeditstats.php [options...]

Options:
  --top       Show given number of language codes (default: 10)
  --days      Calculate for given number of days (default: 7)
  --bots      Include bot edits (default: false)
  --ns        Comma separated list of Namespace IDs (default: all)

EOT
);
	exit( 1 );
}

/** Process command line parameters
 */
if ( isset( $options['help'] ) ) {
	showUsage();
}

if ( isset( $options['days'] ) ) {
	$hours = intval( $options['days'] ) * 24; // no day change cutoff
} else {
	$hours = 7 * 24;
}

if ( isset( $options['top'] ) ) {
	$top = intval( $options['top'] );
} else {
	$top = 10;
}

if ( isset( $options['bots'] ) ) {
	$bots = true;
} else {
	$bots = false;
}

$namespaces = array();
if ( isset( $options['ns'] ) ) {
	$input = explode( ',', $options['ns'] );

	foreach ( $input as $namespace ) {
		if ( is_numeric( $namespace ) ) {
			array_push( $namespaces, $namespace );
		}
	}
}

function figureMessage( $text ) {
	$pos = strrpos( $text, '/' );
	$code = substr( $text, $pos + 1 );
	$key = substr( $text, 0, $pos );
	return array( $key, $code );
}

/** Select set of edits to report on
 */
$rows = TranslateUtils::translationChanges( $hours, $bots, $namespaces );

/** Get counts for edits per language code after filtering out edits by
 *  $wgTranslateFuzzyBotName
 */
$codes = array();
foreach ( $rows as $_ ) {
	// Filter out edits by $wgTranslateFuzzyBotName
	if ( $_->rc_user_text === $wgTranslateFuzzyBotName ) continue;

	list( , $code ) = figureMessage( $_->rc_title );

	if ( !isset( $codes[$code] ) ) $codes[$code] = 0;
	$codes[$code]++;
}

/** Sort counts and report descending up to $top rows.
 */
arsort( $codes );
$i = 0;
foreach ( $codes as $code => $num  ) {
	if ( $i++ === $top ) break;
	STDOUT( "$code\t$num" );
}

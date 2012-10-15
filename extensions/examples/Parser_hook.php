<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * A parser hook example, use it on a page like
 * <hook arg1="foo" arg2="bar" ...>input</hook>
 *
 * @file
 * @ingroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @author Niklas Laxström
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Parser hook',
	'description' => 'a sample parser hook',
	'author' => 'Ævar Arnfjörð Bjarmason'
);

/* Register the registration function */
$wgHooks['ParserFirstCallInit'][] = 'wfParserHook';

/**
 * The registration function.
 */
function wfParserHook( $parser ) {
	$parser->setHook( 'hook' , 'wfParserHookParse' );
	// Always return true.
	return true;
}

/**
 * @param String $data The input passed to <hook>
 * @param Array $params The attributes of the <hook> element in array form
 * @param Parser $parser Not used in this extension, but can be used to
 * turn wikitext into html or do some other "advanced" stuff
 * @param PPFrame $frame Not used in this extension, but can be used
 * to see what template arguments ({{{1}}}) this hook was used with.
 *
 * @return String HTML to put in page at spot where <hook> tag is.
 */
function wfParserHookParse( $data, $params, $parser, $frame ) {
	// Very important to escape user data to prevent an XSS
	// security vulnerability.
	// print_r just turns an array into something readable.
	$paramsEscaped = htmlspecialchars( print_r( $params, true ) );
	$dataEscaped = htmlspecialchars( $data );

	if ( !count( $params ) ) {
		return $dataEscaped;
	} else {
		return '<pre>' . $dataEscaped . "\n" . $paramsEscaped . '</pre>';
	}
}


<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A parser hook example, use it on a page like
 * <hook arg1="foo" arg2="bar" ...>input</hook>
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfParserHook';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Parser hook',
	'description' => 'a sample parser hook',
	'author' => 'Ævar Arnfjörð Bjarmason'
);

function wfParserHook() {
	global $wgParser;
	
	$wgParser->setHook( 'hook' , 'wfParserHookParse' );
}

/**
 * @param string $in The input passed to <hook>
 * @param array $argv The attributes of the <hook> element in array form
 */
function wfParserHookParse( $in, $argv ) {
	if ( ! count( $argv ) )
		return $in;
	else
		return '<pre>' . $in . "\n" . print_r( $argv, true ) . '</pre>';
}


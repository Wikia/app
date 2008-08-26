<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An example parser hook that defines a new variable, {{EXAMPLE}}
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgHooks['MagicWordwgVariableIDs'][] = 'wfVariableHookVariables';
$wgHooks['LanguageGetMagic'][] = 'wfVariableHookRaw';
$wgHooks['ParserGetVariableValueSwitch'][] = 'wfVariableHookSwitch';
$wgExtensionCredits['variable'][] = array(
	'name' => 'Parser hook',
	'description' => 'a sample variable hook',
	'author' => 'Ævar Arnfjörð Bjarmason'
);

function wfVariableHookVariables( &$wgVariableIDs ) {
	$wgVariableIDs[] = 'example';

	return true;
}

function wfVariableHookRaw( &$raw ) {
	$raw['example'] = array( 0, 'EXAMPLE' );;

	return true;
}

function wfVariableHookSwitch( &$parser, &$varCache, &$index, &$ret ) {
	if ( $index === 'example' )
		$ret = $varCache[$index] = wfVariableHookRet();
	
	return true;
}

function wfVariableHookRet() {
	return 'example';
}

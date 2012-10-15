<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * An example parser hook that defines a new variable, {{EXAMPLE}}
 *
 * @file
 * @ingroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['variable'][] = array(
	'path' => __FILE__,
	'name' => 'Parser hook',
	'description' => 'a sample variable hook',
	'author' => 'Ævar Arnfjörð Bjarmason'
);

$wgHooks['MagicWordwgVariableIDs'][] = 'wfVariableHookVariables';
$wgHooks['ParserGetVariableValueSwitch'][] = 'wfVariableHookSwitch';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Variable_hookMagic'] = $dir . 'Variable_hook.i18n.magic.php';

function wfVariableHookVariables( &$wgVariableIDs ) {
	$wgVariableIDs[] = 'example';

	return true;
}

function wfVariableHookSwitch( &$parser, &$varCache, &$index, &$ret ) {
	if ( $index === 'example' ) {
		$ret = $varCache[$index] = wfVariableHookRet();
	}
	return true;
}

function wfVariableHookRet() {
	return 'example';
}

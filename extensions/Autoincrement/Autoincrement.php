<?php
if (!defined('MEDIAWIKI')) die();
/**
 * An example parser hook that defines a new variable, {{AUTOINCREMENT}},
 * useful for maintaining a citation count with {{ref|}} and {{note|}} pairs
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['variable'][] = array(
	'path' => __FILE__,
	'name' => 'Autoincrement',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'description' => 'A variable hook that adds an autoincrementing variable, <nowiki>{{AUTOINCREMENT}}</nowiki>',
	'description-desc' => 'autoincrement-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Autoincrement',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Autoincrement'] = $dir . 'Autoincrement.i18n.php';
$wgExtensionMessagesFiles['AutoincrementMagic'] = $dir . 'Autoincrement.i18n.magic.php';

class Autoincrement {
	var $mCount;

	function Autoincrement() {
		global $wgHooks;

		$this->mCount = 0;

		$wgHooks['MagicWordwgVariableIDs'][] = array( $this, 'wfAutoincrementHookVariables' );
		$wgHooks['ParserGetVariableValueSwitch'][] = array( $this, 'wfAutoincrementHookSwitch' );
	}

	function wfAutoincrementHookVariables( &$wgVariableIDs ) {
		$wgVariableIDs[] = 'autoincrement';

		return true;
	}

	function wfAutoincrementHookSwitch( &$parser, &$varCache, &$index, &$ret ) {
		if ( $index === 'autoincrement' )
			$ret = ++$this->mCount; // No formatNum() just like url autonumbering

		return true;
	}
}

new Autoincrement;

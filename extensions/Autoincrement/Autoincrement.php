<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * An example parser hook that defines a new variable, {{AUTOINCREMENT}},
 * useful for maintaining a citation count with {{ref|}} and {{note|}} pairs
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
	'name' => 'Autoincrement',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'descriptionmsg' => 'autoincrement-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Autoincrement',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Autoincrement'] = $dir . 'Autoincrement.i18n.php';
$wgExtensionMessagesFiles['AutoincrementMagic'] = $dir . 'Autoincrement.i18n.magic.php';

class Autoincrement {
	var $mCount;

	function __construct() {
		global $wgHooks;

		$this->mCount = 0;

		$wgHooks['MagicWordwgVariableIDs'][] = array( $this, 'wfAutoincrementHookVariables' );
		$wgHooks['ParserGetVariableValueSwitch'][] = array( $this, 'wfAutoincrementHookSwitch' );
	}

	function wfAutoincrementHookVariables( &$wgVariableIDs ) {
		$wgVariableIDs[] = 'autoincrement';

		return true;
	}

	function wfAutoincrementHookSwitch( Parser $parser, &$varCache, &$index, &$ret ) {
		if ( $index === 'autoincrement' )
			$ret = ++$this->mCount; // No formatNum() just like url autonumbering

		return true;
	}
}

new Autoincrement;

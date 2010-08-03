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
	'name' => 'Autoincrement',
	'description' => 'a variable hook that adds an autoincrementing variable, <nowiki>{{AUTOINCREMENT}}</nowiki>',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Autoincrement',
	'svn-date' => '$LastChangedDate: 2008-10-04 11:51:52 +0200 (sob, 04 paź 2008) $',
	'svn-revision' => '$LastChangedRevision: 41637 $',
);

class Autoincrement {
	var $mCount;
	
	function Autoincrement() {
		global $wgHooks;
		
		$this->mCount = 0;
		
		$wgHooks['MagicWordwgVariableIDs'][] = array( $this, 'wfAutoincrementHookVariables' );
		$wgHooks['LanguageGetMagic'][] = array( $this, 'wfAutoincrementHookRaw' );
		$wgHooks['ParserGetVariableValueSwitch'][] = array( $this, 'wfAutoincrementHookSwitch' );
	}
	
	function wfAutoincrementHookVariables( &$wgVariableIDs ) {
		$wgVariableIDs[] = 'autoincrement';

		return true;
	}
	
	function wfAutoincrementHookRaw( &$raw ) {
		$raw['autoincrement'] = array( 0, 'AUTOINCREMENT' );

		return true;
	}

	function wfAutoincrementHookSwitch( &$parser, &$varCache, &$index, &$ret ) {
		if ( $index === 'autoincrement' )
			$ret = ++$this->mCount; // No formatNum() just like url autonumbering
	
		return true;
	}
}

new Autoincrement;

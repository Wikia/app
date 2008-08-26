<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2006, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfSyntaxHook';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Syntax',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'description' => 'adds a <code>&lt;syntax&gt;</code> parser hook for highlighting'
);

function wfSyntaxHook() {
	wfUsePHP( 5.1 );
	wfUseMW( '1.6alpha' );
	
	class SyntaxHook {
		public function __construct() {
			$this->setHook();
		}
		
		private function setHook() {
			global $wgParser;

			$wgParser->setHook( 'syntax', array( $this, 'hook' ) );
		}

		public function hook( $in, array $argv ) {
			$in = ltrim( $in, "\n" );
			$syntax = new Syntax( $in );

			return $syntax->getOut();
		}
	}
	
	new SyntaxHook;
}

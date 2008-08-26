<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page sample that can be included on a wikipage like
 * {{Special:Inc}} as well as being accessed on [[Special:Inc]]
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfIncludable';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Includable',
	'description' => 'a sample includable Special Page',
	'author' => 'Ævar Arnfjörð Bjarmason'
);
	

function wfIncludable() {
	global $IP, $wgMessageCache;

	$wgMessageCache->addMessage( 'includable', 'Includable' );
	
	require_once "$IP/includes/SpecialPage.php";
	class SpecialIncludable extends SpecialPage {
		/**
		 * Constructor
		 */
		function SpecialIncludable() {
			SpecialPage::SpecialPage( 'Includable' );
			$this->includable( true );
		}

		/**
		 * main()
		 */
		function execute( $par = null ) {
			global $wgOut;
			
			if ( $this->including() )
				$out = "I'm being included";
			else {
				$out = "I'm being viewed as a Special Page";
				$this->setHeaders();
			}

			$wgOut->addHtml( $out );
		}
	}
	
	SpecialPage::addPage( new SpecialIncludable );
}

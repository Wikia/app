<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * A Special Page sample that can be included on a wikipage like
 * {{Special:Includable}} as well as being accessed on [[Special:Includable]]
 *
 * @file
 * @ingroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @author Niklas Laxström
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Includable',
	'description' => 'a sample includable Special Page',
	'author' => 'Ævar Arnfjörð Bjarmason'
);

$wgSpecialPages['Includable'] = 'SpecialIncludable';

// See FourFileTemplate how to do i18n
//$wgExtensionMessagesFiles['Includable'] = dirname( __FILE__ ) . '/Includable.i18n.php';

class SpecialIncludable extends IncludableSpecialPage {
	/**
		* Constructor
		*/
	function __construct() {
		parent::__construct( 'Includable' );
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

		$wgOut->addWikiText( $out );
	}
}
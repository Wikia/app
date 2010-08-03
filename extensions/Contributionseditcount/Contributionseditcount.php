<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Display an edit count at the top of Special:Contributions
 *
 * @addtogroup Extensions
 *
 * @bug 1725
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfContributionseditcount';
$wgExtensionCredits['other'][] = array(
	'name' => 'Contributionseditcount',
	'svn-date' => '$LastChangedDate: 2008-05-06 13:59:58 +0200 (wto, 06 maj 2008) $',
	'svn-revision' => '$LastChangedRevision: 34306 $',
	'description' => 'Displays an edit count on Special:Contributions',
	'descriptionmsg' => 'contributionseditcount-desc',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Contributionseditcount',
);

$wgExtensionMessagesFiles['Contributionseditcount'] = dirname( __FILE__ ) . '/Contributionseditcount.i18n.php';

function wfContributionseditcount() {

	wfUsePHP( 5.0 );
	wfUseMW( '1.6alpha' );

	class Contributionseditcount {

		public function __construct() {
			global $wgHooks;
			$wgHooks['SpecialContributionsBeforeMainOutput'][] = array( &$this, 'hook' );
		}

		public function hook( $uid ) {
			global $wgOut, $wgLang;
			if ( $uid != 0 )
				wfLoadExtensionMessages( 'Contributionseditcount' );
				$wgOut->addWikiText( wfMsg( 'contributionseditcount', $wgLang->formatNum( User::edits( $uid ) ) ) );
			return true;
		}
	}

	new Contributionseditcount();
}

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
 * @author Chad Horohoe <chad@anyonecanedit.org>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Contributionseditcount',
	'description' => 'Displays an edit count on Special:Contributions',
	'descriptionmsg' => 'contributionseditcount-desc',
	'author' => array( 'Ævar Arnfjörð Bjarmason', 'Chad Horohoe' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:Contributionseditcount',
);
$wgExtensionMessagesFiles['Contributionseditcount'] = dirname( __FILE__ ) . '/Contributionseditcount.i18n.php';
$wgHooks['SpecialContributionsBeforeMainOutput'][] = 'wfContributionseditcount';

function wfContributionseditcount( $uid ) {
	if ( $uid != 0 ) {
		global $wgOut, $wgLang;
		wfLoadExtensionMessages( 'Contributionseditcount' );
		$wgOut->addWikiText( wfMsgExt( 'contributionseditcount', array( 'parsemag' ),
						$wgLang->formatNum( User::edits( $uid ) ),
						User::whoIs( $uid ) ) );
	}
	return true;
}

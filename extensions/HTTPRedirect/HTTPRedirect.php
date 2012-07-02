<?php
/**
 * An extension to make the wiki issue HTTP redirects rather than wiki redirects
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'HTTP redirect',
	'description' => 'A hook to make the wiki issue HTTP redirects rather than wiki redirects',
	'author' => 'Ævar Arnfjörð Bjarmason',
);

$wgHooks['ArticleViewRedirect'][] = 'efRedirectHook';

function efRedirectHook( Article &$article ) {
	global $wgOut;

	$wgOut->redirect( $article->getTitle()->escapeFullURL(), 302 );

	return false;
}
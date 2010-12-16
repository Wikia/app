<?php
/**
 * An extension that adds a purge tab on each page
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Purge',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Purge',
	'description' => 'Adds a purge tab on all normal pages and bypasses the purge check for anonymous users allowing for quick purging of the cache',
	'descriptionmsg' => 'purge-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Purge'] = $dir . 'Purge.i18n.php';

class PurgeAction {
	public static function init() {
		global $wgHooks;

		$wgHooks['SkinTemplateContentActions'][] = 'PurgeAction::contentHook';
		#$wgHooks['ArticlePurge'][] = 'PurgeAction::purgeHook';
	}
		
	public static function contentHook( array &$content_actions ) {
		global $wgRequest, $wgTitle;

		if ( $wgTitle->getNamespace() !== NS_SPECIAL ) {
			$action = $wgRequest->getText( 'action' );

			wfLoadExtensionMessages( 'Purge' );

			$content_actions['purge'] = array(
				'class' => $action === 'purge' ? 'selected' : false,
				'text' => wfMsg( 'purge' ),
				'href' => $wgTitle->getLocalUrl( 'action=purge' )
			);
		}

		return true;
	}

	public static function purgeHook( Article &$article ) {
		return false;
	}
}

PurgeAction::init();
<?php
/**
 * An extension that adds a tidy tab on each page
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'TidyTab',
	'version'        => '1.1',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:TidyTab',
	'author'         => 'Ævar Arnfjörð Bjarmason',
	'descriptionmsg' => 'tidy-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['tidy'] = $dir . 'Tidy.i18n.php';

$wgHooks['SkinTemplateNavigation::Universal'][] = 'TidyAction::tidyHook';
$wgHooks['UnknownAction'][] = 'TidyAction::action';

class TidyAction {

	public static function tidyHook( $skin, array &$content_actions ) {
		global $wgRequest, $wgUseTidy;

		$title = $skin->getTitle();
		$action = $wgRequest->getText( 'action' );

		if ( $title->getNamespace() !== NS_SPECIAL ) {
			if ( $action === 'tidy' || $action === 'untidy' ) {
				self::setTidy( $title, $content_actions, $action, $action === 'tidy' );
			} elseif ( $wgUseTidy ) {
				self::setTidy( $title, $content_actions, $action, false );
			} else {
				self::setTidy( $title, $content_actions, $action, true );
			}
		}

		return true;
	}

	private static function setTidy( $title, array &$content_actions, $action, $tidy ) {
		if ( $tidy )
			$content_actions['actions']['tidy'] = array(
				'class' => $action === 'tidy' ? 'selected' : false,
				'text' => wfMsg( 'tidy' ),
				'href' => $title->getLocalUrl( 'action=tidy' )
			);
		else
			$content_actions['actions']['untidy'] = array(
				'class' => $action === 'untidy' ? 'selected' : false,
				'text' => wfMsg( 'untidy' ),
				'href' => $title->getLocalUrl( 'action=untidy' )
			);
	}

	public static function action( $action, Article $article ) {
		global $wgUseTidy;

		if ( $action === 'tidy' || $action === 'untidy' )
			$wgUseTidy = $action === 'tidy';

		$article->purge();

		return false;
	}
}

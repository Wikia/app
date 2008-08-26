<?php
/**
 * An extension that adds a tidy tab on each page
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfTidy';
$wgExtensionCredits['other'][] = array(
	'name'           => 'TidyTab',
	'version'        => '1.1',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:TidyTab',
	'author'         => 'Ævar Arnfjörð Bjarmason',
	'description'    => 'Adds a tidy or untidy tab (depending on $wgUseTidy) on normal pages allowing for overriding the global HTML tidy setting for a single view',
	'descriptionmsg' => 'tidy-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['tidy'] = $dir . 'Tidy.i18n.php';

function wfTidy() {
	wfUsePHP( 5.1 );
	wfUseMW( '1.6alpha' );

	class TidyAction {
		public function __construct() {
			global $wgUseTidy, $wgHooks;
			wfLoadExtensionMessages( 'tidy' );

			$wgHooks['SkinTemplateContentActions'][] = array( &$this, 'tidyHook' );
			$wgHooks['UnknownAction'][] = array( &$this, 'action' );
		}

		public function tidyHook( array &$content_actions ) {
			global $wgRequest, $wgUseTidy, $wgTitle;

			$action = $wgRequest->getText( 'action' );

			if ( $wgTitle->getNamespace() !== NS_SPECIAL )
				if ( $action === 'tidy' || $action === 'untidy' )
					self::setTidy( $content_actions, $action, $action === 'tidy' );
				else if ( $wgUseTidy )
					self::setTidy( $content_actions, $action, false );
				else
					self::setTidy( $content_actions, $action, true );

			return true;
		}

		private static function setTidy( array &$content_actions, $action, $tidy ) {
			global $wgTitle;

			if ( $tidy )
				$content_actions['tidy'] = array(
					'class' => $action === 'tidy' ? 'selected' : false,
					'text' => wfMsg( 'tidy' ),
					'href' => $wgTitle->getLocalUrl( 'action=tidy' )
				);
			else
				$content_actions['untidy'] = array(
					'class' => $action === 'untidy' ? 'selected' : false,
					'text' => wfMsg( 'untidy' ),
					'href' => $wgTitle->getLocalUrl( 'action=untidy' )
				);
		}

		public static function action( $action, Article &$article ) {
			global $wgUseTidy;

			if ( $action === 'tidy' || $action === 'untidy' )
				$wgUseTidy = $action === 'tidy';

			$article->purge();

			return false;
		}
	}

	// Establish a singleton.
	new TidyAction;
}

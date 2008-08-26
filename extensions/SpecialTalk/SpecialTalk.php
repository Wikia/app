<?php
if ( ! defined( 'MEDIAWIKI' ) ) die();
/**
 * A hook that adds a talk tab to Special Pages
 *
 * @addtogroup Extensions
 *
 * @bug 4078
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
$wgExtensionFunctions[] = 'wfSpecialTalk';
$wgExtensionCredits['other'][] = array(
	'name' => 'Special talk',
	'description' => 'Adds a talk tab to Special Pages',
	'author' => 'Ævar Arnfjörð Bjarmason'
);

function wfSpecialTalk() {
	wfUsePHP( 5.1 );
	wfUseMW( '1.6alpha' );
	
	class SpecialTalk {
		public function __construct() {
			global $wgHooks;

			$wgHooks['SkinTemplateBuildContentActionUrlsAfterSpecialPage'][] = array( &$this, 'SpecialTalkHook' );
		}

		public function SpecialTalkHook( SkinTemplate &$skin_template, array &$content_actions ) {
			global $wgTitle;

			$title = Title::makeTitle( NS_PROJECT_TALK, $skin_template->mTitle->getText() );

			$content_actions['talk'] = $skin_template->tabAction(
				$title,
				// msg
				'talk',
				// selected
				false,
				// &query=
				'',
				// check existance
				true
			);
			
			return true;
		}
	}

	// Establish a singleton.
	new SpecialTalk;
}

<?php
if ( ! defined( 'MEDIAWIKI' ) ) die();
/**
 * A hook that adds a talk tab to Special Pages
 *
 * @file
 * @ingroup Extensions
 *
 * @bug 4078
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'SpecialTalk',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SpecialTalk',
	'version' => '1.0',
	'descriptionmsg' => 'specialtalk-desc',
	'description' => 'Adds a talk tab to Special Pages',
	'author' => 'Ævar Arnfjörð Bjarmason'
);

$dir = dirname( __FILE__ ) . '/';

// Extension messages.
$wgExtensionMessagesFiles['SpecialTalk'] =  $dir . 'SpecialTalk.i18n.php';

$wgHooks['SkinTemplateBuildContentActionUrlsAfterSpecialPage'][] = 'wfSpecialTalkHook';

function wfSpecialTalkHook( SkinTemplate &$skin_template, array &$content_actions ) {
	$title = Title::makeTitle( NS_PROJECT_TALK, $skin_template->getTitle()->getText() );

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

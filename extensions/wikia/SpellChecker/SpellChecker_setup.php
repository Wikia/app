<?php

/**
 * SpellChecker
 *
 * Provides spell checking interface for enchant PHP module.
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/SpellChecker/SpellChecker_setup.php");
 */
$wgExtensionCredits['other'][] = array(
	'name' => 'Spell Checker',
	'version' => '0.1',
	'author' => 'Maciej Brencz',
	'description' => 'Provides spell checking interface for enchant PHP module',
	'descriptionmsg' => 'spellchecker-desc',
);

$dir = dirname(__FILE__);

// i18n
$wgExtensionMessagesFiles['SpellChecker'] = $dir . '/SpellChecker.i18n.php';

// classes
$wgAutoloadClasses['SpellChecker'] = $dir . '/SpellChecker.class.php';
$wgAutoloadClasses['SpellCheckerAjax'] = $dir . '/SpellCheckerAjax.class.php';
$wgAutoloadClasses['SpellCheckerDictionary'] = $dir . '/SpellCheckerDictionary.class.php';
$wgAutoloadClasses['SpellCheckerInfoSpecial'] = $dir . '/SpellCheckerInfoSpecial.class.php';
$wgAutoloadClasses['SpellCheckerService'] = $dir . '/SpellCheckerService.class.php';

// special page
$wgSpecialPages['SpellCheckerInfo'] = 'SpellCheckerInfoSpecial';

// hooks
$wgHooks['RTEAddGlobalVariablesScript'][] = 'SpellChecker::onRTEAddGlobalVariablesScript';
$wgHooks['GetPreferences'][] = 'SpellChecker::onGetPreferences';

$wgAjaxExportList[] = 'SpellCheckerAjax';

function SpellCheckerAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('SpellCheckerAjax', $method)) {
		wfProfileIn(__METHOD__);

		$data = SpellCheckerAjax::$method();

		// send array as JSON
		$json = json_encode($data);
		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');

		wfProfileOut(__METHOD__);
		return $response;
	}
}

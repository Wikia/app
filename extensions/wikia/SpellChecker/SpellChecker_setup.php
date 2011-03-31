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

$wgExtensionFunctions[] = 'SpellCheckerSetup';

function SpellCheckerSetup() {
        $dir = dirname(__FILE__);

	// WikiaApp
	$app = WF::build('App');

	// i18n
	$app->registerExtensionMessageFile('SpellChecker', $dir . '/SpellChecker.i18n.php' );

	// classes
	$app->registerClass('SpellChecker', $dir . '/SpellChecker.class.php');
	$app->registerClass('SpellCheckerAjax', $dir . '/SpellCheckerAjax.class.php');
	$app->registerClass('SpellCheckerDictionary', $dir . '/SpellCheckerDictionary.class.php');
	$app->registerClass('SpellCheckerInfoSpecial', $dir . '/SpellCheckerInfoSpecial.class.php');
	$app->registerClass('SpellCheckerService', $dir . '/SpellCheckerService.class.php');

	WF::addClassConstructor('SpellChecker', array('app' => $app));

	// special page
	$app->registerSpecialPage('SpellCheckerInfo', 'SpellCheckerInfoSpecial');

	// hooks
	$app->registerHook('RTEAddGlobalVariablesScript', 'SpellChecker', 'onRTEAddGlobalVariablesScript');
	$app->registerHook('GetPreferences', 'SpellChecker', 'onGetPreferences');
}

$wgAjaxExportList[] = 'SpellCheckerAjax';

function SpellCheckerAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('SpellCheckerAjax', $method)) {
		wfProfileIn(__METHOD__);

		$data = SpellCheckerAjax::$method();

		// send array as JSON
		$json = Wikia::json_encode($data);
		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');

		wfProfileOut(__METHOD__);
		return $response;
	}
}

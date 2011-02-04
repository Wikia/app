<?php

/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-01-31
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

$wgExtensionCredits['special'][] = array(
	'name' => 'Scavenger hunt',
	'version' => '1.0',
	'author' => array(
		'[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'Władysław Bodzek' ),
	'description-msg' => 'scavengerhunt-desc'
);

$dir = dirname(__FILE__);

// WikiaApp
$app = WF::build('App');

// autoloaded classes
$app->registerClass('ScavengerHunt', "$dir/ScavengerHunt.class.php");
$app->registerClass('ScavengerHuntAjax', "$dir/ScavengerHuntAjax.class.php");
$app->registerClass('SpecialScavengerHunt', "$dir/SpecialScavengerHunt.php");
$app->registerClass('ScavengerHuntService', "$dir/data/ScavengerHuntService.class.php");
$app->registerClass('ScavengerHuntGame', "$dir/data/ScavengerHuntGame.class.php");
$app->registerClass('ScavengerHuntGameArticle', "$dir/data/ScavengerHuntGameArticle.class.php");
$app->registerClass('ScavengerHuntGameEntry', "$dir/data/ScavengerHuntGameEntry.class.php");

// hooks
$app->registerHook('MakeGlobalVariablesScript', 'ScavengerHunt', 'onMakeGlobalVariablesScript' );

// i18n
$app->registerExtensionMessageFile('ScavengerHunt', "$dir/ScavengerHunt.i18n.php");

// special page
$app->registerSpecialPage('ScavengerHunt', 'SpecialScavengerHunt');

// constuctors
WF::addClassConstructor( 'ScavengerHuntService', array( 'app' => $app ) );
WF::addClassConstructor( 'ScavengerHuntGame', array( 'app' => $app, 'id' => 0, 'readWrite' => false ) );
WF::addClassConstructor( 'ScavengerHuntGame', array( 'app' => $app, 'row' => null ), 'newFromRow' );
WF::addClassConstructor( 'ScavengerHuntGameEntry', array(), 'newFromRow' );

// XXX: standard MW constructors - needed to be moved to global place
WF::addClassConstructor( 'Title', array(), 'newFromText' );

// Ajax dispatcher
$wgAjaxExportList[] = 'ScavengerHuntAjax';
function ScavengerHuntAjax() {
	global $wgUser, $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('ScavengerHuntAjax', $method)) {
		wfProfileIn(__METHOD__);

		$data = ScavengerHuntAjax::$method();

		if (is_array($data)) {
			// send array as JSON
			$json = Wikia::json_encode($data);
			$response = new AjaxResponse($json);
			$response->setContentType('application/json; charset=utf-8');
		}
		else {
			// send text as text/html
			$response = new AjaxResponse($data);
			$response->setContentType('text/html; charset=utf-8');
		}

		wfProfileOut(__METHOD__);
		return $response;
	}
}
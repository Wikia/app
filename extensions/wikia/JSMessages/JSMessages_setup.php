<?php

/**
 * Adds support for MW messages in JS code
 *
 * @author macbre
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'JSMessages',
	'version' => '1.0',
	'author' => 'Maciej Brencz',
	'description' => 'Adds support for MW messages in JS code',
);

$dir = dirname(__FILE__);

// WikiaApp
$app = WF::build('App');

// classes
$app->registerClass('JSMessages', $dir . '/JSMessages.class.php');

// hooks
$app->registerHook('MakeGlobalVariablesScript', 'JSMessages', 'onMakeGlobalVariablesScript');
$app->registerHook('SkinAfterBottomScripts', 'JSMessages', 'onSkinAfterBottomScripts');

// dispatch AJAX requests
$wgAjaxExportList[] = 'JSMessagesAjax';
function JSMessagesAjax() {
	global $wgRequest;
	wfProfileIn(__METHOD__);

	// get requested packages
	$packages = explode(',', $wgRequest->getVal('packages', ''));

	// get messages from given packages
	$msgs = JSMessages::getInstance()->getPackages($packages);

	// output them as JS object
	$js = 'window.wgMessages = $.extend(window.wgMessages, ' . json_encode($msgs) . ');';

	$response = new AjaxResponse($js);
	$response->setContentType('application/javascript; charset=utf-8');
	$response->setCacheDuration(86400 * 7);

	wfProfileOut(__METHOD__);
	return $response;
}
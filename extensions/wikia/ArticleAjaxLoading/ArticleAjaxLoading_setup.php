<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name' => 'Article Ajax Loading',
	'author' => 'Inez Korczyński'
);

$wgAutoloadClasses['AALModule'] = dirname(__FILE__).'/AALModule.class.php';
$wgHooks['UserLoadFromSession'][] = 'ArticleAjaxLoadinig_UserLoadFromSession';
$wgHooks['MakeGlobalVariablesScript'][] = 'ArticleAjaxLoadinig_addJSVariable';

function ArticleAjaxLoadinig_UserLoadFromSession($user, $result) {
	global $wgRequest, $wgShowAds, $wgDotDisplay;

	if($wgRequest->getVal('mode') == 'AAL') {
		Wikia::setVar( 'OasisEntryModuleName', 'AAL' );
		$user->loadDefaults();
		$result = false;
		$wgShowAds = false;
		$wgDotDisplay = null;
	}

	return true;
}

function ArticleAjaxLoadinig_addJSVariable($vars) {
	global $wgRequest, $wgUser;
	if($wgUser->isLoggedIn()) {
		if($wgRequest->getVal('mode') != 'AAL') {
			$anon = new User();
			if($wgUser->getPageRenderingHash() == $anon->getPageRenderingHash()) {
				$vars['aal'] = $wgUser->getID() % 10;
			}
		}
	}
	return true;
}
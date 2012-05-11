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

$wgAutoloadClasses['AALController'] = dirname(__FILE__).'/AALController.class.php';
$wgHooks['UserLoadFromSession'][] = 'ArticleAjaxLoadinig_UserLoadFromSession';
$wgHooks['MakeGlobalVariablesScript'][] = 'ArticleAjaxLoadinig_addJSVariable';

function ArticleAjaxLoadinig_UserLoadFromSession($user, $result) {
	global $wgRequest, $wgShowAds, $wgDotDisplay;

	if($wgRequest->getVal('mode') == 'AAL') {
		Wikia::setVar( 'OasisEntryControllerName', 'AAL' );
		$user->loadDefaults();
		$result = false;
		$wgShowAds = false;
		$wgDotDisplay = null;
	}

	return true;
}

function ArticleAjaxLoadinig_addJSVariable($vars) {

	// Assign logged-in users to groups
	// G1 - 6% (for this group Article Ajax Loading is enabled)
	// G2 - 6% (control group)
	// G3 - 6% (control group)

	global $wgRequest, $wgUser;
	if($wgUser->isLoggedIn()) {
		if($wgRequest->getVal('mode') != 'AAL') {
			$anon = new User();
			if($wgUser->getPageRenderingHash() == $anon->getPageRenderingHash()) {

				$mod = $wgUser->getID() % 100;

				if($mod >= 1 && $mod <= 20) {
					$vars['aal'] = 'G1';
				} else if($mod >= 21 && $mod <= 40) {
					$vars['aal'] = 'G2';
				} else if($mod >= 41 && $mod <= 60) {
					$vars['aal'] = 'G3';
				}

				if($wgUser->getID() == 51654) {
					$vars['aal'] = 'G1';
				}
			}
		}
	}
	return true;
}

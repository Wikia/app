<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name' => 'A/B testing',
	'author' => 'Christian Williams'
);

$wgHooks['BeforePageDisplay'][] = 'getABtestJSandCSS';

function getABtestJSandCSS() {
	global $wgOut, $wgExtensionsPath, $wgUser, $wgABTests;

	// For testing
	//$wgABTests[] = 'noHistoryBar';

	if (!isset($wgABTests)) {
		return true;
	}

	// If a user logs in add them back to a special group so they are not part of the test
	if ($wgUser->isLoggedIn()) {
		$expire = time() + 12*60*60;  // 12 hours
		setrawcookie("wikia-ab", 'v6/name=loggedin/UA=UA-19473076-33/', $expire, "/", 'wikia.com');
		return true;
	}

	if (in_array('editbutton1', $wgABTests)) {
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/ABtesting/css/editbutton1.scss'));
	}

	if (in_array('editbutton2', $wgABTests)) {
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/ABtesting/css/editbutton2.scss'));
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/ABtesting/js/editbutton2.js"></script>');
	}

	if (in_array('editbutton3', $wgABTests)) {
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/ABtesting/css/editbutton3.scss'));
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/ABtesting/js/editbutton3.js"></script>');
	}

	if (in_array('editbutton4', $wgABTests)) {
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/ABtesting/css/editbutton4.scss'));
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/ABtesting/js/editbutton4.js"></script>');
	}

	if (in_array('editbutton5', $wgABTests)) {
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/ABtesting/css/editbutton5.scss'));
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/ABtesting/js/editbutton5.js"></script>');
	}

	return true;
}

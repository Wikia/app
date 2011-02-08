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
	global $wgOut, $wgExtensionsPath;
	
	// For testing
	//$wgABTests[] = 'editbutton1';
	
	if (!isset($wgABTests)) {
		return true;
	}
	
	if (in_array('editbutton1', $wgABTests)) {
		$wgOut->addStyle(wfGetSassUrl('/extensions/wikia/ABtesting/css/editbutton1.scss'));
	}

	if (in_array('editbutton2', $wgABTests)) {
		$wgOut->addStyle(wfGetSassUrl('/extensions/wikia/ABtesting/css/editbutton2.scss'));
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/ABtesting/js/editbutton2.js"></script>');
	}

	if (in_array('editbutton3', $wgABTests)) {
		$wgOut->addStyle(wfGetSassUrl('/extensions/wikia/ABtesting/css/editbutton3.scss'));
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/ABtesting/js/editbutton3.js"></script>');
	}

	if (in_array('editbutton4', $wgABTests)) {
		$wgOut->addStyle(wfGetSassUrl('/extensions/wikia/ABtesting/css/editbutton4.scss'));
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/ABtesting/js/editbutton4.js"></script>');
	}

	if (in_array('editbutton5', $wgABTests)) {
		$wgOut->addStyle(wfGetSassUrl('/extensions/wikia/ABtesting/css/editbutton5.scss'));
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/ABtesting/js/editbutton5.js"></script>');
	}

	return true;
}

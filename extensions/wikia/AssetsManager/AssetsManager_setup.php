<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name' => 'AssetsManager',
	'author' => 'Inez Korczyński'
);

$dir = dirname(__FILE__).'/';

$wgAutoloadClasses['AssetsConfig'] = $dir.'AssetsConfig.class.php';
$wgAutoloadClasses['AssetsManager'] = $dir.'AssetsManager.class.php';

$wgAjaxExportList[] = 'AssetsManagerEntryPoint';
$wgExtensionFunctions[] = 'AssetsManagerEntrySetup';

function AssetsManagerEntrySetup() {
	$app = F::build('App');
	F::setInstance('AssetsManager', new AssetsManager($app->getGlobal('wgCdnRootUrl'), $app->getGlobal('wgStyleVersion'), $app->getGlobal('wgAllInOne'), $app->getGlobal('wgAllInOne')));
}

function AssetsManagerEntryPoint() {
	global $wgRequest, $wgAutoloadClasses;

	$dir = dirname(__FILE__).'/';

	// Temporary log
	global $wgRequest;
	error_log("Temp log - #1 - AssetsManagerEntryPoint: " . $wgRequest->getFullRequestURL());

	$wgAutoloadClasses['AssetsManagerBaseBuilder'] = $dir.'builders/AssetsManagerBaseBuilder.class.php';
	$wgAutoloadClasses['AssetsManagerOneBuilder'] = $dir.'builders/AssetsManagerOneBuilder.class.php';
	$wgAutoloadClasses['AssetsManagerGroupBuilder'] = $dir.'builders/AssetsManagerGroupBuilder.class.php';
	$wgAutoloadClasses['AssetsManagerSassBuilder'] = $dir.'builders/AssetsManagerSassBuilder.class.php';	
	$wgAutoloadClasses['AssetsManagerServer'] = $dir.'AssetsManagerServer.class.php';
	
	AssetsManagerServer::serve($wgRequest);
	
	exit();
}



<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 *
 * @see https://internal.wikia-inc.com/wiki/AssetsManager
 */

if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name' => 'AssetsManager',
	'author' => 'Inez Korczyński'
);

$dir = dirname(__FILE__).'/';

$wgAutoloadClasses['AssetsManagerBaseBuilder'] = $dir.'builders/AssetsManagerBaseBuilder.class.php';
$wgAutoloadClasses['AssetsManagerOneBuilder'] = $dir.'builders/AssetsManagerOneBuilder.class.php';
$wgAutoloadClasses['AssetsManagerGroupBuilder'] = $dir.'builders/AssetsManagerGroupBuilder.class.php';
$wgAutoloadClasses['AssetsManagerGroupsBuilder'] = $dir.'builders/AssetsManagerGroupsBuilder.class.php';
$wgAutoloadClasses['AssetsManagerSassBuilder'] = $dir.'builders/AssetsManagerSassBuilder.class.php';
$wgAutoloadClasses['AssetsManagerSassesBuilder'] = $dir.'builders/AssetsManagerSassesBuilder.class.php';
$wgAutoloadClasses['AssetsManagerServer'] = $dir.'AssetsManagerServer.class.php';

$wgAutoloadClasses['AssetsManagerController'] = $dir.'AssetsManagerController.class.php';

$wgAjaxExportList[] = 'AssetsManagerEntryPoint';
$wgHooks['MakeGlobalVariablesScript'][] = 'AssetsManager::onMakeGlobalVariablesScript';
$wgHooks['UserLoadFromSession'][] = 'AssetsManagerClearCookie';
$wgHooks['UserGetRights'][] = 'onUserGetRights';

/**
 * Add read right to all am reqest.
 * That is solving problems with Loading Assets
 */
function onUserGetRights( $user, &$aRights ) {
	global $wgRequest;
	if ( $wgRequest->getVal('action') === 'ajax' && $wgRequest->getVal('rs') === 'AssetsManagerEntryPoint' ) {
		$aRights[] = 'read';
	}
	return true;
}

/**
 * @param User $user
 * @param $result
 * @return bool
 */
function AssetsManagerClearCookie( $user, &$result ) {
	global $wgRequest;
	if ( $wgRequest->getVal('action') === 'ajax' && $wgRequest->getVal('rs') === 'AssetsManagerEntryPoint'
			&& !AssetsConfig::isUserDependent( $wgRequest->getVal('oid') ) ) {
		$result = new User();
	}
	return true;
}

function AssetsManagerEntryPoint() {
	global $wgRequest;
	AssetsManagerServer::serve($wgRequest);
	exit();
}

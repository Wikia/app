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
	'author' => 'Inez Korczyński',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AssetsManager',
	'descriptionmsg' => 'assestsmanager-desc',
);

//i18n
$wgExtensionMessagesFiles['AssetsManager'] = __DIR__ . '/i18n/AssetsManager.i18n.php';

$wgAutoloadClasses['AssetsManagerBaseBuilder'] = __DIR__ . '/builders/AssetsManagerBaseBuilder.class.php';
$wgAutoloadClasses['AssetsManagerOneBuilder'] = __DIR__ . '/builders/AssetsManagerOneBuilder.class.php';
$wgAutoloadClasses['AssetsManagerGroupBuilder'] = __DIR__ . '/builders/AssetsManagerGroupBuilder.class.php';
$wgAutoloadClasses['AssetsManagerGroupsBuilder'] = __DIR__ . '/builders/AssetsManagerGroupsBuilder.class.php';
$wgAutoloadClasses['AssetsManagerSassBuilder'] = __DIR__ . '/builders/AssetsManagerSassBuilder.class.php';
$wgAutoloadClasses['AssetsManagerSassesBuilder'] = __DIR__ . '/builders/AssetsManagerSassesBuilder.class.php';

$wgAutoloadClasses['AssetsManagerServer'] = __DIR__ . '/AssetsManagerServer.class.php';

$wgAutoloadClasses['AssetsManagerController'] = __DIR__ . '/AssetsManagerController.class.php';

$wgAjaxExportList[] = 'AssetsManagerEntryPoint';
$wgHooks['MakeGlobalVariablesScript'][] = 'AssetsManager::onMakeGlobalVariablesScript';
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

function AssetsManagerEntryPoint() {
	global $wgRequest;
	AssetsManagerServer::serve($wgRequest);

	wfRunHooks('RestInPeace');
	exit();
}

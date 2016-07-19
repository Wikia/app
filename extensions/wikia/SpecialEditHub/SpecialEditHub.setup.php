<?php

/**
 * EditHub
 *
 * @author Damian Jóźwiak
 * @author Sebastian Marzjan
 * @author Łukasz Konieczny
 * @author Bartosz Bentkowski
 *
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Edit Hub',
	'descriptionmsg' => 'edithub-desc',
	'authors' => array(
		'Damian Jóźwiak',
		'Sebastian Marzjan',
		'Łukasz Konieczny',
		'Bartosz Bentkowski'
	),
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialEditHub'
);

//classes
$wgAutoloadClasses['EditHubController'] = $dir . 'EditHubController.class.php';
$wgAutoloadClasses['EditHubVideosController'] =  $dir . 'EditHubVideosController.class.php';

// hooks
$wgAutoloadClasses['EditHubHooks'] =  $dir . 'hooks/EditHubHooks.class.php';
$wgHooks['MakeGlobalVariablesScript'][] = 'EditHubHooks::onMakeGlobalVariablesScript';

//special page
$wgSpecialPages['EditHub'] = 'EditHubController';
$wgSpecialPageGroups['EditHub'] = 'wikia';

//message files
$wgExtensionMessagesFiles['EditHub'] = $dir . 'EditHub.i18n.php';
JSMessages::registerPackage('EditHub', array('edit-hub-*', 'wikia-hubs-*'));


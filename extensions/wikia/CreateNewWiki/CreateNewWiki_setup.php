<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CreateNewWiki',
	'descriptionmsg' => 'createnewwiki-desc',
	'author' => [
		'Hyun Lim',
		'Krzysztof Krzyżaniak',
		'Piotr Molski',
	],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CreateNewWiki'
);

$dir = __DIR__ . '/';

// class autoloads mappings
$wgAutoloadClasses['CreateNewWikiObfuscate'] = $dir . 'CreateNewWikiObfuscate.class.php';
$wgAutoloadClasses['CreateWikiLocalJob'] = $dir."CreateWikiLocalJob.php";
$wgAutoloadClasses['CreateWiki'] = $dir."/CreateWiki.php";
$wgAutoloadClasses['AutoCreateWiki'] = $dir."/AutoCreateWiki.php";
$wgAutoloadClasses['SpecialCreateNewWiki'] = $dir . 'SpecialCreateNewWiki.class.php';

// Nirvana controllers
$wgAutoloadClasses['CreateNewWikiController'] = $dir . 'CreateNewWikiController.class.php';

// special page mapping
$wgSpecialPages['CreateNewWiki'] = 'SpecialCreateNewWiki';
$wgSpecialPages['CreateWiki'] = 'SpecialCreateNewWiki';

// i18n mapping
$wgExtensionMessagesFiles['AutoCreateWiki'] = $dir . 'AutoCreateWiki.i18n.php';
$wgExtensionMessagesFiles['CreateNewWiki'] = $dir . 'CreateNewWiki.i18n.php';

// permissions
$wgAvailableRights[] = 'createnewwiki';
$wgGroupPermissions['*']['createnewwiki'] = true;
$wgGroupPermissions['staff']['createnewwiki'] = true;

$wgAvailableRights[] = 'createwikilimitsexempt'; // user not bound by creation throttle
$wgGroupPermissions['staff']['createwikilimitsexempt'] = true;

// setup functions
$wgExtensionFunctions[] = 'CreateNewWikiController::setupCreateNewWiki';

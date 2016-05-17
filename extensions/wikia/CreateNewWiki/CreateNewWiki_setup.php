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
$wgAutoloadClasses['CreateWiki'] = $dir."/CreateWiki.php";
$wgAutoloadClasses['CreateWikiChecks'] = $dir."/CreateWikiChecks.php";
$wgAutoloadClasses['SpecialCreateNewWiki'] = $dir . 'SpecialCreateNewWiki.class.php';
$wgAutoloadClasses['CreateNewWikiHooks'] = __DIR__ . '/CreateNewWikiHooks.class.php';

// Tasks related with new wiki creation
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\Task'] = __DIR__ . '/tasks/Task.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\TaskContext'] = __DIR__ . '/tasks/TaskContext.php';

$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\ConfigureCategories'] = __DIR__ . '/tasks/ConfigureCategories.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\ConfigureUsers'] = __DIR__ . '/tasks/ConfigureUsers.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\ConfigureWikiFactory'] = __DIR__ . '/tasks/ConfigureWikiFactory.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\CreateDatabase'] = __DIR__ . '/tasks/CreateDatabase.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\CreateTables'] = __DIR__ . '/tasks/CreateTables.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\ImportStarterData'] = __DIR__ . '/tasks/ImportStarterData.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\PrepareDomain'] = __DIR__ . '/tasks/PrepareDomain.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\SetCustomSettings'] = __DIR__ . '/tasks/SetCustomSettings.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\SetTags'] = __DIR__ . '/tasks/SetTags.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\SetupWikiCities'] = __DIR__ . '/tasks/SetupWikiCities.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\TaskHelper'] = __DIR__ . '/tasks/TaskHelper.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\TaskResult'] = __DIR__ . '/tasks/TaskResult.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\TaskRunner'] = __DIR__ . '/tasks/TaskRunner.php';

// Nirvana controllers
$wgAutoloadClasses['CreateNewWikiController'] = $dir . 'CreateNewWikiController.class.php';

// special page mapping
$wgSpecialPages['CreateNewWiki'] = 'SpecialCreateNewWiki';

// i18n mapping
$wgExtensionMessagesFiles['CreateWikiChecks'] = $dir . 'CreateWikiChecks.i18n.php';
$wgExtensionMessagesFiles['CreateNewWiki'] = $dir . 'CreateNewWiki.i18n.php';
$wgExtensionMessagesFiles['CreateNewWikiAlias'] = $dir . 'CreateNewWiki.alias.php';

// setup functions
$wgExtensionFunctions[] = 'CreateNewWikiController::setupCreateNewWiki';

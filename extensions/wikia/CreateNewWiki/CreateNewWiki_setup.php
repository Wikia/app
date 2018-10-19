<?php

$GLOBALS['wgExtensionCredits']['specialpage'][] = array(
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
$GLOBALS['wgAutoloadClasses']['CreateNewWikiObfuscate'] = $dir . 'CreateNewWikiObfuscate.class.php';
$GLOBALS['wgAutoloadClasses']['CreateWikiTask'] = $dir."/CreateWikiTask.php";
$GLOBALS['wgAutoloadClasses']['CreateWikiChecks'] = $dir."/CreateWikiChecks.php";
$GLOBALS['wgAutoloadClasses']['SpecialCreateNewWiki'] = $dir . 'SpecialCreateNewWiki.class.php';
$GLOBALS['wgAutoloadClasses']['CreateNewWikiHooks'] = __DIR__ . '/CreateNewWikiHooks.php';

// Tasks related with new wiki creation
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\Task'] = __DIR__ . '/tasks/Task.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\TaskContext'] = __DIR__ . '/tasks/TaskContext.php';

$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\ReplicationWaitHelper'] = __DIR__ . '/tasks/ReplicationWaitHelper.php';

$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\ConfigureCategories'] = __DIR__ . '/tasks/ConfigureCategories.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\ConfigureUsers'] = __DIR__ . '/tasks/ConfigureUsers.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\ConfigureWikiFactory'] = __DIR__ . '/tasks/ConfigureWikiFactory.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\CreateDatabase'] = __DIR__ . '/tasks/CreateDatabase.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\CreateTables'] = __DIR__ . '/tasks/CreateTables.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\EnableDiscussionsTask'] = __DIR__ . '/tasks/EnableDiscussionsTask.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\ImportStarterData'] = __DIR__ . '/tasks/ImportStarterData.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\PrepareDomain'] = __DIR__ . '/tasks/PrepareDomain.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\SetupWikiCities'] = __DIR__ . '/tasks/SetupWikiCities.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\StartPostCreationTasks'] = __DIR__ . '/tasks/StartPostCreationTasks.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\TaskHelper'] = __DIR__ . '/tasks/TaskHelper.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\TaskResult'] = __DIR__ . '/tasks/TaskResult.php';
$GLOBALS['wgAutoloadClasses']['Wikia\\CreateNewWiki\\Tasks\\TaskRunner'] = __DIR__ . '/tasks/TaskRunner.php';

$GLOBALS['wgAutoloadClasses']['BulkRevisionImporter'] = __DIR__ . '/classes/BulkRevisionImporter.php';

// Nirvana controllers
$GLOBALS['wgAutoloadClasses']['CreateNewWikiController'] = $dir . 'CreateNewWikiController.class.php';

// special page mapping
$GLOBALS['wgSpecialPages']['CreateNewWiki'] = 'SpecialCreateNewWiki';

// i18n mapping
$GLOBALS['wgExtensionMessagesFiles']['CreateNewWiki'] = $dir . 'CreateNewWiki.i18n.php';
$GLOBALS['wgExtensionMessagesFiles']['CreateNewWikiAlias'] = $dir . 'CreateNewWiki.alias.php';

// setup functions
$GLOBALS['wgExtensionFunctions'][] = 'CreateNewWikiController::setupCreateNewWiki';

$GLOBALS['wgHooks']['MakeGlobalVariablesScript'][] = '\CreateNewWikiHooks::onMakeGlobalVariablesScript';

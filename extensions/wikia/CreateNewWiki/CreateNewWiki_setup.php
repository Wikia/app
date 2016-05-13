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
$wgAutoloadClasses['CreateWikiChecks'] = $dir."/CreateWikiChecks.php";


// Tasks related with new wiki creation
$wgAutoloadClasses['ConfigureCategories'] = __DIR__ . '/tasks/ConfigureCategories.php';
$wgAutoloadClasses['ConfigureUsers'] = __DIR__ . '/tasks/ConfigureUsers.php';
$wgAutoloadClasses['ConfigureWikiFactory'] = __DIR__ . '/tasks/ConfigureWikiFactory.php';
$wgAutoloadClasses['CreateDatabase'] = __DIR__ . '/tasks/CreateDatabase.php';
$wgAutoloadClasses['CreateTables'] = __DIR__ . '/tasks/CreateTables.php';
$wgAutoloadClasses['ImportStarterData'] = __DIR__ . '/tasks/ImportStarterData.php';
$wgAutoloadClasses['PrepareDomain'] = __DIR__ . '/tasks/PrepareDomain.php';
$wgAutoloadClasses['SetCustomSettings'] = __DIR__ . '/tasks/SetCustomSettings.php';
$wgAutoloadClasses['SetTags'] = __DIR__ . '/tasks/SetTags.php';
$wgAutoloadClasses['SetupWikiCities'] = __DIR__ . '/tasks/SetupWikiCities.php';
$wgAutoloadClasses['Task'] = __DIR__ . '/tasks/Task.php';
$wgAutoloadClasses['TaskContext'] = __DIR__ . '/tasks/TaskContext.php';
$wgAutoloadClasses['TaskHelper'] = __DIR__ . '/tasks/TaskHelper.php';
$wgAutoloadClasses['TaskResult'] = __DIR__ . '/tasks/TaskResult.php';
$wgAutoloadClasses['TaskRunner'] = __DIR__ . '/tasks/TaskRunner.php';

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

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
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\EnableDiscussionsTask'] = __DIR__ . '/tasks/EnableDiscussionsTask.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\ImportStarterData'] = __DIR__ . '/tasks/ImportStarterData.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\PrepareDomain'] = __DIR__ . '/tasks/PrepareDomain.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\SetCustomSettings'] = __DIR__ . '/tasks/SetCustomSettings.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\SetTags'] = __DIR__ . '/tasks/SetTags.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\SetupWikiCities'] = __DIR__ . '/tasks/SetupWikiCities.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\StartPostCreationTasks'] = __DIR__ . '/tasks/StartPostCreationTasks.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\TaskHelper'] = __DIR__ . '/tasks/TaskHelper.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\TaskResult'] = __DIR__ . '/tasks/TaskResult.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Tasks\\TaskRunner'] = __DIR__ . '/tasks/TaskRunner.php';

// Validation logic
$wgAutoloadClasses['Wikia\\CreateNewWiki\\UserValidator'] = __DIR__ . '/classes/validation/UserValidator.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\RequestValidator'] = __DIR__ . '/classes/validation/RequestValidator.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\UserValidatorProxy'] = __DIR__ . '/classes/validation/UserValidatorProxy.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\ValidationException'] = __DIR__ . '/classes/validation/ValidationException.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\EmailNotConfirmedException'] = __DIR__ . '/classes/validation/EmailNotConfirmedException.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\MissingParamsException'] = __DIR__ . '/classes/validation/MissingParamsException.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\NotLoggedInException'] = __DIR__ . '/classes/validation/NotLoggedInException.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\RateLimitedException'] = __DIR__ . '/classes/validation/RateLimitedException.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\TorNodeException'] = __DIR__ . '/classes/validation/TorNodeException.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\UserBlockedException'] = __DIR__ . '/classes/validation/UserBlockedException.php';

// Nirvana controllers
$wgAutoloadClasses['CreateNewWikiController'] = $dir . 'CreateNewWikiController.class.php';

// special page mapping
$wgSpecialPages['CreateNewWiki'] = 'SpecialCreateNewWiki';

// i18n mapping
$wgExtensionMessagesFiles['CreateWikiChecks'] = $dir . 'CreateWikiChecks.i18n.php';
$wgExtensionMessagesFiles['CreateNewWiki'] = $dir . 'CreateNewWiki.i18n.php';
$wgExtensionMessagesFiles['CreateNewWikiAlias'] = $dir . 'CreateNewWiki.alias.php';

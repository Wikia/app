<?php

$GLOBALS['wgExtensionCredits']['other'][] = [
	'name' => 'Phalanx II',
	'description' => 'Integrated spam control mechanism',
	'descriptionmsg' => 'phalanx-desc',
	'author' => [
		'[http://community.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'[http://community.wikia.com/wiki/User:Macbre Maciej Brencz]',
		'[http://community.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]',
		'Bartek Łapiński',
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]',
		'Władysław Bodzek',
		'Piotr Molski (moli@wikia-inc.com)',
		'Krzysztof Krzyżaniak (eloy@wikia-inc.com)',
		'Maciej Szumocki (szumo@wikia-inc.com)',
	],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PhalanxII',
];

$classes = [
	/* models */
	'Phalanx' => __DIR__ . '/classes/Phalanx.class.php',
	'PhalanxModel' => __DIR__ . '/models/PhalanxModel.php',
	'PhalanxUserModel' => __DIR__ . '/models/PhalanxUserModel.php',
	'PhalanxContentModel' => __DIR__ . '/models/PhalanxContentModel.php',
	'PhalanxTextModel' => __DIR__ . '/models/PhalanxTextModel.php',

	'PhalanxService' => __DIR__ . '/services/PhalanxService.php',
	'DefaultPhalanxService' => __DIR__ . '/services/DefaultPhalanxService.php',
	'DesperatePhalanxService' => __DIR__ . '/services/DesperatePhalanxService.php',

	'PhalanxServiceFactory' => __DIR__ . '/services/PhalanxServiceFactory.php',

	'PhalanxServiceException' => __DIR__ . '/services/PhalanxServiceException.php',
	'RegexValidationException' => __DIR__ . '/services/RegexValidationException.php',

	'PhalanxBlockInfo' => __DIR__ . '/services/PhalanxBlockInfo.php',
	'PhalanxMatchParams' => __DIR__ . '/services/PhalanxMatchParams.php',
	'PhalanxHttpClient' => __DIR__ . '/services/PhalanxHttpClient.php',

	/* hooks */
	'PhalanxUserBlock' => __DIR__ . '/hooks/PhalanxUserBlock.class.php',
	'PhalanxContentBlock' => __DIR__ . '/hooks/PhalanxContentBlock.class.php',
	'PhalanxTitleBlock' => __DIR__ . '/hooks/PhalanxTitleBlock.class.php',
	'PhalanxAnswersBlock' => __DIR__ . '/hooks/PhalanxAnswersBlock.class.php',
	'PhalanxWikiCreationBlock' => __DIR__ . '/hooks/PhalanxWikiCreationBlock.class.php',
	'PhalanxHooks' => __DIR__ . '/hooks/PhalanxHooks.class.php',
];

foreach ( $classes as $className => $classPath ) {
	$GLOBALS['wgAutoloadClasses'][$className] = $classPath;
}

$phalanxHooks = [
	'PhalanxUserBlock' => [
		'GetBlockedStatus' => 'blockCheck',
		'UserCanSendEmail' => 'userCanSendEmail',
		'AbortNewAccount' => 'abortNewAccount',
		'cxValidateUserName' => 'validateUserName',
	],
	'PhalanxContentBlock' => [
		'SpecialMovepageBeforeMove' => 'beforeMove',
		'EditFilter' => 'editFilter',
		'AbortMove' => 'abortMove',
		'EditContent' => 'editContent',
		'CheckContent' => 'checkContent',
		'APIEditBeforeSave' => 'filterAPIEditBeforeSave',
		'FileUploadSummaryCheck' => 'checkContent',
	],
	'PhalanxTitleBlock' => [
		'EditFilter' => 'editFilter',
		'CreateDefaultQuestionPageFilter' => 'checkTitle',
		'CreatePageTitleCheck' => 'checkTitle',
		'PageTitleFilter' => 'pageTitleFilter',
		'UploadVerification' => 'checkFileTitle',
	],
	'PhalanxAnswersBlock' => [
		'CreateDefaultQuestionPageFilter' => 'badWordsTest',
	],
	'PhalanxWikiCreationBlock' => [
		'CreateWikiChecks::checkBadWords' => 'isAllowedText',
	],
	'PhalanxHooks' => [
		'ContributionsToolLinks' => 'loadLinks',
		'SpamFilterCheck' => 'onSpamFilterCheck',
		'AfterFormatPermissionsErrorMessage' => 'onAfterFormatPermissionsErrorMessage',
		// temp logging for PLATFORM-317
		'GetBlockedStatus' => 'onGetBlockedStatus',
		'ContributionsLogEventsList' => 'onContributionsLogEventsList',
	],
];

foreach ( $phalanxHooks as $class => $hooks ) {
	foreach ( $hooks as $name => $method ) {
		$GLOBALS['wgHooks'][$name][] = "$class::$method";
	}
}

$GLOBALS['wgExtensionMessagesFiles']['Phalanx'] = __DIR__ . '/Phalanx.i18n.php';

$GLOBALS['wgLogTypes'][] = 'phalanx';
$GLOBALS['wgLogTypes'][] = 'phalanxemail';

$GLOBALS['wgLogNames']['phalanx'] = 'phalanx-rule-log-name';
$GLOBALS['wgLogNames']['phalanxemail'] = 'phalanx-email-rule-log-name';

$GLOBALS['wgLogHeaders']['phalanx'] = 'phalanx-rule-log-header';
$GLOBALS['wgLogHeaders']['phalanxemail'] = 'phalanx-email-rule-log-header';

$GLOBALS['wgLogRestrictions']['phalanx'] = 'phalanx';
$GLOBALS['wgLogRestrictions']['phalanxemail'] = 'phalanxemailblock';

$GLOBALS['wgLogActions']['phalanx/add'] = 'phalanx-rule-log-add';
$GLOBALS['wgLogActions']['phalanx/edit'] = 'phalanx-rule-log-edit';
$GLOBALS['wgLogActions']['phalanx/delete'] = 'phalanx-rule-log-delete';
$GLOBALS['wgLogActions']['phalanxemail/add'] = 'phalanx-rule-log-add';
$GLOBALS['wgLogActions']['phalanxemail/edit'] = 'phalanx-rule-log-edit';
$GLOBALS['wgLogActions']['phalanxemail/delete'] = 'phalanx-rule-log-delete';

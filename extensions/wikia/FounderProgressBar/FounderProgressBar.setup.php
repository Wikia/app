<?php
$GLOBALS['wgExtensionCredits']['other'][] = [
	'path' => __FILE__,
	'name' => 'FounderProgressBar',
	'author' => 'Wikia',
	'descriptionmsg' => 'founderprogressbar-credits',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FounderProgressBar',
];

//Autoload
$GLOBALS['wgAutoloadClasses']['FounderProgressBarController'] = __DIR__ . '/FounderProgressBarController.class.php';
$GLOBALS['wgAutoloadClasses']['FounderProgressBarHooks'] = __DIR__ . '/FounderProgressBarHooks.class.php';

$GLOBALS['wgAutoloadClasses']['BonusTasksHelperTrait'] = __DIR__ . '/BonusTasksHelperTrait.php';
$GLOBALS['wgAutoloadClasses']['FounderProgressBarModel'] = __DIR__ . '/FounderProgressBarModel.php';
$GLOBALS['wgAutoloadClasses']['FounderTask'] = __DIR__ . '/FounderTask.php';
$GLOBALS['wgAutoloadClasses']['UpdateFounderProgressTask'] = __DIR__ . '/UpdateFounderProgressTask.php';

// I18N
$wgExtensionMessagesFiles['FounderProgressBar'] =__DIR__ . '/FounderProgressBar.i18n.php';

// Hooks
$GLOBALS['wgHooks']['ArticleSaveComplete'][] = 'FounderProgressBarHooks::onArticleSaveComplete';
$GLOBALS['wgHooks']['UploadComplete'][] = 'FounderProgressBarHooks::onUploadComplete';
$GLOBALS['wgHooks']['UploadWordmarkComplete'][] = 'FounderProgressBarHooks::onUploadWordmarkComplete';
$GLOBALS['wgHooks']['AddNewAccount'][] = 'FounderProgressBarHooks::onAddNewAccount';
$GLOBALS['wgHooks']['AfterVideoFileUploaderUpload'][] = 'FounderProgressBarHooks::onAfterVideoFileUploaderUpload';

// On wiki creation or WikiFactory enable add db columns
$GLOBALS['wgHooks']['CreateWikiLocalJob-complete'][] = "FounderProgressBarHooks::onWikiCreation";


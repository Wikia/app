<?php
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'FounderProgressBar',
	'author'         => 'Wikia',
	'descriptionmsg' => 'founderprogressbar-credits',
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FounderProgressBar'
);

$dir = dirname(__FILE__).'/';

//Autoload
$wgAutoloadClasses['FounderProgressBarController'] =  $dir . '/FounderProgressBarController.class.php';
$wgAutoloadClasses['FounderProgressBarHooks'] =  $dir . '/FounderProgressBarHooks.class.php';

// I18N
$wgExtensionMessagesFiles['FounderProgressBar'] = $dir . '/FounderProgressBar.i18n.php';

// Hooks
$wgHooks[ 'ArticleSaveComplete' ][] = 'FounderProgressBarHooks::onArticleSaveComplete';
$wgHooks[ 'UploadComplete' ][] = 'FounderProgressBarHooks::onUploadComplete';
$wgHooks[ 'UploadWordmarkComplete' ][] = 'FounderProgressBarHooks::onUploadWordmarkComplete';
$wgHooks[ 'AddNewAccount' ][] = 'FounderProgressBarHooks::onAddNewAccount';
$wgHooks['AfterVideoFileUploaderUpload'][] = 'FounderProgressBarHooks::onAfterVideoFileUploaderUpload';

// On wiki creation or WikiFactory enable add db columns
$wgHooks['CreateWikiLocalJob-complete'][] = "FounderProgressBarHooks::onWikiCreation";


<?php
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'FounderProgressBar',
	'author'         => 'Wikia',
	'descriptionmsg' => 'founderprogressbar-credits',
);

$dir = dirname(__FILE__).'/';

//Autoload
$wgAutoloadClasses[ 'FounderProgressBarController' ] = $dir . '/FounderProgressBarController.class.php';
$wgAutoloadClasses[ 'FounderProgressBarHooks' ] = $dir . '/FounderProgressBarHooks.class.php';

// I18N
$wgExtensionMessagesFiles['FounderProgressBar'] = $dir . '/FounderProgressBar.i18n.php';

// SETUP
$wgExtensionFunctions[] = 'FounderProgressBar_setup';


function FounderProgressBar_setup () {
	wfProfileIn(__METHOD__);
	$app = F::app();
	
	// Register hooks for founder events
	$app->registerHook("ArticleSaveComplete", "FounderProgressBarHooks", "onArticleSaveComplete");
	$app->registerHook("UploadComplete", "FounderProgressBarHooks", "onUploadComplete");
	$app->registerHook("CreateWikiLocalJob-complete", "FounderProgressBarHooks", "onWikiCreation");

	wfProfileOut(__METHOD__);	
}

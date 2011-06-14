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
$wgExtensionMessagesFiles['FounderProgressBarController'] = $dir . '/FounderProgressBarController.i18n.php';

// SETUP
$wgExtensionFunctions[] = 'FounderProgressBar_setup';


function FounderProgressBar_setup () {
	wfProfileIn(__METHOD__);
	$app = F::app();
	
	// Register hooks for founder events
	$app->registerHook("ArticleSaveComplete", "FounderProgressBarHooks", "onArticleSave");
	$app->registerHook("ImageUploadComplete", "FounderProgressBarHooks", "onImageUploadComplete");

	wfProfileOut(__METHOD__);	
}

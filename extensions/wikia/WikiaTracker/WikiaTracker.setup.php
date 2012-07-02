<?php

/**
 * Wikia events tracking system
 *
 * Provides WikiaTracker and _wtq in JavaScript
 */

$dir = dirname(__FILE__);

// WikiaApp
$app = F::app();

$app->registerClass('WikiaTrackerController', "$dir/WikiaTrackerController.class.php");

//$app->registerHook('MakeGlobalVariablesScript', 'WikiaTrackerController', 'onMakeGlobalVariablesScript');
//$app->registerHook('SkinGetHeadScripts', 'WikiaTrackerController', 'onSkinGetHeadScripts');
$app->registerHook('WikiaSkinTopScripts', 'WikiaTrackerController', 'onWikiaSkinTopScripts');

<?php
$app = F::app();
$dir = dirname(__FILE__) . '/';

/*
 * Register classes
 */
$wgAutoloadClasses['PageClassificationController'] =  $dir . 'PageClassificationController.class.php';
$wgAutoloadClasses['PageClassificationData'] =  $dir . 'PageClassificationData.class.php';
$wgAutoloadClasses['EntityAPIClient'] =  $dir . 'EntityAPIClient.class.php';
$wgAutoloadClasses['ImportantArticles'] =  $dir . 'ImportantArticles.class.php';
$wgAutoloadClasses['CommonPrefix'] =  $dir . 'CommonPrefix.class.php';

/*
 * Special page
 */
// $wgSpecialPages['PageClassification'] = 'PageClassificationController';
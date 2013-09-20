<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$wgAutoloadClasses['SearchedKeywordsController'] =  $dir . 'SearchedKeywordsController.class.php';
$wgAutoloadClasses['SearchedKeywords'] =  $dir . 'SearchedKeywords.class.php';

/**
 * special pages
 */
$wgSpecialPages['SearchedKeywords'] = 'SearchedKeywordsController';

/**
 * hookds
 */
$app->registerHook('Search-beforeBackendCall', 'SearchedKeywordsController', 'onSearchBeforeBackendCall');


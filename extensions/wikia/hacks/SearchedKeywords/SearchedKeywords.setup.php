<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('SearchedKeywordsController', $dir . 'SearchedKeywordsController.class.php');
$app->registerClass('SearchedKeywords', $dir . 'SearchedKeywords.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('SearchedKeywords', 'SearchedKeywordsController');

/**
 * hookds
 */
$app->registerHook('Search-beforeBackendCall', 'SearchedKeywordsController', 'onSearchBeforeBackendCall');

F::addClassConstructor('SearchedKeywords', array( 'app' => $app ));
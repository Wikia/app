<?php

$dir = dirname( __FILE__ );

$wgAutoloadClasses['ScribeEventProducer'] =  $dir . '/ScribeEventProducer.class.php';
$wgAutoloadClasses['ScribeEventProducerController'] =  $dir . '/ScribeEventProducerController.class.php';

$wgHooks['ArticleSaveComplete'][] = 'ScribeEventProducerController::onSaveComplete';
$wgHooks['NewRevisionFromEditComplete'][] = 'ScribeEventProducerController::onSaveRevisionComplete';
$wgHooks['ArticleDeleteComplete'][] = 'ScribeEventProducerController::onDeleteComplete';
$wgHooks['ArticleUndelete'][] = 'ScribeEventProducerController::onArticleUndelete';
$wgHooks['TitleMoveComplete'][] = 'ScribeEventProducerController::onMoveComplete';

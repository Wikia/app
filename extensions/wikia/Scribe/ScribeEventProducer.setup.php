<?php

$dir = dirname( __FILE__ );

$wgAutoloadClasses['ScribeProducer'] =  $dir . '/ScribeProducer.php';  //was this removed?
$wgAutoloadClasses['ScribeEventProducer'] =  $dir . '/ScribeEventProducer.class.php';
$wgAutoloadClasses['ScribeEventProducerController'] =  $dir . '/ScribeEventProducerController.class.php';

$wgHooks['ArticleSaveComplete'][] = 'ScribeEventProducerController::onSaveComplete';
$wgHooks['ArticleDeleteComplete'][] = 'ScribeEventProducerController::onDeleteComplete';
$wgHooks['ArticleUndelete'][] = 'ScribeEventProducerController::onArticleUndelete';
$wgHooks['TitleMoveComplete'][] = 'ScribeEventProducerController::onMoveComplete'; 
$wgHooks['UploadComplete'][] = 'ScribeEventProducerController::onUploadComplete';

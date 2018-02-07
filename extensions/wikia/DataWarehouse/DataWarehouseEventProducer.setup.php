<?php

$dir = dirname( __FILE__ );

$wgAutoloadClasses['DataWarehouseEventProducer'] =  $dir . '/DataWarehouseEventProducer.class.php';
$wgAutoloadClasses['DataWarehouseEventProducerController'] =  $dir . '/DataWarehouseEventProducerController.class.php';

$wgHooks['ArticleSaveComplete'][] = 'DataWarehouseEventProducerController::onSaveComplete';
$wgHooks['NewRevisionFromEditComplete'][] = 'DataWarehouseEventProducerController::onSaveRevisionComplete';
$wgHooks['ArticleDeleteComplete'][] = 'DataWarehouseEventProducerController::onDeleteComplete';
$wgHooks['ArticleUndelete'][] = 'DataWarehouseEventProducerController::onArticleUndelete';
$wgHooks['TitleMoveComplete'][] = 'DataWarehouseEventProducerController::onMoveComplete';

<?php

$dir = dirname( __FILE__ );
$wgAutoloadClasses['PipelineConnectionBase'] =  $dir . '/PipelineConnectionBase.class.php';
$wgAutoloadClasses['PipelineEventProducerController'] =  $dir . '/PipelineEventProducerController.class.php';

$wgHooks['ArticleSaveComplete'][] = 'PipelineEventProducerController::onArticleSaveComplete';
$wgHooks['NewRevisionFromEditComplete'][] = 'PipelineEventProducerController::onNewRevisionFromEditComplete';
$wgHooks['ArticleDeleteComplete'][] = 'PipelineEventProducerController::onArticleDeleteComplete';
$wgHooks['ArticleUndelete'][] = 'PipelineEventProducerController::onArticleUndelete';
$wgHooks['TitleMoveComplete'][] = 'PipelineEventProducerController::onTitleMoveComplete';

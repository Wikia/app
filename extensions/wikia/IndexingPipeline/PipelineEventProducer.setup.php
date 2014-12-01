<?php

$dir = dirname( __FILE__ );
$wgAutoloadClasses['PipelineConnectionBase'] =  $dir . '/PipelineConnectionBase.class.php';
$wgAutoloadClasses['PipelineEventProducer'] =  $dir . '/PipelineEventProducer.class.php';

$wgHooks['ArticleSaveComplete'][] = 'PipelineEventProducer::onArticleSaveComplete';
$wgHooks['NewRevisionFromEditComplete'][] = 'PipelineEventProducer::onNewRevisionFromEditComplete';
$wgHooks['ArticleDeleteComplete'][] = 'PipelineEventProducer::onArticleDeleteComplete';
$wgHooks['ArticleUndelete'][] = 'PipelineEventProducer::onArticleUndelete';
$wgHooks['TitleMoveComplete'][] = 'PipelineEventProducer::onTitleMoveComplete';

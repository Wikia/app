<?php

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'IndexingPipeline',
	'author' => 'Wikia',
	'descriptionmsg' => 'indexingpipeline-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/IndexingPipeline',
);

$dir = dirname( __FILE__ );

//i18n
$wgExtensionMessagesFiles['IndexingPipeline'] = $dir . '/IndexingPipeline.i18n.php';

$wgAutoloadClasses['PipelineConnectionBase'] =  $dir . '/PipelineConnectionBase.class.php';
$wgAutoloadClasses['PipelineEventProducer'] =  $dir . '/PipelineEventProducer.class.php';

$wgHooks['NewRevisionFromEditComplete'][] = 'PipelineEventProducer::onNewRevisionFromEditComplete';
$wgHooks['ArticleDeleteComplete'][] = 'PipelineEventProducer::onArticleDeleteComplete';
$wgHooks['ArticleUndelete'][] = 'PipelineEventProducer::onArticleUndelete';
$wgHooks['TitleMoveComplete'][] = 'PipelineEventProducer::onTitleMoveComplete';
$wgHooks['UserTemplateClassification::TemplateClassified'][] = 'PipelineEventProducer::onTemplateClassified';

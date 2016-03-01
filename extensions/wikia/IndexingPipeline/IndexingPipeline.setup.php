<?php

$wgExtensionCredits[ 'other' ][] = [
	'name' => 'IndexingPipeline',
	'author' => 'Wikia',
	'descriptionmsg' => 'indexingpipeline-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/IndexingPipeline',
];

$dir = dirname( __FILE__ );

//i18n
$wgExtensionMessagesFiles[ 'IndexingPipeline' ] = $dir . '/IndexingPipeline.i18n.php';

$wgAutoloadClasses[ 'Wikia\IndexingPipeline\ConnectionBase' ] = $dir . '/ConnectionBase.class.php';
$wgAutoloadClasses[ 'Wikia\IndexingPipeline\PipelineEventProducer' ] = $dir . '/PipelineEventProducer.class.php';
$wgAutoloadClasses[ 'Wikia\IndexingPipeline\MySQLMetricEventProducer' ] = $dir . '/MySQLMetricEventProducer.class.php';
$wgAutoloadClasses[ 'Wikia\IndexingPipeline\PipelineMessageBuilder' ] = $dir . '/PipelineMessageBuilder.class.php';
$wgAutoloadClasses[ 'Wikia\IndexingPipeline\PipelineRoutingBuilder' ] = $dir . '/PipelineRoutingBuilder.class.php';

$wgHooks[ 'NewRevisionFromEditComplete' ][] = 'Wikia\IndexingPipeline\PipelineEventProducer::onNewRevisionFromEditComplete';
$wgHooks[ 'ArticleDeleteComplete' ][] = 'Wikia\IndexingPipeline\PipelineEventProducer::onArticleDeleteComplete';
$wgHooks[ 'ArticleUndelete' ][] = 'Wikia\IndexingPipeline\PipelineEventProducer::onArticleUndelete';
$wgHooks[ 'TitleMoveComplete' ][] = 'Wikia\IndexingPipeline\PipelineEventProducer::onTitleMoveComplete';
$wgHooks[ 'UserTemplateClassification::TemplateClassified' ][] = 'Wikia\IndexingPipeline\PipelineEventProducer::onTemplateClassified';
$wgHooks[ 'AfterWikiCreated' ][] = 'Wikia\IndexingPipeline\PipelineEventProducer::onAfterWikiCreated';

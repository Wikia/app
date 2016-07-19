<?php

$dir = dirname(__FILE__) . '/';
$searchDir = dirname(dirname(__FILE__)) . '/Search/classes/Services/';

//classes
$wgAutoloadClasses['MetadataSpecialController'] = $dir . 'MetadataSpecialController.class.php';
$wgAutoloadClasses['PalantirApiController'] = $dir . 'PalantirApiController.class.php';
$wgAutoloadClasses['MetaCSVService'] = $dir . 'MetaCSVService.class.php';
$wgAutoloadClasses['ArticleMetadataModel'] = $dir . 'ArticleMetadataModel.php';
$wgAutoloadClasses['ArticleMetadataSolrCoreService'] = $dir . "ArticleMetadataSolrCoreService.class.php";
$wgAutoloadClasses['EntitySearchService'] = $searchDir . "EntitySearchService.php";
$wgAutoloadClasses['QuestDetailsSearchService'] = $searchDir . "QuestDetails/QuestDetailsSearchService.class.php";
$wgAutoloadClasses['QuestDetailsSolrHelper'] = $searchDir . "QuestDetails/QuestDetailsSolrHelper.class.php";

$wgSpecialPages['Metadata']		= 'MetadataSpecialController';

$wgWikiaApiControllers['PalantirApiController'] =  $dir . 'PalantirApiController.class.php';

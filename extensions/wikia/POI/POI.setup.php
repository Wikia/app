<?php

$dir = dirname(__FILE__) . '/';
$searchDir = dirname(dirname(__FILE__)) . '/Search/classes/Services/';

//classes
$wgAutoloadClasses['EntitySearchService'] =  $searchDir . "EntitySearchService.php";
$wgAutoloadClasses['QuestDetailsSearchService'] =  $dir . "QuestDetailsSearchService.class.php";

$wgAutoloadClasses['POIApiController'] =  $dir . "POIApiController.class.php";
$wgAutoloadClasses['QuestDetailsApiController'] = $dir . 'QuestDetailsApiController.class.php';
$wgAutoloadClasses['ArticleMetadataModel'] = $dir . 'ArticleMetadataModel.php';
$wgAutoloadClasses['ArticleMetadataService'] = $dir . 'ArticleMetadataService.php';



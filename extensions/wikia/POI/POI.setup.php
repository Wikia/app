<?php

$dir = dirname(__FILE__) . '/';
$searchDir = dirname(dirname(__FILE__)) . '/Search/classes/Services/';

//classes
$wgAutoloadClasses['POIApiController'] =  $dir . "POIApiController.class.php";
$wgAutoloadClasses['MetadataSpecialController'] = $dir . 'MetadataSpecialController.class.php';
$wgAutoloadClasses['QuestDetailsApiController'] = $dir . 'QuestDetailsApiController.class.php';
$wgAutoloadClasses['MetaCSVService'] = $dir . 'MetaCSVService.class.php';
$wgAutoloadClasses['ArticleMetadataModel'] = $dir . 'ArticleMetadataModel.php';
$wgAutoloadClasses['EntitySearchService'] = $searchDir . "EntitySearchService.php";
$wgAutoloadClasses['QuestDetailsSearchService'] = $searchDir . "QuestDetails/QuestDetailsSearchService.class.php";
$wgAutoloadClasses['QuestDetailsSolrHelper'] = $searchDir . "QuestDetails/QuestDetailsSolrHelper.class.php";

$wgSpecialPages['Metadata']		= 'MetadataSpecialController';

$wgAvailableRights[] = 'metadata';
$wgGroupPermissions['*']['metadata'] = false;
$wgGroupPermissions['staff']['metadata'] = true;
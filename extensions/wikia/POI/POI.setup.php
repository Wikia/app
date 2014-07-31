<?php

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['POIApiController'] =  $dir . "POIApiController.class.php";
$wgAutoloadClasses['MetadataSpecialController'] = $dir . 'MetadataSpecialController.class.php';
$wgAutoloadClasses['QuestDetailsApiController'] = $dir . 'QuestDetailsApiController.class.php';
$wgAutoloadClasses['MetaCSVService'] = $dir . 'MetaCSVService.class.php';
$wgAutoloadClasses['ArticleMetadataModel'] = $dir . 'ArticleMetadataModel.php';
$wgAutoloadClasses['ArticleMetadataService'] = $dir . 'ArticleMetadataService.php';


$wgSpecialPages['Metadata']		= 'MetadataSpecialController';
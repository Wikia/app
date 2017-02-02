<?php

$wgExtensionCredits['specialpage'][] = [
	'name' => 'POI',
	'author' => 'Wikia',
	'version' => '0.1',
	'descriptionmsg' => 'poi-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/POI',
];

// i18n
$wgExtensionMessagesFiles['POI'] = __DIR__ . '/POI.i18n.php';

$searchDir = dirname( __DIR__ ) . '/Search/classes/Services/';

//classes
$wgAutoloadClasses['MetadataSpecialController'] = __DIR__ . '/MetadataSpecialController.class.php';
$wgAutoloadClasses['PalantirApiController'] = __DIR__ . '/PalantirApiController.class.php';
$wgAutoloadClasses['MetaCSVService'] = __DIR__ . '/MetaCSVService.class.php';
$wgAutoloadClasses['ArticleMetadataModel'] = __DIR__ . '/ArticleMetadataModel.php';
$wgAutoloadClasses['ArticleMetadataSolrCoreService'] = __DIR__ . '/ArticleMetadataSolrCoreService.class.php';
$wgAutoloadClasses['EntitySearchService'] = $searchDir . 'EntitySearchService.php';
$wgAutoloadClasses['QuestDetailsSearchService'] = $searchDir . 'QuestDetails/QuestDetailsSearchService.class.php';
$wgAutoloadClasses['QuestDetailsSolrHelper'] = $searchDir . 'QuestDetails/QuestDetailsSolrHelper.class.php';

$wgSpecialPages['Metadata']		= 'MetadataSpecialController';

$wgWikiaApiControllers['PalantirApiController'] =  __DIR__ . '/PalantirApiController.class.php';

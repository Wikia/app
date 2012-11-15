<?php

$app = F::app();

//$app->registerHook( 'EditFormPreloadText', 'CensusDataRetrieval', 'retrieveFromName' );
$app->registerHook( 'EditPage::showEditForm:initial', 'CensusDataRetrieval', 'retrieveFromName' );
//$app->registerHook( 'ParserBeforeInternalParse', 'CensusArticleSave', 'replaceLinks' );
$app->registerHook( 'EditPage::attemptSave', 'CensusArticleSave', 'replaceLinks' );
//$app->registerHook( 'OutputPageParserOutput', 'CensusDataRetrieval', 'onOutputPageParserOutput' );
$app->registerClass( 'CensusDataRetrieval', __DIR__ . '/CensusDataRetrieval.class.php' );
$app->registerClass( 'CensusArticleSave', __DIR__ . '/CensusArticleSave.php' );
$app->registerExtensionMessageFile( 'CensusDataRetrieval', __DIR__ . '/CensusDataRetrieval.i18n.php' );

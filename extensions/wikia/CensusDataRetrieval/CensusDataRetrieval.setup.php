<?php

$app = F::app();

//$app->registerHook( 'EditFormPreloadText', 'CensusDataRetrieval', 'retrieveFromName' );
//static run
$wgHooks['EditPage::showEditForm:initial'][] = 'CensusDataRetrieval::retrieveFromName';
//object run
//$app->registerHook(' EditPage::showEditForm:initial', 'CensusDataRetrieval', 'retrieveFromName' );
//$app->registerHook( 'EditPage::importFormData', 'CensusDataRetrieval', 'retrieveFromName' );
//$app->registerHook( 'ParserBeforeInternalParse', 'CensusArticleSave', 'replaceLinks' );
$app->registerHook( 'EditPage::attemptSave', 'CensusArticleSave', 'replaceLinks' );
//$app->registerHook( 'OutputPageParserOutput', 'CensusDataRetrieval', 'onOutputPageParserOutput' );
$wgAutoloadClasses[ 'CensusDataRetrieval'] =  __DIR__ . '/CensusDataRetrieval.class.php' ;
$wgAutoloadClasses[ 'CensusArticleSave'] =  __DIR__ . '/CensusArticleSave.php' ;
$wgAutoloadClasses[ 'CensusEnabledPagesUpdate'] =  __DIR__ . '/CensusEnabledPagesUpdate.php' ;
$app->registerExtensionMessageFile( 'CensusDataRetrieval', __DIR__ . '/CensusDataRetrieval.i18n.php' );

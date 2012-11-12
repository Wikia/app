<?php

$app = F::app();

$app->registerHook( 'EditFormPreloadText', 'CensusDataRetrieval', 'retrieveFromName' );
//$app->registerHook( 'ParserBeforeInternalParse', 'CensusDataRetrieval', 'replaceLinks' );
$app->registerHook( 'EditPage::attemptSave', 'CensusDataRetrieval', 'replaceLinks' );
$app->registerClass( 'CensusDataRetrieval', __DIR__ . '/CensusDataRetrieval.class.php' );
$app->registerExtensionMessageFile( 'CensusDataRetrieval', __DIR__ . '/CensusDataRetrieval.i18n.php' );

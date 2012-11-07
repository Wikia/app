<?php

$app = F::app();

$app->registerHook( 'EditFormPreloadText', 'CensusDataRetrieval', 'retrieveFromName' );
$app->registerClass( 'CensusDataRetrieval', __DIR__ . '/CensusDataRetrieval.class.php' );

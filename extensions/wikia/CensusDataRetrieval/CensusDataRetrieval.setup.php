<?php

$app = F::app();

$app->registerHook( 'EditFormPreloadText', 'CensusDataRetrieval', 'execute' );
$app->registerClass( 'CensusDataRetrieval', __DIR__ . '/CensusDataRetrieval.class.php' );

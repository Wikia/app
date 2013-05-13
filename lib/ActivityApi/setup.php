<?php

$app = F::app();

$dir = __DIR__ . "/";

// classes
$app->registerClass( 'IRevisionService', $dir . 'services/IRevisionService.class.php' );
$app->registerClass( 'RevisionService', $dir . 'services/RevisionService.class.php' );
$app->registerClass( 'RevisionServiceCacheWrapper', $dir . 'services/RevisionServiceCacheWrapper.class.php' );
$app->registerClass( 'RevisionServiceFactory', $dir . 'services/RevisionServiceFactory.class.php' );

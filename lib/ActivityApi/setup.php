<?php

$app = F::app();

$dir = __DIR__ . "/";

// classes
$app->registerClass( 'IRevisionService', $dir . 'IRevisionService.php' );
$app->registerClass( 'RevisionService', $dir . 'RevisionService.php' );
$app->registerClass( 'RevisionServiceCacheWrapper', $dir . 'RevisionServiceCacheWrapper.php' );
$app->registerClass( 'RevisionServiceFactory', $dir . 'RevisionServiceFactory.php' );

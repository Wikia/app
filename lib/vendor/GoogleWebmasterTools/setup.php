<?php


$app = F::app();

$dir = __DIR__ . "/";

// classes
$app->registerClass( 'GWTException',                $dir . 'GWTException.php' );
$app->registerClass( 'GWTAuthenticationException',  $dir . 'GWTAuthenticationException.php' );
$app->registerClass( 'GWTClient',                   $dir . 'GWTClient.php' );
$app->registerClass( 'GWTUser',                     $dir . 'GWTUser.php' );
$app->registerClass( 'GWTUserRepository',           $dir . 'GWTUserRepository.php' );
$app->registerClass( 'GWTWiki',                     $dir . 'GWTWiki.php' );
$app->registerClass( 'GWTWikiRepository',           $dir . 'GWTWikiRepository.php' );
$app->registerClass( 'WebmasterToolsUtil',          $dir . 'WebmasterToolsUtil.php' );
$app->registerClass( 'GWTService',                  $dir . 'GWTService.php' );
$app->registerClass( 'GWTSiteSyncStatus',           $dir . 'GWTSiteSyncStatus.php' );
$app->registerClass( 'IGoogleCredentials',          $dir . 'IGoogleCredentials.php' );
$app->registerClass( 'GWTLogHelper',                $dir . 'GWTLogHelper.php' );

$app->registerClass( 'WikiPageCountService',        $dir . 'WikiPageCount/WikiPageCountService.php' );
$app->registerClass( 'WikiPageCountServiceFactory', $dir . 'WikiPageCount/WikiPageCountServiceFactory.php' );
$app->registerClass( 'WikiPageCountModel',          $dir . 'WikiPageCount/WikiPageCountModel.php' );

$app->registerClass( 'Iterators',                   $dir . 'util/Iterators.php' );
$app->registerClass( 'GroupingIterator',            $dir . 'util/GroupingIterator.php' );

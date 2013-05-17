<?php


$app = F::app();

$dir = __DIR__ . "/";

// classes
$wgAutoloadClasses[ 'GWTException'] =  $dir . 'GWTException.php' ;
$wgAutoloadClasses[ 'GWTAuthenticationException'] =  $dir . 'GWTAuthenticationException.php' ;
$wgAutoloadClasses[ 'GWTClient'] =  $dir . 'GWTClient.php' ;
$wgAutoloadClasses[ 'GWTLocalCache'] =  $dir . 'GWTLocalCache.php' ;
$wgAutoloadClasses[ 'GWTUser'] =  $dir . 'GWTUser.php' ;
$wgAutoloadClasses[ 'GWTUserRepository'] =  $dir . 'GWTUserRepository.php' ;
$wgAutoloadClasses[ 'GWTWiki'] =  $dir . 'GWTWiki.php' ;
$wgAutoloadClasses[ 'GWTWikiRepository'] =  $dir . 'GWTWikiRepository.php' ;
$wgAutoloadClasses[ 'WebmasterToolsUtil'] =  $dir . 'WebmasterToolsUtil.php' ;
$wgAutoloadClasses[ 'GWTService'] =  $dir . 'GWTService.php' ;
$wgAutoloadClasses[ 'GWTSiteSyncStatus'] =  $dir . 'GWTSiteSyncStatus.php' ;
$wgAutoloadClasses[ 'IGoogleCredentials'] =  $dir . 'IGoogleCredentials.php' ;
$wgAutoloadClasses[ 'GWTLogHelper'] =  $dir . 'GWTLogHelper.php' ;


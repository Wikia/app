<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Cache Tool',
	'version' => '0.1',
	'author' => 'Owen Davis',
	'descriptionmsg' => 'cachetool-desc',
);

$dir = dirname(__FILE__) . '/';

/**
 * classes (controllers)
 */
$app->registerClass('CacheToolController', $dir . 'CacheToolController.class.php');

$app->registerSpecialPage('CacheTool', 'CacheToolController');

$wgGroupPermissions['*']['cachetool'] = false;
$wgGroupPermissions['staff']['cachetool'] = true;
		
global $wgRedis;
$wgRedis = new Predis\Client();		
		
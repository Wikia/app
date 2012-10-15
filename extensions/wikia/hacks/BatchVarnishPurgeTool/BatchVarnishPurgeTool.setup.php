<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Batch Varnish Purge Tool',
	'version' => '0.1',
	'author' => 'William Lee',
	'descriptionmsg' => 'batchvarnishpurgetool-desc',
);

$dir = dirname(__FILE__) . '/';

/**
 * classes (controllers)
 */
$app->registerClass('BatchVarnishPurgeToolController', $dir . 'BatchVarnishPurgeToolController.class.php');

$app->registerExtensionMessageFile('BatchVarnishPurgeTool', $dir . '/BatchVarnishPurgeTool.i18n.php');

$app->registerSpecialPage('BatchVarnishPurgeTool', 'BatchVarnishPurgeToolController');

$wgGroupPermissions['*']['batchvarnishpurgetool'] = false;
$wgGroupPermissions['staff']['batchvarnishpurgetool'] = true;
			

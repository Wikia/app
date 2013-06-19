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
$wgAutoloadClasses['BatchVarnishPurgeToolController'] =  $dir . 'BatchVarnishPurgeToolController.class.php';

	$wgExtensionMessagesFiles['BatchVarnishPurgeTool'] = $dir . '/BatchVarnishPurgeTool.i18n.php';

$wgSpecialPages['BatchVarnishPurgeTool'] = 'BatchVarnishPurgeToolController';

$wgGroupPermissions['*']['batchvarnishpurgetool'] = false;
$wgGroupPermissions['staff']['batchvarnishpurgetool'] = true;
			

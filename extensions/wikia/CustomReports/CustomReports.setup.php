<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';

$app->registerClass('Report', $dir.'Report.class.php');

$app->registerClass('CustomReportsSpecialController', $dir.'CustomReportsSpecialController.class.php');

$app->registerSpecialPage('CustomReports', 'CustomReportsSpecialController');

$app->registerExtensionMessageFile('CustomReports', $dir.'CustomReports.i18n.php');

$wgAvailableRights[] = 'customreports';

$wgGroupPermissions['*']['customreports'] = false;
$wgGroupPermissions['staff']['customreports'] = true;

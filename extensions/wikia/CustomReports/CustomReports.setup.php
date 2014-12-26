<?php

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'CustomReports',
	'author' => 'Wikia',
	'descriptionmsg' => 'custom-reports-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CustomReports',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['Report'] =  $dir . 'Report.class.php';

$wgAutoloadClasses['CustomReportsSpecialController'] =  $dir . 'CustomReportsSpecialController.class.php';

$wgSpecialPages['CustomReports'] = 'CustomReportsSpecialController';

$wgExtensionMessagesFiles['CustomReports'] = $dir . 'CustomReports.i18n.php';

$wgAvailableRights[] = 'customreports';

$wgGroupPermissions['*']['customreports'] = false;
$wgGroupPermissions['staff']['customreports'] = true;

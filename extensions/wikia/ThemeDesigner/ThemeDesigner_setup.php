<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Theme designer',
	'author' => array( 'Christian Williams', 'Inez Korczyński', 'Maciej Brencz' ),
	'descriptionmsg' => 'themedesigner-desc',
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['ThemeDesignerModule'] = "$dir/ThemeDesignerModule.class.php";
$wgAutoloadClasses['ThemeDesignerHelper'] = "$dir/ThemeDesignerHelper.class.php";
$wgAutoloadClasses['ThemeSettings'] = "$dir/ThemeSettings.class.php";
$wgAutoloadClasses['SpecialThemeDesigner'] = "$dir/SpecialThemeDesigner.class.php";
$wgSpecialPages['ThemeDesigner'] = 'SpecialThemeDesigner';
$wgExtensionMessagesFiles['ThemeDesigner'] = "$dir/ThemeDesigner.i18n.php";

$wgHooks['MyTools::getCustomTools'][] = 'ThemeDesignerHelper::addToMyTools';

$wgAvailableRights[] = 'themedesigner';
$wgGroupPermissions['*']['themedesigner'] = false;
$wgGroupPermissions['helper']['themedesigner'] = true;
$wgGroupPermissions['staff']['themedesigner'] = true;
$wgGroupPermissions['sysop']['themedesigner'] = true;

// Ajax dispatcher
$wgAjaxExportList[] = 'ThemeDesignerHelper::saveSettings';

<?php
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Theme designer',
	'author' => array('Christian Williams', 'Inez Korczyński', 'Maciej Brencz')
);

$dir = dirname(__FILE__);

$wgAutoloadClasses['ThemeDesignerModule'] = "$dir/ThemeDesignerModule.class.php";
$wgAutoloadClasses['SpecialThemeDesigner'] = "$dir/SpecialThemeDesigner.class.php";
$wgSpecialPages['ThemeDesigner'] = 'SpecialThemeDesigner';
$wgExtensionMessagesFiles['ThemeDesigner'] = "$dir/ThemeDesigner.i18n.php";


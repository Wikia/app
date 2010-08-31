<?php
$wgAutoloadClasses['ThemeDesignerModule'] = dirname(__FILE__).'/ThemeDesignerModule.class.php';
$wgAutoloadClasses['SpecialThemeDesigner'] = dirname(__FILE__).'/SpecialThemeDesigner.class.php';
$wgSpecialPages['ThemeDesigner'] = 'SpecialThemeDesigner';
$wgExtensionMessagesFiles['ThemeDesigner'] = dirname(__FILE__).'/ThemeDesigner.i18n.php';


<?php
$wgAutoloadClasses['ThemeDesignerModule'] = dirname(__FILE__).'/ThemeDesignerModule.class.php';
$wgAutoloadClasses['SpecialThemeDesigner'] = dirname(__FILE__).'/SpecialThemeDesigner.class.php';
$wgSpecialPages['ThemeDesigner'] = 'SpecialThemeDesigner';
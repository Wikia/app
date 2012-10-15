<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

$lfip = dirname( __FILE__ );
$wgAutoloadClasses['LuaFoo_SpecialLuaTranslation'] = "$lfip/includes/SpecialLuaTranslation.php";
$wgAutoloadClasses['LuaFoo_Converter'] = "$lfip/includes/Converter.php";

$wgSpecialPages['LuaTranslation'] = 'LuaFoo_SpecialLuaTranslation';
$wgExtensionMessagesFiles['LuaFoo'] = "$lfip/LuaFoo.i18n.php";


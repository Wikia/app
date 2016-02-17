<?php
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'PortableInfoboxBuilderService' ] = $dir . 'PortableInfoboxBuilderService.class.php';

$wgAutoloadClasses[ 'PortableInfoboxBuilderController' ] = $dir . 'PortableInfoboxBuilderController.class.php';
$wgAutoloadClasses[ 'PortableInfoboxBuilderSpecialController' ] = $dir . 'PortableInfoboxBuilderSpecialController.class.php';
$wgAutoloadClasses[ 'PortableInfoboxBuilderHooks' ] = $dir . 'PortableInfoboxBuilderHooks.class.php';

// special pages
$wgSpecialPages[ 'PortableInfoboxBuilder' ] = 'PortableInfoboxBuilderSpecialController';
$wgSpecialPageGroups[ 'PortableInfoboxBuilder' ] = 'wikia';

// iframe loading sctipt
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'PortableInfoboxBuilderHooks::onSkinAfterBottomScripts';

// i18n mapping
$wgExtensionMessagesFiles[ 'PortableInfoboxBuilder' ] = $dir . 'PortableInfoboxBuilder.i18n.php';

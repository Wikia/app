<?php
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'PortableInfoboxBuilderService' ] = $dir . 'services/PortableInfoboxBuilderService.class.php';

$wgBuilderNodeValidators = [
	'NodeValidator',
	'NodeImageValidator',
	'NodeInfoboxValidator',
	'NodeDataValidator',
	'NodeDefaultValidator',
	'NodeCaptionValidator',
	'NodeLabelValidator',
	'NodeTitleValidator',
];

$wgAutoloadClasses[ 'Wikia\\PortableInfoboxBuilder\\Validators\\ValidatorBuilder' ] = $dir . 'services/Validators/ValidatorBuilder.class.php';
foreach ( $wgBuilderNodeValidators as $nodeValidator ) {
	$wgAutoloadClasses[ 'Wikia\\PortableInfoboxBuilder\\Validators\\' . $nodeValidator ] = $dir . 'services/Validators/' . $nodeValidator . '.class.php';
}

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

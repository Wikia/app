<?php
$dir = dirname( __FILE__ ) . '/';

$wgBuilderNodes = [
	'Node',
	'NodeCaption',
	'NodeData',
	'NodeDefault',
	'NodeGroup',
	'NodeHeader',
	'NodeImage',
	'NodeInfobox',
	'NodeLabel',
	'NodeTitle',
];

$wgAutoloadClasses[ 'Wikia\\PortableInfoboxBuilder\\Nodes\\NodeBuilder' ] = $dir . 'services/Nodes/NodeBuilder.class.php';
foreach ( $wgBuilderNodes as $node ) {
	$wgAutoloadClasses[ 'Wikia\\PortableInfoboxBuilder\\Nodes\\' . $node ] = $dir . 'services/Nodes/' . $node . '.class.php';
}

$wgAutoloadClasses[ 'PortableInfoboxBuilderController' ] = $dir . 'PortableInfoboxBuilderController.class.php';
$wgAutoloadClasses[ 'PortableInfoboxBuilderSpecialController' ] = $dir . 'PortableInfoboxBuilderSpecialController.class.php';
$wgAutoloadClasses[ 'PortableInfoboxBuilderHooks' ] = $dir . 'PortableInfoboxBuilderHooks.class.php';

// special pages
$wgSpecialPages[ 'InfoboxBuilder' ] = 'PortableInfoboxBuilderSpecialController';
$wgSpecialPageGroups[ 'InfoboxBuilder' ] = 'wikia';

// iframe loading sctipt
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'PortableInfoboxBuilderHooks::onSkinAfterBottomScripts';

// i18n mapping
$wgExtensionMessagesFiles[ 'PortableInfoboxBuilder' ] = $dir . 'PortableInfoboxBuilder.i18n.php';

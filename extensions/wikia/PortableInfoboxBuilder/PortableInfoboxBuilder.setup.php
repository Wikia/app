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

// passing of top variables
$wgHooks['EditPageMakeGlobalVariablesScript'][] = 'PortableInfoboxBuilderHooks::onEditPageMakeGlobalVariablesScript';
$wgHooks['MakeGlobalVariablesScript'][] = 'PortableInfoboxBuilderHooks::onMakeGlobalVariablesScript';

// iframe loading script
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'PortableInfoboxBuilderHooks::onSkinAfterBottomScripts';
$wgHooks[ 'CustomEditor' ][] = 'PortableInfoboxBuilderHooks::onCustomEditor';

// template classification helper
$wgHooks[ 'TemplateClassificationHooks::afterEditPageAssets' ][] = 'PortableInfoboxBuilderHooks::onTCAfterEditPageAssets';

// i18n mapping
$wgExtensionMessagesFiles[ 'PortableInfoboxBuilder' ] = $dir . 'PortableInfoboxBuilder.i18n.php';

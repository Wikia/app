<?php
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'parserhook' ][] = [
	'name' => 'Portable Infobox',
	'author' => [
		'Adam Robak',
		'Jacek Jursza',
		'Mateusz Rybarski',
		'Rafał Leszczyński',
		'Sebastian Marzjan'
	],
	'descriptionmsg' => 'portable-infobox-desc',
	'version' => 0.1,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PortableInfobox'
];

$wgAutoloadClasses[ 'InfoboxServiceConnector' ] = $dir . 'InfoboxServiceConnector.class.php';
$wgAutoloadClasses[ 'PortableInfoboxRenderService' ] = $dir . 'services/PortableInfoboxRenderService.class.php';

// parser
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\XmlParser'] = $dir . 'services/Parser/XmlParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\ExternalParser'] = $dir . 'services/Parser/ExternalParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\MediaWikiParserService'] = $dir . 'services/Parser/MediaWikiParserService.php';
$wgInfoboxParserNodes = [
	'Node',
	'NodeComparison',
	'NodeSet',
	'NodeFooter',
	'NodeGroup',
	'NodeHeader',
	'NodeImage',
	'NodePair',
	'NodeTitle',
	'NodeUnimplemented'
];
foreach ( $wgInfoboxParserNodes as $parserNode ) {
	$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\Nodes\\'.$parserNode ] = $dir . 'services/Parser/Nodes/'.$parserNode.'.php';
}

// controller classes
$wgAutoloadClasses[ 'PortableInfoboxParserTagController' ] = $dir . 'controllers/PortableInfoboxParserTagController.class.php';
$wgAutoloadClasses[ 'PortableInfoboxHooks' ] = $dir . 'PortableInfoboxHooks.class.php';

// hooks
$wgHooks[ 'ParserFirstCallInit' ][] = 'PortableInfoboxParserTagController::parserTagInit';
$wgHooks['BeforePageDisplay'][] = 'PortableInfoboxHooks::onBeforePageDisplay';
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'PortableInfoboxHooks::onSkinAfterBottomScripts';

// i18n mapping
$wgExtensionMessagesFiles[ 'PortableInfobox' ] = $dir . 'PortableInfobox.i18n.php';

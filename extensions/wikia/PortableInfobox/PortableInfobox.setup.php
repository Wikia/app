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

$wgAutoloadClasses[ 'PortableInfoboxRenderService' ] = $dir . 'services/PortableInfoboxRenderService.class.php';

// parser
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\ExternalParser'] = $dir . 'services/Parser/ExternalParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\SimpleParser'] = $dir . 'services/Parser/SimpleParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\XmlParser'] = $dir . 'services/Parser/XmlParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\DummyParser'] = $dir . 'services/Parser/DummyParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\MediaWikiParserService'] = $dir . 'services/Parser/MediaWikiParserService.php';
$wgInfoboxParserNodes = [
	'Node',
	'NodeComparison',
	'NodeSet',
	'NodeFooter',
	'NodeGroup',
	'NodeHeader',
	'NodeImage',
	'NodeData',
	'NodeTitle',
	'NodeUnimplemented'
];
foreach ( $wgInfoboxParserNodes as $parserNode ) {
	$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\Nodes\\'.$parserNode ] = $dir . 'services/Parser/Nodes/'.$parserNode.'.php';
}

// helpers
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer' ] = $dir . 'services/Helpers/ImageFilenameSanitizer.php';

// controller classes
$wgAutoloadClasses[ 'PortableInfoboxParserTagController' ] = $dir . 'controllers/PortableInfoboxParserTagController.class.php';
$wgAutoloadClasses[ 'PortableInfoboxHooks' ] = $dir . 'PortableInfoboxHooks.class.php';

// hooks
$wgHooks[ 'ParserFirstCallInit' ][] = 'PortableInfoboxParserTagController::parserTagInit';
$wgHooks['BeforePageDisplay'][] = 'PortableInfoboxHooks::onBeforePageDisplay';
$wgHooks['ParserAfterTidy'][] = 'PortableInfoboxParserTagController::replaceInfoboxMarkers';

// i18n mapping
$wgExtensionMessagesFiles[ 'PortableInfobox' ] = $dir . 'PortableInfobox.i18n.php';

<?php
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'parserhook' ][] = [
	'name' => 'Portable Infobox',
	'author' => [
		'Adam Robak',
		'Diana Falkowska',
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
$wgAutoloadClasses[ 'PortableInfoboxErrorRenderService' ] = $dir . 'services/PortableInfoboxErrorRenderService.class.php';

// parser
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\ExternalParser'] = $dir . 'services/Parser/ExternalParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\SimpleParser'] = $dir . 'services/Parser/SimpleParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\XmlParser'] = $dir . 'services/Parser/XmlParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\DummyParser'] = $dir . 'services/Parser/DummyParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\MediaWikiParserService'] = $dir . 'services/Parser/MediaWikiParserService.php';
$wgInfoboxParserNodes = [
	'Node',
	'NodeNavigation',
	'NodeGroup',
	'NodeHeader',
	'NodeImage',
	'NodeInfobox',
	'NodeData',
	'NodeTitle',
	'NodeUnimplemented'
];
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\Nodes\\NodeFactory' ] = $dir . 'services/Parser/Nodes/NodeFactory.class.php';
foreach ( $wgInfoboxParserNodes as $parserNode ) {
	$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\Nodes\\'.$parserNode ] = $dir . 'services/Parser/Nodes/'.$parserNode.'.php';
}

// helpers
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer' ] = $dir . 'services/Helpers/ImageFilenameSanitizer.php';
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\SimpleXmlUtil' ] = $dir . 'services/Helpers/SimpleXmlUtil.php';
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\InfoboParamsValidator' ] = $dir . 'services/Helpers/InfoboParamsValidator.php';
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag' ] = $dir . 'services/Helpers/PortableInfoboxDataBag.php';
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper' ] = $dir . 'services/Helpers/PortableInfoboxRenderServiceHelper.php';
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\PortableInfoboxClassification' ] = $dir . 'services/Helpers/PortableInfoboxClassification.php';

// controller classes
$wgAutoloadClasses[ 'PortableInfoboxParserTagController' ] = $dir . 'controllers/PortableInfoboxParserTagController.class.php';
$wgAutoloadClasses[ 'ApiPortableInfobox' ] = $dir . 'controllers/ApiPortableInfobox.class.php';
$wgAutoloadClasses[ 'ApiQueryPortableInfobox' ] = $dir . 'controllers/ApiQueryPortableInfobox.class.php';
$wgAutoloadClasses[ 'PortableInfoboxHooks' ] = $dir . 'PortableInfoboxHooks.class.php';

// hooks
$wgHooks['ParserFirstCallInit'][] = 'PortableInfoboxParserTagController::parserTagInit';
$wgHooks['ParserTagHooksBeforeInvoke'][] = 'PortableInfoboxHooks::onParserTagHooksBeforeInvoke';
$wgHooks['BeforePageDisplay'][] = 'PortableInfoboxHooks::onBeforePageDisplay';
$wgHooks['ParserAfterTidy'][] = 'PortableInfoboxParserTagController::replaceInfoboxMarkers';
$wgHooks['ImageServing::buildAndGetIndex'][] = 'PortableInfoboxHooks::onImageServingCollectImages';

// i18n mapping
$wgExtensionMessagesFiles[ 'PortableInfobox' ] = $dir . 'PortableInfobox.i18n.php';

// MW API
$wgAPIModules['infobox'] = 'ApiPortableInfobox';
$wgAPIPropModules[ 'infobox' ] = 'ApiQueryPortableInfobox';

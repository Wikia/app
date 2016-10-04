<?php
$dir = dirname( __FILE__ ) . '/';

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

$wgAutoloadClasses[ 'PortableInfoboxQueryService' ] = $dir . 'services/PortableInfoboxQueryService.class.php';
$wgAutoloadClasses[ 'PortableInfoboxRenderService' ] = $dir . 'services/PortableInfoboxRenderService.class.php';
$wgAutoloadClasses[ 'PortableInfoboxErrorRenderService' ] = $dir . 'services/PortableInfoboxErrorRenderService.class.php';

// parser
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\ExternalParser' ] = $dir . 'services/Parser/ExternalParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\SimpleParser' ] = $dir . 'services/Parser/SimpleParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\XmlParser' ] = $dir . 'services/Parser/XmlParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\DummyParser' ] = $dir . 'services/Parser/DummyParser.php';
$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\MediaWikiParserService' ] = $dir . 'services/Parser/MediaWikiParserService.php';
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
	$wgAutoloadClasses[ 'Wikia\\PortableInfobox\\Parser\\Nodes\\' . $parserNode ] = $dir . 'services/Parser/Nodes/' . $parserNode . '.php';
}

// helpers
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\InfoboxParamsValidator' ] = $dir . 'services/Helpers/InfoboxParamsValidator.php';
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag' ] = $dir . 'services/Helpers/PortableInfoboxDataBag.php';
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper' ] = $dir . 'services/Helpers/PortableInfoboxRenderServiceHelper.php';
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\PortableInfoboxTemplatesHelper' ] = $dir . 'services/Helpers/PortableInfoboxTemplatesHelper.php';
$wgAutoloadClasses[ 'Wikia\PortableInfobox\Helpers\PagePropsProxy' ] = $dir . 'services/Helpers/PagePropsProxy.php';

//sanitizers
$wgAutoloadClasses[ 'SanitizerBuilder' ] = $dir . 'services/Sanitizers/SanitizerBuilder.php';
$wgAutoloadClasses[ 'NodeSanitizer' ] = $dir . 'services/Sanitizers/NodeSanitizer.php';
$wgAutoloadClasses[ 'PassThroughSanitizer' ] = $dir . 'services/Sanitizers/PassThroughSanitizer.php';
$wgAutoloadClasses[ 'NodeTypeSanitizerInterface' ] = $dir . 'services/Sanitizers/NodeTypeSanitizerInterface.php';
$wgAutoloadClasses[ 'NodeDataSanitizer' ] = $dir . 'services/Sanitizers/NodeDataSanitizer.php';
$wgAutoloadClasses[ 'NodeHeroImageSanitizer' ] = $dir . 'services/Sanitizers/NodeHeroImageSanitizer.php';
$wgAutoloadClasses[ 'NodeHorizontalGroupSanitizer' ] = $dir . 'services/Sanitizers/NodeHorizontalGroupSanitizer.php';
$wgAutoloadClasses[ 'NodeImageSanitizer' ] = $dir . 'services/Sanitizers/NodeImageSanitizer.php';
$wgAutoloadClasses[ 'NodeTitleSanitizer' ] = $dir . 'services/Sanitizers/NodeTitleSanitizer.php';

// controller classes
$wgAutoloadClasses[ 'PortableInfoboxParserTagController' ] = $dir . 'controllers/PortableInfoboxParserTagController.class.php';
$wgAutoloadClasses[ 'ApiPortableInfobox' ] = $dir . 'controllers/ApiPortableInfobox.class.php';
$wgAutoloadClasses[ 'ApiQueryPortableInfobox' ] = $dir . 'controllers/ApiQueryPortableInfobox.class.php';
$wgAutoloadClasses[ 'PortableInfoboxHooks' ] = $dir . 'PortableInfoboxHooks.class.php';
$wgAutoloadClasses[ 'ApiQueryAllinfoboxes' ] = $dir . 'controllers/ApiQueryAllinfoboxes.class.php';

// query pages
$wgAutoloadClasses[ 'AllinfoboxesQueryPage' ] = $dir . 'querypage/AllinfoboxesQueryPage.php';

// hooks
$wgHooks[ 'ParserFirstCallInit' ][] = 'PortableInfoboxParserTagController::parserTagInit';
$wgHooks[ 'ParserTagHooksBeforeInvoke' ][] = 'PortableInfoboxHooks::onParserTagHooksBeforeInvoke';
$wgHooks[ 'BeforePageDisplay' ][] = 'PortableInfoboxHooks::onBeforePageDisplay';
$wgHooks[ 'ParserAfterTidy' ][] = 'PortableInfoboxParserTagController::replaceInfoboxMarkers';
$wgHooks[ 'ImageServing::buildAndGetIndex' ][] = 'PortableInfoboxHooks::onImageServingCollectImages';
$wgHooks[ 'wgQueryPages' ][] = 'PortableInfoboxHooks::onWgQueryPages';
$wgHooks[ 'AllInfoboxesQueryRecached' ][] = 'PortableInfoboxHooks::onAllInfoboxesQueryRecached';
$wgHooks[ 'ArticlePurge' ][] = 'PortableInfoboxHooks::onArticlePurge';
$wgHooks[ 'ArticleSave' ][] = 'PortableInfoboxHooks::onArticleSave';
$wgHooks[ 'BacklinksPurge' ][] = 'PortableInfoboxHooks::onBacklinksPurge';
$wgHooks[ 'ArticleInsertComplete' ][] = 'PortableInfoboxHooks::onArticleInsertComplete';
$wgHooks[ 'ArticleAsJsonBeforeEncode' ][] = 'PortableInfoboxHooks::onArticleAsJsonBeforeEncode';

// special pages
$wgSpecialPages[ 'AllInfoboxes' ] = 'AllinfoboxesQueryPage';
$wgSpecialPageGroups[ 'AllInfoboxes' ] = 'wikia';

// i18n mapping
$wgExtensionMessagesFiles[ 'PortableInfobox' ] = $dir . 'PortableInfobox.i18n.php';

// MW API
$wgAPIModules[ 'infobox' ] = 'ApiPortableInfobox';
$wgAPIPropModules[ 'infobox' ] = 'ApiQueryPortableInfobox';
$wgAPIListModules[ 'allinfoboxes' ] = 'ApiQueryAllinfoboxes';

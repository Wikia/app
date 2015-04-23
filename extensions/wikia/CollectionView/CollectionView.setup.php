<?php
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'parserhook' ][] = [
	'name' => 'Collection View',
	'author' => [
	],
	'descriptionmsg' => 'collection-view-desc',
	'version' => 0.1,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CollectionView'
];

$wgAutoloadClasses[ 'CollectionViewRenderService' ] = $dir . 'services/CollectionViewRenderService.class.php';

// parser
$wgAutoloadClasses[ 'Wikia\\CollectionView\\Parser\\XmlParser'] = $dir . 'services/Parser/XmlParser.php';
$wgAutoloadClasses[ 'Wikia\\CollectionView\\Parser\\MediaWikiParserService'] = $dir . 'services/Parser/MediaWikiParserService.php';

$wgCollectionViewParserNodes = [
	'Node',
	'NodeDescription',
	'NodeHeader',
	'NodeItem',
	'NodeUnimplemented'
];

foreach ( $wgCollectionViewParserNodes as $parserNode ) {
	$wgAutoloadClasses[ 'Wikia\\CollectionView\\Parser\\Nodes\\'.$parserNode ] = $dir . 'services/Parser/Nodes/' . $parserNode . '.php';
}

// controller classes
$wgAutoloadClasses[ 'CollectionViewParserTagController' ] = $dir . 'controllers/CollectionViewParserTagController.class.php';
$wgAutoloadClasses[ 'CollectionViewHooks' ] = $dir . 'CollectionViewHooks.class.php';

// hooks
$wgHooks[ 'ParserFirstCallInit' ][] = 'CollectionViewParserTagController::parserTagInit';
$wgHooks[ 'BeforePageDisplay' ][] = 'CollectionViewHooks::onBeforePageDisplay';
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'CollectionViewHooks::onSkinAfterBottomScripts';

// i18n mapping
$wgExtensionMessagesFiles[ 'CollectionView' ] = $dir . 'CollectionView.i18n.php';

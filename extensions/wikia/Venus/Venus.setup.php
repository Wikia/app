<?php
/**
 * Venus Skin
 *
 * @author Consumer Team
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

/**
 * info
 */
$wgExtensionCredits['other'][] =
	[
		"name" => "Venus",
		"description" => "Venus Skin for Wikia",
		"author" => [
			'Consumer Team',
		]
	];

/**
 * settings
 */

/**
 * classes
 */

$wgAutoloadClasses['ResourceVariablesGetter'] = 'includes/wikia/resourceloader/ResourceVariablesGetter.class.php';
$wgAutoloadClasses['VenusHooks'] = __DIR__ . '/VenusHooks.class.php';
$wgAutoloadClasses['InfoboxExtractor'] = 'includes/wikia/InfoboxExtractor.class.php';


/**
 * services
 */

/**
 * models
 */


/**
 * controllers
 */
$wgAutoloadClasses['VenusController'] = __DIR__ . '/VenusController.class.php';

/**
 * special pages
 */

/**
 * message files
 */
$wgExtensionMessagesFiles['Venus'] = __DIR__ . '/Venus.i18n.php';
JSMessages::registerPackage('VenusArticle', [ 'venus-article-*' ]);

/**
 * hooks
 */
$wgHooks['ParserSectionCreate'][] = 'VenusHooks::onParserSectionCreate';


//404 Pages

// Resources Loader modules


$wgResourceModules['ext.wikia.venus.article.infobox'] = [
	'scripts' => [
		'scripts/Infobox.js',
		'scripts/modules/infobox.module.js'
	],
	'messages' => [
		'venus-article-infobox-see-more',
	],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/Venus'
];

$wgResourceModules['ext.wikia.venus.recommendations'] = [
	'scripts' => [
		'extensions/wikia/Venus/scripts/venusRecommendations.js'
	],
	'dependencies' => [
		'ext.wikia.recommendations',
	]
];

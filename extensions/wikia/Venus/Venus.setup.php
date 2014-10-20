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

$wgAutoloadClasses['ResourceVariablesGetter'] = "includes/wikia/resourceloader/ResourceVariablesGetter.class.php";
$wgAutoloadClasses['VenusHooks'] = __DIR__ . '/VenusHooks.class.php';


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
JSMessages::registerPackage('VenusArticle', array('venus-article-*'));

/**
 * hooks
 */
$wgHooks['ParserSectionCreate'][] = 'VenusHooks::onParserSectionCreate';


//404 Pages

// Resources Loader module
$wgResourceModules['ext.wikia.venus.article.infobox'] = array(
	'scripts' => array(
		'scripts/Infobox.js',
	),
	'styles' => array(
		'styles/article/infobox.scss',
	),
	'messages' => array(
		'venus-article-infobox-see-more',
	),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/Venus'
);

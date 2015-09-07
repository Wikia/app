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
		"descriptionmsg" => "venus-desc",
		"author" => [
			'Consumer Team',
		],
		'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Venus'
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
$wgHooks['MakeGlobalVariablesScript'][] = 'VenusHooks::onMakeGlobalVariablesScript';
$wgHooks['ParserAfterTidy'][] = 'VenusHooks::onParserAfterTidy';
$wgHooks['ParserSectionCreate'][] = 'VenusHooks::onParserSectionCreate';
$wgHooks['MakeHeadline'][] = 'VenusHooks::onMakeHeadline';
$wgHooks['UserLogoutComplete'][] = 'BannerNotificationsController::addLogOutConfirmation';
$wgHooks['BeforeSkinLoad'][] = 'VenusHooks::onBeforeSkinLoad';

//404 Pages

// Resources Loader modules


$wgResourceModules['ext.wikia.venus.article.infobox'] = [
	'scripts' => [
		'scripts/modules/infobox.module.js',
		'scripts/Infobox.js'
	],
	'messages' => [
		'venus-article-infobox-see-more',
	],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/Venus'
];

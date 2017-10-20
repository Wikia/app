<?php
/**
 * Setup instructions for the InfoboxBuilder extension.
 *
 * @author Adam Karmiński < adamk@wikia-inc.com >
 * @date   Jun 26, 2014 (Thu) (start)
 * 
 */

/**
 * Terminate if used outside MediaWiki
 */
if ( !defined('MEDIAWIKI') ) {
	exit( 1 );
}

/**
 * Extension credits
 */
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'InfoboxBuilder',
	'descriptionmsg' => 'infoboxbuilder-desc',
	'author' => 'Adam Karmiński <adamk@wikia-inc.com>',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/InfoboxBuilder'
);

/**
 * Register Lua libraries
 */
$wgAutoloadClasses['InfoboxBuilder\LuaLibrary'] = __DIR__ . '/includes/LuaLibrary.php';

/**
 * Load InfoboxBuilder's hooking functions
 */
$wgAutoloadClasses['InfoboxBuilder\InfoboxBuilderHooks'] = __DIR__ . '/InfoboxBuilder.hooks.php';

/**
 * Add hooks
 */
$wgHooks['ParserFirstCallInit'][]        = '\InfoboxBuilder\InfoboxBuilderHooks::setupParserHook';
$wgHooks['ScribuntoExternalLibraries'][] = '\InfoboxBuilder\InfoboxBuilderHooks::registerScribuntoLibraries';
$wgHooks['EditPageLayoutExecute'][]       = '\InfoboxBuilder\InfoboxBuilderHooks::addInfoboxBuilderStyles';

/**
 * I18n files
 */
$wgExtensionMessagesFiles['InfoboxBuilder']      = __DIR__ . '/InfoboxBuilder.i18n.php';
$wgExtensionMessagesFiles['InfoboxBuilderMagic'] = __DIR__ . '/InfoboxBuilder.magic.i18n.php';

/**
 * Register SCSS with the default theme for an infobox
 */
$wgResourceModules['ext.wikia.InfoboxBuilder'] = [
	'styles' => [ 'resources/infoboxBuilder.scss' ],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/InfoboxBuilder',
];

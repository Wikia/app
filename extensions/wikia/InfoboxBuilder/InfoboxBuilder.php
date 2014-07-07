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
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'InfoboxBuilder',
	'description' => 'InfoboxBuilder is a tool that allows users to build Lua-based infoboxes without any programming skills and to use custom Lua modules for logical operations on demand.',
	'descriptionmsg' => 'infoboxbuilder-desc',
	'author' => 'Adam Karmiński <adamk@wikia-inc.com>',
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

/**
 * I18n files
 */
$wgExtensionMessagesFiles['InfoboxBuilder']      = __DIR__ . '/InfoboxBuilder.i18n.php';
$wgExtensionMessagesFiles['InfoboxBuilderMagic'] = __DIR__ . '/InfoboxBuilder.magic.i18n.php';

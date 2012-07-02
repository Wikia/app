<?php
/**
 * Local jQuery - An extension to load jQuery from the wiki
 *
 *
 * For more info see http://mediawiki.org/wiki/Extension:Local_jQuery
 *
 * @file
 * @ingroup Extensions
 * @author Timo Tijhof, timotijhof@gmail.com
 * @copyright © 2011 Timo Tijhof
 * @license Creative Commons 1.0 Universal (CC0 1.0) Public Domain Dedication
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

if ( version_compare( $wgVersion, '1.18', '<' ) ) {
	die( "LocalJQuery extension requires MediaWiki 1.18+\n" );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Local jQuery',
	'author' => array( 'Timo Tijhof' ),
	'url' => 'http://mediawiki.org/wiki/Extension:Local_jQuery',
	'descriptionmsg' => 'localjquery-desc',
);

$dir = dirname(__FILE__);
$wgExtensionMessagesFiles['LocalJQuery'] = $dir . '/LocalJQuery.i18n.php';

// Create a wiki module for MediaWiki:JQuery.js
class JQueryWikiModule extends ResourceLoaderWikiModule {
	protected function getPages( ResourceLoaderContext $context ) {
		return array(
			'MediaWiki:JQuery.js' => array( 'type' => 'script' ),
		);
	}
}

// Register it
$wgResourceModules['jquery-wiki'] = array(
	'class' => 'JQueryWikiModule',
);

// Load it during startup instead of the default jquery
$wgHooks['ResourceLoaderGetStartupModules'][] = 'efLoadJQueryFromWiki';
function efLoadJQueryFromWiki( &$modules ) {
	$key = array_search( 'jquery', $modules );
	if ( $key !== false ) {
		$modules[$key] = 'jquery-wiki';
	} else {
		$modules[] = 'jquery-wiki';
	}
	return true;
}

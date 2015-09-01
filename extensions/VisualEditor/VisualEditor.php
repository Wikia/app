<?php

// Wikia change begin, @author: Inez Korczyński
// Method wfLoadExtension if ported https://raw.githubusercontent.com/wikimedia/mediawiki/master/includes/GlobalFunctions.php
// and it is slightly modified to not use $wgExtensionDirectory global which is not present in our code

require_once( __DIR__ . '/registration/Processor.php' );
require_once( __DIR__ . '/registration/ExtensionProcessor.php' );
require_once( __DIR__ . '/registration/ExtensionRegistry.php' );

/**
 * Load an extension
 *
 * This queues an extension to be loaded through
 * the ExtensionRegistry system.
 *
 * @param string $ext Name of the extension to load
 * @param string|null $path Absolute path of where to find the extension.json file
 */
function wfLoadExtension( $ext, $path = null ) {
	if ( !$path ) {
		//global $wgExtensionDirectory;
		$path = "extensions/$ext/extension.json";
	}
	ExtensionRegistry::getInstance()->queue( $path );
}

// Wikia change end

/**
 * VisualEditor extension
 *
 * This PHP entry point is deprecated. Please use wfLoadExtension() and the extension.json file
 * instead. See https://www.mediawiki.org/wiki/Manual:Extension_registration for more details.
 *
 * @file
 * @ingroup Extensions
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'VisualEditor' );

	//ExtensionRegistry::getInstance()->loadFromQueue();

	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['VisualEditor'] = array(
		__DIR__ . '/lib/ve/i18n',
		__DIR__ . '/modules/ve-mw/i18n',
		__DIR__ . '/modules/ve-wmf/i18n'
	);

	// Wikia change begin, @author: Inez Korczyński
	ExtensionRegistry::getInstance()->loadFromQueue();
	// Wikia change end

	/* wfWarn(
	'Deprecated PHP entry point used for VisualEditor extension. Please use wfLoadExtension '.
	'instead, see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	); */
	return true;
}

die( 'This version of the VisualEditor extension requires MediaWiki 1.25+.' );

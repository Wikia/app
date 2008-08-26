<?php
# Google Maps Extension: wiki maps made easy
# http://www.mediawiki.org/wiki/Extension:Google_Maps

# Copyright Evan Miller (emmiller@gmail.com)
# Modifications copyright Joshua Hodge

# Version 0.9.4a, 2 Jun 2008

define('GOOGLE_MAPS_EXTENSION_VERSION', '0.9.4a');

// if we're not in the mediawiki framework just die
if( !defined( 'MEDIAWIKI' ) ) {
  die( );
}

# This file contains the hook registration and installation

// require the message file
require( 'extensions/GoogleMaps/GoogleMaps.i18n.php' );
require( 'extensions/GoogleMaps/export/GoogleMapsExporter.php' );
require( 'extensions/GoogleMaps/export/GoogleMapsJsExporter.php' );
require( 'extensions/GoogleMaps/export/GoogleMapsKmlExporter.php' );
require( 'extensions/GoogleMaps/export/GoogleMapsImgExporter.php' );
require( 'extensions/GoogleMaps/SpecialGoogleMapsKML.php' );
require( 'extensions/GoogleMaps/GoogleMaps.body.php' );

/**
 * This function is for rendering a <googlemap> tag on MW 1.5.
 * It cannot be an object function. (Compare to the render16 function
 * of the GoogleMaps class.)
 *
 * @param $pContent string - the content of the <googlemap> tag
 * @param $pArgv array - an array of attribute name/value pairs for the
 *  tag
 *
 * @return string - the HTML string to output for the <googlemap> tag
 **/
function wfGoogleMaps_Render15 ( $pContent, $pArgv ) {
	global $wgGoogleMaps, $wgParser;
	// get the global parser and pass through to the main render function
	return $wgGoogleMaps->render( $pContent, $pArgv, $wgParser, $wgParser );
}

function wfGoogleMaps_RenderKmlLink15 ( $pContent, $pArgv ) {
	global $wgGoogleMaps;
	return $wgGoogleMaps->renderKmlLink( $pContent, $pArgv );
}

function wfGoogleMaps_CommentJS(&$pParser, &$pText) {
    global $wgGoogleMaps;
    return $wgGoogleMaps->commentJS($pParser, $pText);
}

/**
 * This function registers all of the MW hook functions necessary for the
 * map extension to function.  These hooks are added using the array_unshift
 * function in order to get the hook added first.  This is because if another
 * extension returns false from its hook function, it will short-circuit
 * any hooks that come later in the list.
 **/
function wfGoogleMaps_Install() {
	global $wgGoogleMapsKey, $wgGoogleMapsKeys, $wgGoogleMapsDisableEditorsMap, $wgGoogleMapsEnablePaths,
		$wgGoogleMapsDefaults, $wgGoogleMapsMessages, $wgGoogleMapsCustomMessages, $wgGoogleMapsUrlPath,
		$wgXhtmlNamespaces, $wgGoogleMapsTemplateVariables, $wgJsMimeType, $wgLanguageCode, $wgContLang,
		$wgParser, $wgProxyKey, $wgVersion, $wgGoogleMaps, $wgHooks, $wgScriptPath, $wgSpecialPages,
		$wgTitle;
	// set up some default values for the various extension configuration parameters
	// to keep from getting PHP notices if running in strict mode
	if( !isset( $wgGoogleMapsKey ) ) {
		$wgGoogleMapsKey = null;
	}
	if( !isset( $wgGoogleMapsKeys ) ) {
		$wgGoogleMapsKeys = array( );
	}
	if( !isset( $wgGoogleMapsDisableEditorsMap ) ) {
		$wgGoogleMapsDisableEditorsMap = false;
	}
	if( !isset( $wgGoogleMapsEnablePaths ) ) {
		$wgGoogleMapsEnablePaths = false;
	}
	if( !isset( $wgGoogleMapsDefaults ) ) {
		$wgGoogleMapsDefaults = null;
	}
	if( !isset( $wgGoogleMapsCustomMessages ) ) {
		$wgGoogleMapsCustomMessages = null;
	}
	if( !isset( $wgGoogleMapsUrlPath ) ) {
		$wgGoogleMapsUrlPath = "{$wgScriptPath}/extensions/GoogleMaps";
	}
	if( !isset( $wgXhtmlNamespaces ) ) {
		$wgXhtmlNamespaces = null;
	}
	if( !isset( $wgGoogleMapsTemplateVariables ) ) {
		$wgGoogleMapsTemplateVariables = false;
	}

	// make poly-lines work with IE in MW 1.9+. See MW bug #7667
	if( is_array( $wgXhtmlNamespaces ) ) {
		$wgXhtmlNamespaces['v'] = 'urn:schemas-microsoft-com:vml';
		$wgGoogleMapsEnablePaths = true;
	}

	// determine the proper API key.  if any of the array keys in the mApiKeys
	// array matches the current page URL, that key is used.  otherwise, the
	// default in mApiKey is used.
	$longest = 0;
	if( is_array( $wgGoogleMapsKeys ) ) {
		foreach( array_keys( $wgGoogleMapsKeys ) as $key ) {
			$path = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			if( strlen($key) > $longest && substr( $path, 0, strlen( $key ) ) == $key ) {
				$longest = strlen($key);
				$wgGoogleMapsKey = $wgGoogleMapsKeys[$key];
			}
		}
	}

	// add the google mime types
	$magic = null;
	if( version_compare( $wgVersion, "1.8" ) >= 0 ) {
		$magic = MimeMagic::singleton( );
	} else {
		$magic = wfGetMimeMagic( );
	}
	$magic->mExtToMime['kml'] = 'application/vnd.google-earth.kml+xml';
	$magic->mExtToMime['kmz'] = 'application/vnd.google-earth.kmz';

	// instantiate the extension
	$wgGoogleMaps = new GoogleMaps(
		$wgGoogleMapsKey,
		$wgGoogleMapsUrlPath,
		$wgGoogleMapsEnablePaths,
		$wgGoogleMapsDefaults,
		$wgGoogleMapsMessages,
		$wgGoogleMapsCustomMessages,
		$wgGoogleMapsTemplateVariables,
		$wgJsMimeType,
		$wgLanguageCode,
		$wgContLang,
		$wgProxyKey,
		$wgTitle );

	// This hook will add the interactive editing map to the article edit page.
	// This hook was introduced in MW 1.6
        $editHook = array( $wgGoogleMaps, 'editForm' );
	if( version_compare( $wgVersion, "1.6" ) >= 0 ) {
		if( !$wgGoogleMapsDisableEditorsMap ) {
			if( isset( $wgHooks['EditPage::showEditForm:initial'] )
				&& is_array( $wgHooks['EditPage::showEditForm:initial'] ) ) {
					array_unshift( $wgHooks['EditPage::showEditForm:initial'], $editHook );
			} else {
				$wgHooks['EditPage::showEditForm:initial'] = array( $editHook );
			}
		}
	}

	// This hook will do some post-processing on the javascript that has been added
	// to an article.
        $hook = 'wfGoogleMaps_CommentJS';
	if( isset( $wgHooks['ParserAfterTidy'] ) && is_array( $wgHooks['ParserAfterTidy'] ) ) {
		array_unshift( $wgHooks['ParserAfterTidy'], $hook );
	} else {
		$wgHooks['ParserAfterTidy'] = array( $hook );
	}

	// This hook will be called any time the parser encounters a <googlemap>
	// tag in an article.  This will render the actual Google map code in
	// the article.
	if( version_compare( $wgVersion, "1.6" ) >= 0 ) {
		$wgParser->setHook( 'googlemap', array( $wgGoogleMaps, 'render16' ) );
		$wgParser->setHook( 'googlemapkml', array( $wgGoogleMaps, 'renderKmlLink' ) );
	} else {
		$wgParser->setHook( 'googlemap', 'wfGoogleMaps_Render15' );
		$wgParser->setHook( 'googlemapkml', 'wfGoogleMaps_RenderKmlLink15' );
	}

	// Set up the special page
	$wgSpecialPages['GoogleMapsKML'] = array('GoogleMapsKML', 'GoogleMapsKML');
}

// add the install extension function
$wgExtensionFunctions[] = 'wfGoogleMaps_Install'; # array( $wgGoogleMapExtension, 'install' );

// extension credits
$wgExtensionCredits['other'][] = array(
	'name'        => 'Google Maps Extension',
	'author'      => 'Evan Miller',
	'version'     => GOOGLE_MAPS_EXTENSION_VERSION,
	'url'         => 'http://www.mediawiki.org/wiki/Extension:Google_Maps',
	'description' => 'Easily create maps with wiki-fied markers'
);

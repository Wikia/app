<?php
/**
 * Theme "extension" (allows using themes of skins)
 *
 * @file
 * @ingroup Extensions
 * @version 1.5
 * @author Ryan Schmidt <skizzerz at gmail dot com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://en.wikipedia.org/wiki/Public_domain Public domain
 * @link http://www.mediawiki.org/wiki/Extension:Theme Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'Theme',
	'version' => '1.5',
	'author' => array( 'Ryan Schmidt', 'Jack Phoenix' ),
	'description' => 'Theme loader extension for skins',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Theme'
);

// For ShoutWiki, $wgDefaultTheme is set in GlobalSettings.php to 'default'
// For a non-ShoutWiki site where you want to use this extension, you should
// set $wgDefaultTheme to the name of one of the available themes for your
// $wgDefaultSkin

// Register themes for core skins here; for custom skins, do the registration
// in the custom skin's Skinname.php file
//
// Monobook
$wgResourceModules['skins.monobook.dark'] = array(
	'styles' => array(
		'extensions/Theme/monobook/dark.css' => array( 'media' => 'screen' )
	)
);

$wgResourceModules['skins.monobook.pink'] = array(
	'styles' => array(
		'extensions/Theme/monobook/pink.css' => array( 'media' => 'screen' )
	)
);

// Actual extension logic begins here
$wgHooks['BeforePageDisplay'][] = 'wfDisplayTheme';

function wfDisplayTheme( &$out, &$sk ) {
	global $wgRequest, $wgStylePath, $wgStyleDirectory, $wgDefaultTheme, $wgValidSkinNames;
	global $wgResourceModules;

	$theme = $wgRequest->getVal( 'usetheme', false );
	$useskin = $wgRequest->getVal( 'useskin', false );
	$skin = $useskin ? $useskin : $sk->getSkinName();

	if( !array_key_exists( strtolower( $skin ), $wgValidSkinNames ) ) {
		// so we don't load themes for skins when we can't actually load the skin
		$skin = $sk->getSkinName();
	}

	// Monaco is a special case, since it handles its themes in its main PHP
	// file instead of leaving theme handling to us (ShoutWiki bug #173)
	if ( strtolower( $skin ) == 'monaco' ) {
		return true;
	}

	if( $theme ) {
		$themeName = $theme;
	} elseif( isset( $wgDefaultTheme ) && $wgDefaultTheme != 'default' ) {
		$themeName = $wgDefaultTheme;
	} else {
		$themeName = false;
	}

	$moduleName = 'skins.' . strtolower( $skin ) . '.' .
		strtolower( $themeName );

	// Check that we have something to include later on; if not, bail out
	if( !$themeName || !isset( $wgResourceModules[$moduleName] ) ) {
		return true;
	}

	// Add the CSS file, either via ResourceLoader or the old (1.16) way.
	// When adding via RL, we also check that such a module has been registered
	// (above, in the if() loop) because RL may explode if we try to add a
	// module that does not exist.
	$out->addModuleStyles( $moduleName );

	return true;
}
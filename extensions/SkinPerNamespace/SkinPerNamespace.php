<?php
/**
 * Extension based on SkinPerPage to allow a customized skin per namespace
 *
 * Require MediaWiki 1.15.0 or greater.
 *
 * @file
 * @author Alexandre Emsenhuber
 * @license GPLv2
 */

$wgHooks['BeforePageDisplay'][] = 'efSkinPerPageBeforePageDisplayHook';

// Add credits :)
$wgExtensionCredits['other'][] = array(
	'path'        => __FILE__,
	'name'        => 'SkinPerNamespace',
	'url'         => 'https://www.mediawiki.org/wiki/Extension:SkinPerNamespace',
	'version'     => '2011-01-10',
	'description' => 'Allow a per-namespace skin',
	'author'      => 'Alexandre Emsenhuber',

);

// Configuration part, you can copy it to your LocalSettings.php and change it
// there, *not* here. Also modify it after including this file or you won't see
// any changes.

/**
 * Array mapping namespace index (i.e. numbers) to skin names
 */
$wgSkinPerNamespace = array();

/**
 * Skins for special pages, mapping canonical name (see SpecialPage.php) to skin
 * names
 */
$wgSkinPerSpecialPage = array();

/**
 * Override preferences for logged in users ?
 * if set to false, this will only apply to anonymous users
 */
$wgSkinPerNamespaceOverrideLoggedIn = true;

// Implementation

/**
 * Hook function for BeforePageDisplay
 */
function efSkinPerPageBeforePageDisplayHook( OutputPage &$out, Skin &$skin ){
	global $wgSkinPerNamespace, $wgSkinPerSpecialPage,
		$wgSkinPerNamespaceOverrideLoggedIn, $wgUser;

	if( !$wgSkinPerNamespaceOverrideLoggedIn && $wgUser->isLoggedIn() )
		return true;

	$title = $out->getTitle();
	$ns = $title->getNamespace();
	$skinName = null;

	if( $ns == NS_SPECIAL ) {
		list( $canonical, /* $subpage */ ) = SpecialPageFactory::resolveAlias( $title->getDBkey() );
		if( isset( $wgSkinPerSpecialPage[$canonical] ) ) {
			$skinName = $wgSkinPerSpecialPage[$canonical];
		}
	}

	if( $skinName === null && isset( $wgSkinPerNamespace[$ns] ) ) {
		$skinName = $wgSkinPerNamespace[$ns];
	}

	if( $skinName !== null ) {
		$skin = Skin::newFromKey( $skinName );
		$skin->setRelevantTitle( $title );
	}

	return true;
}

<?php

/**
 * Extension based on SkinPerPage to allow a customized skin per namespace
 *
 * Require MediaWiki 1.13.0 for the new version of BeforePageDisplay hook, will
 * produce a warning on older versions.
 *
 * @author Alexandre Emsenhuber
 * @license GPLv2
 */

$wgHooks['BeforePageDisplay'][] = 'efSkinPerPageBeforePageDisplayHook';

// Add credits :)
$wgExtensionCredits['other'][] = array(
	'path'        => __FILE__,
	'name'        => 'SkinPerNamespace',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:SkinPerNamespace',
	'version'     => '2009-04-25',
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
function efSkinPerPageBeforePageDisplayHook( &$out, &$skin ){
	global $wgSkinPerNamespace, $wgSkinPerSpecialPage,
		$wgSkinPerNamespaceOverrideLoggedIn, $wgUser, $wgTitle;

	if( !$wgSkinPerNamespaceOverrideLoggedIn && $wgUser->isLoggedIn() )
		return true;

	$title = is_callable( array( $out, 'getTitle' ) ) ? # 1.15 +
		$out->getTitle() : $wgTitle;
	$ns = $title->getNamespace();
	$skinName = null;

	if( $ns == NS_SPECIAL ) {
		list( $canonical, /* $subpage */ ) = SpecialPage::resolveAliasWithSubpage( $title->getDBkey() );
		if( isset( $wgSkinPerSpecialPage[$canonical] ) ) {
			$skinName = $wgSkinPerSpecialPage[$canonical];
		}
	}

	if( $skinName === null && isset( $wgSkinPerNamespace[$ns] ) ) {
		$skinName = $wgSkinPerNamespace[$ns];
	}
	
	if( $skinName !== null ) {
		$skin = Skin::newFromKey( $skinName );
		if( is_callable( array( $skin, 'setTitle' ) ) ) # 1.15 +
			$skin->setTitle( $out->getTitle() );
	}

	return true;
}

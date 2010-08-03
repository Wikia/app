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
	'name'        => 'SkinPerNamespace',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:SkinPerNamespace',
	'svn-date' => '$LastChangedDate: 2008-06-19 16:50:12 +0200 (czw, 19 cze 2008) $',
	'svn-revision' => '$LastChangedRevision: 36457 $',
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
 * Override preferences for logged in users ?
 * if set to false, this will only apply to anonymous users
 */
$wgSkinPerNamespaceOverrideLoggedIn = true;

// Implementation

/**
 * Hook function for BeforePageDisplay
 */
function efSkinPerPageBeforePageDisplayHook( &$out, &$skin ){
	global $wgSkinPerNamespace, $wgSkinPerNamespaceOverrideLoggedIn, $wgUser, $wgTitle;
	if( !$wgSkinPerNamespaceOverrideLoggedIn && $wgUser->isLoggedIn() )
		return true;

	$ns = $wgTitle->getNamespace();
	if( isset( $wgSkinPerNamespace[$ns] ) )
		$skin = Skin::newFromKey( $wgSkinPerNamespace[$ns] );

	return true;
}

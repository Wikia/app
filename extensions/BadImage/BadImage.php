<?php

/**
 * Extension to extend the bad image list capabilities of MediaWiki
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence Copyright holder allows use of the code for any purpose
 */

if( defined( 'MEDIAWIKI' ) ) {

	global $wgAutoloadClasses, $wgSpecialPages;

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'BadImages',
	'version' => '1.0',
	'author' => 'Rob Church',
	'description' => 'Extend the bad image list capabilities of MediaWiki',
	'descriptionmsg' => 'badimages-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Bad_Image_List',
);
	
	$dir = dirname(__FILE__) . '/';
	$wgAutoloadClasses['BadImageList'] = $dir . 'BadImage.class.php';
	$wgAutoloadClasses['BadImageManipulator'] = $dir . 'BadImage.page.php';
	$wgExtensionMessagesFiles['BadImages'] = $dir . 'BadImage.i18n.php';

	$wgSpecialPages['Badimages'] = 'BadImageManipulator';
	$wgExtensionFunctions[] = 'efBadImageSetup';
	
	$wgAvailableRights[] = 'badimages';
	$wgGroupPermissions['sysop']['badimages'] = true;
	
	/** Set this to false to disable caching results with shared memory caching */
	$wgBadImageCache = true;
	
	function efBadImageSetup() {
		wfLoadExtensionMessages( 'BadImages' );
		global $wgHooks, $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
		$wgHooks['BadImage'][] = 'efBadImage';
		$wgLogTypes[] = 'badimage';
		$wgLogNames['badimage'] = 'badimages-log-name';
		$wgLogHeaders['badimage'] = 'badimages-log-header';
		$wgLogActions['badimage/add']  = 'badimages-log-add';
		$wgLogActions['badimage/remove'] = 'badimages-log-remove';
	}
	
	function efBadImage( $image, &$bad ) {
		if( BadImageList::check( $image ) ) {
			$bad = true;
			return false;
		} else {
			return true;
		}
	}
	
} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}


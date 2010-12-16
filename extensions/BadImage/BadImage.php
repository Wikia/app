<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**
 * Extension to extend the bad image list capabilities of MediaWiki
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence Copyright holder allows use of the code for any purpose
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'BadImages',
	'version' => '1.2',
	'author' => 'Rob Church',
	'description' => 'Extend the bad image list capabilities of MediaWiki',
	'descriptionmsg' => 'badimages-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Bad_Image_List',
);

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['BadImageList'] = $dir . 'BadImage.class.php';
$wgAutoloadClasses['BadImageManipulator'] = $dir . 'BadImage.page.php';
$wgExtensionMessagesFiles['BadImages'] = $dir . 'BadImage.i18n.php';
$wgExtensionAliasesFiles['BadImages'] = $dir . 'BadImage.alias.php';

$wgSpecialPages['Badimages'] = 'BadImageManipulator';
$wgSpecialPageGroups['Badimages'] = 'media';

$wgAvailableRights[] = 'badimages';
$wgGroupPermissions['sysop']['badimages'] = true;

/** Set this to false to disable caching results with shared memory caching */
$wgBadImageCache = true;

$wgHooks['BadImage'][] = 'efBadImage';
$wgHooks['ParserTestTables'][] = 'efBadImageAddTable';

$wgLogTypes[] = 'badimage';
$wgLogNames['badimage'] = 'badimages-log-name';
$wgLogHeaders['badimage'] = 'badimages-log-header';
$wgLogActions['badimage/add']  = 'badimages-log-add';
$wgLogActions['badimage/remove'] = 'badimages-log-remove';

function efBadImage( $image, &$bad ) {
	if ( BadImageList::check( $image ) ) {
		$bad = true;
		return false;
	} else {
		return true;
	}
}

function efBadImageAddTable( &$tables ) {
	$tables[] = 'bad_images';
	return true;
}

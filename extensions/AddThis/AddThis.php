<?php
/**
 * MediaWiki extension to add AddThis widget in a portlet in the sidebar and page header.
 * Installation instructions can be found on
 * https://www.mediawiki.org/wiki/Extension:AddThis
 *
 * @addtogroup Extensions
 * @author Gregory Varnum, significant contributions by Johnduhart
 * @license GPL
 *
 * Loosely based on the Google Translator extension by Joachim De Schrijver
 * Thank you to Johnduhart, Roan Kattouw, Unikum111, catrope, Nikerabbit, Reedy and folks at AddThis for feedback and cleaning up code
 * Thank you to Raymond, Kghbln, Michawiki, Toliño, McDutchie, Bjankuloski06, SPQRobin, Veeven, Gucci Mane Burrr, Kaajawa, Purodha, Kwj2772,
 *     Unikum111, Y-M D, Xuacu, Naudefj, Gomoko, Anakmalaysia, פוילישער, Shizhao, and others mentioned in AddThis.i18n.php for translation work
 */
 
/**
 * Exit if called outside of MediaWiki
 */
if( !defined( 'MEDIAWIKI' ) ) {
        echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
        die( 1 );
}
 

/**
 * SETTINGS
 * --------
 * The following variables may be reset in your LocalSettings.php file.
 *
 * $wgAddThispubid
 * 			- AddThis Profile ID - more info: http://www.addthis.com/help/profiles
 * $wgAddThisBackground
 * 			- Background color for AddThis toolbox displayed in article header
 *			  Default is #f6f6f6
 * $wgAddThisBorder
 * 			- Border color for AddThis toolbox displayed in article header
 *			  Default is #a7d7f9
 * $wgAddThisSidebar
 * 			- Display AddThis widget as sidebar portlet
 *			  Default is true
 * $wgAddThisHeader
 * 			- Display AddThis widget in article headers
 *			  Default is true
 * $wgAddThisMain
 * 			- Display AddThis widget on main page
 *			  Default is true
 * $wgAddThis['addressbarsharing']
 * 			- Enable AddThis Address Bar Sharing - http://www.addthis.com/help/address-bar-sharing-analytics
 *			  Default is false
 * $wgAddThisSBServ[0]['service']
 * 			- Service code for 1st button in sidebar - service codes: http://www.addthis.com/services/list
 *			  Default is compact - AddThis icon used to access full AddThis popup menu
 * $wgAddThisSBServ[0]['attribs']
 * 			- Settings for 1st button in sidebar - more info: http://www.addthis.com/help/client-api#attribute-config
 * $wgAddThisSBServ[1]['service']
 * 			- Service code for 2nd button in sidebar
 *			  Default is facebook
 * $wgAddThisSBServ[1]['attribs']
 * 			- Settings for 2nd button in sidebar
 * $wgAddThisSBServ[2]['service']
 * 			- Service code for 3rd button in sidebar
 *			  Default is twitter
 * $wgAddThisSBServ[2]['attribs']
 * 			- Settings for 3rd button in sidebar
 * $wgAddThisSBServ[3]['service']
 * 			- Service code for 4th button in sidebar
 *			  Default is google_plusone
 * $wgAddThisSBServ[3]['attribs']
 * 			- Settings for 4th button in sidebar
 *			  Default is g:plusone:count="false" style="margin-top:1px;"
 * $wgAddThisSBServ[4]['service']
 * 			- Service code for 5th button in sidebar
 *			  Default is email
 * $wgAddThisSBServ[4]['attribs']
 * 			- Settings for 5th button in sidebar
 * $wgAddThisHServ[0]['service']
 * 			- Service code for 1st button in article header after AddThis icon (which cannot be moved in the header)
 *			  Default is facebook
 * $wgAddThisHServ[0]['attribs']
 * 			- Settings for 1st button in article header
 * $wgAddThisHServ[1]['service']
 * 			- Service code for 2nd button in article header
 *			  Default is twitter
 * $wgAddThisHServ[1]['attribs']
 * 			- Settings for 2nd button in article header
 * $wgAddThisHServ[2]['service']
 * 			- Service code for 3rd button in article header
 *			  Default is google_plusone
 * $wgAddThisHServ[2]['attribs']
 * 			- Settings for 3rd button in article header
 *			  Default is g:plusone:count="false" style="margin-top:1px;"
 * $wgAddThisHServ[3]['service']
 * 			- Service code for 4th button in article header
 *			  Default is linkedin
 * $wgAddThisHServ[3]['attribs']
 * 			- Settings for 4th button in article header
 * $wgAddThisHServ[4]['service']
 * 			- Service code for 5th button in article header
 *			  Default is tumblr
 * $wgAddThisHServ[4]['attribs']
 * 			- Settings for 5th button in article header
 * $wgAddThisHServ[5]['service']
 * 			- Service code for 6th button in article header
 *			  Default is stumbleupon
 * $wgAddThisHServ[5]['attribs']
 * 			- Settings for 6th button in article header
 * $wgAddThisHServ[6]['service']
 * 			- Service code for 7th button in article header
 *			  Default is reddit
 * $wgAddThisHServ[6]['attribs']
 * 			- Settings for 7th button in article header
 * $wgAddThisHServ[7]['service']
 * 			- Service code for 8th button in article header
 *			  Default is email
 * $wgAddThisHServ[7]['attribs']
 * 			- Settings for 8th button in article header
 */

$wgAddThispubid		 = '';

# Default values for most options
$wgAddThisBackground = '#f6f6f6';
$wgAddThisBorder	 = '#a7d7f9';
$wgAddThisSidebar	 = true;
$wgAddThisHeader	 = true;
$wgAddThisMain		 = true;
$wgAddThis = array(
	'addressbarsharing' => false,
);

# Sidebar settings
$wgAddThisSBServ = array(
	array(
		'service' => 'compact',
	),
	array(
		'service' => 'facebook',
	),
	array(
		'service' => 'twitter',
	),
	array(
		'service' => 'google_plusone',
		'attribs' => 'g:plusone:count="false" style="margin-top:1px;"',
	),
	array(
		'service' => 'email',
	),
);

# Toolbar settings
$wgAddThisHServ = array(
	array(
		'service' => 'facebook',
	),
	array(
		'service' => 'twitter',
	),
	array(
		'service' => 'google_plusone',
		'attribs' => 'g:plusone:count="false" style="margin-top:1px;"',
	),
	array(
		'service' => 'linkedin',
	),
	array(
		'service' => 'tumblr',
	),
	array(
		'service' => 'stumbleupon',
	),
	array(
		'service' => 'reddit',
	),
	array(
		'service' => 'email',
	),
);


/**
 * Credits
 *
 */
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'AddThis',
	'version'        => '1.0.1',
	'author'         => '[https://www.mediawiki.org/wiki/User:Varnent Gregory Varnum] (Contributions by [https://www.mediawiki.org/wiki/User:Johnduhart John Du Hart])',
	'description'    => 'Adds [http://www.addthis.com AddThis button] to the sidebar and page header',
	'descriptionmsg' => 'addthis-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:AddThis',
);

/**
 * Register class and localisations
 *
 */
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['AddThis'] = $dir . 'AddThis.body.php';
$wgExtensionMessagesFiles['AddThis'] = $dir . 'AddThis.i18n.php';

$wgResourceModules['ext.addThis'] = array(
	'styles' => 'addThis.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'AddThis',
);

/**
 * Hooks
 *
 */
$wgHooks['ArticleViewHeader'][] = 'AddThis::AddThisHeader';
$wgHooks['ParserFirstCallInit'][] = 'AddThis::AddThisHeaderTag';
$wgHooks['SkinBuildSidebar'][] = 'AddThis::AddThisSidebar';

<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Reflect',
	'version' => '0.1-alpha',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Reflect',
	'author' => array( 'Travis Kriplean' ),
	'descriptionmsg' => 'reflect-desc',
);
	
/************************* 
 * CONFIGURATION SECTION * 
 *************************/

/* Allows activation of LiquidThreads on individual pages */
$wgReflectTalkPages = array( 'Talk:Main_Page' );

/* Allows switching Reflect off for regular talk pages
	(intended for testing and transition) */
$wgReflectPages = false;

/* Whether or not to activate Reflect email notifications */
$wgReflectEnotif = true;

/* Whether or not a research study is being conducted 
 * This should not be enabled for a long-term deployments.
 * Find more information in server/api/ApiReflectStudyAction.php */
$wgReflectStudy = true;

if ( $wgReflectStudy ) {
	/* Unique identifier for the current study */
	$wgReflectStudyDomain = 'mediawiki_chi';
	
	/* The location of the study API for posting results of surveys through RPC */
	$wgReflectStudyRPCHost = 'http://daniels.cs.washington.edu/reflect_study/rpc/';
}
/********* end configuration ***************/


/**************************** 
 * EXTENSION INITIALIZATION * 
 ****************************/

$dir = dirname( __FILE__ ) . '/';

$wgReflectExtensionName = 'Reflect';

// Classes
$wgAutoloadClasses['ApiReflectAction'] = "$dir/server/api/ApiReflectAction.php";
$wgAutoloadClasses['ReflectDispatch'] = "$dir/server/classes/Dispatch.php";

// API
$wgAPIModules['reflectaction'] = 'ApiReflectAction';

// Hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'reflectAddGlobalVars';
$wgHooks['BeforePageDisplay'][] = 'ReflectDispatch::tryPage';

// Localisation
$wgExtensionMessagesFiles['Reflect'] = "$dir/server/i18n/Reflect.i18n.php";

function reflectAddGlobalVars( &$vars ) {
	global $wgUser, $wgReflectStudy;
	$vars['wgUser'] = $wgUser->getName();
	$vars['wgIsAdmin'] = in_array( 'sysop', $wgUser->getGroups() );
	$vars['wgReflectStudyEnabled'] = $wgReflectStudy;
	return true;
}

/* If this reflect deployment has a research component, need to enable XML-RPC
 * NOTE: this requires http://pear.php.net/package/XML_RPC2/ */
if ( $wgReflectStudy ) {
	// Classes
	$wgAutoloadClasses['ApiReflectStudyAction'] = "$dir/server/api/ApiReflectStudyAction.php";
	// API
	$wgAPIModules['reflectstudyaction'] = 'ApiReflectStudyAction';
}
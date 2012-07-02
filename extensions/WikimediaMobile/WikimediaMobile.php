<?php

/**
 * MediaWiki support functions for the Wikimedia-mobile project hosted 
 * at http://github.com/hcatlin/wikimedia-mobile
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'WikimediaMobile',
	'author' => array( 'Tim Starling', 'Brion Vibber', 'Hampton Catlin', 'Patrick Reilly' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:WikimediaMobile',
	'descriptionmsg' => 'wikimediamobile-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WikimediaMobile'] = $dir . 'WikimediaMobile.i18n.php';

/**
 * Increment this when the JS file changes
 */
$wgWikimediaMobileVersion = '8';

/**
 * The base URL of the mobile gateway
 */
$wgWikimediaMobileUrl = 'http://en.m.wikipedia.org/wiki';


$wgHooks['BeforePageDisplay'][] = 'wfWikimediaMobileAddJs';
$wgHooks['MakeGlobalVariablesScript'][] = 'wfWikimediaMobileVars';

function wfWikimediaMobileAddJs( &$outputPage, &$skin ) {
	global $wgOut, $wgExtensionAssetsPath, $wgWikimediaMobileVersion;

	global $wgTitle, $wgRequest, $wgWikimediaMobileUrl;
	$ns = $wgTitle->getNamespace();
	$action = FormatJson::encode( $wgRequest->getVal( 'action', 'view' ) );
	$page = FormatJson::encode( $wgTitle->getPrefixedDBkey() );
	$mainpage = Title::newMainPage();
	$mp = FormatJson::encode( $mainpage ? $mainpage->getPrefixedText() : null );
	$url = FormatJson::encode( $wgWikimediaMobileUrl );
	$wgOut->addHeadItem( 'mobileredirectvars', Html::inlineScript( "wgNamespaceNumber=$ns;wgAction=$action;wgPageName=$page;wgMainPageTitle=$mp;wgWikimediaMobileUrl=$url;" ) );
	$wgOut->addHeadItem( 'mobileredirect', Html::linkedScript(
		"$wgExtensionAssetsPath/WikimediaMobile/MobileRedirect.js?$wgWikimediaMobileVersion"
	) );
	return true;
}

function wfWikimediaMobileVars( &$vars ) {
	global $wgWikimediaMobileUrl;
	$vars['wgWikimediaMobileUrl'] = $wgWikimediaMobileUrl;
	return true;
}

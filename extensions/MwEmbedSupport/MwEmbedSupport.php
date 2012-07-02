<?php
/**
 * MwEmbed Support Extension, Supports MwEmbed based modules, 
 * and registers shared javascript resources. 
 * 
 * @file
 * @ingroup Extensions
 * 
 * @author Michael Dale ( michael.dale@kaltura.com )
 * @license GPL v2 or later
 * @version 0.3.0
 */
   
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is the TimedMediaHandler extension. Please see the README file for installation instructions.\n";
	exit( 1 );
}

/* Configuration */

// When used as a MediaWiki extension we are not in $wgEnableMwEmbedStandAlone mode:
$wgEnableMwEmbedStandAlone = false; 


/* Setup */
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MwEmbedSupport',
	'author' => array( 'Michael Dale' ),
	'version' => '0.2',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MwEmbed',
	'descriptionmsg' => 'mwembed-desc',
);

$wgAutoloadClasses['MwEmbedResourceManager'] = dirname( __FILE__ ) . '/MwEmbedResourceManager.php';
$wgAutoloadClasses['MwEmbedSupportHooks'] = dirname( __FILE__ ) . '/MwEmbedSupport.hooks.php';

/* MwEmbed Module Registration */
$wgHooks['SetupAfterCache'][] = 'MwEmbedSupportHooks::register';
	

<?php

/**
 * @author Anna Kantorovitch and Benedikt Kämpgen
 * @file SWB_Settings
 * @ingroup SWB
 */

#################################################################
#    CHANGING THE CONFIGURATION FOR SEMANTIC WEBBROWSER         #
#################################################################
# Do not change this file directly, but copy custom settings    #
# into your LocalSettings.php. Most settings should be made     #
# between including this file and the call to enableSemantics().#
# Exceptions that need to be set before are documented below.   #
#################################################################
$swbgIP = dirname( __FILE__ ) . '/';

$wgExtensionCredits['semantic'][] = array(
	'path'    => __FILE__,
	'name'    => 'Semantic Web Browser',
	'version' =>  '0.2',
	'author'  =>  array( 'Benedikt Kaempgen', 'Anna Kantorovitch' ),
	'url'     =>  'http://semantic-mediawiki.org',
	'descriptionmsg' =>  'swb_desc'
);

/**
 * The toolbox of each content page show a link to browse the semantic web
 * of that page using Special:Browse Wiki & Semantic Web
 */
$swbgToolboxBrowseSemWeb = true;

// load global constants and setup functions
require_once( $swbgIP . 'SemanticWebBrowser.php' );
<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is not a valid entry point.\n";
	exit( 1 );
}

# default settings for UNIWIKI extension package
$wgLogo = "$wgScriptPath/extensions/uniwiki/uniwiki.png"; 
$uw = "$IP/extensions/uniwiki"; 
require_once("$uw/CssHooks/CssHooks.php"); 
require_once("$uw/Javascript/Javascript.php"); 
require_once("$uw/MooTools12core/MooTools12core.php"); 
require_once("$uw/AutoCreateCategoryPages/AutoCreateCategoryPages.php"); 
require_once("$uw/GenericEditPage/GenericEditPage.php"); 
require_once("$uw/CatBoxAtTop/CatBoxAtTop.php"); 
require_once("$uw/Layouts/Layouts.php"); 
# Broken. creditLink() missing.
#require_once("$uw/Authors/Authors.php"); 
require_once("$uw/CustomToolbar/CustomToolbar.php"); 
require_once("$uw/CreatePage/CreatePage.php"); 
require_once("$uw/FormatChanges/FormatChanges.php"); 
require_once("$uw/FormatSearch/FormatSearch.php");

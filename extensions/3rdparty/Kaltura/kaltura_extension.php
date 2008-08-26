<?php
/*
This file is part of the Kaltura Collaborative Media Suite which allows users 
to do with audio, video, and animation what Wiki platfroms allow them to do with 
text.

Copyright (C) 2006-2008  Kaltura Inc.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/



require_once ( dirname(__FILE__) . "/kalturaapi_php5_lib.php" );
require_once ( dirname(__FILE__) . "/partner_settings.php" );
require_once ( dirname(__FILE__) . "/wiki_helper_functions.php" );

require_once ( dirname(__FILE__) . "/KalturaNamespace.php" );
require_once ( dirname(__FILE__) . "/NamespaceManager.php" );

define ( 'KALTURA_NAMESPACE' , "Kaltura:" );
define ( 'KALTURA_NAMESPACE_ID' , 320);
define ( 'KALTURA_DISCUSSION_NAMESPACE_ID' , 321);

$wgExtensionCredits['other'][] = array(
        'name'              => "CollaborativeVideo", 
        'version'           => "0.5" ,
        'author'            => "Kaltura" , 
        'description'  		=> "Enables to create collaborative videos, add to them and edit them.",
        'url'               => "http://www.mediawiki.org/wiki/Extension:KalturaCollaborativeVideo" ,                      
);

$wgExtensionFunctions[] = 'efKalturaSetup';

$wgExtraNamespaces[KALTURA_NAMESPACE_ID]  = "Kaltura" ;
$wgExtraNamespaces[KALTURA_NAMESPACE_ID + 1]  = "Kaltura_talk";

$wgContentNamespaces[] = KALTURA_NAMESPACE_ID;
$wgGroupPermissions[ '*' ][ 'ns' . KALTURA_NAMESPACE_ID . '_edit' ] = true;
$wgGroupPermissions[ '*' ][ 'ns' . KALTURA_NAMESPACE_ID . '_read' ] = true;
$wgGroupPermissions[ '*' ][ 'ns' . KALTURA_NAMESPACE_ID . '_create' ] = true;
$wgGroupPermissions[ '*' ][ 'ns' . KALTURA_NAMESPACE_ID . '_move' ] = false;
$wgContentNamespaces[] = KALTURA_DISCUSSION_NAMESPACE_ID;
$wgGroupPermissions[ '*' ][ 'ns' . KALTURA_DISCUSSION_NAMESPACE_ID . '_edit' ] = true;
$wgGroupPermissions[ '*' ][ 'ns' . KALTURA_DISCUSSION_NAMESPACE_ID . '_read' ] = true;
$wgGroupPermissions[ '*' ][ 'ns' . KALTURA_DISCUSSION_NAMESPACE_ID . '_create' ] = true;
$wgGroupPermissions[ '*' ][ 'ns' . KALTURA_DISCUSSION_NAMESPACE_ID . '_move' ] = false;

//$wgGroupPermissions[ 'user' ][ 'ns' . KALTURA_NAMESPACE_ID . '_move' ] = false;  // users can't move the Kaltura: pages

//require_once ( dirname(__FILE__) . "/NamespacePermissions.php" );

//$wgHooks['OutputPageParserOutput'][] = 'fnKalturaOutputPageParserOutput'; 
$wgHooks['SkinAfterBottomScripts'][] = 'fnKalturaSkinAfterBottomScripts'; 
//$wgHooks['BeforePageDisplay'][] = 'fnKalturaBeforePageDisplay';
$wgHooks['OutputPageBeforeHTML'][] = 'fnKalturaBeforePageDisplay';
$wgHooks['MonoBookTemplateToolboxEnd'][] = 'fnKalturaMonoBookTemplateToolboxEnd';

// create/update kshow
$wgAutoloadClasses['KalturaCollaborativeVideoInfo'] = dirname(__FILE__) . '/KalturaCollaborativeVideoInfo_body.php'; # Tell MediaWiki to load the extension body.
$wgSpecialPages['KalturaCollaborativeVideoInfo'] = 'KalturaCollaborativeVideoInfo'; # Let MediaWiki know about your new special page.
$wgAutoloadClasses['KalturaAjaxCollaborativeVideoInfo'] = dirname(__FILE__) . '/KalturaAjaxCollaborativeVideoInfo_body.php'; # Tell MediaWiki to load the extension body.
$wgSpecialPages['KalturaAjaxCollaborativeVideoInfo'] = 'KalturaAjaxCollaborativeVideoInfo'; # Let MediaWiki know about your new special page.

// CW
$wgAutoloadClasses['KalturaContributionWizard'] = dirname(__FILE__) . '/KalturaContributionWizard_body.php'; # Tell MediaWiki to load the extension body.
$wgSpecialPages['KalturaContributionWizard'] = 'KalturaContributionWizard'; # Let MediaWiki know about your new special page.

// Editor launcher
$wgAutoloadClasses['KalturaVideoEditor'] = dirname(__FILE__) . '/KalturaVideoEditor_body.php'; # Tell MediaWiki to load the extension body.
$wgSpecialPages['KalturaVideoEditor'] = 'KalturaVideoEditor'; # Let MediaWiki know about your new special page.

// Test page 
// TODO - remove when in production
$wgAutoloadClasses['KalturaTestPage'] = dirname(__FILE__) . '/KalturaTestPage_body.php'; # Tell MediaWiki to load the extension body.
$wgSpecialPages['KalturaTestPage'] = 'KalturaTestPage'; # Let MediaWiki know about your new special page.

$kaltura_namespace_mgr = null;



// TODO -  should add to toolbar ??
// hook to bottom of toolbar
function fnKalturaMonoBookTemplateToolboxEnd ( $monobook ) 
{
	echo createCollaborativeVideoLinkForToolbox();
	return true;
}


/**
 * Add JS to be called at the end of the regular edit page
 * See SkinAfterBottomScripts hook for the skin & text paramters.
 * All we need is to add a script element that calls the 'kalturaAddButtonsToEdit' js function with the 
 * 	$root_url - to create the iframe/ajax call
 * 	$kaltura_path - to find the button's image in kaltura extension path 
 */ 
function fnKalturaSkinAfterBottomScripts ($skin, &$text)
{
	$text .= createJsForAddButtonForEdit (); 
	return true;	
}

/**
 * Will add JS and CSS depending on the context of the page.
 * kaltura.js & kaltura.css will always be added.
 * a group of js for widgets will always be added.
 * a function to add a button to the edit page will be added only when in NON KALTURA NAMESPACE 
 * 	and when in edit mode.
 */
function fnKalturaBeforePageDisplay ( $out )
{
	global $wgTitle , $wgVersion;
	
	// always add kaltura css & js - they should be harmless for other pages due to the kaltura prefix
	$out->addScript ( getKalturaScriptAndCss() );

	// add js for widget - for now in all pages
	$current_paget_url = $wgTitle->getFullURL( "" );
	$out->addScript ( createJsForWidget ( $current_paget_url ) );

	// if of early versions - add the script here - 
	// this will cause the button to be added earlt and will appear at the beginning of the button list
	if (version_compare($wgVersion, '1.10', '<' ) ) 
	{
		$js_to_add = createJsForAddButtonForEdit ();
		if ( ! empty ( $js_to_add ) )
		{
			$out->addScript($js_to_add);
		}
	}
	return true;	
}


function efKalturaSetup()
{
    global $wgParser;
    $wgParser->setHook( 'kaltura-widget', 'efKalturaWidgetRender' );

    NamespaceManagers::register ( KALTURA_NAMESPACE_ID  , "KalturaNamespace" , pathinfo( __FILE__ , PATHINFO_DIRNAME ) . "/KalturaNamespace.php" );
}
 
// add some ajax hooks
$wgAjaxExportList[] = 'ajaxKalturaUpdateArticle';


function ajaxKalturaUpdateArticle ( $kshow_id ) 
{
	kalturaLog( "ajaxKalturaUpdateArticle: [$kshow_id]" );
	KalturaNamespace::updateThisArticle( false , $kshow_id , ktoken ( "update_article_contrib" ) );
	return "";	
}


$current_widget_kshow_id_list = array();
$set_hooks_after_widget = false;


/**
Add us as a listner to the page save - only in this case
*/
function efKalturaWidgetRender( $input, $args, $parser ) 
{
	global $wgHooks;
	global $wgOut ;

	global $set_hooks_after_widget;
	
	// this will prevent adding several hooks when more than one widget is used in a page
	if ( ! $set_hooks_after_widget)
	{
		// set a hook
//    	$wgHooks['ParserAfterTidy'][] = 'kalturaWidgetParserAfterTidy';
    	$wgHooks['SearchUpdate'][] = 'kalturaWidgetSearchUpdate';
    	$set_hooks_after_widget = true;
	}
    
    $attr = array();

    $entry_id = null;
    $kshow_id = @$args["kalturaid"];
    //$entry_id = @$args["entryid"];
    $size = strtolower( @$args["size"] );
    $align = strtolower( @$args["align"] );
    $version = strtolower( @$args["version"] );
    $name = strtolower( @$args["name"] );
    $description = strtolower( @$args["summary"] );
    
   	if ( empty ( $kshow_id ) )
    {
		return "<b>kaltura-widget: Mandatory tag missing: 'kalturaid'. Make sure the case of the attribute is LOWER-CASE.</b>";	
    }
    

    kalturaLog ( "efKalturaWidgetRender" );

    // here we don't expect to insert the version - if we do set it, it will no be up-to-date
	if ( $parser->getTitle()->getNamespace() != KALTURA_NAMESPACE_ID )
	{
		// for all widgets that are not in the kaltura namespace - ignore the version so they will be up-to-date 
		$version = null;
	}
    return createWidgetHtml ( $kshow_id , $entry_id , $size , $align , $version , $name, $description );
}


function kalturaWidgetSearchUpdate( $id, $namespace, $title, &$text)
{
	global $current_widget_kshow_id_list;
	
	foreach ( $current_widget_kshow_id_list as $kshow_id )
	{
		$text .= searchableText ( $kshow_id );
	}
			
	return true;
}
?>

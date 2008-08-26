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

define ( 'PLACEHOLDER_FOR_WIDGET_JAVASCRIPT' , "__PLACEHOLDER_FOR_WIDGET_JAVASCRIPT__");

function escapeString ( $str )
{
	return 	str_replace ( array ( "'" , "\n\r" , "\n" , "\r" , ), array ( "\\'" , " " , " " , " " ) , $str );
}


function formatDate ( $time )
{
	return strftime( "%d/%m/%y %H:%M:%S" , $time ) ;	
}


function TRACE ( $str , $pre = false)
{
	//return ;
	
	global  $wgOut;
	
	if ( is_array ( $str ) )
	{
		$str = print_r ( $str , true );
		$pre = true;
	}
	
	$html = ""; 
	if ( $pre ) 
	{
		$html .= "<pre>" . "[" . time() . "] " . $str . "</pre>" ;
	}
	else
	{
		$html .= "[" . time() . "] " . $str . "<br>";
	}
	
	$wgOut->addHTML ( $html );  
}



$log_file_name = $wgKalturaLog;
$log_fh = null; 
function kalturaLog ( $content )
{
	global $log_file_name;
	global $log_fh;
	global $log_kaltura_services;
	if ( ! $log_kaltura_services ) return;	
	
	if ( $log_fh == null )	$log_fh = @fopen($log_file_name, 'a');
	
	if ( $log_fh != FALSE )	fwrite($log_fh, "(" . time() . ")" . $content . "\n"); // if the directory of file don't exuist - continue ...
}

function closeKalturaLog ( )
{
	if ( $log_fh != null )	$log_fh = fclose($log_fh );
}

function getKalturaLogName ( )
{
	global $log_file_name;
	return $log_file_name;
}

function getKalturaUserFromWgUser ( $w_user = null )
{
	global $wgUser;
	global $kg_allow_anonymous_users;
	
	if ( $w_user == null )
	{
		$w_user = $wgUser;
	}
	
	$kaltura_user = new kalturaUser();
	if ( $w_user->isLoggedIn() ) 
	{	
		$kaltura_user->puser_id = $w_user->getId();
		$kaltura_user->puser_name = $w_user->getName();
	}
	elseif ( $kg_allow_anonymous_users )
	{
		// create an anonymous user only if allowed by partner
		// 	if Anonymous - set some default values
		$kaltura_user->puser_id = "_" . $w_user->getId();
		$kaltura_user->puser_name = "__ANONYMOUS__";
	}
	else
	{
		$kaltura_user->puser_id = "";
		$kaltura_user->puser_name = "";
	}
		
	return $kaltura_user;
}


function verifyUserRights($w_user = null )
{
	global $wgUser;
	global $kg_allow_anonymous_users;
	
//	echo "<pre>" . print_r ( $w_user , true ) . "</pre>";
	
	if ( $w_user == null )
	{
		$w_user = $wgUser;
	}
	
	$rights = $w_user->getRights();
	// is allow anonymous users - check the user's rights
	if ( $kg_allow_anonymous_users ) 
	{
		return in_array ( "edit" , $rights );
	}
	else
	{
		return $w_user->isLoggedIn();		
	}
	
	return false;
}

function kshowIdFromTitle ( $title_obj )
{
	$namespace = $title_obj->mNamespace	;
	$title = $title_obj->mUrlform	;
	
	if ( $namespace == KALTURA_NAMESPACE_ID )
	{
		$kshow_id = preg_replace ( "/[vV]ideo[^\d]*/" , "" , $title );
		return $kshow_id;
	}
	return -1;
}

function searchableText ( $kshow_id )
{
	return " video_$kshow_id ";	
}

function titleFromKshowId ( $kshow_id )
{
	$str = KALTURA_NAMESPACE . "video_" . $kshow_id;
	return $str; 
}


function getRelevantText ( $text )
{
	global $send_raw_text;
	if ( $send_raw_text )
	{ 
		$extract_text = preg_replace ( "/<script[^<]+?<\/script>/"  , " " , $text ); // remove the html script tag and it's content		
	}
	else
	{
		$extract_text = preg_replace ( "/<[^>]+?>/"  , " " , $text );
		$extract_text = preg_replace ( '/ {2,}/' , " " , $text ); // remove double spaces
	}
	return $extract_text;
}

function createSelectHtml ( $name , $option_values , $current_value = null )
{
	$str = "<select name='$name' id='$name'>" ;
	foreach ( $option_values as $value => $option )
	{
		$str .= "<option value='$value' " . ( $current_value == $value ? "selected='selected'" : "" ) . ">$option</option>" ;
	}
	$str .= "</select>";
	return $str;
}

function createRadioHtml ( $name , $option_values , $current_value = null )
{
//<label class="radio"><input type="radio" name="widget_align" value="L" checked="checked" />Left</label>
	$str = "";	
	foreach ( $option_values as $value => $option )
	{
		$str .= "<label class='radio'><input type='radio' name='{$name}' value='{$value}' " . ( $current_value == $value ? "checked='checked'" : "" ) . "/>{$option}</label>\n";
	}

	return $str;
}


function createWidgetTag ( $kshow_id ,$entry_id = null,  $size = "l" , $align = "" , $version=null , $name=null , $description=null )
{
	return "<kaltura-widget kalturaid='$kshow_id' size='$size' align='$align'" . 
		( $version ? " version='$version'" : "" ) . 
		( $name ? " name='$name'" : "" ) .
		( $description ? " summary='$description'" : "" ) .
		"/>";
}
 	
$added_js_for_widget = false;
$javascript_for_widget = "";

// 
function createWidgetHtml ( $kshow_id , $entry_id , $size , $align , $version=null , $version_kshow_name=null , $version_kshow_description=null)
{
	global $wgTitle , $wgUser , $wgOut;
	global $partner_id, $subp_id, $partner_name;
	global $ks; // assume there is a ks for the user- there as a successful startSession
	global $WIDGET_HOST;	
	global $current_widget_kshow_id_list;
	global $added_js_for_widget, $javascript_for_widget ;
	
    $media_type = 2;
    $widget_type = 3;
    
     // add the version as an additional parameter
	$domain = $WIDGET_HOST; //"http://www.kaltura.com";
	$swf_url = "/index.php/widget/$kshow_id/" . 
		( $entry_id ? $entry_id : "-1" ) . "/" .
		( $media_type ? $media_type : "-1" ) . "/" .
		( $widget_type ? $widget_type : "3" ) . "/" . // widget_type=3 -> WIKIA
		( $version ? "$version" : "-1" ); 

	$current_widget_kshow_id_list[] = $kshow_id;
	
	$kshowCallUrl = "$domain/index.php/browse?kshow_id=$kshow_id";
	$widgetCallUrl = "$kshowCallUrl&browseCmd=";
	$editCallUrl = "$domain/index.php/edit?kshow_id=$kshow_id";
//	$producerCallUrl = "$domain/index.php/mykaltura/viewprofile?screenname=$producerName";

/* 
  widget3:
  url:  /widget/:kshow_id/:entry_id/:kmedia_type/:widget_type/:version
  param: { module: browse , action: widget }
 */
    if ( $size == "m")
    {
    	// medium size
    	$height = 198 + 105;
    	$width = 267;
    }
    else
    {
    	// large size
    	$height = 300 + 105 + 20;
    	$width = 400;
    }
    
	$titleObj = $wgTitle;
	$current_paget_url = $titleObj->getFullURL( "" );


	$root_url = getRootUrl();
	
// because there might be more than one widget per page - the kshow_id should be passed as a parameter
    $extra_links  = "<a href='javascript:gotoCW( \"$kshow_id\" )'>Contribute<a> ";
    $extra_links .= "<a href='javascript:gotoEdit( \"$kshow_id\" )'>Edit<a> ";
    $extra_links .= "<a href='javascript:gotoEditor( \"$kshow_id\" )'>Editor<a> ";
    $extra_links .= "<a href='javascript:gotoKalturaArticle( \"$kshow_id\" )'>KalturaArticle<a> ";
    $extra_links .= "<a href='javascript:gotoGenerate( \"$kshow_id\" )'>Generate<a> ";
    $extra_links .= "<br>";
    
    $str = "";//$extra_links ; //"";

/*    
    if ( ! $added_js_for_widget )
    {
	    // will add the script every time there is a widget
    	$javascript_for_widget = createJsForWidget ( $current_paget_url );

	    if ( $titleObj->getNamespace() == KALTURA_NAMESPACE_ID )
	    {
	    	// these pages have the widget added dynamically 
	    	$wgOut->addScript ( $javascript_for_widget );
	    }
	    
	    else
	    {
	    	kalturaLog( "createWidgetHtml [$added_js_for_widget] [$javascript_for_widget]" );
	    	$str .= PLACEHOLDER_FOR_WIDGET_JAVASCRIPT ; //$javascript_for_widget ;
	    }

		$added_js_for_widget = true;	    
    }    
  */  
    $external_url = "http://" . @$_SERVER["HTTP_HOST"] ."$root_url";

    // TODO - move to some better place !!
	// TODO - PERFORMACE -cache the request to getkshow - this data is used several time within a single request
	// TODO - PERFORMACE no need to start a session either ! 
	$user_id = $wgUser->getId();
	$share = $titleObj->getFullUrl ();
    
/*   
    $links_arr = array (
//    		"base" => "$external_url/Special:KalturaDispatcher?id=$kshow_id&c=" , 
    		"add" => "$external_url/Special:KalturaContributionWizard?kshow_id=$kshow_id" ,
    		"edit" => "$external_url/Special:KalturaVideoEditor?kshow_id=$kshow_id" ,
    		"kshow" => "$external_url/"  . titleFromKshowId( $kshow_id ) . "?kshow_id=$kshow_id" ,
			"share" => $share ,
    	);
*/
	
	// this is a shorthand version of the kdata
    $links_arr = array (
    		"base" => "$external_url/" , 
    		"add" =>  "Special:KalturaContributionWizard?kshow_id=$kshow_id" ,
    		"edit" => "Special:KalturaVideoEditor?kshow_id=$kshow_id" ,
    		"share" => $share ,
    	);
    	
    $links_str = str_replace ( array ( "|" , "/") , array ( "|01" , "|02" ) , base64_encode ( serialize ( $links_arr ) ) ) ;
    
//    $links_arr = str_replace ( array ( "|02" , "|01" ) , array ( "/" , "|" ) , base64_decode ( unserialize ( $links_str ) ) ) ;
     
	//$kaltura_link = "<a href='http://www.kaltura.com' style='color:#bcff63; text-decoration:none; '>Kaltura</a>";
	$kaltura_link = "<a href='http://www.kaltura.com' style='color:#bcff63; text-decoration:none; '>Kaltura</a>";
	$kaltura_link_str = "A $partner_name collaborative video powered by  "  . $kaltura_link;
	
	$flash_vars = array (  "CW" => "gotoCW" ,
    						"Edit" => "gotoEdit" ,
    						"Editor" => "gotoEditor" ,
							"Kaltura" => "gotoKalturaArticle" ,
							"Generate" => "gotoGenerate" ,
							"share" => $share ,
							"WidgetSize" => $size );

	// add only if not null 							
	if ( $version_kshow_name ) $flash_vars["Title"] = $version_kshow_name;
	if ( $version_kshow_description ) $flash_vars["Description"] = $version_kshow_description;	

/*	
	// this means we are trying to freeze the version, therefor we'll send the name and value from the  
		$kaltura_services = kalturaService::getInstance( $user_id );
		$params = array (  "kshow_id" => $kshow_id ); 
		$res = $kaltura_services->getkshow( $user_id , $params );
		$name = @$res["result"]["kshow"]["name"] ;
		$description = @$res["result"]["kshow"]["description"] ;
*/	
	
	
	$swf_url .= "/" . $links_str;
   	$flash_vars_str = http_build_query( $flash_vars , "" , "&" )		;	
    
    $widget = /*$extra_links .*/
		 '<object id="kaltura_player_' . (int)microtime(true) . '" type="application/x-shockwave-flash" allowScriptAccess="always" allowNetworking="all" height="' . $height . '" width="' . $width . '" data="'.$domain. $swf_url . '">'.
			'<param name="allowScriptAccess" value="always" />'.
			'<param name="allowNetworking" value="all" />'.
			'<param name="bgcolor" value=#000000 />'.
			'<param name="movie" value="'.$domain. $swf_url . '"/>'.
			'<param name="flashVars" value="' . $flash_vars_str . '"/>'.
			'<param name="wmode" value="opaque"/>'.
			$kaltura_link .
			'</object>' ; 

//	$widget = "<table cellpading='0' cellspacing='0' style='background-color:#000;'><tr><td>" . $widget . 
		"</td></tr><tr><td style='background-color:black; color:white; font-size: 11px; padding:5px 10px; '>$kaltura_link</td></tr></table>";
	
	if ( $align == 'r' ) 
	{
		$str .= '<div class="floatright"><span>' . $widget . '</span></div>';
	}
	elseif ( $align == 'l' ) 
	{
		$str .= '<div class="floatleft"><span>' . $widget . '</span></div>';
	}	
	elseif ( $align == 'c' ) 
	{
		$str .= '<div class="center"><div class="floatnone"><span>' . $widget . '</span></div></div>';
	}	
	else
	{
		$str .= $widget;	
	}
				
	return $str ;
}

function fixJavascriptForWidget ( &$text )
{
	global $added_js_for_widget, $javascript_for_widget ;	
	kalturaLog( "fixJavascriptForWidget [$added_js_for_widget] [$javascript_for_widget]" );
	if ( $added_js_for_widget )
	{
		// if this is turned on - we need to replace the javascrip placeholder
		// first time replace with the relevant values 
		$text = str_replace (  PLACEHOLDER_FOR_WIDGET_JAVASCRIPT , $javascript_for_widget , $text );
		// for all the rest - remove
		//$text = str_replace (  PLACEHOLDER_FOR_WIDGET_JAVASCRIPT , "" , $text );		
		
	}	
}

function getKalturaScriptAndCss ()
{
	global $wgJsMimeType, $wgScriptPath, $wgStyleVersion ;
	$kaltura_path = getKalturaPath();
		
$s = <<< JS_AND_CSS
<script type='{$wgJsMimeType}' src='{$kaltura_path}/kaltura.js'><!-- kaltura js --></script> 
<style type="text/css" media="screen, projection">/*<![CDATA[*/
	@import "{$kaltura_path}/kaltura.css?{$wgStyleVersion}";
/*]]>*/</style>

JS_AND_CSS;
	return $s;
}

function createJsForWidget ( $current_paget_url )
{
		// don't add the kshow_id to the list - it can change from one widget to another within the page
   	$editor_launch_params = array( /*"kshow_id" => $kshow_id ,*/ 
								"back_url" => $current_paget_url );
								
	$editor_launch_params_str = http_build_query( $editor_launch_params , "" , "&" )		;	

	$root_url = getRootUrl();
	
	    $javascript_for_widget = "<script type='text/javascript'>\n" .
//	    	"function gotoCW ( kshow_id ) { document.location='$root_url/Special:KalturaContributionWizard?$editor_launch_params_str' + '&kshow_id=' + kshow_id;}\n" . 
	    	"function gotoCW ( kshow_id ) {  kalturaInitModalBox ( '$root_url' , '$editor_launch_params_str' , kshow_id ) ;}\n" .
	    	"function gotoEdit ( kshow_id ) { document.location='$root_url/Special:KalturaCollaborativeVideoInfo?$editor_launch_params_str' + '&kshow_id=' + kshow_id;}\n" .
	    	"function gotoEditor ( kshow_id ) { document.location='$root_url/Special:KalturaVideoEditor?$editor_launch_params_str' + '&kshow_id=' + kshow_id;}\n" .
	    	"function gotoKalturaArticle ( kshow_id ) { document.location='$root_url/" . titleFromKshowId( "" ) . "' + kshow_id + '?$editor_launch_params_str' + '&kshow_id=' + kshow_id;}\n" . 
	    	"function gotoGenerate ( kshow_id ) { document.location='$root_url/Special:KalturaCollaborativeVideoInfo?$editor_launch_params_str';}\n" .
	    	"</script>\n";
	return 	    $javascript_for_widget;		
}

$kg_added_buttons_to_edit = false;
// adds a script section that calls kalturaAddButtonsToEdit.
// depending on when called on the server - a js hook is added in the page.

// if called using the 'BeforePageDisplay' hook, it is placed early in the html -> the button will be added at the beggining of the button list.
// if called using the 'SkinAfterBottomScripts' hook, it is placed late in the html -> the button will be added at the end of the button list.
function createJsForAddButtonForEdit ( )
{
	global $wgJsMimeType, $wgScriptPath, $wgStyleVersion ;
	global $wgTitle ;
	
	global $kg_added_buttons_to_edit;
	
	$root_url = getRootUrl();
	$kaltura_path = getKalturaPath();
	
	$text = "";
	if ( ! $kg_added_buttons_to_edit )
	{
		// add a button to the wysiwyg editor when not in KNS 
		if ( $wgTitle->getNamespace() != KALTURA_NAMESPACE_ID )
		{
			// try to add some script for adding buttons for the editor
			$action = kgetText ( "action" );
			if ( $action == "edit" )
			{
				$javascript_all_add_buttons = "kalturaAddButtonsToEdit( '$root_url' , '$kaltura_path/images/' , '" . ktoken ( "btn_txt_edit_page") . "' );";
				$text = "<script type='{$wgJsMimeType}'>{$javascript_all_add_buttons}</script>";
			}
		}
		$kg_added_buttons_to_edit = true;
	}
	
	return $text;
}

// TODO - I18N !
function createCollaborativeVideoLinkForToolbox ()
{
	return "<li id=\"t-collaborativevideo\"><a href='" . getRootUrl() . "/Special:KalturaCollaborativeVideoInfo?nk=t' >Collaborative Video</a></li>";
}

function createKshowLink ( $kshow_id )
{
	return	"<a href='./" . titleFromKshowId( $kshow_id ) . "'>See more details</a>";
}

function getRootUrl ()
{
	global $wiki_root;
	return $wiki_root;//"/wiki/index.php";
}


function getKalturaPath()
{
	global $wgKalturaPath;
	return $wgKalturaPath;
}
// search_order 
// 0 - first getText then cookie
// 1 - first cookie then getText
// 2 - only getText
// 3 - only cookie
function kgetText ( $param , $default_val = null , $search_order = 0 )
{
	$val = kgetTextImpl ( $param , $search_order );
	if ( $val == null )
		return $default_val;
	return $val ;
}

function kgetTextImpl ( $param , $search_order = 0 )
{
	global $wgRequest;
	
	global $wgCookiePath, $wgCookieDomain, $wgCookieSecure, $wgCookiePrefix;

	// prefer post/get data
	if ( $search_order == 2 )
		return $wgRequest->getText ( $param );
	if ( $search_order == 0 )
	{
		$val = $wgRequest->getText ( $param  );
		if ( ! $val )
			$val = @$_COOKIE[$wgCookiePrefix.$param];
		return $val;
	}

	// prefer cookie
	if ( $search_order == 1 )
		return @$_COOKIE[$wgCookiePrefix.$param];
	if ( $search_order == 3 )
	{
		if ( ! $val )
			$val = $wgRequest->getText ( $param  );
		return $val;
	}
}

function kresetcookie ( $name , $expiry_in_seconds = 180 )
{
	$value = kgetText ( $name );
	ksetcookie ( $name , $value , $expiry_in_seconds );
}

function ksetcookie ( $name , $value , $expiry_in_seconds = 3600 )
{
	global $wgCookiePath, $wgCookieDomain, $wgCookieSecure, $wgCookiePrefix;
	setcookie( $wgCookiePrefix.$name, $value , time() + $expiry_in_seconds, $wgCookiePath, $wgCookieDomain, $wgCookieSecure );	
}

function kdeletecookie ( $name )
{
	global $wgCookiePath, $wgCookieDomain, $wgCookieSecure, $wgCookiePrefix;
	setcookie( $wgCookiePrefix.$name, "" , 1000 , $wgCookiePath, $wgCookieDomain, $wgCookieSecure );	
}

function kdeletecookies ( $arr )
{
	if ( is_array ( $arr ) )
	{
		foreach ( $arr as $name )
			kdeletecookie ( $name );
	}
}


function kloadMessages() {
	static $messagesLoaded = false;
	global $wgMessageCache, $wgLanguageCode;
	global $kaltura_objects;
	
	if ( !$messagesLoaded ) {
		$messagesLoaded = true;

		// get the current lang
		$lang = $wgLanguageCode ;
		$lang_file_name = ucwords ( $lang );
		$file_to_load =  dirname( __FILE__ ) . "/KalturaMessages{$lang_file_name}.php";
		if ( ! file_exists($file_to_load ))			$lang_file_name  ="En" ; //the default-always existing lang

		require( dirname( __FILE__ ) . "/KalturaMessages{$lang_file_name}.php" );

		$wgMessageCache->addMessages( $kaltura_messages, $lang );
	}
	//return true;
}	

function ktoken ( $lable )
{
	$args = func_get_args();
	array_shift( $args );	
	kloadMessages();
	//return wfMsgHtml ( $lable );
	return wfMsg ( $lable , $args );
}

// have a local mechanism for oobjects - we won't have tah many !
$kaltura_objects = null;
function kobject ( $lable )
{
	global $kaltura_objects;
	kloadMessages();
	//return wfMsgHtml ( $lable );
	return @$kaltura_objects[$lable];
}


?>

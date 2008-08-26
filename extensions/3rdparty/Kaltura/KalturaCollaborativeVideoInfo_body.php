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



require_once ( dirname(__FILE__) . "/wiki_helper_functions.php" );


class KalturaCollaborativeVideoInfo extends SpecialPage
{
	const VIDEO_PREFIX = "Kaltura:video_";
	
	const DISPLAY = 0;
	const CREATE_KALTURA = 1;
	const GET_KALTURA = 2;
	const UPDATE_KALTURA = 3;

	private $extra_params = null;
	
	function KalturaCollaborativeVideoInfo( $call_impl_only = false ) {
		if ( ! $call_impl_only )
		{
			SpecialPage::SpecialPage("KalturaCollaborativeVideoInfo");
			kloadMessages();
		}
	}

	// this is the regular interface of specialPages
	function execute( $par ) {
		return $this->executeImpl( $par );
	}
	
	
	// This method is run in 2 modes - one as a special page and the other as the edit version of the kaltura article.
	// TODO - split into 2 pages:
	// 1 - special page for generating the widgets
	// 2 - edit mode of kaltura article
	// they are different flows anyway ! 
	function executeImpl( $par , $extra_params = null ) 
	{
		global $wgRequest, $wgOut , $wgUser;
		global $wgEnableUploads;
		global $kg_allow_anonymous_users;

		$this->extra_params = $extra_params;
		
		if ( !verifyUserRights() ) 
		{
			ksetcookie( "kshow_id" , $this->kgetText( 'kshow_id' ) ) ;
			$wgOut->loginToUse( );//'kalturakshowidrequestnologin', 'kalturakshowidrequestnologintext' , array( $this->mDesiredDestName ) );
			return;
		}
		
		# Check blocks
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$kaltura_user = getKalturaUserFromWgUser ( );
		 
		$this->setHeaders();

		if ( $extra_params )
		{
			// in case of edit mode
			$page_title = ktoken ( 'title_update_collaborative' );
		}
		else
		{
			$page_title = ktoken ( "title_add_collaborative" );
		}
		
		$wgOut->setPagetitle( $page_title );//" (" . time() .")" );
		
		// TODO - get rif of this code after the new/edit split !
		// 2 ways to indicate the new kaltrau:
		// ?nk=t - for normal links
		// /nk at the end of the URL - for links from the upper menu in the sidebar
		$url = @$_SERVER["PATH_INFO"];
		$new_kshow = ( $this->kgetText( 'nk' ) != null ) || ( strpos ( $url , "nk" ) > 0 );
	
		if ( ! $new_kshow  ) 
		{
			$kshow_id = $this->kgetText( 'kshow_id' );
			kresetcookie ( 'kshow_id' );
		}
		else
		{
			// if newkshow -> remove the cookie and start from scratch 
			$kshow_id = null;
			kdeletecookie( 'kshow_id' ); // delete the cookie so it won't drag along the session
		}
		
		$kshow_name = $this->kgetText( 'kshow_name' );
		$kshow_description = $this->kgetText( 'kshow_description' );
		
		$embed_str = "";
		$submitted = $this->kgetText( 'kaltura_submitted' );
		$res = "";

		$back_url =   $this->kgetText( "back_url" );
		$back_count = $this->kgetText( "back_count" , 0 );
		$back_count++;
		
		$mode = self::DISPLAY;
		// if arrived with kshow_id - assume submitted
		if ( $kshow_id ) 	
		{
			if ( $submitted )	$mode = self::UPDATE_KALTURA;
			else $mode = self::GET_KALTURA;
		}
		else
		{
			// no kshow - this should be the first time -> create
			if ( $submitted ) $mode = self::CREATE_KALTURA;
		}

		// in case of edit mode
		if ( $this->kgetText( "form_action" ) )
		{
			// this means we are now under the "edit" action of a kaltura article
			$form_action = $this->kgetText( "form_action" );
		}
		else
		{
			// this means we are in the special page
			$titleObj = SpecialPage::getTitleFor( get_class() ) ;//'Userlogin' );
			$form_action = $titleObj->getLocalUrl( "" );
		}
		//$titleObj->getFullURL( 'wpCookieCheck='.$type );

		$already_exists = false;
		$result_info = "";

		$widget_size = $this->kgetText ( 'widget_size' , 'L' );
		$widget_align = $this->kgetText ( 'widget_align' , 'R' );
		
			
		// can be both - update & submitted = 
		if ( $mode != self::DISPLAY ) 
		{
			$kaltura_services = kalturaService::getInstance ( $kaltura_user );
			
			// TODO - handle errors !!!
			if ( $mode == self::GET_KALTURA )
			{
				// getkshow					
				$params = array ( "kshow_id" => $kshow_id , 
					 /*"metadata" => "true" */);
				$res = $kaltura_services->getkshow( $kaltura_user , $params );	

				$already_exists = true;
			}
			elseif ( $mode == self::UPDATE_KALTURA )
			{
				// updatekshow
				$params = array ( "kshow_id" => $kshow_id ,						 
					 "kshow_name" => $kshow_name ,
					 "kshow_description" => $kshow_description ,
					 /*"metadata" => "true" */);
				$res = $kaltura_services->updatekshow( $kaltura_user , $params );
				
				$prev_kshow_name = @$res["result"]["old_kshow"]["name"];
				$prev_kshow_description = @$res["result"]["old_kshow"]["description"];

				if ( $prev_kshow_name != $kshow_name || $prev_kshow_description != $kshow_description )
				{
					// 	update the article only if name or description changed
					$watch_this = true;
					KalturaNamespace::updateThisArticle( false , $kshow_id , ktoken ( "update_article_info_change")  , false , $watch_this );
				}
				
				// now - if there is a return_url, redirect there
  				if ( $back_url )
  				{
  					// now - delete the cookies
  					kdeletecookie( 'kshow_id' ); // delete the cookie so it won't drag along the session
					$wgOut->redirect ( $back_url );
					return; 
  				}
				
				$result_info = "<b>Updated</b>";
				
				$already_exists = true;
			}
			elseif ( $mode == self::CREATE_KALTURA ) 
			{
				// addkshow
				$params = array ( "kshow_name" => $kshow_name ,
					 "kshow_description" => $kshow_description ,
					 /*"metadata" => "true" */);
				$res = $kaltura_services->addkshow( $kaltura_user , $params );
				
				$error = @$res["error"][0];

				if ( $error )
				{
					$already_exists = ( $error['code'] == -1 ); // already exists
					if ( $already_exists )
					$result_info = "<b style='color:red;'>" . ktoken ( "err_title_taken" ) . "</b>";
				}
			}
			else
			{
				// ERROR !
			}

			$kshow_id = @$res["result"]["kshow"]["id"];
			$kshow_name = @$res["result"]["kshow"]["name"];
			$kshow_description = @$res["result"]["kshow"]["description"];
			$kshow_version = @$res["result"]["kshow"]["version"];
			
			if ( $res )
			{
				// dont' use the version for the embed code - it will fix the altura on a specific version rathern than 
				// leave it up-to-date
				$kshow_version = null;
				$embed_str = createWidgetTag( $kshow_id , null , $widget_size , $widget_align , $kshow_version );
			}
			
			$wgOut->setPagetitle( $page_title . " [" . 
				 ( $kshow_name ? "$kshow_name" : "" ) . 
				"]");
				
			$should_update_kaltura_article = !$already_exists && $kshow_id!= null;

			kalturaLog( "Submitted kshow_id: $kshow_id, kshow_name: $kshow_name");
			
			if ( $should_update_kaltura_article )
			{
				$version = @$res["result"]["kshow"]["version"];
				$text_to_submit = empty ( $version  ) ? $kshow_id : $version;
				$watch_this = true;
				KalturaNamespace::updateThisArticle( true , $kshow_id ,  ktoken ( "update_article_new")  , false , $watch_this );
			}
		}
		
		if ( $wgUser != null )
		{
			$html = "";//"$form_action<br/>";

			if ( $mode == self::DISPLAY || $mode == self::CREATE_KALTURA )
			{					
				// in this case - ignore the kshow_id - this is for now the indicator for GET or UPDATE
				$kshow_id= "";  
				
$back_to_previous_page = "<a href='javascript:history.go(-{$back_count})'>" . ktoken ( "btn_txt_back" ) . "</a>";				
$a = $back_to_previous_page . "<br/>" .
	"<div style='border:1px solid #999; padding: 8px; background-color: lightyellow; width:60%'>" .
		ktoken ( "body_text_add_collaborative" ).
	"</div>" . 
	"<br/>" . 
		ktoken ('body_text_add_collaborative_instructions') . 
	"<br/>" ;
				
				$html .= $a ;
				
			}
			elseif ( $mode == self::UPDATE_KALTURA || $mode== self::GET_KALTURA )
			{
				$html .=
	"<br/>" . ktoken ( "body_text_update_collaborative" ) . " <br/>" ;
			}
			
			$html .=
				"<form method='post' action='" . $form_action . "'>" . 
					"<input type='hidden' name='kaltura_submitted' value='true'>" .
					"<input type='hidden' name='user_name' value='{$kaltura_user->puser_name}'>" .
					"<input type='hidden' name='user_id' value='{$kaltura_user->puser_id}'>" .
					"<input type='hidden' name='kshow_id' value='$kshow_id'>" .
					"<input type='hidden' name='back_url' value='$back_url'>" .
					"<input type='hidden' name='back_count' value='$back_count'>" .
					"<table>" .
					"<tr><td></td><td id='result_info'>$result_info<td></tr>" .
					"<tr><td>" . ktoken ( 'lbl_video_title' ) . "</td>" .
					"<td><input type='text' size='50' name='kshow_name' id='kshow_name' value='$kshow_name'></td></tr>" .
//					"<span id='generating'></span>" .
					"<tr><td>" . ktoken ( 'lbl_summary' ) . "</td>" .
					"<td><textarea cols='60' rows='3' name='kshow_description' id='kshow_description'>$kshow_description</textarea></td></tr>" ;
					
			if ( $mode == self::DISPLAY || $mode == self::CREATE_KALTURA )
			{					
			
				$html .=					
					"<tr height='60'><td></td> " .
					"<td>" .
					ktoken ( 'lbl_size' ) .  " " . createSelectHtml ( "widget_size" , kobject ( "list_widget_size") , $widget_size) . " " . 
					ktoken ( 'lbl_align' ) . " " . createSelectHtml ( "widget_align" , kobject ( "list_widget_align") , $widget_align ) . " " .
					"<input type='submit' name='submit' value='" . ktoken ( 'btn_txt_generate' ) . "' onclick='return validateForm()' style='margin-left:40px'>" .
					"</td></tr>".
					"<tr><td>" .ktoken ( 'lbl_widget_tag' ) . "</td>" .
					"<td><textarea style='	' cols='60' rows='2' readonly='readonly' name='dummy'>$embed_str</textarea></td></tr>" ;	
			}
			elseif ( $mode == self::UPDATE_KALTURA || $mode== self::GET_KALTURA )
			{
				$html .= "<tr><td></td> " .
					"<td>" .
					"<input type='submit' name='submit' value='" . ktoken ( 'btn_txt_update' ) . "'  onclick='return validateForm()'>" . 	
					" <a href='{$this->kgetText("back_url")}'>" . ktoken ( 'btn_txt_cancel' ) . "</a>" .
					"</td></tr>";		
			}
			
				$html .= "</table>" .
					"</form>" ;
			
			$wgOut->addHTML( $html );
		}
		else
		{
			$wgOut->addHTML( "User is not logged in" );
		}
		
		// javascript to make sure the form is valid
		$javascript = "<script type='text/javascript'>\n" .
			"function validateForm () { \n" .
			" var kshow_name = document.getElementById ( 'kshow_name' );\n" .
			" var trimmed = (kshow_name.value).replace(/^\s+|\s+$/g, '') ;" .
			" if ( trimmed == '' ) {\n".
			" alert ( '" . ktoken ( 'err_no_title' ) . "' );\n" .
			" return false;" .
			" }\n" .
			" var result_info = document.getElementById ( 'result_info' );\n" .
			" result_info.style.visibility='hidden';\n" .
			" return true;" .
			"}\n" . 
			"</script>";
		
		$wgOut->addScript ( $javascript );
		 
	}


	private function kgetText ( $param_name , $default_value = null )
	{
		if ( isset ( $this->extra_params[$param_name] ))
			return $this->extra_params[$param_name];
		return kgetText ( $param_name , $default_value );
	}
	
	
}

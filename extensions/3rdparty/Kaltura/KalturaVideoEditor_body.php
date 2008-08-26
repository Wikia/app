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



global $IP;
require_once($IP.'/includes/Wiki.php');
require_once ( dirname(__FILE__) . "/wiki_helper_functions.php" );


class KalturaVideoEditor extends SpecialPage
{
	function KalturaVideoEditor() {
		SpecialPage::SpecialPage("KalturaVideoEditor");
		kloadMessages();
	}

	function execute( $par ) {
		global $wgRequest, $wgOut , $wgUser;
		global $wgEnableUploads;
		global $partner_id, $subp_id, $partner_name;
		global $WIDGET_HOST;	
		global $btn_txt_back, $btn_txt_publish, $logo_url; 
		global $kg_allow_anonymous_users ,	$kg_open_editor_as_special ;
		 
		if ( !verifyUserRights() )
		{
			ksetcookie( "kshow_id" , kgetText( 'kshow_id' ) ) ;
			ksetcookie( "back_url" , kgetText( 'back_url' ) ) ;
			
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

//		$this->setHeaders();
 		$kaltura_user = getKalturaUserFromWgUser ( );
		
		$wgOut->setPagetitle( ktoken ( "title_editor" ) );

		$kshow_id = kgetText( 'kshow_id' );
		$original_page_url = kgetText ( 'back_url' );
		kresetcookie ( 'kshow_id' );
		kresetcookie ( 'back_url' );
//		kdeletecookies ( array ('kshow_id', 'back_url'  ) ); // cookie will be deleted so it won't be dragged as part of the session
		
		$domain = $WIDGET_HOST; //"http://www.kaltura.com";
		$user_name = $wgUser->getName();
		$user_id = $wgUser->getId();
		
		
		// this page has 2 purposes:
		// a launch page for the editor for a specific kshow_id
		// the return page from the editor -> will update the kshow_id's article
		$from_editor = kgetText ( "keditor" );
//		kresetcookie ( 'keditor' );
		kdeletecookie( "keditor" );
		
		$res = "";
		if ( ! empty ( $from_editor) )
		{
			//  kaltura_update is what the editor returns after the editor actually modifies the kshow
			$kshow_id_to_update = kgetText ( "kaltura_modified"  ); 
			if ( $kshow_id_to_update )
			{
				// see if the same as what we stored in the cookie 
				$edited_kshow_id = kgetText( "edited_kshow_id" , 3 ) ; // only from cookie
				if ( $edited_kshow_id != $kshow_id_to_update )
				{
					// Strange !! - we'll update some other kshow's article
				}
				// TODO !!!
				// update the article !!
				// get the articel in hand - it will be of type KalturaNamespace
				// TODO - maybe not believe the return value - verify with the cookie
				$watch_this = true ; // does user want to watch the changes ?
				KalturaNamespace::updateThisArticle( false , $kshow_id_to_update ,  ktoken ( "update_article_editor")  , false , $watch_this );
			}
			
			$original_page_url = kgetText( "original_page_url" );
			$wgOut->redirect ( $original_page_url );
		}
		elseif ( ! empty ( $kshow_id  ) ) 
		{
			// 	start a session
			$kaltura_services = kalturaService::getInstance( $kaltura_user );
			$ks = $kaltura_services->getKs();
			
			if ( !$ks )
			{
				// ERROR - starting a session to kaltura failed !!
				$error = "FATAL - cannot connect to kaltura";
				$wgOut->addHTML( $error );
			}
			
			// set the back_url for this page to return to once back from the editor
			ksetcookie( "original_page_url" , $original_page_url );
			ksetcookie( "edited_kshow_id" , kgetText( 'kshow_id' ) ) ;
			
			// tell the editor to return to this page, handle wiki-update and then redirect back to $original_page_url
			
			$titleObj = SpecialPage::getTitleFor( get_class() ) ;
			$back_url = $titleObj->getFullUrl( "keditor=true" ); // This will be used as an indicator when the editor returns to this page - go back to original u
			
			$first_visit = kgetText( "visit$kshow_id" );
			
    //		$var_names = array( "partner_id" , "subp_id" , "logo_url" , "btn_txt_back" , "btn_txt_publish" ,/* "back_url"*/ );
		    $editor_params = array( "partner_id" => $partner_id , 
		    						"subp_id" => $subp_id , 
		    						"uid" => $kaltura_user->puser_id , 
		    						"ks" => $ks ,
		    						"kshow_id" => $kshow_id ,
		    						"logo_url" => $logo_url , 
		    						"btn_txt_back" => $btn_txt_back , 
		    						"btn_txt_publish" => $btn_txt_publish ,
									"back_url" => $back_url ,
									"partner_name" => $partner_name );
									
			if ( $first_visit ) 	
			{	$editor_params ["first_visit"] ="1";
			}
			else
			{
				// remember that the editor was visited for this kshow_id - skip the message box
				ksetcookie( "visit$kshow_id" , 1 , 30 );			
			}

			$editor_params_str = http_build_query( $editor_params , '' , "&" )		;		
							
			$editor_url = $domain . "/index.php/edit?$editor_params_str";
			
			// instead of redirecting - open editro in current special page
			if ( $kg_open_editor_as_special )
			{
				$iframe_html = "<iframe src='$editor_url' width='100%' height='800px'></iframe>";
				$wgOut->addHtml ( $iframe_html );
				// to allow full-screen:
				//$wgOut->setArticleBodyOnly ( true );
			}
			else
			{
				TRACE ( $editor_params );
				$wgOut->redirect ( $editor_url );				
			}
		}
		else
		{
			$error = "Must set the kshow_id";
			$wgOut->addHTML( $error );
		}		
	}
}

?>

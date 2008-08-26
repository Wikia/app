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

class KalturaContributionWizard extends SpecialPage
{
	const VIDEO_PREFIX = "Kaltura:video_";
	
	function KalturaContributionWizard() {
		SpecialPage::SpecialPage("KalturaContributionWizard");
		kloadMessages();
	}

	function execute( $par ) {
		global $wgRequest, $wgOut , $wgUser;
		global $wgEnableUploads, $wgRequest;
		
		global $wgJsMimeType, $wgScriptPath, $wgStyleVersion, $wgStylePath;
		global $wgLanguageCode;
		
		global $partner_id , $subp_id;
		global $WIDGET_HOST;
		global $kg_allow_anonymous_users;

		$inframe = false;
		// incase of inframe some things should change:
		// 1. render body only
		// 2. display only the SWF + relevant JS
		// 3. JS will change to refresh the whole page (assuming this page is called from an iframe)
		$inframe = ( kgetText ( "inframe" ) == "true" );

		if ( !verifyUserRights() ) 
		{
			// store the kshow_id so it will be used wen user IS logged in
			ksetcookie( "kshow_id" , kgetText( 'kshow_id' ) ) ;
			ksetcookie( "back_url" , kgetText( 'back_url' ) ) ;
			
			if ( $inframe) 
			{
				// return html that causes the parent page to go to the login page
				// this time we'll hit this page WITHOUT the inframe mode !!
				$wgOut->setArticleBodyOnly ( true );
				
				$titleObj = SpecialPage::getTitleFor( get_class() ) ;//'Userlogin' );
				$url = $titleObj->getLocalUrl( "" );

				$js = "<script type='{$wgJsMimeType}'>	window.top.location= '$url';	</script>";
				
				$wgOut->addHtml ( $js );
				return; 
			}
			else
			{
				$wgOut->loginToUse( );//'kalturakshowidrequestnologin', 'kalturakshowidrequestnologintext' , array( $this->mDesiredDestName ) );
				return;
			}
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

		// We only need the body
		if ( $inframe)
		{
			$wgOut->setArticleBodyOnly ( true );
		}
		
		$this->setHeaders();
		$kaltura_user = getKalturaUserFromWgUser ( );
		
		$kshow_id = kgetText( 'kshow_id' );
		$original_page_url = kgetText ( 'back_url' );
		kresetcookie ( 'kshow_id' );
		kresetcookie ( 'back_url' );
//		kdeletecookies ( array ('kshow_id', 'back_url'  ) ); // cookie will be deleted so it won't be dragged as part of the session

		if ( $inframe )
		{
			$page_title = "";
		}
		else
		{
			$page_title = ktoken ( "title_add_to_collaborative" );	
		}
		
		$wgOut->setPagetitle( $page_title );//" (" . time() .")" );
		
		$res = "";
		if ( ! empty ( $kshow_id  ) ) 
		{
			$kaltura_services = kalturaService::getInstance( $kaltura_user );
			$ks = $kaltura_services->getKs();
			
			$params = array ( "kshow_id" => $kshow_id );
			$res = $kaltura_services->getkshow( $kaltura_user , $params );

			$error = @$res["error"][0];
			$err_str = "";
			if ( $error )
			{
				$err_str = "<b>" . $error[1] . "</b><br>";	
			}

			// use the kshow name in the page title 
			$title = $res["result"]["kshow"]["name"];
			$wgOut->setPagetitle( $page_title  . ": $title" );//" (" . time() .")" );

	$domain = $WIDGET_HOST;
	if ( strpos ( $domain , "localhost"  ) !== false )		$host = 2;
	elseif ( strpos ( $domain , "kaldev" ) !== false ) 		$host = 0;
	else													$host = 1;

	$swf_url = "/swf/ContributionWizard.swf";

   // will add the script to be called by the CW
    $javascript =  	"function addentry (){\n". 
// 		"alert ( 'updating...$kshow_id' ) ; \n" .
		"	sajax_do_call('ajaxKalturaUpdateArticle' , ['$kshow_id'] , updateEnded ) ;\n".
		"}\n" . 
		"function updateEnded (){\n".
//		"alert ( '...updated' ) ; \n" .
//		" finished();\n" .
		"}\n" .
		"function finished (){\n" ;
if ( $inframe )		
{
	$javascript .= "window.top.kalturaRefreshTop()";
}
else
{
	$javascript .=	"document.location='$original_page_url';\n";
}
	$javascript .=
//		"alert ( '...finished' ) ; \n" .
		"}\n" ;
    
    $wgOut->addInlineScript ( $javascript );
    	
    $lang = $wgLanguageCode ;
	$height = 360;
	$width = 680;
	$flashvars = 		'userId=' . $kaltura_user->puser_id .
						'&sessionId=' . $ks. 
						'&partnerId=' . $partner_id .
						'&subPartnerId=' . $subp_id . 
						'&kshow_id=' . $kshow_id . 
						'&host=' . $host . //$domain; it's an enum
						'&afterAddentry=addentry' .
						'&close=finished' .
						'&lang=' . $lang . 
						'&terms_of_use=http://www.kaltura.com/index.php/static/tandc' ;

	$str = ktoken ( 'body_text_contribution_wizard' );
							
    $extra_links  = "<a href='javascript:addentry()'>addentry<a><br> " ;
    
					
    $widget = '<object id="kaltura_contribution_wizard" type="application/x-shockwave-flash" allowScriptAccess="always" allowNetworking="all" height="' . $height . '" width="' . $width . '" data="'.$domain. $swf_url . '">'.
			'<param name="allowScriptAccess" value="always" />'.
			'<param name="allowNetworking" value="all" />'.
			'<param name="bgcolor" value=#000000 />'.
			'<param name="movie" value="'.$domain. $swf_url . '"/>'.
    		'<param name="flashVars" value="' . $flashvars . '" />' .
			'</object>';

	if ( $inframe )
	{
		// because we're using bodyOnly - we'll have to take care of adding the head and creating the body element
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgStylePath}/common/ajax.js?$wgStyleVersion\"></script>\n" );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgStylePath}/common/ajaxwatch.js?$wgStyleVersion\"></script>\n" );
		$head = $wgOut->headElement();
		$wgOut->addHTML( $head );
				
		// display the widget only
		$wgOut->addHTML( "<body style='padding:0; margin:0;'>$widget</body>" );
	}
	else
	{
		$str .= 	/* $extra_links . */ $widget;
		$wgOut->addHTML( $str );
		$wgOut->addHTML( "<br><br>" . createKshowLink ( $kshow_id ) . "<br>" );
	}
	

		}
		else
		{
			$error = "Must set the kshow_id";
			$wgOut->addHTML( $error );
		}
	}
}

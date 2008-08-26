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



require_once ( "wiki_helper_functions.php" );

// TODO - change the name of the class & reuse code with other CollborativeVideoInfo
// use the inframe parameter do differentiate between the 2 flows  
// this part of code can be reused in the other CollborativeVideoInfo class 
// it will hold the frame that submits the kshow parameter
class KalturaTestPage extends SpecialPage
{
	
	function KalturaTestPage(  ) {
		SpecialPage::SpecialPage("KalturaTestPage");
		kloadMessages();
	}

	// this is the regular interface of specialPages
	function execute( $par ) {
		return $this->executeImpl( $par );
	}
	
	/**
	 * TODO - remove this page on production 
	 */
	function executeImpl( $par ) 
	{
		global $wgRequest, $wgOut , $wgUser;
		global $wgJsMimeType, $wgScriptPath, $wgStyleVersion, $wgStylePath;
		global $wgUseAjax;
		global $partner_id , $log_kaltura_services, $kg_allow_anonymous_users;
		
		
		// check if alloed:
		global $secret ; 
		$allow = ( kgetText("pp" ) == md5($secret) );
		if ( !$allow )
		{
			return;
		}
	
		$wgOut->addHtml ( "<div style='font-size:12px; font-family: arial;'>" );
		
		if (  kgetText("log" ) != null )
		{
			$log_file_name =  getKalturaLogName();
			$maxlen = kgetText("maxlen" , 10000 );
			$def_offset = filesize( $log_file_name ) - $maxlen ;
			$offset = kgetText("offset" , $def_offset );

			$this->actionDesc ( "kaltura log: starting at: $offset, bytes : $maxlen <br>" );
						
			$log_content = @file_get_contents( $log_file_name , false ,null , $offset  , $maxlen  ) ;
			$wgOut->addWikiText ( "<pre>$log_content</pre>");
			return;	
		}
		
		try
		{
			
			
			// check the log and tried to create it
			$log_file_name =  getKalturaLogName();
			$file_exists = file_exists( $log_file_name );
			if ( $file_exists )
			{
				$h = @fopen ( $log_file_name , "a" );
				$can_write = ( $h != null ); 
				if ( $h ) fclose ( $h );
			}
			$this->actionDesc ( "kaltura log:<br>" . 
				'$log_kaltura_services is set to ' . ( $log_kaltura_services ? "'true'" : 'false' ) . "<br>" .
				"When the logging is turned on, will write to file '$log_file_name'<br>" . 
				"This file " . ($file_exists ? 
					"already exists " .	( $can_write ? "and can be writen to" : "<b style='color:red'>BUT CANNOT BE WRITTEN TO! Please change the file and directory privileges for the log to work.</b>") 
					: "Does not yet exist. <b style='color:red'>Please create it's directory with write-permissions</b>." ) . 
				".<br>"  
				);			
			
			$this->actionDesc ( "kalturaUser:<br>" .
				'$kg_allow_anonymous_users is set to ' . ( $kg_allow_anonymous_users ? "'true'" : 'false' ) . ".<br>" .
				"Users who are not logged-in " . 
					($kg_allow_anonymous_users ? "will be considered anounymous and will be allowed to use the system." : "will be forced to do so before creating or modifying a collaborative video." ) 
				 );
			
			$kaltura_user = getKalturaUserFromWgUser();
			$this->printObj( $kaltura_user );

			if ( $kaltura_user->puser_id == "" )
			{
				// user is not logged in and partner does not allow anonymous users
				$this->actionDesc ( "User is not logged-in and partner does not allow anonymous users<br>" .
					'Either login as a wiki user or, if your policy is to allow anonymous users to modify wiki pages, change <b>\'$kg_allow_anonymous_users\'</b> to <b>\'true\'</b> in the partner_settings.php file.<br>' );
				$this->actionDesc ( "<span style='color:red; font-weight:bold;'>All further tests should fail!</span><br>" );					
			}
			
			$this->actionDesc ( "kalturaService::getInstance. Will initialize a session with Kaltura" );
			$kaltura_services = kalturaService::getInstance ( $kaltura_user );
			$this->printObj( $kaltura_services );

			$this->actionDesc ( "create a sample collaborative video (will indicate an existing kshow second time onwards)" );
			$params = array ( "kshow_name" => "collvideo{$partner_id}" , "kshow_description" => "Some text to be used as the summary");
			$this->printObj( $params );
			$result = $kaltura_services->addkshow ($kaltura_user , $params );
			$this->printObj( $result );
			
			$kshow_id = @$result["result"]["kshow"]["id"];
			$this->actionDesc ( "extra details about the collaborative video above" );
			$params = array ( "kshow_id" => $kshow_id , "detailed" => "true" );
			$this->printObj( $params );
			$kshow = $kaltura_services->getkshow ($kaltura_user , $params );
			$this->printObj( $kshow );
			
			$should_add_entry = kgetText( "addentry" );
			if ( $should_add_entry )
			{
				$this->actionDesc ( "add an image entry to the collaborative video" );
				$params = array (	"kshow_id" => $kshow_id , 	
									"entry1_mediaType" => "2" , 
									"entry1_source" => "20" ,  
									"entry1_name" => "kaltura logo" , 
									"entry1_tags" => "kaltura, logo" , 
									"entry1_url" => "http://www.kaltura.com/content/entry/data/0/0/10_100000.jpg" ,
									"entry1_thumbUrl" => "http://www.kaltura.com/content/entry/thumbnail/0/0/10_100000.jpg" );
				$this->printObj( $params );
				$entry = $kaltura_services->addentry ($kaltura_user , $params );
				$this->printObj( $entry );
			}
			else
			{
				// TODO - make the feature work !
				//$this->actionDesc ( "<b>To add an entry to the collaborative video, add '?addentry=t' to the URL.</b>" );
			}
			
			$this->actionDesc ( "Finally: The widget..." );
			$widget = createWidgetHtml( $kshow_id , null , 'm' , 'l' , null  );
//			fixJavascriptForWidget ( $widget );
			$wgOut->addHtml ( $widget );
						
			$wgOut->addHtml ( "</div>" );
		}
		catch ( Exception $ex )
		{
			
		}
		 
	}

	function loadMessages() {
		
		static $messagesLoaded = false;
		global $wgMessageCache;
		if ( !$messagesLoaded ) {
			$messagesLoaded = true;

			require( dirname( __FILE__ ) . '/KalturaAjaxCollaborativeVideoInfo.i18n.php' );
			foreach ( $allMessages as $lang => $langMessages ) {
				$wgMessageCache->addMessages( $langMessages, $lang );
			}
		}
		return true;
	}

	private function printObj ( $obj )
	{
		global $wgRequest, $wgOut;
		$wgOut->addHtml ( "<pre>" . print_r ( $obj , true ) . "</pre>" );
	}
	
	private function actionDesc ( $str )
	{
		global $wgRequest, $wgOut;
		$wgOut->addHtml ( "<span style='background-color:lightyellow'>" . $this->t() . $str . "<br/></span>" );
	}
	
	private function t() 
	{
		$time = ( microtime(true) );
		$milliseconds = (int)(($time - (int)$time) * 1000);  
		$formatted = strftime( "%d/%m %H:%M:%S." , time() ) . $milliseconds; 
		return "[" . $formatted . "] ";
	}
	
}

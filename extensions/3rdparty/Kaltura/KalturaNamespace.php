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



require_once ( dirname(__FILE__) . "/NamespaceManager.php" );

function LOGME ( $method , $article )
{
	return ;
	
	global  $wgOut; 
	
	$text = $article->getLatest() . "|" . $article->getOldID();
	
	//$text = "<pre>$method\n" . $text . "</pre>";
	$wgOut->addHtml ( $text );	
	
	kalturaLog( $method . " " . $text );
}

class KalturaNamespace extends NamespaceManager
{
	public $update_version = false;
	private $rollback_version = null;
	
	private $displayed_lines_of_history = false;
	public  $ignore_redirect = false;
	
	private $kshow_version = null;
	private $kshow = null;
	static $best_revision = -1;
	
	private $kshow_id;

	
	public static function updateThisArticle ( $first_time , $kshow_id , $summary  , $minor = false ,  $watch_this =true)
	{
		$title_str = titleFromKshowId( $kshow_id );
		$title = Title::newFromURL ($title_str);
		$kaltura_article = MediaWiki::articleFromTitle ( $title );
		$kaltura_article->update_version = true; // marks this article for update - not rollback
		
		$kaltura_article->ignore_redirect = true;
		if ( $first_time )
		{
			$kaltura_article->insertNewArticle( "Will be modified anyway"  , $summary , $minor , $watch_this );
		}
		else
		{
		 	$kaltura_article->updateArticle( "Will be modified anyway"  , $summary , $minor , $watch_this );
		}
		
	}

	// override the function  Article:doRedirect  - to be able to skip this action sometimes, 
	// depending on if the insert/update where behind the scenes or not
	function doRedirect( $noRedir = false, $sectionAnchor = '', $extraq = '' ) {
		if ( $this->ignore_redirect )
			return;
		else
			parent::doRedirect( $noRedir , $sectionAnchor , $extraq ); 
	}
		
	// will control the view of all Kaltura: pages
/**
 	Some data is fetched from the content (set at save time) - see hArticleSave
	This data will be part of "diff" - it's the real content.
	At view time, the rest can be created
	Here we should NOT call any external services !!  
 */
	public function view()
	{
		global $wgRequest, $wgOut , $wgUser, $wgLang;
		global $wgMaxTocLevel;
				
		LOGME ( __METHOD__ , $this );
		
		$diff = kgetText ( "diff" );
		if ( $diff )
		{
			// disable the table of content so it won't appear in the diff table
			$wgMaxTocLevel = 0;
			// show diff between diff and oldid
			$oldid = kgetText ( "oldid" );

			// set the title after calling fetchContent - or else it will be overriden
			$wgOut->setPageTitle( $this->mTitle->getPrefixedText() . " $diff | $oldid");
			
			
			// because fetchContent works on the state of this object - create another object to compare this one too
			$kaltura_article_1 = MediaWiki::articleFromTitle ( $this->mTitle );
			$content_1  = $kaltura_article_1->fetchContent ( $diff );
			$revision_1 = Revision::newFromId( $diff );
			
			$kaltura_article_2 = MediaWiki::articleFromTitle ( $this->mTitle );
			$content_2  = $kaltura_article_2->fetchContent ( $oldid );			
//			$content_2  = $this->fetchContent ( $oldid );
			$revision_2 = Revision::newFromId( $oldid );
			
			$timestamp_1 =  $wgLang->timeanddate( $revision_1->getTimestamp() , true );
			$timestamp_2 =  $wgLang->timeanddate( $revision_2->getTimestamp() , true );
	//return wfTimestamp(TS_MW, $this->mTimestamp);
	//$visible_date = $wgLang->timeanddate( wfTimestampNow (TS_MW ), true );				
					
	$lbl_revision = ktoken ( "lbl_revision" );
			$html = "<table width='80%' cellpadding='10'>" .
				"<thead>" . 
				"<tr><td width='40%' >{$lbl_revision} {$timestamp_2}</td>" .
					"<td width='40%' >{$lbl_revision} {$timestamp_1}</td></tr>" . 
				"</thead>" .
				"<tbody>" .
				"<tr style='vertial-align:top;'>" .
				"<td>" ;
			$wgOut->addHtml( $html );
			$wgOut->addWikiText( $content_2 );
			$wgOut->addHtml ( "</td><td>" );
			$wgOut->addWikiText( $content_1 );
			
			$html = "</td>".
				"</tr>" .
				"</tbody>" .
				"</table><br><br>" ;
				 
			$wgOut->addHtml( $html );

		}
		else
		{
			// this is for the standard view
			$content = $this->getContent();
	//		$wgOut->addWikiText( "<pre>$content</pre>" );
			$wgOut->addWikiText( $content );
		}
	
		$embed_code_title = "\n== " . ktoken ( "lbl_tag_code" ) ." ==" ; 
		$wgOut->addWikiText( $embed_code_title );
		
		$embed_code = "Copy the code below and paste it in any article page to display this Collaborative Video<br>" .
		   "<input type='text' style='font-size:11px;' size='50' value='" . 
			htmlspecialchars( $this->createWidgetCode( "L" , "L" , null ) , 1 )."'/> <br>";
		
		$wgOut->addHtml( $embed_code );

		// search results for this article
		//Special:Search?search=kalturaid_10234&fulltext=Search

		$search_title = "\n== " . ktoken ( "lbl_search" ) ." ==" ; 
		$wgOut->addWikiText( $search_title );
		
		$search_results =  "<a href='" . getRootUrl() . "/Special:Search?search=" . searchableText ( $this->getKshowForArticle() ) . 
			"&fulltext=Search'>Search results from this Colaborative Video</a>";
		$wgOut->addHtml( $search_results );
		
		
		$history_title = "<br>\n== " . ktoken ( "lbl_history" ) ." ==";
		$wgOut->addWikiText( $history_title );
		
		// continue with the dynamic stuff (wich is modified between views)
		$history = new PageHistory( $this );
		$history->history();
	}
	
	// if we return true - the 'edit' chain in the CustomEditor hook will continue
	// this funciton will actually be used only for undo/revert
	// no reason for a user to edit the kalturaArticle
	public function edit()
	{
		global $wgRequest, $wgOut , $wgUser;
		global $kg_allow_anonymous_users;
		
		LOGME ( __METHOD__ , $this );
		
/*		$html = "This article is not really suposed to be manually modified.";
		$wgOut->addHTML( $html );
*/
		# Get variables from query string :P
		$undo = kgetText( 'undo' );

		kalturaLog( "User Wants to undo to [$undo]");
					
		// action=edit & undo -> rollback 
		if ( $undo )
		{
			// This should actually not happen - users will not see the revern link if not logged in 
			if ( !verifyUserRights() ) 
			{
				// store the kshow_id so it will be used wen user IS logged in
				ksetcookie( "undo" , $undo ) ;
				ksetcookie( "back_url" , kgetText( 'back_url' ) ) ;
				
				kalturaLog( "User should log in. Will undo [$undo]");
				$wgOut->loginToUse( );//'kalturakshowidrequestnologin', 'kalturakshowidrequestnologintext' , array( $this->mDesiredDestName ) );
				return false;
			}		

			// make sure user can revert
			// TODO - retrun condition !!
			if ( true ) //$wgUser->isAllowed( 'rollback' ) )
			{
				$this->rollback_version = $undo; // set the rollback_version so will be fetched at save time
				$this->updateArticle( "Will be modified anyway"  , ktoken ( "update_article_revert") . " $undo" , false , true );
			}
			else
			{
				$this->rollback_version =  null;
			}
			
			return true;
		}
		else
		{
			// here we'll actually display our edit page
			// for now - use the executeImpl function of the special page 
			$edit_page = new KalturaCollaborativeVideoInfo( true );
			$extra_params = array( 
				"kshow_id" => $this->getKshowForArticle() ,  
				"form_action" => $this->mTitle->getLocalURL ( "action=edit" ),
				"back_url" => $this->mTitle->getLocalURL ( "action=view" ) 
			);
			$edit_page->executeImpl( null , $extra_params );	
			
			return false;
		}
		return true;
	}
	
	
	// IMPORTANT - will override the article's default save and will store relevant data for future use
 	public function hArticleSave        ( &$article, &$user, &$text, $summary, $minor, $dontcare1, $dontcare2, &$flags )
 	{
 		global $wgOut , $wgUser, $wgRequest, $wgLang;
 		
		LOGME ( __METHOD__ , $article );

		$current_version = $this->getLatest();
 		if ( ! $current_version )
		{
			$current_version = ktoken ( "new_version");
		}		
		if ( ! $this->update_version && $this->rollback_version  )
		{
			// time to rollback - 
			// fetch the content of the desired version.
			// there we'll find the name,summary and the kaltura_desired_version to update the kshow with
			$kaltura_article = MediaWiki::articleFromTitle ( $this->mTitle );
			$content  = $kaltura_article->fetchContent ( $this->rollback_version );
			
			$revision_data = kalturaHistoryData::fromText( $content );
			
			kalturaLog ( "content: $content\nrevision_data: " . print_r ( $revision_data , true ) );
			
			$desired_name = $revision_data->data["name"]; // from the content
			$desired_description = $revision_data->data["description"];// from the content
			$desired_kaltura_version = $revision_data->data["version"]; // from the content
			
			// this is where we revert the version rather than get it from kaltura
			// get the desired version from the text
			$kshow = $this->kshowRollback ( $desired_name , $desired_description , $desired_kaltura_version );
			// if there was a problem - use the previous string 
			if ( ! $kshow )
			{
				// TODO - a problem !!
				$kshow_version = $desired_kaltura_version;
			}
			$kshow_version = $kshow["version"];
			// update the version to be the new one from kaltura
			$revision_data->data["version"] = $kshow_version;
			// because the version on kaltura will change to be a new one - not necessarily the current one -
			// we'll override the text all together
		}
		else
		{
			// get the current version from kaltura
			$kshow  = $this->getKshow ( );
			$revision_data =  new kalturaHistoryData ( null );
			$revision_data->data["version"] = $kshow["version"]; 
		}

		$kshow = $this->getKshow();		
		// for the this special page of the show - use the version so it will be part of the page and will help 
		// while looking through the history
		
		$description = @$kshow["description"];
		$text  = $this->createWidgetCode( "l" , "" , $kshow["version"]	 , $kshow["name"] , $description );
			

		$info_data = "<br>\n==" . ktoken ( "lbl_info" ) . "==\n";
		$text .= $info_data . "Name: " . $kshow["name"] . "<br>Summary: " . $description ; 
		
		$version_data = "<br>\n==" . ktoken ( "lbl_version" ) . "==\n" ;
		// mark the 
		$visible_date = $wgLang->timeanddate( wfTimestampNow (TS_MW ), true );
		$text .= $version_data . $visible_date ; // . " [{$kshow["version"]}]";  
 
		// make the revision_data invisible

		$revision_data->data["name"] = @$kshow["name"];
		$revision_data->data["description"] = $description;
		$revision_data->data["wgUserName"] = $wgUser->mName;
		$revision_data->data["timestamp"] = time();
		$revision_data->data["articleCurrentVersion"] = $current_version ;
//		$revision_data->data["raw"]= print_r ( $kshow , true );
		
		$revision_data_str = "\n<span style='display:none;'>" . $revision_data->toText() .	"</span>"	;
		$text .= $revision_data_str;		

		return true;		 		
 	}

 	
 	// This is the best way to manipulate the history line
	// we would like to enable/disable the 'rollback' option according to user's rights - INSTEAD of 'undo' 
	// this is a strange hook because it manipulates the string of each row rathern than the raw data 
	// TODO - is there any other better way 
 	public function hPageHistoryLineEnding ( &$row , &$s )
 	{
 		global $wgUser;

 		// keep count - if this is the first time, don't display the link
 		$rev_to_rollback_to = $row->rev_id;

 		$user_allowed_to_rollback = true;//$wgUser->isAllowed( 'rollback' ) ;
 		if( $user_allowed_to_rollback && $this->displayed_lines_of_history )  
 		{
 			$url  = $this->mTitle->getLocalURL ( "action=edit" );
 			$link_for_rollback  = "<a href=\"#\" onclick=\"return kalturaRevert ( '$url' , '$rev_to_rollback_to' , '" . ktoken ( "alert_txt_revert" ) . "' );\">" .
 				"(" . ktoken ( "revert_to_version" ) . ")</a>"; 			
		} 	
		else
		{	
 			$link_for_rollback  = "";
		} 
/*
 * <span class="mw-history-undo">
<a title="Kaltura:Video 10230" href="/wiki/index.php?title=Kaltura:Video_10230&action=edit&undoafter=179&undo=180">undo</a>
</span>
 */ 		
 		// replace the link to display 'rollback' rathern than 'undo' and
		// call javascript before rollbacking 
		$pattern = "/\([ ]*(<span[^>]*history\-undo[^>]*\>)(.*)<\/a>(<\/span>)[ ]*\)/";
		if ( strpos ( $s  , "kalturaRevert" ) === false  )
		{
 			// add text only if the origianal text doesn't include the javascript we want to add
			// this happens because our code is called several times for each history line when in 'diff' mode 
	 		$res = preg_replace ( $pattern , "\\1 $link_for_rollback \\3" , $s ); 		
	 		
	 		if ( $res == $s )
	 		{
	 			// might be that there was never the history-undo tag- ususally the last row in the list (first revision)
				if ( ! preg_match ( $pattern , $s ) )
				{
					// tidy the last line
					 $s .= " " . $link_for_rollback ;		
				}
	 		}
	 		else
	 		{
	 			$s = $res ; 
	 		}
		}
		 		
 		$this->displayed_lines_of_history = true;
 		
 		return true;
 	} 
 	
 	
 	public function getKshowForArticle()
 	{
 		if ( !$this->kshow_id )
 		{
 			$this->kshow_id = kshowIdFromTitle( $this->mTitle );
 		}
 		return $this->kshow_id;
 	}
 	
 	
	private function getKshow ()
 	{
 		if ( $this->kshow == null )
 		{
	 		$kshow_id = $this->getKshowForArticle();//kshowIdFromTitle ( $this->mTitle );

	 		$kaltura_user = getKalturaUserFromWgUser ();
			$kaltura_services = kalturaService::getInstance( $kaltura_user );
			$params = array (  "kshow_id" => $kshow_id ); 
			$res = $kaltura_services->getkshow( $kaltura_user , $params );
			$kshow = @$res["result"]["kshow"];
			// cache $kshow for the current requset
			$this->kshow  = $kshow;
 		}
		return $this->kshow;
 	}
 	
 	private function getKshowVersion ()
 	{
 		if ( $this->kshow_version == null )
 		{
 			$kshow = $this->getKshow();
 			$version = @$kshow["version"];
/*
	 		$kshow_id = $this->getKshowForArticle();//kshowIdFromTitle ( $this->mTitle );
	 		$user_id = $wgUser->getId();
	 		
			$kaltura_services = kalturaService::getInstance( $user_id );
			$params = array (  "kshow_id" => $kshow_id ); 
			$res = $kaltura_services->getkshow( $user_id , $params );
			$version = @$res["result"]["kshow"]["version"];
	*/		
			$this->kshow_version = $version;
 		}
 		
		return $this->kshow_version;
 	}
 	
 	private function kshowRollback ( $desired_name, $desired_description , $desired_version )
 	{
 		$kshow_id = kshowIdFromTitle ( $this->mTitle );
	 	$kaltura_user = getKalturaUserFromWgUser ();
		$kaltura_services = kalturaService::getInstance( $kaltura_user );
			
		$params = array (  "kshow_id" => $kshow_id ,
							"kshow_name" => $desired_name ,
							"kshow_description" => $desired_description ,
							"kshow_version" => $desired_version ); 
		$res = $kaltura_services->rollbackkshow( $kaltura_user , $params );
		
		$this->kshow  =  @$res["result"]["kshow"];
		$version = @$res["result"]["kshow"]["version"];
			
		$this->kshow_version = $version;
		
		return $this->kshow;
 	}
 	
 	
 	private function createWidgetCode ( $size = "l" , $align = "" , $version=null , $name=null , $description=null)
 	{
 		$kshow_id = kshowIdFromTitle ( $this->mTitle );
		$entry_id = null;
		
		return createWidgetTag ( $kshow_id , $entry_id , $size , $align , $version , $name , $description);
 	}

}

class kalturaHistoryData
{
	const SYMBOL = "kalturaHistoryData";
	// name
	// summary
	// kaltura_version
	public $data ; 
	
	public function kalturaHistoryData ( $arr )
	{
		if ( $arr == null )
			$this->data = array(); 
		$this->data = $arr;
	}
	
	public static function fromText ( $text )
	{
		$pat = "/(" . self::SYMBOL . ")\|(\d+?)\|(.*)/s";
		preg_match ( $pat , $text , $matchs );
		$len = $matchs[2];
		
		if ( is_numeric( $len ))
		{
			$data_str = substr ( $matchs[3] , 0 , $len );
			return new kalturaHistoryData ( unserialize( $data_str ) );
		}
		
		return new kalturaHistoryData ( null );
	}
	
	public function toText ( )
	{
		$ser = serialize($this->data);
		return self::SYMBOL . "|" . strlen ( $ser ) . "|" . $ser ;
	}
}


?>

<?php
//GLOBAL VIDEO NAMESPACE REFERENCE
define( 'NS_POLL', 300 );

$wgPollDisplay['comments'] = false;

$wgHooks['TitleMoveComplete'][] = 'fnUpdatePollQuestion';
function fnUpdatePollQuestion(&$title, &$newtitle, &$user, $oldid, $newid) {
	if($title->getNamespace() == NS_POLL){
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->update( 'poll_question',
		array( 'poll_text' => $newtitle->getText() ),
		array( 'poll_page_id' => $oldid ),
		__METHOD__ );
	}
	return true;
}

$wgHooks['ArticleDelete'][] = 'fnDeletePollQuestion';
function fnDeletePollQuestion(&$article, &$user, $reason) {
	global $wgTitle, $wgSupressPageTitle;
	if($wgTitle->getNamespace() == NS_POLL){
		$wgSupressPageTitle = true;
		

			
		$dbr =& wfGetDB( DB_MASTER );
		
		$s = $dbr->selectRow( '`poll_question`', array( 'poll_user_id' , 'poll_id'), array( 'poll_page_id' => $article->getID() ), __METHOD__ );
		if ( $s !== false ) {
			//clear profile cache for user id that created poll
			global $wgMemc;
			$key = wfMemcKey( 'user', 'profile', 'polls' , $s->poll_user_id);
			$wgMemc->delete( $key );
			
			//delete poll recorda
			$dbr->delete( 'poll_user_vote',
			array( 'pv_poll_id' =>  $s->poll_id ),
			__METHOD__ );
						
			$dbr->delete( 'poll_choice',
			array( 'pc_poll_id' =>  $s->poll_id ),
			__METHOD__ );
					
			$dbr->delete( 'poll_question',
			array( 'poll_page_id' => $article->getID() ),
			__METHOD__ );
		}
		
	}
	return true;
}

$wgExtensionFunctions[] = "wfUserPoll";
function wfUserPoll() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "userpoll", "RenderPollny" );
}

function RenderPollny( $input, $args, &$parser ){
	return "";
}

$wgHooks['ArticleFromTitle'][] = 'wfPollFromTitle';
function wfPollFromTitle( &$title, &$article ){
	global $wgUser, $wgRequest, $IP, $wgOut, $wgTitle, $wgMessageCache, $wgStyleVersion,
	$wgSupressPageTitle, $wgSupressSubTitle, $wgSupressPageCategories, $wgParser;
	
	if ( NS_POLL == $title->getNamespace()  ) {
		
		global $wgPollDirectory, $wgPollScripts;
		
		$wgOut->enableClientCache(false);
		$wgParser->disableCache();
		
		//prevents editing of POLL
		if( $wgRequest->getVal("action") == "edit" ){
			if( $wgTitle->getArticleID() == 0 ){
				$create = Title::makeTitle( NS_SPECIAL, "CreatePoll");
				$wgOut->redirect( $create->getFullURL("wpDestName=".$wgTitle->getText() ) );
			}else{
				$update = Title::makeTitle( NS_SPECIAL, "UpdatePoll");
				$wgOut->redirect( $update->getFullURL("id=".$wgTitle->getArticleID() ) );
			}
		}
		
	 	$wgSupressSubTitle = true;
		$wgSupressPageCategories = true;
		
		require_once ( "Poll.i18n.php" );
		foreach( efWikiaPoll() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		$wgNameSpacesWithEditMenu[] = NS_POLL;

		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgPollScripts}/Poll.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgPollScripts}/lightbox_light.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgPollScripts}/Poll.css?{$wgStyleVersion}\"/>\n");
		$wgOut->setOnloadHandler( "initLightbox()" );
		
		
		require_once( "{$wgPollDirectory}/PollPage.php" );
		
		$article = new PollPage($wgTitle);
	}
	
	return true;
	
}

$wgExtensionFunctions[] = "wfEmbedPoll";
function wfEmbedPoll() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "pollembed", "RenderEmbedPoll" );
}

function followPollID( $poll_title ){
	 
	$poll_article = new Article( $poll_title );
	$poll_wiki_content = $poll_article->getContent();

	if( $poll_article->isRedirect( $poll_wiki_content ) ){
		$poll_title =  $poll_article->followRedirect();
		return followPollID( $poll_title );
	}else{
		return $poll_title;
	}

}

function RenderEmbedPoll( $input, $args, &$parser ){
	global $wgOut, $wgParser, $wgUser, $wgUploadPath, $wgMessageCache, $wgPollDirectory;
	
	$poll_name = $args["title"];
	if( $poll_name ){
		$wgOut->enableClientCache(false);
		$wgParser->disableCache();
		
		require_once ( "{$wgPollDirectory}/Poll.i18n.php" );
		foreach( efWikiaPoll() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}

		$poll_title = Title::newFromText( $poll_name, NS_POLL );
		$poll_title = followPollID( $poll_title );
		$poll_page_id = $poll_title->getArticleID();
		
		if( $poll_page_id > 0 ){
			$p = new Poll();
			$poll_info = $p->get_poll($poll_page_id);
			
			$output = "";
			$output .= "<div class=\"poll-embed-title\">{$poll_info["question"]}</div>";
			if( $poll_info["image"]){
				$poll_image_width = 100;
				$poll_image = Image::newFromName( $poll_info["image"] );
				$poll_image_url = $poll_image->createThumb($poll_image_width);
				$poll_image_tag = '<img width="' . ($poll_image->getWidth() >= $poll_image_width ? $poll_image_width : $poll_image->getWidth()) . '" alt="" src="' . $poll_image_url . '"/>';
				$output .= "<div class=\"poll-image\">{$poll_image_tag}</div>";
			}
	
			//Display Question and Let user vote
			if( ! $p->user_voted( $wgUser->getName(), $poll_info["id"] ) && $poll_info["status"] == 1 ){
				$wgOut->addScript( "<script type=\"text/javascript\">YAHOO.util.Event.on(window, 'load', function () {show_embed_poll({$poll_info["id"]});});</script>");
				$output .= "<div id=\"loading-poll_{$poll_info["id"]}\" >" . wfMsgForContent( 'poll_js_loading' ) . "</div>";
				$output .= "<div id=\"poll-display_{$poll_info["id"]}\" style=\"display:none;\">";
				$output .= "<form name=\"poll_{$poll_info["id"]}\"><input type=\"hidden\" id=\"poll_id_{$poll_info["id"]}\" name=\"poll_id_{$poll_info["id"]}\" value=\"{$poll_info["id"]}\"/>";
				
				foreach($poll_info["choices"] as $choice){
					$output .= "<div class=\"poll-choice\"><input type=\"radio\" name=\"poll_choice\"  onclick=\"poll_embed_vote({$poll_info["id"]}, {$poll_page_id})\" id=\"poll_choice\" value=\"{$choice["id"]}\">{$choice["choice"]}</div>";
				}
				
				
				$output .= "</div>
					</form>";
			}else{
				//Display Message if Poll has been closed for voting
				if( $poll_info["status"] == 0 ){
					$output .= "<div class=\"poll-closed\">" . wfMsgForContent( 'poll_closed' ) . "</div>";
				}
				
				$x = 1;
				
				foreach($poll_info["choices"] as $choice){
					//$percent = round( $choice["votes"] / $poll_info["votes"]  * 100 );
					if( $poll_info["votes"] > 0 ){
						$bar_width = floor( 480 * ( $choice["votes"] / $poll_info["votes"] ) );
					}
					$bar_img = "<img src=\"{$wgUploadPath}/common/vote-bar-{$x}.gif\"  border=\"0\" class=\"image-choice-{$x}\" style=\"width:{$choice["percent"]}%;height:12px;\"/>";
					
					$output .= "<div class=\"poll-choice\">
					<div class=\"poll-choice-left\">{$choice["choice"]} ({$choice["percent"]}%)</div>";
					
					$output .= "<div class=\"poll-choice-right\">{$bar_img} <span class=\"poll-choice-votes\">".(($choice["votes"] > 0)?"{$choice["votes"]}":"0")." " . wfMsgExt( 'poll_votes' , "parsemag",  $choice["votes"] ) ."</span></div>";
					$output .= "</div>";
					
					$x++;
				}
				
				$output .= "<div class=\"poll-total-votes\">(" . wfMsgForContent( 'poll_based_on' ) . " {$poll_info["votes"]} " . wfMsgExt( 'poll_votes' , "parsemag", $poll_info["votes"] ) . ")</div>";	
				$output .= "<div><a href=\"" . $poll_title->escapeFullURL() . "\">" . wfMsg("poll_discuss") . "</a></div>";
				$output .= "<div style=\"font-size:12px;color:#666666;margin-top:15px;\">Created " . get_time_ago($poll_info["timestamp"]) . " ago</div>";
			}
			
			return $output;
					
		}else{
			$output = "";
			$output .= "<div class=\"poll-embed-title\">" . wfMsg("poll_unavailable") . "</div>";
			return $output;
		}
	}
	return "";
}

$wgHooks['UserRename::Local'][] = "PollNYUserRenameLocal";

function PollNYUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'poll_question',
		'userid_column' => 'poll_user_id',
		'username_column' => 'poll_user_name',
	);
	$tasks[] = array(
		'table' => 'poll_user_vote',
		'userid_column' => 'pv_user_id',
		'username_column' => 'pv_user_name',
	);
	return true;
}

?>

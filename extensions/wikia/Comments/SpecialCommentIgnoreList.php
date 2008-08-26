<?php
$wgExtensionFunctions[] = 'wfSpecialCommentIgnoreList';


function wfSpecialCommentIgnoreList(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class CommentIgnoreList extends SpecialPage {
	
		function CommentIgnoreList(){
			SpecialPage::SpecialPage("CommentIgnoreList");
		}
		
		function execute(){
			global $wgUser, $wgOut, $wgRequest, $IP, $wgCommentsDirectory, $wgMessageCache;
			
			$wgOut->setPagetitle( wfMsg("comment_ignore_title") );
			
			require_once ("$wgCommentsDirectory/CommentClass.php");
			require_once ("$IP/extensions/wikia/UserStats/UserStatsClass.php");
			
			//language messages
			require_once ( "$IP/extensions/wikia/Comments/Comments.i18n.php" );
			foreach( efWikiaComments() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
			
			$c = new Comment(0);
		
			/*/
			/* Redirect Non-logged in users to Login Page
			/* It will automatically return them to the CommentBlockList page
			/*/
			if($wgUser->getID() == 0 && $user_name==""){
				$block_list =  Title::makeTitle( NS_SPECIAL  , "CommentIgnoreList"  );
				$wgOut->redirect( $block_list->getFullURL() . "&returnto=Special:CommentIgnoreList" );
				return false;
			}
			
			if($wgRequest->getVal("user")==""){
				$out .= $this->displayCommentBlockList();
			}else{
				if($wgRequest->wasPosted()){
					$user_id = User::idFromName($wgRequest->getVal("user"));
					$c->delete_block($wgUser->getID(),$user_id);
					if($user_id){
						$stats = new UserStatsTrack($user_id, $wgRequest->getVal("user"));
						$stats->decStatField("comment_ignored");
					}
					$out .= $this->displayCommentBlockList();
				}else{
					$out .= $this->confirmCommentBlockDelete();
				}
			}
			$wgOut->addHTML($out);
		}
		
		function displayCommentBlockList(){
			global $wgUser;
			$block_title = Title::makeTitle( NS_SPECIAL  , "CommentIgnoreList" );
			
			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT cb_user_name_blocked, cb_date
				FROM Comments_block 
				WHERE cb_user_id = {$wgUser->getID()}
				ORDER BY cb_user_name
				";
			
			
			$res = $dbr->query($sql);
			
			if( $dbr->numRows($res)>0){
				$out = "<ul>";
				while ($row = $dbr->fetchObject( $res ) ) {
					$user_title =  Title::makeTitle( NS_USER  , $row->cb_user_name_blocked );
					$out .= "<li>
							".wfMsg("comment_ignore_item", $user_title->escapeFullURL(), $user_title->getText(), $row->cb_date, $block_title->escapeFullURL("user=".$user_title->getText()))."
						</li>";
				}
				$out .= "</ul>";
			}else{
				$out = "<div class=\"comment_blocked_user\">".wfMsg("comment_ignore_no_users")."</div>";
			}
			return $out;		
		}
		
		function confirmCommentBlockDelete(){
			global $wgUser, $wgRequest;
			
			$user_name = $wgRequest->getVal("user");
			
			$out = "<div class=\"comment_blocked_user\">
					".wfMsg("comment_ignore_remove_message", $user_name)."
				</div>
				<p>
				<div>
					<form action=\"\" method=\"POST\" name=\"comment_block\">
					<input type=\"hidden\" name=\"{$user_name}\">
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg("comment_ignore_unblock")."\" onclick=\"document.comment_block.submit()\">
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg("comment_ignore_cancel")."\" onclick=\"history.go(-1)\">
					</form>
				</div>
				";
			return $out;	
						
		}
	}
	

	SpecialPage::addPage( new CommentIgnoreList );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'commentignorelist', 'Comment Ignore List' );
}

?>
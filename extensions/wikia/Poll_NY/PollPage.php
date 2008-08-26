<?php
class PollPage extends Article{


	var $title = null;
	
	function __construct (&$title){
		parent::__construct(&$title);
	
	}

	function view(){
		global $wgUser, $wgTitle, $wgOut, $wgStyleVersion, $wgRequest, $wgSupressPageTitle, $wgNameSpacesWithEditMenu, $wgUploadPath;
		
		$wgSupressPageTitle = true;
		$wgOut->setHTMLTitle(  $wgTitle->getText() );
		$wgOut->setPageTitle(  $wgTitle->getText() );
	
		$wgNameSpacesWithEditMenu[] = NS_POLL;
	
		$wgOut->addScript("<script>YAHOO.util.Event.on(window, 'load', function () {initLightbox();show_poll();});</script>");
		
		$wgOut->addHTML("<script>
					var _POLL_OPEN_MESSAGE = \"" . addslashes(wfMsgForContent( 'poll_open_message' )) . "\"
					var _POLL_CLOSE_MESSAGE = \"" . addslashes(wfMsgForContent( 'poll_close_message' )) . "\"
					var _POLL_FLAGGED_MESSAGE = \"" . addslashes(wfMsgForContent( 'poll_flagged_message' )) . "\"
					var _POLL_FINISHED = \"" . addslashes(wfMsgForContent( 'poll_finished', $wgTitle->getFullURL() )) . "\"
				</script>
				");
					
		//Get Total Polls Count so we can tell the user how many they have voted for out of total
		$dbr =& wfGetDB( DB_MASTER );
		$total_polls = 0;
		$s = $dbr->selectRow( '`poll_question`', array( 'count(*) as count' ), '', $fname );
		if ( $s !== false )$total_polls = number_format($s->count);	
		
		$stats = new UserStats($wgUser->getID(), $wgUser->getName() );
		$stats_current_user = $stats->getUserStats();
		
		$sk =& $wgUser->getSkin();
		
		$p = new Poll();
		$poll_info = $p->get_poll( $wgTitle->getArticleID() );
		
		if(!$poll_info["id"]){
			return "";
		}

		//Set Up Submitter Data
			$user_title = Title::makeTitle( NS_USER  , $poll_info["user_name"]  );
			$avatar = new wAvatar($poll_info["user_id"],"l");
			$avatarID = $avatar->getAvatarImage();
			$stats = new UserStats($poll_info["user_id"], $poll_info["user_name"]);
			$stats_data = $stats->getUserStats();
			$user_name_short = ($poll_info["user_name"] == substr($poll_info["user_name"], 0, 27) ) ?
								 $poll_info["user_name"] : ( substr($poll_info["user_name"], 0, 27) . "...");
			
			$output .= "<div class=\"poll-right\" >";
			if ($wgUser->isLoggedIn()) {
				$output .= "<div class=\"create-link\">
				<a href=\"" . Title::makeTitle(NS_SPECIAL, "CreatePoll")->escapeFullURL() . "\">
						<img src=\"{$wgUploadPath}/common/addIcon.gif\" border=\"0\"/>
						" . wfMsgForContent( 'poll_create' ) . "
					</a>
				</div>";
			}
			$output .= "<div class=\"credit-box\" >
					<h1>" . wfMsgForContent( 'poll_submitted_by' ) . "</h1>
					<div class=\"submitted-by-image\">
					<a href=\"{$user_title->getFullURL()}\"><img src=\"{$wgUploadPath}/avatars/{$avatarID}\" style=\"border:1px solid #d7dee8; width:50px; height:50px;\"/></a>
					</div>
					<div class=\"submitted-by-user\">
						<a href=\"{$user_title->getFullURL()}\">{$user_name_short}</a>
						<ul>
							<li>
								<img src=\"{$wgUploadPath}/common/voteIcon.gif\" border=\"0\" alt=\"\"> {$stats_data["votes"]}
							</li>
							<li>
								<img src=\"{$wgUploadPath}/common/pencilIcon.gif\" border=\"0\" alt=\"\"> {$stats_data["edits"]}
							</li>
							<li>
								<img src=\"{$wgUploadPath}/common/commentsIcon.gif\" border=\"0\" alt=\"\"> {$stats_data["comments"]}
							</li>
						</ul>
					</div>
					<div class=\"cleared\"></div>
					
					<a href=\"" . Title::makeTitle(NS_SPECIAL, "ViewPoll")->escapeFullURL("user=".$poll_info["user_name"]) . "\">" . wfMsgForContent( 'poll_view_all_by' ) . " {$user_name_short}</a>
					
				</div>";
				
				$output .= "<div class=\"poll-stats\">";
				
					if( $wgUser->isLoggedIn() ){
						$output .= wfMsgForContent( 'poll_voted_for' ) . " <b>{$stats_current_user["poll_votes"]}</b> " . (($stats_current_user["poll_votes"]!=1)?wfMsgForContent( 'poll_polls' ):wfMsgForContent( 'poll_poll' )) . " " . wfMsgForContent( 'poll_out_of',$total_polls ) . "<br>" . wfMsgForContent( 'poll_received',number_format($stats_current_user["poll_votes"]*5) ) . "";
					}else{
						$register_title = Title::makeTitle(NS_SPECIAL,"UserRegister");
						$output .= wfMsgForContent( 'poll_would_have_earned', number_format($total_polls*5) ) . " <a href=\"" . $register_title->getFullURL() . "\">" . wfMsgForContent( 'poll_register_link' ) . "</a>";
					}
				
				$output .= "</div>";
				
				$toggle_flag_label = (($poll_info["status"]==1)? wfMsg("poll_flag_poll") :wfMsg("poll_unflag_poll"));
				$toggle_flag_status = (($poll_info["status"]==1)?2:1);
				
				if( $poll_info["status"] == 1){
					//Creator and Admins can change the status of a poll
					$toggle_label = (($poll_info["status"]==1)? wfMsg("poll_close_poll") :wfMsg("poll_open_poll"));
					$toggle_status = (($poll_info["status"]==1)?0:1);
				}
				
				
				$output .= "<div class=\"poll-links\">";
				
					if( $wgUser->isAllowed('protect') ){
						$output .= "<a href=\"" . Title::makeTitle( NS_SPECIAL, "AdminPoll")->escapeFullURL() . "\">" . wfMsg("poll_admin_panel") . "</a> | ";
					}
					if( $poll_info["status"] == 1 && ( $poll_info["user_id"] == $wgUser->getID() || $wgUser->isAllowed('protect') ) ){
						$output .= "<a href=\"javascript:void(0)\" onclick=\"poll_toggle_status({$toggle_status});\">{$toggle_label}</a> |";
					}
					if( $poll_info["status"] == 1 || $wgUser->isAllowed('protect')){
						$output .= " <a href=\"javascript:void(0)\" onclick=\"poll_toggle_status({$toggle_flag_status});\">{$toggle_flag_label}</a>";
					}
				$output .= "</div>";
				
				
				
			$output .= "</div>";
			$output .= "<div class=\"poll\">";
		
			$output .= "<h1 class=\"pagetitle\">{$wgTitle->getText()}</h1>";
			
			if( $poll_info["image"]){
				$poll_image_width = 150;
				$poll_image = Image::newFromName( $poll_info["image"] );
				$poll_image_url = $poll_image->createThumb($poll_image_width);
				$poll_image_tag = '<img width="' . ($poll_image->getWidth() >= $poll_image_width ? $poll_image_width : $poll_image->getWidth()) . '" alt="" src="' . $poll_image_url . '"/>';
				$output .= "<div class=\"poll-image\">{$poll_image_tag}</div>";
			}
	
			//Display Question and Let user vote
			if( ! $p->user_voted( $wgUser->getName(), $poll_info["id"] ) && $poll_info["status"] == 1 ){
				
				$output .= "<div id=\"loading-poll\" >" . wfMsgForContent( 'poll_js_loading' ) . "</div>";
				$output .= "<div id=\"poll-display\" style=\"display:none;\">";
				$output .= "<form name=\"poll\"><input type=\"hidden\" id=\"poll_id\" name=\"poll_id\" value=\"{$poll_info["id"]}\"/>";
				
				foreach($poll_info["choices"] as $choice){
					$output .= "<div class=\"poll-choice\"><input type=\"radio\" name=\"poll_choice\"  onclick=\"poll_vote()\" id=\"poll_choice\" value=\"{$choice["id"]}\">{$choice["choice"]}</div>";
				}
				
				
				$output .= "</div>
					</form>";
				
				$output .= "<div style=\"font-size:12px;color:#666666;margin-top:15px;\">Created " . get_time_ago($poll_info["timestamp"]) . " ago</div>";
			
				$output .= "<div class=\"poll-button\">
					<a href=\"javascript:poll_skip();\">" . wfMsgForContent( 'poll_skip' ) . "</a>
				</div>";
				
				if( $wgRequest->getVal("prev_id") ){
					
					$p = new Poll();
					$poll_info_prev = $p->get_poll( $wgRequest->getVal("prev_id") );
					$poll_title = Title::makeTitle(300,$poll_info_prev["question"]);
					$output .= "<div class=\"previous-poll\" >";
						
					$output .= "<div class=\"previous-poll-title\">" . wfMsgForContent( 'poll_previous_poll' ) . " - <a href=\"{$poll_title->getFullURL()}\">{$poll_info_prev["question"]}</a></div>
						<div class=\"previous-sub-title\">" . wfMsgForContent( 'poll_answered' ) . " " . $poll_info_prev["votes"] . " " . wfMsgExt( 'poll_times' , "parsemag",  $poll_info_prev["votes"] ) . "</div>";
						
						$x=1;
						
						foreach($poll_info_prev["choices"] as $choice) {
							$percent = round( $choice["votes"] / $poll_info_prev["votes"]  * 100 );
							if( $poll_info_prev["votes"]  > 0 ){
								$bar_width = floor( 360 * ( $choice["votes"] / $poll_info_prev["votes"] ) );
							}else{
								$bar_width = 0;
							}
							$bar_img = "<img src=\"{$wgUploadPath}/common/vote-bar-{$x}.gif\"  border=\"0\" class=\"image-choice-{$x}\" style=\"width:{$bar_width}px;height:11px;\"/>";
							$output .= "<div class=\"previous-poll-choice\">
								<div class=\"previous-poll-choice-left\">{$choice["choice"]} ({$choice["percent"]}%)</div>";
							
							$output .= "<div class=\"previous-poll-choice-right\">{$bar_img} <span class=\"previous-poll-choice-votes\">".(($choice["votes"]>0)?"{$choice["votes"]}":"0")." ". wfMsgExt( 'poll_votes' , "parsemag",  $choice["votes"] ) ."</span></div>";
							
							$output .= "</div>";
							
						$x++;
						
						}
					$output .= "</div>";
				}
				
					
			} else {
				
				$show_results = true;
				//Display Message if Poll has been closed for voting
				if( $poll_info["status"] == 0 ){
					$output .= "<div class=\"poll-closed\">" . wfMsgForContent( 'poll_closed' ) . "</div>";
				}
				
				//Display Message if Poll has been closed for voting
				if( $poll_info["status"] == 2 ){
					$output .= "<div class=\"poll-closed\">" . wfMsgForContent( 'poll_flagged' ) . "</div>";
					if( !$wgUser->isAllowed('protect') ){
						$show_results = false;
					}
				}
				if( $show_results ){
					$x = 1;
					
					foreach($poll_info["choices"] as $choice){
						//$percent = round( $choice["votes"] / $poll_info["votes"]  * 100 );
						if( $poll_info["votes"] > 0 ){
							$bar_width = floor( 480 * ( $choice["votes"] / $poll_info["votes"] ) );
						}
						$bar_img = "<img src=\"{$wgUploadPath}/common/vote-bar-{$x}.gif\"  border=\"0\" class=\"image-choice-{$x}\" style=\"width:{$bar_width}px;height:12px;\"/>";
						
						$output .= "<div class=\"poll-choice\">
						<div class=\"poll-choice-left\">{$choice["choice"]} ({$choice["percent"]}%)</div>";
						
						$output .= "<div class=\"poll-choice-right\">{$bar_img} <span class=\"poll-choice-votes\">".(($choice["votes"] > 0)?"{$choice["votes"]}":"0")." " . wfMsgExt( 'poll_votes' , "parsemag",  $choice["votes"] ) ."</span></div>";
						$output .= "</div>";
						
						$x++;
					}
				}
				
				$output .= "<div class=\"poll-total-votes\">(" . wfMsgForContent( 'poll_based_on' ) . " {$poll_info["votes"]} " . wfMsgExt( 'poll_votes' , "parsemag", $poll_info["votes"] ) . ")</div>";	
				$output .= "<div style=\"font-size:12px;color:#666666;margin-top:15px;\">Created " . get_time_ago($poll_info["timestamp"]) . " ago</div>";
			
				$output .= "<div class=\"poll-button\">
					<input type=\"hidden\" id=\"poll_id\" name=\"poll_id\" value=\"{$poll_info["id"]}\"/>
					<a href=\"javascript:poll_loading_light_box();goto_new_poll();\">" .wfMsgForContent( 'poll_next_poll' ) . " ></a>
				</div>";
						
				
			}
			$poll_embed_name = htmlspecialchars( $wgTitle->getText(), ENT_QUOTES );
			$output .= "<br/><table cellpadding=\"0\" cellspacing=\"2\" border=\"0\"><tr><td><b>" . wfMsgForContent( 'poll_embed') . "</b> </td><td><form name=\"embed_poll\"><input name='embed_code' style='width:300px;font-size:10px;' type='text' value='<pollembed title=\"{$poll_embed_name}\"></pollembed>'  onClick='javascript:document.embed_poll.embed_code.focus();document.embed_poll.embed_code.select();' readonly='true'></form></td></tr></table>";
			 
			$output .= "</div>";
			
			
			$output .= "<div class=\"cleared\"></div>";
		
		
		 
		$wgOut->addHTML( $output ); 
		
		global $wgPollDisplay;
		if( $wgPollDisplay["comments"] == true ){
			$wgOut->addWikiText("<comments></comments>");
		}
	}

}
?>
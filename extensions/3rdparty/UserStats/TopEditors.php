<?php

$wgExtensionFunctions[] = 'wfSpecialTopUsersEditors';


function wfSpecialTopUsersEditors(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class TopUsersEdits extends UnlistedSpecialPage {

  function TopUsersEdits(){
    UnlistedSpecialPage::UnlistedSpecialPage("TopEditors");
  }

  function execute(){
    global $wgUser, $wgOut; 
    $wgOut->setPagetitle( "Top Editors" );
    $dbr =& wfGetDB( DB_MASTER );
    $sql = "SELECT stats_user_id,stats_user_name, stats_edit_count as stat_count from user_stats where stats_year_id = 1 and stats_user_id <> 0 ORDER BY stats_edit_count DESC LIMIT 0,50";
    $res = $dbr->query($sql);
    $header = wfMsg("topuserseditsheader");
    if($header != "&lt;topuserseditsheader&gt;"){
	    $out = $header;
    }
   // $out = "<span style='font-size:11px;color:#666666;'>Here are the top users since the new \"season\" started on March 7th, 2007.  Points are based on a super secret formula.<p><a href=\"index.php?title=ArmchairGM Top Users: Year 1\">Click here for the Top Users of the Inaugural Year</a></span><p>";
    $x = 1;
    $out .= "<div class=\"top-users\">
    <div class=\"top-user-header\"><span class=\"top-user-num\">#</span><span class=\"top-user\">User</span><span class=\"top-user-points\">Edits</span></div>";
    while ($row = $dbr->fetchObject( $res ) ) {
	    $user_name = $row->stats_user_name;
	    $user_title = Title::makeTitle( NS_USER  , $row->stats_user_name  );
	    $avatar = new wAvatar($row->stats_user_id,"s");
	    $CommentIcon = $avatar->getAvatarImage();
	    $out .= "<div class=\"top-user-row\">
	    		<span class=\"top-user-num\">{$x}</span><span class=\"top-user\"><img src='images/avatars/" . $CommentIcon . "' alt='' border=''> <a href='" . $user_title->getFullURL() . "' class=\"top-user-link\">" . $row->stats_user_name . "</a><a href='" . $user_title->getTalkPage()->getFullURL() .   "' class=\"top-user-talk\"><img src=\"images/commentIcon.gif\" border=\"0\" hspace=\"3\" align=\"middle\" alt=\"\" /></a>
			</span>";
			
	    $out .=  "<span class=\"top-user-points\">" . $row->stat_count . "</span>
	    	</div>";
	    $x++;
    }
     $out .= "</div>";
    $wgOut->addHTML($out);
  }

}

 SpecialPage::addPage( new TopUsersEdits );
 global $wgMessageCache,$wgOut;
 //$wgMessageCache->addMessage( 'commenteaction', 'comment action' );
 


}

?>
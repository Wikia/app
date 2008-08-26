<?php

$wgExtensionFunctions[] = 'wfSpecialTopUsers';


function wfSpecialTopUsers(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class TopUsersPoints extends UnlistedSpecialPage {

  function TopUsersPoints(){
    UnlistedSpecialPage::UnlistedSpecialPage("TopUsers");
  }

  function execute(){
    global $wgUser, $wgOut; 
    $wgOut->setPagetitle( "Top Users" );
    $dbr =& wfGetDB( DB_MASTER );
    $sql = "SELECT stats_user_id,stats_user_name, stats_total_points from user_stats where stats_year_id = 1 and stats_user_id <> 0 ORDER BY stats_total_points DESC LIMIT 0,50";
    $res = $dbr->query($sql);
    $header = wfMsg("topusersheader");
    if($header != "&lt;topusersheader&gt;"){
	    $out = $header;
    }
   // $out = "<span style='font-size:11px;color:#666666;'>Here are the top users since the new \"season\" started on March 7th, 2007.  Points are based on a super secret formula.<p><a href=\"index.php?title=ArmchairGM Top Users: Year 1\">Click here for the Top Users of the Inaugural Year</a></span><p>";
    $x = 1;
    $out .= "<div class=\"top-users\">
    <div class=\"top-user-header\"><span class=\"top-user-num\">#</span><span class=\"top-user\">User</span><span class=\"top-user-points\">Points</span></div>";
    while ($row = $dbr->fetchObject( $res ) ) {
	    $user_name = $row->stats_user_name;
	    $user_title = Title::makeTitle( NS_USER  , $row->stats_user_name  );
	    $avatar = new wAvatar($row->stats_user_id,"s");
	    $CommentIcon = $avatar->getAvatarImage();
	    $out .= "<div class=\"top-user-row\">
	    		<span class=\"top-user-num\">{$x}</span><span class=\"top-user\"><img src='images/avatars/" . $CommentIcon . "' alt='' border=''> <a href='" . $user_title->getFullURL() . "' class=\"top-user-link\">" . $row->stats_user_name . "</a><a href='" . $user_title->getTalkPage()->getFullURL() .   "' class=\"top-user-talk\"><img src=\"images/commentIcon.gif\" border=\"0\" hspace=\"3\" align=\"middle\" alt=\"\" /></a>
			</span>";
			
	    $out .=  "<span class=\"top-user-points\">" . $row->stats_total_points . "</span>
	    	</div>";
	    $x++;
    }
     $out .= "</div>";
    $wgOut->addHTML($out);
  }

}

 SpecialPage::addPage( new TopUsersPoints );
 global $wgMessageCache,$wgOut;
 //$wgMessageCache->addMessage( 'commenteaction', 'comment action' );
 


}

?>
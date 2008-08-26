<?php

$wgExtensionFunctions[] = 'wfViewPoll';

function wfViewPoll(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class ViewPoll extends SpecialPage {

	
	function ViewPoll(){
		UnlistedSpecialPage::UnlistedSpecialPage("ViewPoll");
	}

	
	function execute(){
		global $wgRequest, $wgUser, $wgOut, $wgRequest, $IP, $wgStyleVersion, $wgUploadPath, $wgPollScripts;
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgPollScripts}/Poll.css?{$wgStyleVersion}\"/>\n");
		
		global $wgMessageCache;
		require_once ( "Poll.i18n.php" );
		foreach( efWikiaPoll() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		
		//page either most or newest for everyone
		$type = $wgRequest->getVal('type');
		if(!$type)$type="most";
		if($type=="newest")$order="ORDER BY poll_id";
		if($type=="most")$order="ORDER BY poll_vote_count";
		
		//display only a user's most or newest
		$user = $wgRequest->getVal('user');
		if ($user) {
			$user_sql = "WHERE poll_user_name='" . addslashes($user)."'";
			$user_link = "&user=" . urlencode($user);
			$user_page_title = "{$user}'s";
		}
		
		//pagination
		$per_page = 20;
		$page = $wgRequest->getVal('page');
		if(!$page  || !is_numeric($page) )$page=1;
		
		$limit=$per_page;

		if ($limit > 0) {
				$limitvalue = 0;
				if($page)$limitvalue = $page * $limit - ($limit); 
				$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		//safelinks
		$random_poll_link = Title::makeTitle(NS_SPECIAL, "RandomPoll");
		
		
		$output .= "
		<div class=\"view-poll-top-links\">
			<a href=\"".$random_poll_link->escapeFullURL()."\">" . wfMsgForContent( 'poll_take_button' ) . "</a>
		</div>
		
		<div class=\"view-poll-navigation\">
			<h2>" . wfMsgForContent( 'poll_view_order' ) . "</h2>";
		
			if ($type=="newest") {
				$output .= "<p><a href=\"/index.php?title=Special:ViewPoll&type=most{$user_link}\">" . wfMsgForContent( 'poll_view_popular' ) . "</a></p><p><b>" . wfMsgForContent( 'poll_view_newest' ) . "</b></p>";
			} else {
				$output .= "<p><b>" . wfMsgForContent( 'poll_view_popular' ) . "</b></p><p><a href=\"index.php?title=Special:ViewPoll&type=newest{$user_link}\">" . wfMsgForContent( 'poll_view_newest' ) . "</a></p>";
			}
		
		$output .= "</div>";
		
		$wgOut->setPageTitle( wfMsgForContent( 'poll_view_title' ,$user_page_titl) );
		
		$dbr =& wfGetDB( DB_SLAVE );
		
		
		$sql = "SELECT poll_user_id, UNIX_TIMESTAMP(poll_date) as poll_time, poll_vote_count,poll_user_name, poll_text, poll_page_id, page_id FROM poll_question INNER JOIN page ON poll_page_id=page_id {$user_sql} {$order} DESC {$limit_sql}";
		$res = $dbr->query($sql);
		
		$sql_total = "SELECT COUNT(*) as total_polls FROM poll_question {$user_sql}";
		$res_total = $dbr->query($sql_total);
		$row_total = $dbr->fetchObject($res_total);
		$total = $row_total->total_polls;
		
		//javascript
		
		$output .= "<script>
				function doHover(divID) {
					\$El(divID).setStyle('backgroundColor', '#FFFCA9'); 
				}
				
				function endHover(divID){
					\$El(divID).setStyle('backgroundColor', ''); 
				}
				
		</script>";
		
		$output .= "<div class=\"view-poll\">";
		
			
			$x = (($page-1)*$per_page) + 1; 
			
			
			while ( $row = $dbr->fetchObject($res) ) {
				
				$user_create = $row->poll_user_name;
				$user_id = $row->poll_user_id;
				$avatar = new wAvatar($user_id,"m");
				$poll_title = $row->poll_text;
				$poll_date = $row->poll_time;
				$poll_answers = $row->poll_vote_count;
				$row_id = "poll-row-{$x}";
				$title = Title::makeTitle(NS_POLL,  $poll_title ) ;
				
				
				if (($x < $dbr->numRows($res) ) && ($x%$per_page != 0)) {
					$output .= "<div class=\"view-poll-row\" id=\"{$row_id}\" onmouseover=\"doHover('{$row_id}')\" onmouseout=\"endHover('{$row_id}')\" onclick=\"window.location='{$title->escapeFullURL()}'\">";
				} else {
					$output .= "<div class=\"view-poll-row-bottom\" id=\"{$row_id}\" onmouseover=\"doHover('{$row_id}')\" onmouseout=\"endHover('{$row_id}')\" onclick=\"window.location='{$title->escapeFullURL()}'\">";
				}
				
					$output .= "<div class=\"view-poll-number\">{$x}.</div>
					<div class=\"view-poll-user-image\"><img src=\"{$wgUploadPath}/avatars/{$avatar->getAvatarImage()}\" /></div>
					<div class=\"view-poll-user-name\">{$user_create}</div>
					<div class=\"view-poll-text\">
						<p><b><u>{$poll_title}</u></b></p>
						<p class=\"view-poll-num-answers\">" . wfMsgForContent( 'poll_view_answered' ) . " {$poll_answers} " .  wfMsgExt( 'poll_view_times', 'parsemag', $poll_answers) . "</p>
						<p class=\"view-poll-time\">(".get_time_ago($poll_date)."ago)</p>
					</div>
					<div class=\"cleared\"></div>
				</div>";
				
				$x++;
			}
		
		$output .= "</div>
		<div class=\"cleared\"></div>";
		
		$numofpages = $total / $per_page; 
		
		if($numofpages>1){
			$output .= "<div class=\"view-poll-page-nav\">";
			if($page > 1){ 
				$output .= "<a href=\"/index.php?title=Special:ViewPoll&type=most{$user_link}&page=" . ($page-1) . "\">prev</a> ";
			}
			
			
			if(($total % $per_page) != 0)$numofpages++;
			if($numofpages >=9 && $page < $total)$numofpages=9+$page;
			if($numofpages >= ($total / $per_page) )$numofpages = ($total / $per_page)+1;
			
			for($i = 1; $i <= $numofpages; $i++){
				if($i == $page){
				    $output .=($i." ");
				}else{
				    $output .="<a href=\"/index.php?title=Special:ViewPoll&type=most{$user_link}&page=$i\">$i</a> ";
				}
			}
	
			if(($total - ($per_page * $page)) > 0){
				$output .=" <a href=\"/index.php?title=Special:ViewPoll&type=most{$user_link}&page=" . ($page+1) . "\">next</a>"; 
			}
			$output .= "</div>";
		}
		
		$wgOut->addHTML($output);
	
	}
  
 
	
}

SpecialPage::addPage( new ViewPoll );

 


}

?>
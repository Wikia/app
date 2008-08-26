<?php
class SiteScout{
	var $showEdits = true;
	var $showVotes = true;
	var $showComments = true;
	var $showNetworkUpdates = true;
	
	var $itemMax = 50;
	var $timestamp = 0;
	var $items = array();
	
	function SiteScout(){
		$this->user_id = $uid;
		return "";
	} 

	function setItemMax($max){ 
		if( is_numeric($max) ){
			$this->itemMax = $max;
		}
	}
	
	function setTimestamp($ts){ 
		if( is_numeric($ts) ){
			$this->timestamp = $ts;
		}
	}
	
	function setShowEdits($details){ 
		if( is_numeric($details) && $details == 1 ){
			$this->showEdits = true;
		}else{
				$this->showEdits = false;
		}
	}
	
	function setShowVotes($details){ 
		if( is_numeric($details) && $details == 1 ){
			$this->showVotes = true;
		}else{
			$this->showVotes = false;
		}
	}
	
	function setShowComments($details){ 
		if( is_numeric($details) && $details == 1 ){
			$this->showComments = true;
		}else{
			$this->showComments = false;
		}
	}

	function setShowNetworkUpdates($details){ 
		if( is_numeric($details) && $details == 1 ){
			$this->showNetworkUpdates = true;
		}else{
			$this->showNetworkUpdates = false;
		}
	}
	
	function getControls(){	
		global $wgSitename, $wgUploadPath;
		$edits = $this->getEditCount();
		$votes = $this->getVoteCount();
		$comments = $this->getCommentCount();
		if($wgSitename=="ArmchairGM"){
		$networkupdates = $this->getNetworkUpdatesCount();
		}
		else {
			$networkupdates = 0;
		}
		$largest_value = max($edits, $votes, $comments,$networkupdates);
		
		$output .= "<script >
			function changeFilter(){
				if(!\$(\"f_edits\").checked){scout_edits=0}else{scout_edits=1};
				if(!\$(\"f_votes\").checked){scout_votes=0}else{scout_votes=1};
				if(!\$(\"f_comments\").checked){scout_comments=0}else{scout_comments=1};
				if(\$(\"f_networkupdates\") && !\$(\"f_networkupdates\").checked){networkupdates=0}else{networkupdates=1};
				document.cookie='scout_edits='+scout_edits
				document.cookie='scout_votes='+scout_votes
				document.cookie='scout_comments='+scout_comments
				document.cookie='scout_networkupdates='+networkupdates
				window.location=\"/index.php?title=Special:SiteScout&edits=\" + scout_edits+\"&votes=\" + scout_votes+\"&comments=\" + scout_comments+\"&networkupdates=\" + networkupdates
			}
			</script>";
		
		$output .= "
			<table>
				<tr>
					<td>
						<table class=site-scout-stats>
							<tr>
								<td class=site-scout-stats-header colspan=2>" . wfMsg( 'sitescout_todaystats' ) . "</td>
							</tr>
							<tr>
								<td>
									<img src=\"{$wgUploadPath}/common/voteIcon.gif\" border=\"0\" alt=\"Votes\"/>
								</td>
								<td>
									".wfMsg( 'sitescout_votes' )."
								</td>
								<td>
									<span id=vote_stats>
										<table>
											<tr>
												<td>
													<table style=\"background-color:#009900; height:7px;\" width=\"".($votes / $largest_value * 300)."\">
														<tr>
															<td></td>
														</tr>
													</table>
												</td>
												<td>{$votes}</td>
											</tr>
										</table>
									</span>
								</td>
							</tr>
							<tr>
								<td>
									<img src=\"{$wgUploadPath}/common/editIcon.gif\" border=\"0\" alt=\"Edits\"/>
								</td>
								<td>
									".wfMsg( 'sitescout_edits' )."
								</td>
								<td>
									<span id=edit_stats>
										<table>
											<tr>
												<td>
													<table style=\"background-color:#285C98; height:7px;\" width=\"".($edits / $largest_value * 300)."\">
														<tr>
															<td></td>
														</tr>
													</table>
												</td>
												<td>{$edits}</td>
											</tr>
										</table>
									</span>
								</td>
							</tr>

							<tr>
								<td>
									<img src=\"{$wgUploadPath}/common/comment.gif\" border=\"0\" alt=\"Comments\"/>
								</td>
								<td>
									".wfMsg( 'sitescout_comments' )."
								</td>
								<td>
									<span id=comment_stats>
										<table>
											<tr>
												<td>
													<table style=\"background-color:#990000; height:7px;\" width=\"".($comments  / $largest_value * 300)."\">
														<tr>
															<td></td>
														</tr>
													</table>
												</td>
												<td>{$comments}</td>
											</tr>
										</table>
									</span>
								</td>
							</tr>";
							if($wgSitename=="ArmchairGM"){
								$output .= "<tr>
									<td>
										<img src=\"{$wgUploadPath}/common/note.gif\" border=\"0\" alt=\"Network Thoughts\"/>
									</td>
									<td>
										".wfMsg( 'sitescout_thoughts' )."
									</td>
									<td>
										<span id=networkupdates_stats>
											<table>
												<tr>
													<td>
														<table bgcolor=\"#FFFCA9\" height=\"7\"  width=\"".($networkupdates  / $largest_value * 300)."\">
															<tr>
																<td></td>
															</tr>
														</table>
													</td>
													<td>{$networkupdates}</td>
												</tr>
											</table>
										</span>
									</td>
								</tr>";
							}
						$output .= "</table>
					</td>
				</tr>
				<tr>
					<td>";
						$output .= "<div style=\"padding:15px 0px 15px 0px;\">
			
						<img src=\"{$wgUploadPath}/common/editIcon.gif\" border=\"0\" alt=\"Edits\"><input type=\"checkbox\" name=\"f_edits\" id=\"f_edits\" value=\"1\" " . (($this->showEdits)?"checked":"") . " />
						<img src=\"{$wgUploadPath}/common/voteIcon.gif\" border=\"0\" alt=\"Votes\"><input type=\"checkbox\" name=\"f_votes\" id=\"f_votes\" value=\"1\" " . (($this->showVotes)?"checked":"") . " />
						<img src=\"{$wgUploadPath}/common/comment.gif\" border=\"0\" alt=\"Comments\"><input type=\"checkbox\" name=\"f_comments\" id=\"f_comments\" value=\"1\" " . (($this->showComments)?"checked":"") . " />";
						if($wgSitename=="ArmchairGM"){
							$output .= "<img src=\"{$wgUploadPath}/common/note.gif\" border=\"0\" alt=\"Network Updates\"><input type=\"checkbox\" name=\"f_networkupdates\" id=\"f_networkupdates\" value=\"1\" " . (($this->showNetworkUpdates)?"checked":"") . " />";
						}
						$output .= "<a href=\"javascript:changeFilter();\">" . wfMsg( 'sitescout_changefilter' ) . "</a>
						</div>";
						
					$output .='</td>
				</tr>
			</table>
			 
		</td><td width=25></td><td valign=bottom>
		</td></tr></table><script>edits_count=' . $edits . ';votes_count=' . $votes . ';comments_count=' . $comments . ';networkupdates_count=' . $networkupdates . '</script>';
		
		$output.= "<script>edits=" . (($this->showEdits)?1:0) . ";votes=" . (($this->showVotes)?1:0) . ";comments=" . (($this->showComments)?1:0) . ";networkupdates=" . (($this->showNetworkUpdates)?1:0) . ";</script>";
		
		return $output;
	}
	
	function getHeader(){
		return '<div id=items>
		<div class="item-header">
		<span class="item-info">' . wfMsg( 'sitescout_header_type' ) . '</span>
		<span class="item-title">' . wfMsg( 'sitescout_header_page' ) . '</span>
		<span class="item-comment">' . wfMsg( 'sitescout_header_comment' ) . '</span>
		<span class="item-user">' . wfMsg( 'sitescout_header_user' ) . '</span>
		</div>
		</div>';
	}
	
	function getEditCount(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT count( * ) AS edit_count, Date_FORMAT(DATE_SUB(`rc_timestamp` , INTERVAL 5 HOUR ) , '%y %m %d' )
				FROM {$dbr->tableName( 'recentchanges' )}
				GROUP BY Date_FORMAT(DATE_SUB( `rc_timestamp` , INTERVAL 5 HOUR )  , '%y %m %d' )
				ORDER BY Date_FORMAT( DATE_SUB( `rc_timestamp` , INTERVAL 5 HOUR )  , '%y %m %d' ) DESC
				LIMIT 0 , 1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			return $row->edit_count;
		}else{
			return 0;
		}
	}
	
	function getCommentCount(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT count( * ) AS comment_count, Date_FORMAT( DATE_SUB(`Comment_Date`, INTERVAL 5 HOUR ) , '%y %m %d' )
				FROM `Comments`
				GROUP BY Date_FORMAT( DATE_SUB(`Comment_Date` , INTERVAL 5 HOUR ), '%y %m %d' )
				ORDER BY Date_FORMAT( DATE_SUB(`Comment_Date` , INTERVAL 5 HOUR ), '%y %m %d' ) DESC
				LIMIT 0 , 1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			return $row->comment_count;
		}else{
			return 0;
		}
	}
	
	function getVoteCount(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT count( * ) AS vote_count, Date_FORMAT( DATE_SUB(`Vote_Date` , INTERVAL 5 HOUR ), '%y %m %d' )
				FROM `Vote`
				GROUP BY Date_FORMAT( DATE_SUB(`Vote_Date` , INTERVAL 5 HOUR ), '%y %m %d' )
				ORDER BY Date_FORMAT( DATE_SUB(`Vote_Date` , INTERVAL 5 HOUR ), '%y %m %d' ) DESC
				LIMIT 0 , 1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			return $row->vote_count;
		}else{
			return 0;
		}
	}
	
	function getNetworkUpdatesCount(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT count( * ) AS count, Date_FORMAT( DATE_SUB(`us_date` , INTERVAL 5 HOUR ), '%y %m %d' )
				FROM `user_status`
				GROUP BY Date_FORMAT( DATE_SUB(`us_date` , INTERVAL 5 HOUR ), '%y %m %d' )
				ORDER BY Date_FORMAT( DATE_SUB(`us_date` , INTERVAL 5 HOUR ), '%y %m %d' ) DESC
				LIMIT 0 , 1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			return $row->count;
		}else{
			return 0;
		}
	}
	function fixItemComment($comment){
		if(!$comment){
			$comment = "-";
		}else{
			$comment = str_replace ("<", "&lt;",$comment);
			$comment = str_replace (">", "&gt;",$comment);
			$comment = str_replace ("&", "%26", $comment );
			$comment = str_replace ("%26quot;","\"",$comment );
		}
		$preview = substr($comment,0,50);
		if($preview != $comment){
			$preview .= "...";
		}
		return $preview ;
	}
	
	function getEditsSQL(){
		$dbr =& wfGetDB( DB_SLAVE );
		if($this->timestamp >0){
			//$TimeSQL = ' WHERE UNIX_TIMESTAMP( rc_timestamp)  > ' . ($this->timestamp );
		}
		$sql = "SELECT  UNIX_TIMESTAMP( rc_timestamp) as item_date, rc_title, rc_user, rc_user_text, rc_comment, rc_id,rc_minor, rc_new,rc_namespace,rc_cur_id,rc_this_oldid,rc_last_oldid FROM {$dbr->tableName( 'recentchanges' )} " . $TimeSQL . " ORDER BY rc_id DESC LIMIT 0," . $this->itemMax;
		return $sql;
	}
	
	function getVotesSQL(){
		$dbr =& wfGetDB( DB_SLAVE );
		if($this->timestamp >0){
			//$TimeSQL = ' AND UNIX_TIMESTAMP( vote_date) > ' . $this->timestamp;
		}
		$sql = "SELECT  UNIX_TIMESTAMP( vote_date) as item_date, username, page_title, vote_count, comment_count, vote_ip,vote_user_id, page_namespace FROM Vote v, {$dbr->tableName( 'page' )} p, wikia_page_stats ps  WHERE v.vote_page_id=p.page_id and p.page_id=ps_page_id " . $TimeSQL . " ORDER BY vote_date DESC LIMIT 0," . $this->itemMax;
		return $sql;
	}
	
	function getCommentsSQL(){
		$dbr =& wfGetDB( DB_SLAVE );
		if($this->timestamp >0){
			//$TimeSQL = ' AND UNIX_TIMESTAMP( comment_date) > ' . $this->timestamp;
		}
		$sql = "SELECT  UNIX_TIMESTAMP( comment_date) as item_date, Comment_Username, Comment_IP, page_title, Comment_Text, Comment_user_id, page_namespace, CommentID FROM Comments c, {$dbr->tableName( 'page' )} p  WHERE c.comment_page_id=p.page_id  " . $TimeSQL . " ORDER BY comment_date DESC LIMIT 0," . $this->itemMax;
		return $sql;
	}
	
	function getNetworkUpdatesSQL(){
		$dbr =& wfGetDB( DB_SLAVE );
		if($this->timestamp >0){
			//$TimeSQL = ' WHERE UNIX_TIMESTAMP( us_date) > ' . $this->timestamp;
		}
		$sql = "SELECT  us_id, UNIX_TIMESTAMP( us_date) as item_date, us_user_name, us_user_id, us_sport_id, us_team_id, us_text FROM user_status " . $TimeSQL . " ORDER BY us_id DESC LIMIT 0," . $this->itemMax;
		return $sql;
	}
	
	function populateItems(){
		global $wgMemc;
		
		$key = wfMemcKey( 'site_scout', $this->itemMax );
		$data = $wgMemc->get( $key );
		if( $data ){
			wfDebug("site scout loaded from cache\n");
			$this->all_items = $data;
		}else{
			$this->populateItemsDB();
		}
		$this->filterItems();
	}
	
	function filterItems(){
		
		foreach ($this->all_items as $item) {
			$show_item = false;
			
			if( $item["type"] == "edit" && $this->showEdits == true )$show_item = true;
			if( $item["type"] == "comment" && $this->showComments == true )$show_item = true;
			if( $item["type"] == "vote" && $this->showVotes == true )$show_item = true;
			if( $item["type"] == "networkupdate" && $this->showNetworkUpdates == true )$show_item = true;
			
			if( $this->timestamp !=0 && (int)$this->timestamp >=  (int)$item["timestamp"] )$show_item = false;
			//echo $this->timestamp . "--" . $item["timestamp"] . "=" . $show_item . "<BR>";
			if( $show_item ){
				$this->items[] = $item;
			}
		}
		//exit();
	}
	
	function populateItemsDB(){
		global $wgUser, $IP, $wgSitename;
		
		/**
		Edits
		**/
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->query($this->getEditsSQL() );
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->all_items[] = array("id"=>0,"type"=>"edit","timestamp"=>($row->item_date ) ,"pagetitle"=>$row->rc_title,"namespace"=>$row->rc_namespace,"username"=>$row->rc_user_text, "userid"=>$row->rc_user, "comment"=>$this->fixItemComment($row->rc_comment) , "minor"=>$row->rc_minor, "new"=>$row->rc_new);
		}
		
		/**
		Votes
		**/
		$res = $dbr->query($this->getVotesSQL() );
		while ($row = $dbr->fetchObject( $res ) ) {
			if( $row->vote_user_id != 0){
				$username = $row->username;
			}else{
				$username = "Anonymous Fanatic";
			}
			$this->all_items[] = array("id"=>0,"type"=>"vote","timestamp"=>$row->item_date ,"pagetitle"=>$row->page_title,"namespace"=>$row->page_namespace,"username"=>$username, "userid"=>$row->vote_user_id, "comment"=>"-","new"=>"0","minor"=>0);
		}
	
		
		$block_list = array();
		if($wgUser->getID()!=0)$block_list = Comment::getBlockList($wgUser->getID());
		
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->query($this->getCommentsSQL() );
		while ($row = $dbr->fetchObject( $res ) ) {
			if(!in_array($row->Comment_Username,$block_list)){
				if( $row->Comment_user_id != 0 || $wgUser->isAllowed('protect') ){
					$username = $row->Comment_Username;
				}else{
					$username = "Anonymous Fanatic";
				}
				$this->all_items[] = array("id"=>$row->CommentID,"type"=>"comment","timestamp"=>$row->item_date ,"pagetitle"=>$row->page_title,"namespace"=>$row->page_namespace,"username"=>$username,"userid"=>$row->Comment_user_id,"comment"=>$this->fixItemComment($row->Comment_Text),"new"=>"0","minor"=>0 );
			}
		}
		
		/**
		ArmchairGM Network Thoughts
		TODO: Turn this into a hook so its not in the base code
		**/			
		if( $wgSitename=="ArmchairGM"){

			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->query($this->getNetworkUpdatesSQL() );
			while ($row = $dbr->fetchObject( $res ) ) {
				$this->all_items[] = array("id"=>$row->us_id,"type"=>"networkupdate","timestamp"=>$row->item_date ,"pagetitle"=>$row->us_user_name,"namespace"=>NS_USER,"username"=>$row->us_user_name,"userid"=>$row->us_user_id,"comment"=>strip_tags($row->us_text),"new"=>"0","minor"=>0,"sport_id"=>$row->us_sport_id, "team_id"=>$row->us_team_id );
				 
			}
		}
		
		usort($this->all_items, array('SiteScout', 'sortItems') );
		
		//Set cache
		global $wgMemc;
		$key = wfMemcKey( 'site_scout', $this->itemMax );
		$wgMemc->set( $key, $this->all_items, 30);
	}
	
	function getTypeIcon($type){
		if($type == "edit"){
			$img =  "editIcon.gif";
		}else if ($type == "vote"){
			$img =  "voteIcon.gif";
		}else if ($type == "networkupdate"){
			$img =  "note.gif";
		}else{
			$img =  "comment.gif";
		}
		return  $img;
	}
	
		
	function sortItems($x, $y){
		if ( $x["timestamp"] == $y["timestamp"] )
		 return 0;
		else if ( $x["timestamp"] > $y["timestamp"] )
		 return -1;
		else
		 return 1;
	}

}

class SiteScoutHTML extends SiteScout{

	function displayItems(){
		global $wgSitename,$wgUploadPath,$wgUserBoard;
		$output = "";
		$this->populateItems();
		$x = 1;
		foreach ($this->items as $item) {
			if($x<=30){
			$title = Title::makeTitle( $item["namespace"]  , $item["pagetitle"]  );
			$user_title = Title::makeTitle( NS_USER  , $item["username"]  );
			$output .= "<div id=comment-" . $x . " class=site-scout><span class=item-info><img src='{$wgUploadPath}/common/" . $this->getTypeIcon($item["type"]) . "' border='0'>";
			if($item["minor"]==1){
				$output .= "<br><span class=edit-minor>" . wfMsg( 'sitescout_minor' ) . "</span>";
			}
			if($item["new"]==1){
				$output .= "<br><span class=edit-new>" . wfMsg( 'sitescout_new' ) . "</span>";
			}
			$output .= "</span>";
			
			if($item["type"]!="networkupdate"){
				$output .= "<a href=" . $title->getFullURL() . " class=item-title>" . $title->getPrefixedText() . "</a> ";
			}else{
				if($item["team_id"]){
					$team = SportsTeams::getTeam($item["team_id"]);
					$network_name= $team["name"];
				}else{
					$sport = SportsTeams::getSport($item["sport_id"]);
					$network_name = $sport["name"];
				}
				$output .= "<span class=\"site-scout-network\"><a href=\"" .SportsTeams::getNetworkURL($item["sport_id"],$item["team_id"])  . "\" class=item-title>{$network_name}</a></span>";
			}
			
			//$output .= "<span class=item-time>" . date("g:i a, m.d.y" ,$item["timestamp"]  ) . "</span>";
			$comment = $item["comment"];
			if($item["type"] == "comment"){
				$comment = "<a href=\"" . $title->getFullURL() . "#comment-" . $item["id"]  . "\" title=\"" . $title->getText() . "\" >" . $item["comment"] . "</a>";
			}
			$output .= "<span class=item-comment>" . $comment . "</span>";
			
			$avatar = new wAvatar($item["userid"],"s");
			$CommentIcon = $avatar->getAvatarURL();
			$talk_page = $user_title->getTalkPage()->getFullURL();
			if($wgUserBoard)$talk_page = UserBoard::getUserBoardURL($item["username"]);
			$output .= "<span class=item-user><a href='" . $user_title->getFullURL() . "' class=item-user-link>" . $CommentIcon . " " . $item["username"] . "</a><a href='" . $talk_page .   "' class=item-user-talk><img src=\"{$wgUploadPath}/common/talkPageIcon.png\" alt=\"\" border=\"0\" hspace=\"3\" align=\"middle\"></a></span>";
			$output .= "</div>";
			$x++;
			}
		}
		return $output;
	}


}

class SiteScoutXML extends SiteScout{

	function displayItems(){
		global $wgUserBoard;
		$output = "";
		$this->populateItems();
		$x = 1;
		foreach ($this->items as $item) {
			$avatar = new wAvatar($item["userid"],"s");
			$CommentIcon = $avatar->getAvatarImage();
			if($item["username"]  == "")$item["username"] = "-";
			$title = Title::makeTitle( $item["namespace"]  , $item["pagetitle"]  );
			$user_title = Title::makeTitle( NS_USER  , $item["username"]  );
			$talk_page = $user_title->getTalkPage()->getFullURL();
			if($wgUserBoard)$talk_page =  UserBoard::getUserBoardURL($item["username"]);
			
			$page_title = str_replace ("&", "%26",  $title->getPrefixedText() );
			$page_url = $title->getFullURL();
			
			if($item["type"]=="networkupdate"){
				if($item["team_id"]){
					$team = SportsTeams::getTeam($item["team_id"]);
					$network_name= $team["name"];
				}else{
					$sport = SportsTeams::getSport($item["sport_id"]);
					$network_name = $sport["name"];
				}
				$page_title = $network_name;
				$page_url = SportsTeams::getNetworkURL($item["sport_id"],$item["team_id"]);
				
			}
				
			$output .= "<item>";
			$output .= "<type_icon>" . $this->getTypeIcon($item["type"]) . "</type_icon>
			<type>" . $item["type"] . "</type>
			<date>" . date("g:i a , m.d.y" ,$item["timestamp"]  ) . "</date>
			<timestamp>" .  $item["timestamp"]  . "</timestamp>
			<title>{$page_title}</title>
			<url>{$page_url}</url>
			<comment>" . $item["comment"] . "</comment>
			<user>" . str_replace ("&", "%26",$item["username"]) . "</user>
			<user_page>" . $user_title->getFullURL() . "</user_page>
			<user_talkpage>" . $talk_page . "</user_talkpage>
			<avatar>" . $CommentIcon . "</avatar>
			<edit_new>" . $item["new"] . "</edit_new>
			<edit_minor>" . $item["minor"] . "</edit_minor>
			<id>" . $item["id"] . "</id>";
			$output .= "</item>";
			$x++;
		}
		if($output)$output = "<items>" . $output . "</items>";
		return $output;
	}
	


}


?>
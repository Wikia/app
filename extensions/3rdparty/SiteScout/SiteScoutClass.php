<?php
class SiteScout{
	var $showEdits = true;
	var $showVotes = true;
	var $showComments = true;
	
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
	
	function getControls(){
		$edits = $this->getEditCount();
		$votes = $this->getVoteCount();
		$comments = $this->getCommentCount();
		$largest_value = max($edits, $votes, $comments);
		
		$output = '<table>
			<tr>
				<td><img id="on" src="http://www.armchairgm.com/mwiki/brand/play_down.gif" alt="Play"  onclick="togglePlay();" hspace=2><img id="off" src="http://www.armchairgm.com/mwiki/brand/pause_up.gif" alt="Pause" onclick="togglePlay();" hspace=2></td>
			</tr>
			</table>
			<table >
			<td><td>
			<table  class=site-scout-controls>
			<tr>
				<td valign=bottom align=center height=109>
				<table>
			<tr>
				<td valign=bottom><input type=checkbox onClick=toggleEdits() checked></td><td valign=bottom><img src="images/contribute.gif" border="0" alt="Edits"></td>
				<td valign=bottom><input type=checkbox onClick=toggleVotes() checked></td><td valign=bottom><img src="images/scout-vote.gif" border="0" alt="Votes"></td>
				<td valign=bottom><input type=checkbox onClick=toggleComments() checked></td><td valign=bottom><img src="images/scout-comment.gif" border="0" alt="Comments"></td>
			</tr>
		</table></td></tr></table>
		</td><td width=25></td><td valign=bottom>
		<table class=site-scout-stats>
		<tr><td class=site-scout-stats-header colspan=2>Today\'s Stats</td></tr>
		<tr><td><img src="images/contribute.gif" border="0" alt="Edits"></td><td>Edits</td><td><span id=edit_stats><table><tr><td><table bgcolor="#285C98"  height=7 width="' . ($edits / $largest_value * 300) . '"><tr><td></td></tr></table></td><td>' . $edits . '</td></tr></table></span></td></tr>
		<tr><td><img src="images/scout-vote.gif" border="0" alt="Votes"></td><td>Votes</td><td><span id=vote_stats><table><tr><td><table bgcolor="#009900"  height=7  width="' . ($votes / $largest_value * 300) . '"><tr><td></td></tr></table></td><td>' . $votes . '</td></tr></table></span></td></tr>
		<tr><td><img src="images/scout-comment.gif" border="0" alt="Comments"></td><td>Comments</td><td><span id=comment_stats><table><tr><td><table bgcolor="#990000" height=7  width="' . ($comments  / $largest_value * 300) . '"><tr><td></td></tr></table></td><td>' . $comments . '</td></tr></table></span></td></tr>
		
		</table></td></tr></table><script>edits_count=' . $edits . ';votes_count=' . $votes . ';comments_count=' . $comments . ';</script>';
		return $output;
	}
	
	function getHeader(){
		return '<div id=items>
		<div class="item-header">
		<span class="item-info">Type</span>
		<span class="item-title">Page</span>
		<span class="item-comment">Comment</span>
		<span class="item-user">User</span>
		</div>
		</div>';
	}
	
	function getEditCount(){
		$dbr =& wfGetDB( DB_MASTER );
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
		$dbr =& wfGetDB( DB_MASTER );
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
		$dbr =& wfGetDB( DB_MASTER );
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
		$dbr =& wfGetDB( DB_MASTER );
		if($this->timestamp >0){
			$TimeSQL = ' WHERE UNIX_TIMESTAMP( rc_timestamp)  > ' . ($this->timestamp );
		}
		$sql = "SELECT  UNIX_TIMESTAMP( rc_timestamp) as item_date, rc_title, rc_user, rc_user_text, rc_comment, rc_id,rc_minor, rc_new,rc_namespace,rc_cur_id,rc_this_oldid,rc_last_oldid FROM {$dbr->tableName( 'recentchanges' )} " . $TimeSQL . " ORDER BY rc_id DESC LIMIT 0," . $this->itemMax;
		return $sql;
	}
	
	function getVotesSQL(){
		$dbr =& wfGetDB( DB_MASTER );
		if($this->timestamp >0){
			$TimeSQL = ' AND UNIX_TIMESTAMP( vote_date) > ' . $this->timestamp;
		}
		$sql = "SELECT  UNIX_TIMESTAMP( vote_date) as item_date, username, page_title, vote_count, comment_count, vote_ip,vote_user_id FROM Vote v, {$dbr->tableName( 'page' )} p, page_stats ps  WHERE v.vote_page_id=p.page_id and p.page_id=ps_page_id " . $TimeSQL . " ORDER BY vote_date DESC LIMIT 0," . $this->itemMax;
		return $sql;
	}
	
	function getCommentsSQL(){
		$dbr =& wfGetDB( DB_MASTER );
		if($this->timestamp >0){
			$TimeSQL = ' AND UNIX_TIMESTAMP( comment_date) > ' . $this->timestamp;
		}
		$sql = "SELECT  UNIX_TIMESTAMP( comment_date) as item_date, Comment_Username, Comment_IP, page_title, vote_count, comment_count, Comment_Text, Comment_user_id, page_namespace, CommentID FROM Comments c, {$dbr->tableName( 'page' )} p, page_stats ps  WHERE c.comment_page_id=p.page_id and p.page_id=ps_page_id " . $TimeSQL . " ORDER BY comment_date DESC LIMIT 0," . $this->itemMax;
		return $sql;
	}
	
	
	
	function populateItems(){
		if($this->showEdits == true){
			$dbr =& wfGetDB( DB_MASTER );
			$res = $dbr->query($this->getEditsSQL() );
			while ($row = $dbr->fetchObject( $res ) ) {
			 	$this->items[] = array("id"=>0,"type"=>"edit","timestamp"=>($row->item_date ) ,"pagetitle"=>$row->rc_title,"namespace"=>$row->rc_namespace,"username"=>$row->rc_user_text, "userid"=>$row->rc_user, "comment"=>$this->fixItemComment($row->rc_comment) , "minor"=>$row->rc_minor, "new"=>$row->rc_new);
			}
		}
		if($this->showVotes == true){
			$dbr =& wfGetDB( DB_MASTER );
			$res = $dbr->query($this->getVotesSQL() );
			while ($row = $dbr->fetchObject( $res ) ) {
				if( $row->username != $row->vote_ip){
					$username = $row->username;
				}else{
					$username = "Anonymous Fanatic";
				}
			 	$this->items[] = array("id"=>0,"type"=>"vote","timestamp"=>$row->item_date ,"pagetitle"=>$row->page_title,"namespace"=>$row->page_namespace,"username"=>$username, "userid"=>$row->vote_user_id, "comment"=>"-","new"=>"0","minor"=>0);
			}
		}
		
		if($this->showComments == true){
			$dbr =& wfGetDB( DB_MASTER );
			$res = $dbr->query($this->getCommentsSQL() );
			while ($row = $dbr->fetchObject( $res ) ) {
				if( $row->Comment_Username != $row->Comment_IP){
					$username = $row->Comment_Username;
				}else{
					$username = "Anonymous Fanatic";
				}
			 	$this->items[] = array("id"=>$row->CommentID,"type"=>"comment","timestamp"=>$row->item_date ,"pagetitle"=>$row->page_title,"namespace"=>$row->page_namespace,"username"=>$username,"userid"=>$row->Comment_user_id,"comment"=>$this->fixItemComment($row->Comment_Text),"new"=>"0","minor"=>0 );
			}
		}
		
		usort($this->items, 'sortItems');
	}
	
	function getTypeIcon($type){
		if($type == "edit"){
			$img =  "contribute.gif";
		}else if ($type == "vote"){
			$img =  "scout-vote.gif";
		}else{
			$img =  "scout-comment.gif";
		}
		return  $img;
	}

}

class SiteScoutHTML extends SiteScout{

	function displayItems(){
		$output = "";
		$this->populateItems();
		$x = 1;
		foreach ($this->items as $item) {
			if($x<=30){
			$title = Title::makeTitle( $item["namespace"]  , $item["pagetitle"]  );
			$user_title = Title::makeTitle( NS_USER  , $item["username"]  );
			$output .= "<div id=comment-" . $x . " class=site-scout><span class=item-info><img src=images/" . $this->getTypeIcon($item["type"]) . " border='0'>";
			if($item["minor"]==1){
				$output .= "<br><span class=edit-minor>minor</span>";
			}
			if($item["new"]==1){
				$output .= "<br><span class=edit-new>new</span>";
			}
			$output .= "</span>";
			$output .= "<a href=" . $title->getFullURL() . " class=item-title>" . $title->getPrefixedText() . "</a> ";
			//$output .= "<span class=item-time>" . date("g:i a, m.d.y" ,$item["timestamp"]  ) . "</span>";
			$comment = $item["comment"];
			if($item["type"] == "comment"){
				$comment = "<a href=\"" . $title->getFullURL() . "#comment-" . $item["id"]  . "\" title=\"" . $title->getText() . "\" >" . $item["comment"] . "</a>";
			}
			$output .= "<span class=item-comment>" . $comment . "</span>";
			
			$avatar = new wAvatar($item["userid"],"s");
			$CommentIcon = $avatar->getAvatarImage();
			$output .= "<span class=item-user><a href='" . $user_title->getFullURL() . "' class=item-user-link><img src='images/avatars/" . $CommentIcon . "' alt='' border=''> " . $item["username"] . "</a><a href='" . $user_title->getTalkPage()->getFullURL() .   "' class=item-user-talk><img src=images/commentIcon.gif border=0 hspace=3 align=middle></a></span>";
			$output .= "</div>";
			$x++;
			}
		}
		return $output;
	}

}

class SiteScoutXML extends SiteScout{

	function displayItems(){
		$output = "";
		$this->populateItems();
		$x = 1;
		foreach ($this->items as $item) {
			$avatar = new wAvatar($item["userid"],"s");
			$CommentIcon = $avatar->getAvatarImage();
			if($item["username"]  == "")$item["username"] = "-";
			$title = Title::makeTitle( $item["namespace"]  , $item["pagetitle"]  );
			$user_title = Title::makeTitle( NS_USER  , $item["username"]  );
			$output .= "<item>";
			$output .= "<type_icon>" . $this->getTypeIcon($item["type"]) . "</type_icon>
			<type>" . $item["type"] . "</type>
			<date>" . date("g:i a , m.d.y" ,$item["timestamp"]  ) . "</date>
			<timestamp>" .  $item["timestamp"]  . "</timestamp>
			<title>" . str_replace ("&", "%26",  $title->getPrefixedText() ) . "</title>
			<url>" . $title->getFullURL() . "</url>
			<comment>" . $item["comment"] . "</comment>
			<user>" . $item["username"] . "</user>
			<user_page>" . $user_title->getFullURL() . "</user_page>
			<user_talkpage>" . $user_title->getTalkPage()->getFullURL() . "</user_talkpage>
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

function sortItems($x, $y){
	if ( $x["timestamp"] == $y["timestamp"] )
	 return 0;
	else if ( $x["timestamp"] > $y["timestamp"] )
	 return -1;
	else
	 return 1;
}
?>
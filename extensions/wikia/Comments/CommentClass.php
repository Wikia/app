<?php

class Comment{
	var $PageID = 0;
	var $Username = NULL;
	var $Userid = 0;
	var $CommentTotal = 0;
	var $CommentText = NULL;
	var $CommentDate = NULL;
	var $CommentID = 0;
	var $CommentParentID = 0;
	var $CommentVote = 0;
	var $CommentScore = 0;
	var $OrderBy = 0;
	var $Allow = "";
	var $Voting = "";
	var $AllowPlus = true;
	var $AllowMinus = true;

	var $title = "";
	
	function Comment($pageid){
		global $wgUser;
		$this->title = wfMsg( 'comment_comment' );
		$this->PageID=$pageid;
		$this->Username =  addslashes ( $wgUser->getName() );
		$this->Userid =  $wgUser->getID();
#		$this->parser = $parser;
	} 

	/*deprecated*/
	function setUser($user_name, $user_id){
	
	}
	
	function setCommentText($comment_text){
		$this->CommentText = $comment_text;
	}
	
	function getCommentText($comment_text){
		global $wgTitle, $wgOut, $max_link_text_length, $wgParser;
	 
		$comment_text =  trim(str_replace("&quot;","'",$comment_text));
		$comment_text_parts = explode("\n",$comment_text);
		$comment_text_fix = "";
		foreach($comment_text_parts as $part){
			$comment_text_fix .= (($comment_text_fix)?"\n":"") . trim($part);
		}
		
		if( $wgTitle->getArticleID() > 0 ){
			$comment_text = $wgParser->recursiveTagParse($comment_text_fix);
		}else{
			//$CommentParser = new Parser();
			$comment_text = $wgParser->parse($comment_text_fix, $wgTitle, $wgOut->parserOptions(), true );
			$comment_text = $comment_text->getText();
		}
	
		//$comment_text = $wgParser->recursiveTagParse($comment_text_fix);
		
		//really bad hack because we want to parse=firstline, but don't want wrapping <p> tags
		if( substr( $comment_text, 0 , 3) == "<p>" ){
			$comment_text = substr( $comment_text, 3);
		}

		if( substr( $comment_text, strlen( $comment_text) -4 , 4) == "</p>" ){
			$comment_text = substr( $comment_text, 0, strlen( $comment_text) -4 );
		}
		
		////make sure link text is not too long (will overflow)
		//this function changes too long links to <a href=#>http://www.abc....xyz.html</a>
		$max_link_text_length = 30;
		$comment_text = preg_replace_callback( "/(<a[^>]*>)(.*?)(<\/a>)/i",'cut_link_text',$comment_text);
		 
		return $comment_text;
	}
	
	function setCommentID($commentid){
		$this->CommentID=$commentid;
	}
	
	function setVoting($voting){
		$this->Voting = $voting;
		$voting = strtoupper($voting);
		
		if( $voting == "OFF" ){
			$this->AllowMinus=false;
			$this->AllowPlus=false;
		}
		if($voting == "PLUS")$this->AllowMinus=false;
		if($voting == "MINUS")$this->AllowPlus=false;
	}
	
	function setTitle($title){
		if($title)$this->title=$title;
	}
	
	function setCommentParentID($parentid){
		if($parentid){
			$this->CommentParentID=$parentid;
		}else{
			$this->CommentParentID = 0;
		}
	}
	
	function setAllow($allow){
		$this->Allow = $allow;
	}
	
	function setBool($name,$value){
		if($value){
			if(strtoupper($value)=="YES" || strtoupper($value) == 1){
				$this->$name = 1;
			}else{
				$this->$name = 0;
			}
		}
	}
	
	function count(){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`Comments`', array( 'count(distinct(comment_username)) as CommentCount' ), array( 'comment_page_id' => $this->PageID ), __METHOD__ );
		if ( $s !== false ) {
			$this->CommentTotal = $s->CommentCount;
		}
		return $this->CommentTotal;
	}
	
	function countTotal(){
		$dbr =& wfGetDB( DB_MASTER );
		$count = 0;
		$s = $dbr->selectRow( '`Comments`', array( 'count(*) as CommentCount' ), array( 'comment_page_id' => $this->PageID ), __METHOD__ );
		if ( $s !== false ) {
			$count = $s->CommentCount;
		}
		return $count;
	}
	
	function updateStats(){
		$dbr =& wfGetDB( DB_MASTER );
	
		$s = $dbr->selectRow( '`wikia_page_stats`', array( 'ps_page_id' ), array( 'ps_page_id' => $this->PageID ), __METHOD__ );
		if ( $s === false ) {
			$dbr->insert( '`wikia_page_stats`',
			array(
				'ps_page_id' => $this->PageID,
				'vote_count' => 0,
				'comment_count' => $this->count()
				), __METHOD__
			);		
		 }else{
			$dbr->update( '`wikia_page_stats`',
				array( /* SET */'comment_count' => $this->countTotal()), 
				array( /* WHERE */'ps_page_id' => $this->PageID
				), ""
			);
		}
	}
	
	function add(){
		global $wgUser, $wgSpamRegex, $wgCommentsLog;
		$dbr =& wfGetDB( DB_MASTER );
		
		$text = $this->fixStr(str_replace("'","&quot;",$this->CommentText));
		$matches = array();
		if ( $wgSpamRegex && preg_match( $wgSpamRegex, $text, $matches ) ) {
			return "spam";
		}
	
		$dbr->insert( '`Comments`',
		array(
			'comment_page_id' => $this->PageID,
			'comment_username' => $this->Username,
			'comment_user_id' => $this->Userid,
			'comment_text' => $text,
			'comment_date' => date("Y-m-d H:i:s"),
			'comment_parent_id' => $this->CommentParentID,
			'Comment_IP' => wfGetIP()
			), __METHOD__
		);
		$comment_id = $dbr->insertId();
		
		$this->clearCommentListCache();
		$this->updateStats();
		
		if( $wgCommentsLog ){
			$page_title = Title::newFromID( $this->PageID);
			$message = wfMsgForContent( 'comments-create-text',
			 
			$page_title->getPrefixedText() . "#comment-{$comment_id}", $text  );
					
			$log = new LogPage( 'comments' );
			$log->addEntry( "+ comment", $wgUser->getUserPage(), $message );
		}
		
	}
	
	function getCommentScore(){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`Comments_Vote`', array( 'sum(Comment_Vote_Score) as CommentScore' ), array( 'Comment_Vote_ID' => $this->CommentID ), __METHOD__ );
		if ( $s !== false ) {
			$this->CommentScore = $s->CommentScore;
		}
		return $this->CommentScore;
	}
	
	function getCommentVoteCount($vote){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`Comments_Vote`', array( 'COUNT(*) as CommentVoteCount' ), array( 'Comment_Vote_ID' => $this->CommentID, 'Comment_Vote_Score' => $vote), __METHOD__ );
		if ( $s !== false ) {
			$VoteCount = $s->CommentVoteCount;
		}
		return $VoteCount;
	}
	
	function getLatestCommentID(){
		$dbr =& wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow( '`Comments`', array( 'CommentID' ), 
			array( 'comment_page_id' => $this->PageID), __METHOD__,
			array( 'ORDER BY' => 'comment_date DESC', 'LIMIT' => 1)
			);
		if ( $s !== false ) {
			$LatestCommentID = $s->CommentID;
		} else {
			$LatestCommentID = 0;
		}
		return $LatestCommentID;
	}
	
	function addVote(){
		global $wgMemc, $wgUser;
		$dbr =& wfGetDB( DB_MASTER );
		if($this->UserAlreadyVoted() == false){
			$dbr->insert( '`Comments_Vote`',
			array(
				'Comment_Vote_id' => $this->CommentID,
				'Comment_Vote_Username' => $this->Username,
				'Comment_Vote_user_id' => $this->Userid,
				'Comment_Vote_Score' => $this->CommentVote,
				'Comment_Vote_Date' => date("Y-m-d H:i:s"),
				'Comment_Vote_IP' => wfGetIP()
				), __METHOD__
			);
			
			//update cache voted list
			$voted = array();
			$key = wfMemcKey( 'comment', 'voted', $this->PageID, 'user_id', $wgUser->getID() );
			$voted = $wgMemc->get( $key );
			$voted[] = $this->CommentID;
			$wgMemc->set( $key, $voted );
			
			//update cache for comment list
			//should perform better than deleting cache completely since Votes happen more frequently
			$key = wfMemcKey(  'comment', 'list', $this->PageID );
			$comments = $wgMemc->get( $key );
			if($comments){
				foreach ($comments as &$comment) {
					if($comment["CommentID"] == $this->CommentID){
						$comment["Comment_Score"] = $comment["Comment_Score"] + $this->CommentVote;
						if($this->CommentVote==1)$comment["CommentVotePlus"] = $comment["CommentVotePlus"] + 1;
						if($this->CommentVote==-1)$comment["CommentVoteMinus"] = $comment["CommentVoteMinus"] + 1;
					}
				}
				$wgMemc->set( $key, $comments );
			}
			
			$this->updateCommentVoteStats();
		}
	}
	
	function updateCommentVoteStats(){
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->update( '`Comments`',
			array( /* SET */'Comment_Plus_Count' => $this->getCommentVoteCount(1), 'Comment_Minus_Count' => $this->getCommentVoteCount(-1)), 
			array( /* WHERE */'CommentID' => $this->CommentID
			), ""
		);
	}
	
	function UserAlreadyVoted(){
		$dbr =& wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow( '`Comments_Vote`', array( 'Comment_Vote_ID' ), array( 'Comment_Vote_ID' => $this->CommentID, 'Comment_Vote_Username' => $this->Username ), __METHOD__ );
		if ( $s !== false ) {
			return true;
		}else{
			return false;
		}
	}
	 
	function setCommentVote($vote){
		if($vote < 0){
			$vote = -1;
		}else{
			$vote = 1;
		}
		$this->CommentVote = $vote;
	}
	
	function setOrderBy($order){
		if(is_numeric($order)){
			if($order == 0){
				$order = 0;
			}else{
				$order = 1;
			}
			$this->OrderBy = $order;
		}
	}
	
	function clearCommentListCache(){
		global $wgMemc;
		$wgMemc->delete( wfMemcKey(  'comment', 'list', $this->PageID ) );
		
		$page_title = Title::newFromID( $this->PageID);
		if( is_object( $page_title ) ){
			$page_title->invalidateCache();
			$page_title->purgeSquid();
		}
	}

	function delete(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "DELETE FROM `Comments` WHERE CommentID= " . $this->CommentID;
		$res = $dbr->query($sql);
		
		$sql = "DELETE FROM `Comments_Vote` WHERE Comment_Vote_ID= " . $this->CommentID;
		$res = $dbr->query($sql);
		
		$this->clearCommentListCache();
		$this->updateStats();
	}

	public function sortCommentList($x, $y){
		if( $x["thread"] == $y["thread"] ){
			if( $x["timestamp"] == $y["timestamp"] ){
				return 0;
			}else if( $x["timestamp"] < $y["timestamp"] ){
				return -1;
			}else{
				return 1;
			}	
		}else if ( $x["thread"] < $y["thread"] ){
			return -1;
		}else{
			return 1;
		}
	}

	public function getCommentVotedList(){
		global $wgUser;
		$dbr =& wfGetDB( DB_SLAVE );
		
		$sql = "SELECT CommentID FROM Comments_Vote LEFT JOIN
			Comments ON Comment_Vote_ID=CommentID
			WHERE comment_page_id={$this->PageID} and Comment_Vote_user_id={$wgUser->getID()}";
			
		$voted = array();
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$voted[] = $row->CommentID;
		}
		
		return $voted;
	}
	
	public function getCommentList(){
		global $wgUser;
		$dbr =& wfGetDB( DB_MASTER );
		
		$sql = "SELECT Comment_Username,comment_ip, comment_text,comment_date,UNIX_TIMESTAMP(comment_date) as timestamp,Comment_user_id,
				CommentID,IFNULL(Comment_Plus_Count - Comment_Minus_Count,0) as Comment_Score,
				Comment_Plus_Count as CommentVotePlus, 
				Comment_Minus_Count as CommentVoteMinus,Comment_Parent_ID, CommentID, stats_total_points 
				FROM Comments LEFT JOIN user_stats ON Comment_user_id=stats_user_id 
				WHERE comment_page_id = {$this->PageID}";
		
		if($this->OrderBy!=0){
			$sql .= " ORDER BY Comment_Score DESC";
		}
	 
		$comments = array();
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			 if($row->Comment_Parent_ID == 0){
				$thread = $row->CommentID;
			 }else{
				$thread = $row->Comment_Parent_ID;	 
			 }
			 $comments[] = array(
				 "Comment_Username"=>$row->Comment_Username,"comment_ip"=>$row->comment_ip,"comment_text"=>$row->comment_text , "comment_date"=>$row->comment_date,
				 "Comment_user_id"=>$row->Comment_user_id,"Comment_user_points"=>number_format($row->stats_total_points),
				 "CommentID"=>$row->CommentID,"Comment_Score"=>$row->Comment_Score,
				 "CommentVotePlus"=>$row->CommentVotePlus, "CommentVoteMinus"=>$row->CommentVoteMinus, "AlreadyVoted" => $row->AlreadyVoted,
				 "Comment_Parent_ID"=>$row->Comment_Parent_ID, "thread" => $thread, "timestamp" => $row->timestamp
				 
				 );
		}
	
		if($this->OrderBy==0){
			usort($comments, array("Comment", "sortCommentList"));
		}
	
		return $comments;
	}
	
	function displayOrderForm(){
		global $wgUploadPath;
		
		$output .= "<div class=\"c-order\">";
			$output .= "<div class=\"c-order-select\">";
				$output .= "<form name=\"ChangeOrder\" action=\"\">";
					$output .= "<select name=\"TheOrder\" onchange=\"ViewComments({$this->PageID},this.value)\">";
						$output .= "<option value=\"0\">".wfMsg('comment_sort_by_date')."</option>";
						$output .= "<option value=\"1\">".wfMsg('comment_sort_by_score')."</option>";
					$output .= "</select>";
				$output .= "</form>";
			$output .= "</div>";
			$output .= "<div id=\"spy\" class=\"c-spy\">";
				$output .= "<a href=\"javascript:ToggleLiveComments(1)\">".wfMsg("comment_enable_auto_refresher")." ". wfMsg("comment_auto_refresher"). "</a>";
			$output .= "</div>";
			$output .= "<div class=\"cleared\"></div>";
		$output .= "</div>";
		
		return $output;
		
	}

	function displayCommentScorecard($status){
		$on = "visibility:visible;display:block";
		$off = "visibility:hidden;display:none";
		if(strtoupper($status) == "ON"){
			$Step2 = $on;
			$Step1 = $off;
		}else{
			$Step2 = $off;
			$Step1 = $on;
		}
		$output .= "<div id=\"Step1\" style='" . $Step1 . "'><a href=\"javascript:ChangeToStep(2,1)\" style='font-size:11px;font-weight:800'>View Comment Scorecard</a><br><br></div><div id=\"Step2\" style='" . $Step2 . "'><a href=\"javascript:ChangeToStep(1,-1)\" style='font-size:12px;font-weight:800'>Hide Comment Scorecard</a><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" style='border:1px solid #eeeeee'>";
		$output .= "<tr bgcolor=\"#184984\">";
		$output .= "<td colspan=\"2\" style='background-image:url(http://www.development.wikiscripts.org/images/TopBarBG.gif);font-weight:800;color:#ffffff'>Comment Scorecard for this Page";
		$output .= "</td>";
		$output .= "<tr><td bgcolor=\"#eeeeee\"><b>User</b></td><td bgcolor=\"#eeeeee\"><b>Score</b></td></tr>";
		foreach ($this->Scorecard as $commenter => $comment_score) {
		 	$output .= "<tr><td style='border-top:1px solid #eeeeee'>" . $commenter . "</td><td style='border-top:1px solid #eeeeee'>" . $comment_score . "</td></tr>";
		}
		$output .= "</table><br></div>";
		return "<script type=\"text/javascript\">$('scorecard').innerHTML = \"" . $output . "\"</script>";
	}
	
	function getVoteLink($CommentID,$VoteType){
		global $wgUser,$wgUploadPath;
		if( $wgUser->isBlocked() ) return "";
		
		$VoteLink = "";
		$VoteKey = "";
		$VoteKey = md5($CommentID . 'pants' . $wgUser->mName);
		if ( $wgUser->isLoggedIn() ) {
			$VoteLink .= '<a href=\'javascript:cv(' . $CommentID . ',' . $VoteType . ',"' . $VoteKey . '","' . $this->Voting . '")\'>';
		}else{
			$login = Title::makeTitle(NS_SPECIAL,"Login");
			$VoteLink .= "<a href=\"{$login->escapeFullURL()}\" rel=\"nofollow\">";
		}
		if ($VoteType==1) {
			$VoteLink .= "<img src=\"{$wgUploadPath}/common/thumbs-up.gif\" border=\"0\" alt=\"+\" /></a>";
		} else {
			$VoteLink .= "<img src=\"{$wgUploadPath}/common/thumbs-down.gif\" border=\"0\" alt=\"-\" /></a>";
		}
		return $VoteLink;
	}
			
	function display(){
		
		global $wgUser,$wgLang,$wgContLang,$wgTitle,$wgOut,$wgParser,$wgAnonName,$wgReadOnly,$wgMemc, $wgChallengesEnabled,$wgUploadPath,$wgUserBoard;
		global $wgDebugComments, $wgUserLevels, $wgSitename;
		
		if($wgUser->getName()=="Pean")$wgDebugComments=true;
		
		$sk =& $wgUser->getSkin();
		
		$dbr =& wfGetDB(DB_MASTER);
		
		$output = "";
		
		$challenge_title = Title::makeTitle(NS_SPECIAL,"ChallengeUser");
		
		//try cache
		$key = wfMemcKey( 'comment', 'list', $this->PageID );
		$data = $wgMemc->get( $key );
		
		if (!$data ) {
			wfDebug( "loading comments for page {$this->PageID} from db\n" );
			$comments = $this->getCommentList();
			$wgMemc->set( $key, $comments );
		} else {
			wfDebug( "loading comments for page {$this->PageID} from cache\n" );
			$comments = $data;
		}
			
		//try cache for voted list for this user
		$voted = array();
		if ($wgUser->isLoggedIn() ) {
			$key = wfMemcKey( 'comment', 'voted', $this->PageID, 'user_id', $wgUser->getID() );
			$data = $wgMemc->get( $key );
		
			if (!$data ) {
				$voted = $this->getCommentVotedList();
				$wgMemc->set( $key, $voted );
			} else {
				wfDebug( "loading comment voted for page {$this->PageID} for user {$wgUser->getID()} from cache\n" );
				$voted = $data;
			}
		}

		//load complete blocked list for logged in user so they don't see their comments
		$block_list = array();
		if($wgUser->getID()!=0)$block_list = $this->getBlockList($this->Userid);
		
		$AFCounter = 1;
		$AFBucket = array();
		if ($comments) {
		foreach ($comments as $comment) {
			
			$CommentScore=$comment["Comment_Score"];
			$this->Scorecard [ $comment["Comment_Username"] ] += $CommentScore;
			
			$CommentPosterLevel="";
			
			if ($comment["Comment_user_id"]!=0) {
				
				$user_level = new UserLevel($comment["Comment_user_points"]);
				$title = Title::makeTitle(NS_USER, $comment["Comment_Username"]);
				
				$CommentPoster = "<a href=\"".$title->escapeFullURL()."\" rel=\"nofollow\">{$comment["Comment_Username"]}</a>";
				
				$CommentReplyTo = $comment["Comment_Username"];
				
				if($wgUserLevels)$CommentPosterLevel = "{$user_level->getLevelName()}";
				
			} else {
				
				if (!array_key_exists( $comment["Comment_Username"] , $AFBucket)) {
					
					$AFBucket[ $comment["Comment_Username"] ] = $AFCounter;
					$AFCounter++;
				}
				
				$CommentPoster = $wgAnonName . " #". $AFBucket[ $comment["Comment_Username"] ];
				$CommentReplyTo = $wgAnonName;
			}
			
			if ($comment["Comment_user_id"]!=0) {
				$avatar = new wAvatar($comment["Comment_user_id"],"ml");
				$CommentIcon = $avatar->getAvatarImage();
			} else {
				$CommentIcon = "af_m.gif";
			}
		
			//Comment Delete Button
			$dlt = "";
			if (in_array('commentadmin',($wgUser->getGroups()))) {
				$dlt = " | <span class=\"c-delete\"><a href=\"javascript:document.commentform.commentid.value={$comment["CommentID"]};document.commentform.submit();\">".wfMsg("comment_delete_link")."</a></span>";
			}

			//Reply Link (does not appear on child comments)
			$replyRow = "";
			if($comment["Comment_Parent_ID"] == 0){
				if($replyRow)$replyRow .= " | ";
				$replyRow .= " | <a href=\"#end\" rel=\"nofollow\" onclick=\"javascript:Reply({$comment["CommentID"]},'".urlencode ($CommentReplyTo)."')\">". wfMsg("comment_reply")."</a>";
			}
			
			if ($comment["Comment_Parent_ID"] == 0) {
				$container_class = "full";
				$comment_class = "f-message";
			} else {
				$container_class = "reply";
				$comment_class = "r-message";
			}
			
			//Display Block icon for logged in users for comments of users that are already not in your block list
			$block_link="";
			
			if($wgUser->getID()!=0 && $wgUser->getID()!=$comment["Comment_user_id"] && !(in_array($comment["Comment_Username"],$block_list)) ) {
				
				$block_link = "<a href=\"javascript:void(0)\" rel=\"nofollow\" onclick=\"javascript:block_user('" . urlencode($comment["Comment_Username"]) . "',{$comment["Comment_user_id"]},{$comment["CommentID"]},'" . md5($comment["Comment_Username"]."-".$comment["Comment_user_id"]) . "')\"><img src=\"{$wgUploadPath}/common/block.png\" border=\"0\" alt=\"\"/></a>";
			
			}

			//If you are ignoring the author of the comment, display message in comment box,
			//along with a link to show the individual comment
			
			$hide_comment_style="";
			
			if (in_array($comment["Comment_Username"],$block_list)) {
				
				$hide_comment_style = "display:none;";
				
				$block_list_title = Title::makeTitle(NS_SPECIAL, "CommentIgnoreList");
				
				$output .= "<div id=\"ignore-{$comment["CommentID"]}\" class=\"c-ignored {$container_class}\">";
					$output .= wfMsgExt( 'comment_ignore_message', 'parsemag' );
					$output .= "<div class=\"c-ignored-links\">";
						$output .= "<a href=\"javascript:show_comment({$comment["CommentID"]});\">".wfMsg( 'comment_show_comment_link' )."</a> | "; 
						$output .= "<a href=\"{$block_list_title->escapeFullURL()}\">".wfMsg( 'comment_manage_blocklist_link' )."</a>";
					$output .= "</div>";
				$output .= "</div>";
			}
			
			
			$avatar = new wAvatar($comment["Comment_user_id"],"ml");
			$avatar_img = "<img src=\"{$wgUploadPath}/avatars/" . $avatar->getAvatarImage() . "\" alt=\"\" border=\"0\"/>";
			
			$output .= "<div id=\"comment-{$comment["CommentID"]}\" class=\"c-item {$container_class}\" style=\"{$hide_comment_style}\">";
				$output .= "<div class=\"c-avatar\">{$avatar_img}</div>";
				$output .= "<div class=\"c-container\">";
					
					$output .= "<div class=\"c-user\">";
						
						$output .= "{$CommentPoster}";	
						$output .= "<span class=\"c-user-level\">{$CommentPosterLevel}</span> {$block_link}";

						$output .= "<div class=\"c-time\">".get_time_ago(strtotime($comment["comment_date"]))." " . wfMsg("time_ago") . "</div>";
						
						$output .= "<div class=\"c-score\">";

							if ($this->AllowMinus == true || $this->AllowPlus == true) {
								$output .= "<span class=\"c-score-title\">".wfMsg("comment_score_text")." <span id=\"Comment{$comment["CommentID"]}\">{$CommentScore}</span></span>";
							

								if (!$wgReadOnly) {
	
									if (!in_array( $comment["CommentID"], $voted)) {
	
										if ($wgUser->getName()!=$comment["Comment_Username"]) {
											$output .= "<span id=\"CommentBtn{$comment["CommentID"]}\">";
											if ($this->AllowPlus == true) { 
												$output .=  $this->getVoteLink($comment["CommentID"],1);
											}
	
											if ($this->AllowMinus == true) { 
												$output .= $this->getVoteLink($comment["CommentID"],-1);
											}
											$output .= "</span>";
										} else {	
											$output .= wfMsg("comment_you");
										}
									} else {
										$output .= "<img src=\"".$wgUploadPath."/common/voted.gif\" border=\"0\" alt=\"\"/>".wfMsg("comment_voted_label");
									}
								}
								$output .= "</span>";
							}

						$output .= "</div>";
						
					$output .= "</div>";
					$output .= "<div class=\"c-comment {$comment_class}\">";
						$output .= $this->getCommentText($comment["comment_text"]);
					$output .= "</div>";
					$output .= "<div class=\"c-actions\">";
						$output .= "<a href=\"".$wgTitle->escapeFullURL()."#comment-{$comment["CommentID"]}\" rel=\"nofollow\">".wfMsg("comment_permalink")."</a> ";
						if ($replyRow || $dlt) {
							$output .= "{$replyRow} {$dlt}";
						}
					$output .= "</div>";
				$output .= "</div>";
				$output .= "<div class=\"cleared\"></div>";
			$output .= "</div>";
			}
		}
		$output .= '<a id="end" name="end" rel="nofollow"></a>';
		return $output;
	}
	
	function fixStr($str){
		$str = str_replace ("%26", "&",$str);
		$str = str_replace ("%2B", "+",$str);
		$str = str_replace ("%5C", "\\",$str);
		return $str;
	}
	
	function diplayForm(){
		global $wgUser, $wgAnonRedirect;
		$output = "";
		$output .= "<form action=\"\" method=\"post\" name=\"commentform\">";
		
		if ($this->Allow) {
			$pos = strpos(strtoupper(addslashes ($this->Allow)), strtoupper($this->Username));
		}
		$CommentKey = md5($this->PageID . 'pants' . $this->Username);
		
		if( !$wgUser->isAllowed('comment') ){
			$output .= wfMsg( 'comment_login_required' );
		} else {
			if($wgUser->isBlocked()==false && ($this->Allow=="" || $pos !== false) ){
				$output .= "<div class=\"c-form-title\">". wfMsg("comment_submit") . " {$this->title}</div>";
				$output .= "<div id=\"replyto\" class=\"c-form-reply-to\"></div>";
				if (!$wgUser->isLoggedIn()) {
					
					$login_title = Title::makeTitle(NS_SPECIAL, "UserLogin");
					$register_title = Title::makeTitle(NS_SPECIAL, "UserRegister");
					
					$output .= "<div class=\"c-form-message\">".wfMsgExt("comment-anon-message", "parsemag", $register_title->escapeFullURL(), $login_title->escapeFullURL())."</div>";
				}
				
				$output .= "<textarea name=\"comment_text\" id=\"comment\" rows=\"5\" cols=\"64\" ></textarea>";
				$output .= "<div class=\"c-form-button\"><input type=\"button\" value=\"".wfMsg("comment_post")." {$this->title}\" onclick=\"javascript:submit_comment()\" class=\"site-button\" /></div>";
			}
			$output .= "<input type=\"hidden\" name=\"action\" value=\"purge\"/>";
			$output .= "<input type=\"hidden\" name=\"pid\" value=\"{$this->PageID}\"/>";
			$output .= "<input type=\"hidden\" name=\"commentid\"/>";
			$output .= "<input type=\"hidden\" name=\"lastcommentid\" value=\"{$this->getLatestCommentID()}\"/>";
			$output .= "<input type=\"hidden\" name=\"comment_parent_id\"/>";
			$output .= "<input type=\"hidden\" name=\"sid\" value=\"{session_id()}\"/>";
			$output .= "<input type=\"hidden\" name=\"mk\" value=\"{$CommentKey}\"/>";
		}
		$output .= "</form>";
		return $output;
	}

			
	public function block_user($user_id,$user_name){
		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'Comments_block::addToDatabase';
		$dbr->insert( '`Comments_block`',
		array(
			'cb_user_id' => $this->Userid,
			'cb_user_name' => $this->Username,
			'cb_user_id_blocked' => $user_id,
			'cb_user_name_blocked' => $user_name,
			'cb_date' => date("Y-m-d H:i:s")
			), $fname
		);
	}
	
	static function getBlockList($user_id){
		$block_list = array();
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT cb_user_name_blocked
			FROM Comments_block 
			WHERE cb_user_id = {$user_id}";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			 $block_list[] = $row->cb_user_name_blocked;
		}
		return $block_list;
	}

	static function isUserCommentBlocked($user_id,$user_id_blocked){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`Comments_block`', array( 'cb_id' ), array( 'cb_user_id' => $user_id, 'cb_user_id_blocked' => $user_id_blocked ), $fname );
		if ( $s !== false ) {
			return true;
		}else{
			return false;
		}
	}
	
	public function delete_block($user_id,$user_id_blocked){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "DELETE FROM Comments_block WHERE cb_user_id={$user_id} AND cb_user_id_blocked={$user_id_blocked}";
		$res = $dbr->query($sql);
	}
}
?>

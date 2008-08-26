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
	var $Scorecard = array();
	var $title = "Comment";
	var $ShowUserRating = 0;
	
	function Comment($pageid){
		$this->PageID=$pageid;
	} 

	function setUser($user_name, $user_id){
		$this->Username =  addslashes ($user_name);
		$this->Userid =  $user_id;
	}
	
	function setCommentText($comment_text){
		$this->CommentText = $comment_text;
	}
	
	function getCommentText($comment_text){
		global $wgTitle;
		global $wgOut;
		$comment_text =  str_replace("&quot;","'",$comment_text);
		$CommentParser = new Parser();
		$comment_text = $CommentParser->parse( $comment_text, $wgTitle, $wgOut->parserOptions(),true );
		$comment_text = $comment_text->getText();
		return $comment_text;
	}
	
	function setCommentID($commentid){
		$this->CommentID=$commentid;
	}
	
	function setVoting($voting){
		$this->Voting = $voting;
		$voting = strtoupper($voting);
		
		if($voting == "OFF" || $this->Username == "Jeter03" ){
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
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT count(distinct(comment_username)) as CommentCount FROM Comments WHERE comment_page_id = " . $this->PageID;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$this->CommentTotal = $row->CommentCount;
		}
		return $this->CommentTotal;
	}
	
	function countTotal(){
		$dbr =& wfGetDB( DB_SLAVE );
		$count = 0;
		$sql = "SELECT count(*) as CommentCount FROM Comments WHERE comment_page_id = " . $this->PageID;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$count = $row->CommentCount;
		}
		return $count;
	}
	
	function updateStats(){
		$dbr =& wfGetDB( DB_SLAVE );
		//update stats
			$sql = "SELECT * from page_stats where ps_page_id =  " . $this->PageID;
			$res = $dbr->query($sql);
			$row = $dbr->fetchObject( $res );
			if(!$row){
					$sql = "INSERT INTO `page_stats` "
	                                      ."( `ps_page_id`, `vote_count`,"
	                                      ." `comment_count`)\n"
	                                      ."\tVALUES ( ". $this->PageID . ", 0 ,"
	                                      . $this->count() . ")";
								
			 }else{
		 		$sql = "update page_stats set comment_count = " . $this->countTotal() . " where ps_page_id = " . $this->PageID;
		 	}
			$res = $dbr->query($sql);
	}
	
	function add(){
		$dbr =& wfGetDB( DB_MASTER );

		 if( $this->CommentText != "" && strstr (strtoupper($_GET['title']), "COMMENTACTION") !== false){
			$sql = "INSERT INTO `Comments` "
                                        ."( `comment_page_id`, `comment_username`, `comment_user_id`, "
                                        ." `comment_text`, `comment_date`, `comment_parent_id`, `Comment_IP` )\n"
                                        ."\tVALUES ( ". $this->PageID . ", '" . $this->Username . "' ,". $this->Userid . ","
                                        ." '" . $this->fixStr(str_replace("'","&quot;",$this->CommentText)) . "', '".date("Y-m-d H:i:s")."'," . $this->CommentParentID . ", '" . $_SERVER['REMOTE_ADDR'] . "')";
			//echo $sql;
			$res = $dbr->query($sql);
			$this->updateStats();
		}
			
	}
	
	function getCommentScore(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT sum(Comment_Vote_Score) as CommentScore FROM Comments_Vote WHERE Comment_Vote_ID = " . $this->CommentID;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$this->CommentScore = $row->CommentScore;
		}
		return $this->CommentScore;
	}
	
	function getCommentVoteCount($vote){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT COUNT(*) as CommentVoteCount FROM Comments_Vote WHERE Comment_Vote_ID = " . $this->CommentID . " AND Comment_Vote_Score=" . $vote;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$VoteCount = $row->CommentVoteCount;
		}
		return $VoteCount;
	}
	
	function getLatestCommentID(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT CommentID FROM Comments WHERE comment_page_id = " . $this->PageID . " ORDER By comment_date DESC LIMIT 1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$LatestCommentID = $row->CommentID;
		}
		return $LatestCommentID;
	}
	
	function addVote(){
		$dbr =& wfGetDB( DB_SLAVE );
		if($this->UserAlreadyVoted() == false){
			$sql = "INSERT INTO `Comments_Vote` "
                                        ."( `Comment_Vote_id`, `Comment_Vote_Username`, `Comment_Vote_user_id`,"
                                        ." `Comment_Vote_Score`, `Comment_Vote_Date`, `Comment_Vote_IP`)\n"
                                        ."\tVALUES ( ". $this->CommentID . ", '" . $this->Username . "' ," . $this->Userid . ","
                                        . " " . $this->CommentVote . ", '".date("Y-m-d H:i:s")."','" . $_SERVER['REMOTE_ADDR'] . "')";
			$res = $dbr->query($sql);
			$this->updateCommentVoteStats();
		}
	}
	
	function updateCommentVoteStats(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "UPDATE Comments SET Comment_Plus_Count = " . $this->getCommentVoteCount(1) . ", Comment_Minus_Count = " . $this->getCommentVoteCount(-1) . " WHERE CommentID = " . $this->CommentID;
		$res = $dbr->query($sql);
	}
	
	function UserAlreadyVoted(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT * FROM Comments_Vote  WHERE Comment_Vote_ID=" . $this->CommentID . " AND Comment_Vote_Username =  '" . $this->Username . "'";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if(!$row)
			return false;
		else
			return true;
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
	
	function delete(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "DELETE FROM `Comments` WHERE CommentID= " . $this->CommentID;
		$res = $dbr->query($sql);
		
		$sql = "DELETE FROM `Comments_Vote` WHERE Comment_Vote_ID= " . $this->CommentID;
		$res = $dbr->query($sql);
		
		$this->updateStats();
	}
	
	function displayOrderForm(){
		$output = "";
		$output .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
		$output .= "<tr><td>";
		$output .= "<form name=\"ChangeOrder\" style='margin:0px' action=''>";
		$output .= "<select style='font-size:10px' name=\"TheOrder\" onchange=\"ViewComments(". $this->PageID . ",this.value)\">";
		$output .= "<option value=\"0\">Sort by Date</option>";
		$output .= "<option value=\"1\">Sort by Score</option>";
		$output .= "</select>";
		$output .= "</form>";
		$output .= "</td>";
		$output .= "<td width=\"10\">&nbsp;</td>";
		$output .= "<td>";
		$Output .= "<img src=\"images/commentIcon.gif\" hspace=\"3\" alt=\"c\" />";
		$output .= "<span id=\"spy\"><a href=\"javascript:ToggleLiveComments(1)\" style='font-size:10px'>";
		$output .= "Enable " . $this->title . " Auto-Refresher";
		$output .= "</a></span>";
		$output .= "</td></tr>";
		$output .= "</table><br/>";
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
			global $wgUser;
			$VoteLink = "";
			$VoteKey = "";
			$VoteKey = md5($CommentID . 'pants' . $wgUser->mName);
			if ( $wgUser->isLoggedIn() ) {
				$VoteLink .= '<a href=\'javascript:cv(' . $CommentID . ',' . $VoteType . ',"' . $VoteKey . '","' . $this->Voting . '")\'>';
			}else{
				$VoteLink .= '<a href="javascript:Login()">';
			}
			if($VoteType==1){
				$VoteLink .= "<img src=\"images/thumbsup.gif\" border=\"0\" alt=\"+\" /></a>";
			}else{
				$VoteLink .= "<img src=\"images/thumbsdown.gif\" border=\"0\" alt=\"-\" /></a>";
			}
			return $VoteLink;
		}
			
	function display(){
		global $wgUser;
    		global $wgLang;
    		global $wgContLang;
		global $wgTitle;
		global $wgOut;
		global $wgParser;
		global $wgAnonName;
		$sk =& $wgUser->getSkin();
		$dbr =& wfGetDB( DB_MASTER );
		$output = "";
		$sql = "SELECT Comment_Username,comment_ip, comment_text,comment_date,Comment_user_id,
				CommentID,IFNULL(Comment_Plus_Count - Comment_Minus_Count,0) as Comment_Score,
				Comment_Plus_Count as CommentVotePlus, 
				Comment_Minus_Count as CommentVoteMinus,
				(select count(*) FROM Comments_Vote WHERE Comment_Vote_ID = CommentID AND Comment_Vote_user_id=" .  $wgUser->mId  . ") as AlreadyVoted,
				Comment_Parent_ID, CommentID,
				CASE Comment_Parent_ID WHEN 0 THEN  CAST(replace(Comment_Parent_ID,0,CommentID) as UNSIGNED) else  CAST(Comment_Parent_ID as UNSIGNED) end as thread";
		if($this->ShowUserRating==1){	
			$sql.=",vote_value";
		}		
		$sql .= " FROM Comments ";
		if($this->ShowUserRating==1){
			$sql .= " LEFT JOIN Vote ON Comment_username=username and vote_page_id=" .$this->PageID ;
		}
		$sql .= " WHERE comment_page_id = " . $this->PageID;
		if($this->OrderBy==0){
			$sql .= " ORDER BY thread,Comment_Date";
		}else{
			$sql .= " ORDER BY Comment_Score DESC";
		}

		$res = $dbr->query($sql);
		$AFCounter = 1;
		$AFBucket = array();
		 while ($row = $dbr->fetchObject( $res ) ) {
			$CommentScore=$row->Comment_Score;

			$this->Scorecard [ $row->Comment_Username ] += $CommentScore;
			
			if($row->Comment_user_id!=0){
				$title = Title::makeTitle( 2, $row->Comment_Username);
				$CommentPoster = $sk->makeKnownLinkObj($title, $wgContLang->convertHtml($title->getText()));
				$CommentReplyTo = $row->Comment_Username;
			}else{
				if(!array_key_exists( $row->Comment_Username, $AFBucket)){
					$AFBucket[ $row->Comment_Username ] = $AFCounter;
					$AFCounter++;
				}
				
				$CommentPoster = $wgAnonName . " #". $AFBucket[ $row->Comment_Username ];
				$CommentReplyTo = $wgAnonName;
			}
			if($row->Comment_user_id!=0){
				$avatar = new wAvatar($row->Comment_user_id,"m");
				$CommentIcon = $avatar->getAvatarImage();
			}else{
				$CommentIcon = "af_m.gif";
			}
		
			if($row->Comment_Parent_ID == 0){
				$Width1 = 629;
				$Width2 = 385;
				$class = "comment";
				$moveleft="";
			}else {
				$Width1 = 520;
				$Width2 = 286;
				$class = "reply";
				$moveleft='style="padding-left:109px"';
			}
			
			$timeArray =  $this-> dateDiff(time(),$row->comment_date  );
			$timeStr = "";
			$timeStrD = $this->getTimeOffset($timeArray,"d","day");
			$timeStrH = $this->getTimeOffset($timeArray,"h","hour");
			$timeStrM = $this->getTimeOffset($timeArray,"m","minute");
			$timeStrS = $this->getTimeOffset($timeArray,"s","second");
			$timeStr = $timeStrD;
			if($timeStr<2){
				$timeStr.=$timeStrH;
				$timeStr.=$timeStrM;
				if(!$timeStr)$timeStr.=$timeStrS;
			}
			$UserRating = "";
			if($this->ShowUserRating == 1){
			$Vote = new VoteStars($this->PageID);
			$UserRating = ' ' . $Vote->displayRating($row->vote_value);
			}
$output .= '<div ' . $moveleft . ' id="comment-' . $row->CommentID . '" ><table border="0" cellspacing="0" cellpadding="0" width="' . $Width1 . '" style="padding-bottom:15px;">
  <tr>
   <td class="' . $class . 'top"><table border="0" cellpadding="0" cellspacing="0" width="' . $Width1 . '">
  <tr>
    <td width="100" class="commenticon"><img src="images/avatars/' . $CommentIcon . '" alt="" border="0"/></td>
    <td width="' . $Width2 . '">
	<table border="0" cellpadding="0" cellspacing="0" width="' . $Width2 . '">
	  <tr>
	  <td class="username">' . $CommentPoster . $UserRating . '</td>
	  </tr>
	  <tr>
	    <td class="commenttime">posted <b>' . $timeStr . '</b> ago</td>
	  </tr>
	</table>
	</td>
    <td width="134">
    <table border="0" cellpadding="0" cellspacing="0" width="134">
      <tr> 
	   <td class="commentscore" nowrap="nowrap" height="35" valign="bottom">';
			if($this->AllowMinus == true || $this->AllowPlus == true){
				$output .= "Score: <span id=\"Comment" . $row->CommentID . "\">" . $CommentScore . "</span>";
			} 
			$output .= "</td>";
			$output .= "<td valign=\"bottom\">";
			$output .= "<span class=\"CommentVote\">";
			$output .= "<span id=\"CommentBtn" . $row->CommentID . "\">";

			if($row->AlreadyVoted == 0){
				if($wgUser->mName!=$row->Comment_Username){
					if($this->AllowPlus == true){ 
						$output .=  $this->getVoteLink($row->CommentID,1); //'<a href=javascript:cv(' . $row['CommentID'] . ',1,"' . $VoteKey . '","' . $this->Voting . '")>';
					}
					if($this->AllowMinus == true){ 
						$output .= $this->getVoteLink($row->CommentID,-1); //'<a href=javascript:cv(' . $row['CommentID'] . ',1,"' . $VoteKey . '","' . $this->Voting . '")>';
					}
				}else{	
					$output .= '<span class="commentscore"><b>You</b></span>';
				}
			}else{
				$output .= '<img src="images/myfeed.gif" align="bottom" hspace="2" alt="v" /><span class="commentscore">voted</span>';
			}

			$output .= "</span>";
			$output .= "</span>";
			$output .= "</td>";
            $output .= '</tr>
    </table>
    </td>
  </tr>
  </table>
  </td>
</tr>
<tr>
  <td class="commentmiddle" width="' . $Width1 . '" height="40">' . $this->getCommentText($row->comment_text) . '</td>
</tr>
<tr>
  <td class="' . $class . 'bottom"></td>
</tr>';

$dlt = "";
if( in_array('staff',($wgUser->getGroups())) || $wgUser->mName=="Pean" ){
	$dlt =' <span ><a href="javascript:document.commentform.commentid.value='. $row->CommentID . ';document.commentform.submit();" style="color:red">x</a></span>&nbsp;';
}
$replyRow = "";
if($row->Comment_Parent_ID == 0){
	if($replyRow)$replyRow .= " | ";
	$replyRow .= "<a href=\"#end\" class=\"reply\" onclick=\"javascript:Reply(". $row->CommentID . ",'" . urlencode ($CommentReplyTo) . "')\">reply</a>";
}
if($replyRow || $dlt)$output .= "<tr><td  align=\"right\">" . $dlt . " " . $replyRow . "</td></tr>";

$output .= '</table></div>';

		}
		$output .= '<a id="end" name="end"></a>';
		return $output;
	}
	
	function fixStr($str){
		$str = str_replace ("%26", "&",$str);
		$str = str_replace ("%2B", "+",$str);
		$str = str_replace ("%5C", "\\",$str);
		return $str;
	}
	
	function diplayForm(){
		global $wgUser;
		$output = "";
		$output .= '<form action="" method="post" name="commentform">';
		
		if($this->Allow){
		$pos = strpos(strtoupper(addslashes ($this->Allow)), strtoupper($this->Username));
		}
		$CommentKey = md5($this->PageID . 'pants' . $this->Username);
		
		if($wgUser->isBlocked()==false && ($this->Allow=="" || $pos !== false) ){
		$output .= '<span style="color:#666666;font-weight:800">Submit a ' . $this->title . '</span><br/><span id="replyto" class="replyto"></span><textarea name="comment_text" id="comment" rows="3" cols="86" ></textarea><br/>';
		$output .= '<input type="button" value="Post ' . $this->title . '" onclick="javascript:SubmitComment()" class="commentsubmit"/>';
		}
		$output .= '<input type="hidden" name="action" value="purge"/>';
		$output .= '<input type="hidden" name="pid" value="' . $this->PageID . '" />';
		$output .= '<input type="hidden" name="commentid" />';
		$output .= '<input type="hidden" name="lastcommentid" value="' . $this->getLatestCommentID() . '" />';
		$output .= '<input type="hidden" name="comment_parent_id" />';
		$output .= '<input type="hidden" name="sid" value="' . session_id() . '"/>';
		$output .= '<input type="hidden" name="mk" value="' . $CommentKey . '"/>';
		$output .= '</form>';
		return $output;
	}
	
	 function dateDiff($dt1, $dt2) {
   $date1 = $dt1; //(strtotime($dt1) != -1) ? strtotime($dt1) : $dt1;
   $date2 = (strtotime($dt2) != -1) ? strtotime($dt2) : $dt2;
   $dtDiff = $date1 - $date2;
   $totalDays = intval($dtDiff/(24*60*60));
   $totalSecs = $dtDiff-($totalDays*24*60*60);
   $dif['w'] = intval($totalDays/7);
   $dif['d'] = $totalDays;
   $dif['h'] = $h = intval($totalSecs/(60*60));
   $dif['m'] = $m = intval(($totalSecs-($h*60*60))/60);
   $dif['s'] = $totalSecs-($h*60*60)-($m*60);
   return $dif;
  }

  			function getTimeOffset($time,$timeabrv,$timename){
				if($time[$timeabrv]>0){
					$timeStr = $time[$timeabrv] . " " . $timename;
					if($time[$timeabrv]>1)$timeStr .= "s";
				}
				if($timeStr)$timeStr .= " ";
				return $timeStr;
			}
}
?>

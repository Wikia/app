<?php

$wgExtensionFunctions[] = 'registerUserStats';

function registerUserStats(){
    global $wgParser ,$wgOut;
	//purgePage();
    $wgParser->setHook('userstats', 'renderUserStats');
}

function renderUserStats($input){
	global $wgUser;
	purgePage();
	getValue($username,$input,"user");
	$userstats = new UserStats();
	$userstats->setUsername($username);
	$output = $userstats->displayUserStats();
	return $output;
}

class UserStats{
	var $Username = "";
	var $Userid = 0;
	var $VoteCount = 0;
	var $CommentCount = 0;
	var $CommentScore = 0;
	var $CommentScorePlus = 0;
	var $CommentScoreMinus = 0;
	var $CreatedOpinions = 0;
	var $CreatedNews = 0;
	var $PromotedOpinions = 0;
	var $EditsCount = 0;
	var $UserID=0;
	var $unix_time_range = 2592000; 
	var $unix_time_30daysago = 0; //= time() - $unix_time_range; 
	var $timeFrame = 0;

	function UserStats(){
		return;
	}
	
	function setUsername($usr){
		$parser = new Parser();
		$CtgTitle = Title::newFromText( $parser->transformMsg(trim(addslashes ($usr)), null) );	
		$this->Username = $CtgTitle->getDbKey();
		$this->Userid = $this->getUserID();
	}
	
	function setTimeFrame($time){
		if(strtoupper($time) == "RECENT")$this->timeFrame = 1;
	}
	
	function getEditsCount(){
		$dbr =& wfGetDB( DB_SLAVE );
		if($this->timeFrame == 1){
			$timeSQL = " AND UNIX_TIMESTAMP( rev_timestamp ) >  " . $this->unix_time_30daysago ;
		}
		$sql = "SELECT count(*) as EditsCount FROM {$dbr->tableName( 'revision' )} WHERE replace(rev_user_text,' ','_') = '" . $this->Username . "' " . $timeSQL;
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->EditsCount = $row->EditsCount;
		}
		return $this->EditsCount;
	}
	
	function getUserID(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT user_id FROM {$dbr->tableName( 'user' )} WHERE replace(user_name,' ','_') = " . $dbr->AddQuotes($this->Username);
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->UserID = $row->user_id;
		}
		return $this->UserID;
	}
	
	function getTotalRank(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT total_rank FROM User_Rankings WHERE rank_user_id = '" . $this->Userid . "' and rank_timeframe=0 ";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->UserID = $row->total_rank;
		}
		return $this->UserID;
	}
	
	function getVoteCount(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT count(distinct(vote_page_id)) as VoteCount FROM Vote WHERE vote_user_id = " . $this->Userid . " AND vote_value = 1 ";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->VoteCount = $row->VoteCount;
		}
		return $this->VoteCount;
	}
	
	function getLastVoteDate(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT UNIX_TIMESTAMP(vote_date) as LastDate FROM Vote WHERE vote_user_id = " . $this->Userid . " ORDER BY vote_date DESC LIMIT 0,1 ";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
 		if($row){
			return $row->LastDate;
		}
	}	

	function getLastCommentDate(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT UNIX_TIMESTAMP(comment_date) as LastDate FROM Comments WHERE Comment_user_id = " . $this->Userid . " ORDER BY comment_date DESC LIMIT 0,1 ";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
 		if($row){
			return $row->LastDate;
		}
	}	
	
	function getLastEditDate(){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT UNIX_TIMESTAMP(DATE_SUB( `rev_timestamp`, INTERVAL 5 HOUR ) )  as LastDate FROM {$dbr->tableName( 'revision' )} WHERE rev_user = " . $this->Userid . "  ORDER BY rev_timestamp DESC LIMIT 0,1 ";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			return $row->LastDate;
		}
	}
	
	function getLastActivity($ts){
	
		
					$timeArray =  $this-> dateDiff(time(),$ts  );
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
			
		return $timeStr . " ago ";
	}
		
	function getCommentCount(){
		$dbr =& wfGetDB( DB_SLAVE );
		if($this->timeFrame == 1){
			$timeSQL = " AND UNIX_TIMESTAMP( Comment_Date ) >  " . $this->unix_time_30daysago ;
		}
		$sql = "SELECT count(*) as CommentCount FROM Comments WHERE Comment_user_id = " . $this->Userid . " " . $timeSQL;
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->CommentCount = $row->CommentCount;
		}
		return $this->CommentCount;
	}
	
	function getCommentVoteCount($vote){
		if($this->timeFrame == 1){
			$timeSQL = " AND UNIX_TIMESTAMP( Comment_Vote_Date ) >  " . $this->unix_time_30daysago ;
		}
		$sql = "SELECT COUNT(*) as CommentVoteCount FROM Comments_Vote WHERE Comment_Vote_ID IN (select CommentID FROM Comments WHERE Comment_user_id = " . $this->Userid . ") AND Comment_Vote_Score=" . $vote . " " . $timeSQL;
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$VoteCount = $row['CommentVoteCount'];
		}
		return $VoteCount;
	}
	
	function setCommmentScorePlus(){
		$this->CommentScorePlus = $this->getCommentVoteCount(1);
	}
	
	function setCommmentScoreMinus(){
		$this->CommentScoreMinus = $this->getCommentVoteCount(-1);
	}
	
	function getCommentScorePlus(){
		return $this->CommentScorePlus;
	}	
	
	function getCommentScoreMinus(){
		return $this->CommentScoreMinus;
	}	
	
	function getCommentScore(){
		$this->setCommmentScorePlus();
		$this->setCommmentScoreMinus();
		return $this->getCommentScorePlus() - $this->getCommentScoreMinus();
	}
	
	function getCreatedOpinions(){
		$parser = new Parser();
		$dbr =& wfGetDB( DB_SLAVE );
		$ctg = "OPINIONS BY USER " . strtoupper($this->Username) ;
		$CtgTitle = Title::newFromText( $parser->transformMsg(trim($ctg), null) );	
		$CtgTitle = $CtgTitle->getDbKey();
		
		if($this->timeFrame == 1){
			$timeSQL = " AND (select UNIX_TIMESTAMP(rev_timestamp) from {$dbr->tableName( 'revision' )} where rev_page=page_id  order by rev_timestamp asc limit 1)  > " . $this->unix_time_30daysago ;
		}
		
		$sql = "SELECT count(*) as CreatedOpinions FROM page INNER JOIN {$dbr->tableName( 'categorylinks' )} ON page_id = cl_from WHERE UPPER(cl_to) = " . $dbr->addQuotes($CtgTitle) . " " . $timeSQL;
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->CreatedOpinions = $row->CreatedOpinions;
		}
		return $this->CreatedOpinions;
	}
	
	function getPromotedOpinions(){
		$parser = new Parser();
		$dbr =& wfGetDB( DB_SLAVE );
		$ctg = "OPINIONS BY USER " . strtoupper($this->Username) ;
		$CtgTitle = Title::newFromText( $parser->transformMsg(trim($ctg), null) );	
		$CtgTitle = $CtgTitle->getDbKey();
		if($this->timeFrame == 1){
			$timeSQL = " AND (select UNIX_TIMESTAMP(rev_timestamp) from {$dbr->tableName( 'revision' )} where rev_page=page_id  order by rev_timestamp asc limit 1)  > " . $this->unix_time_30daysago ;
		}
		$sql = "SELECT count(*) as PromotedOpinions FROM {$dbr->tableName( 'page' )} INNER JOIN {$dbr->tableName( 'categorylinks' )} ON page_id = cl_from INNER JOIN published_page ON page_id=published_page_id WHERE UPPER(cl_to) = " . $dbr->addQuotes($CtgTitle) . " AND published_type=1 " . " " . $timeSQL;
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->PromotedOpinions = $row->PromotedOpinions;
		}
		return $this->PromotedOpinions;
	}
	
	function displayUserStats(){
		$output = "<table cellpadding=3 cellspacing=0 border=0 class=statsTable width=250>";
		$output .= "<tr bgcolor=#184984>";
		$output .= "<td colspan=2 style='background-image:url(http://www.armchairgm.com/mwiki/images/TopBarBG.gif);font-weight:800;color:#ffffff'>#" . $this->getUserID() . " " . $this->Username;
		$output .= "</td>";
		$output .= "</tr>";
		$output .="<tr >";
		$output .= "<td width=50% bgcolor=#78BF5F style=\"font-weight:800;border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#ffffff;  text-align:center;\">";
		$output .= "Overall Rank";
		$output .="</span></td>";
		$output .= "<td width=50% align=center style=\"border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F; text-align:center;\">";
		$output .= $this->getTotalRank();
		$output .="</span></td>";
		$output .= "</tr>";
		$output .="<tr >";
		$output .= "<td width=50% bgcolor=#eeeeee style=\"font-weight:800;border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F;  text-align:center;\">";
		$output .= "# Votes Cast";
		$output .="</span></td>";
		$output .= "<td width=50% align=center style=\"border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F; text-align:center;\">";
		$output .= $this->getVoteCount();
		$output .="</span></td>";
		$output .= "</tr>";
		$output .="<tr sbgcolor=#eeeeee>";
		$output .= "<td width=50% bgcolor=#eeeeee style=\"font-weight:800;border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F;  text-align:center;\">";
		$output .= 	"# Edits";
		$output .="</span></td>";
		$output .= "<td width=50% align=center style=\"border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F; text-align:center;\">";
		$output .= $this->getEditsCount();
		$output .="</span></td>";
		$output .= "</tr>";

		$output .="<tr >";
		$output .= "<td width=50% bgcolor=#eeeeee style=\"font-weight:800;border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px; color:#4F4F4F; text-align:center;\">";
		$output .= 	"# Opinions Created";
		$output .="</span></td>";
		$output .= "<td width=50% align=center style=\"border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F;  text-align:center;\">";
		$output .=  $this->getCreatedOpinions();
		$output .="</span></td>";
		$output .= "</tr>";
		$output .="<tr sbgcolor=#eeeeee>";
		$output .= "<td width=50% bgcolor=#eeeeee style=\"font-weight:800;border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px; color:#4F4F4F; text-align:center;\">";
		$output .= 	"# Opinions Promoted";
		$output .="</span></td>";
		$output .= "<td width=50% align=center style=\"border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F;  text-align:center;\">";
		$output .=  $this->getPromotedOpinions();
		$output .="</span></td>";
		$output .= "</tr>";

		$output .="<tr>";
		$output .= "<td width=50% bgcolor=#eeeeee style=\"font-weight:800;border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F; text-align:center;\">";
		$output .= 	"# Comments";
		$output .="</span></td>";
		$output .= "<td width=50% align=center style=\"border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F;  text-align:center;\">";
		$output .= $this->getCommentCount();
		$output .="</span></td>";
		$output .= "</tr>";
		$output .="<tr sbgcolor=#eeeeee>";
		$output .= "<td width=50% bgcolor=#eeeeee style=\"font-weight:800;border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px; color:#4F4F4F; text-align:center;\">";
		$output .= 	"+ Comment Score";
		$output .="</span></td>";
		$output .= "<td width=50% align=center style=\"border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F;  text-align:center;\">";
		//$output .= "<b>" . $this->getCommentScore() . "</b> [+" . $this->getCommentScorePlus() . " / -" . $this->getCommentScoreMinus() . "]";
		$this->getCommentScore();
		$output .= "" . $this->getCommentScorePlus();
		$output .="</span></td>";
		$output .= "</tr>";

		$output .="<tr sbgcolor=#eeeeee>";
		$output .= "<td width=50% bgcolor=#eeeeee style=\"font-weight:800;border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px; color:#4F4F4F; text-align:center;\">";
		$output .= 	"Last Comment";
		$output .="</span></td>";
		$output .= "<td width=50% align=center style=\"border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F;  text-align:center;\">";
		$output .=  $this->getLastActivity($this->getLastCommentDate());
		$output .="</span></td>";
		$output .= "</tr>";
		
				$output .="<tr sbgcolor=#eeeeee>";
		$output .= "<td width=50% bgcolor=#eeeeee style=\"font-weight:800;border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px; color:#4F4F4F; text-align:center;\">";
		$output .= 	"Last Vote";
		$output .="</span></td>";
		$output .= "<td width=50% align=center style=\"border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F;  text-align:center;\">";
		$output .=  $this->getLastActivity($this->getLastVoteDate());
		$output .="</span></td>";
		$output .= "</tr>";
				
		$output .="<tr sbgcolor=#eeeeee>";
		$output .= "<td width=50% bgcolor=#eeeeee style=\"font-weight:800;border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px; color:#4F4F4F; text-align:center;\">";
		$output .= 	"Last Edit";
		$output .="</span></td>";
		$output .= "<td width=50% align=center style=\"border-bottom:1px solid #CED4CA; border-right:1px solid #CED4CA;\"><span style=\"font-size:11px;color:#4F4F4F;  text-align:center;\">";
		$output .=  $this->getLastActivity($this->getLastEditDate());
		$output .="</span></td>";
		$output .= "</tr>";
		
		$output .= "</table>";
		return $output;
	}
	
	 function dateDiff($dt1, $dt2) {
   $date1 = (strtotime($dt1) != "") ? strtotime($dt1) : $dt1;
   $date2 = (strtotime($dt2) != "") ? strtotime($dt2) : $dt2;
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
					$timeStr = $time[$timeabrv] . "" . $timeabrv;
					//if($time[$timeabrv]>1)$timeStr .= "s";
				}
				if($timeStr)$timeStr .= " ";
				return $timeStr;
			}
}
?>
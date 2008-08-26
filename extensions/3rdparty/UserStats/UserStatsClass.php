<?php


class UserStatsTrack{
	
	function UserStatsTrack($yearid,$userid,$username){
		$this->year_id = $yearid;
		$this->user_id = $userid;
		$this->user_name = $username;
		$this->initStatsTrack();
	}
	
	function initStatsTrack(){	
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT stats_user_id from user_stats where stats_user_id =  " . $this->user_id . " and stats_year_id = " . $this->year_id;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if(!$row){
			$this->addStatRecord();
		}
	}
	
	function addStatRecord(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "INSERT INTO `user_stats` "
                       . "(`stats_year_id`, `stats_user_id`, `stats_user_name`,`stats_comment_count`"
			       . ",`stats_comment_score_positive_rec`,`stats_comment_score_negative_rec`"
			       . ",`stats_comment_score_positive_given`,`stats_comment_score_negative_given`"
			       . ",`stats_vote_count`,`stats_edit_count`"
			       . ",`stats_opinions_created`,`stats_opinions_published`,`stats_referrals`,`stats_referrals_completed`"
			       . ",`stats_challenges_won`,`stats_overall_rank`,`stats_total_points`)\n"
                       ."\tVALUES ( ". $this->year_id . ", " . $this->user_id . " ," . $dbr->AddQuotes($this->user_name) . ","
                                       ."0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
		$res = $dbr->query($sql);
	}
	
	function incVoteCount(){
		global $wgUser;
		if( !$wgUser->isAnon() ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'user_stats',
				array( 'stats_vote_count=stats_vote_count+1' ),
				array( 'stats_user_id' => $this->user_id , 'stats_year_id' => $this->year_id ),
				__METHOD__ );
			$this->updateTotalPoints();
		}
	}

	function incEditCount(){
		global $wgUser;
		if( !$wgUser->isAnon() ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'user_stats',
				array( 'stats_edit_count=stats_edit_count+1' ),
				array( 'stats_user_id' => $this->user_id , 'stats_year_id' => $this->year_id ),
				__METHOD__ );
			$this->updateTotalPoints();
		}
	}
	
	function incCommentCount(){
		global $wgUser;
		if( !$wgUser->isAnon() ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'user_stats',
				array( 'stats_comment_count=stats_comment_count+1' ),
				array( 'stats_user_id' => $this->user_id , 'stats_year_id' => $this->year_id ),
				__METHOD__ );
			$this->updateTotalPoints();
		}
	}
	
	function incCommentScoreGiven($vote_type){
		global $wgUser;
		if( !$wgUser->isAnon() ) {
			if($vote_type==1){
				$field = 'stats_comment_score_positive_given=stats_comment_score_positive_given+1';
			}else{
				$field = 'stats_comment_score_negative_given=stats_comment_score_negative_given+1';
			}
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'user_stats',
				array( $field ),
				array( 'stats_user_id' => $this->user_id , 'stats_year_id' => $this->year_id ),
				__METHOD__ );
			$this->updateTotalPoints();
		}	
	}
	
	function updateCommentScoreRec($vote_type){
		global $wgUser,$wgStatsStartTimestamp;
		if( !$wgUser->isAnon() ) {
			$dbr = wfGetDB( DB_MASTER );
			$sql = "update low_priority user_stats set ";
			if($vote_type==1){
				$sql  .= 'stats_comment_score_positive_rec=';
			}else{
				$sql  .= 'stats_comment_score_negative_rec=';
			}
			$sql .= "(SELECT COUNT(*) as CommentVoteCount FROM Comments_Vote WHERE Comment_Vote_ID IN (select CommentID FROM Comments WHERE Comment_user_id = " . $this->user_id . ") AND Comment_Vote_Score=" . $vote_type;
			if($wgStatsStartTimestamp){
				$sql .= " AND UNIX_TIMESTAMP( Comment_Vote_Date ) >  " . $wgStatsStartTimestamp ;
			}	
			$sql .=	 ")";
			$sql .= " WHERE stats_user_id = " . $this->user_id . " AND stats_year_id = " . $this->year_id;
			$res = $dbr->query($sql);
			$this->updateTotalPoints();
		}	
	}

	function updateCreatedOpinionsCount(){
		global $wgUser, $wgOut, $wgStatsStartTimestamp;
		if( !$wgUser->isAnon() && $this->user_id && $this->year_id) {
			$ctg = "OPINIONS BY USER " . strtoupper($this->user_name) ;
			$parser = new Parser();
			$CtgTitle = Title::newFromText( $parser->transformMsg(trim($ctg), $wgOut->parserOptions() ) );	
			$CtgTitle = $CtgTitle->getDbKey();
			$dbr = wfGetDB( DB_MASTER );
			$sql = "update low_priority user_stats set stats_opinions_created=";
			$sql .= "(SELECT count(*) as CreatedOpinions FROM {$dbr->tableName( 'page' )} INNER JOIN {$dbr->tableName( 'categorylinks' )} ON page_id = cl_from WHERE UPPER(cl_to) = " . $dbr->addQuotes($CtgTitle) . " ";
			if($wgStatsStartTimestamp)$sql .= " AND (select UNIX_TIMESTAMP(rev_timestamp) from {$dbr->tableName( 'revision' )} where rev_page=page_id  order by rev_timestamp asc limit 1)  > " . $wgStatsStartTimestamp;
			$sql .= ")";
			$sql .= " WHERE stats_user_id = " . $this->user_id . " AND stats_year_id = " . $this->year_id;
			//echo $sql;
			$res = $dbr->query($sql);
			$this->updateTotalPoints();
		}	
	}

	function updatePublishedOpinionsCount(){
		global $wgUser, $wgOut, $wgStatsStartTimestamp;
		$parser = new Parser();
		$dbr =& wfGetDB( DB_MASTER );
		$ctg = "OPINIONS BY USER " . strtoupper($this->user_name) ;
		$CtgTitle = Title::newFromText( $parser->transformMsg(trim($ctg), $wgOut->parserOptions()) );	
		$CtgTitle = $CtgTitle->getDbKey();
		if($wgStatsStartTimestamp){
			$timeSQL = " AND (select UNIX_TIMESTAMP(rev_timestamp) from {$dbr->tableName( 'revision' )} where rev_page=page_id  order by rev_timestamp asc limit 1)  > " . $wgStatsStartTimestamp ;
		}
		$sql = "update  user_stats set stats_opinions_published = ";
		$sql .= "(SELECT count(*) as PromotedOpinions FROM {$dbr->tableName( 'page' )} INNER JOIN {$dbr->tableName( 'categorylinks' )} ON page_id = cl_from INNER JOIN published_page ON page_id=published_page_id WHERE UPPER(cl_to) = " . $dbr->addQuotes($CtgTitle) . " AND published_type=1 " . " " . $timeSQL;
		$sql .= ")";
		$sql .= " WHERE stats_user_id = " . $this->user_id . " AND stats_year_id = " . $this->year_id;
		echo $sql . "<BR>";
		$res = $dbr->query($sql);
		$this->updateTotalPoints();
	}
	
	function incOpinionsPublished(){
		global $wgUser;
		//if( !$wgUser->isAnon() ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'user_stats',
				array( 'stats_opinions_published=stats_opinions_published+1' ),
				array( 'stats_user_id' => $this->user_id , 'stats_year_id' => $this->year_id ),
				__METHOD__ );
			$this->updateTotalPoints();
		//}
	}	
	
	function updateTotalPoints(){	
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT stats_user_id,stats_comment_count,stats_comment_score_positive_rec, stats_vote_count,stats_edit_count, stats_opinions_created, stats_opinions_published, stats_referrals_completed from user_stats where stats_user_id =  " . $this->user_id . " and stats_year_id = " . $this->year_id;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$comment_count = $row->stats_comment_count;
			$stats_comment_score_positive_rec = $row->stats_comment_score_positive_rec;
			$stats_vote_count = $row->stats_vote_count;
			$stats_edit_count = $row->stats_edit_count;
			$stats_opinions_published = $row->stats_opinions_published;
			$stats_opinions_created = $row->stats_opinions_created;
			$stats_referrals_completed = $row->stats_referrals_completed;
		}
		$new_total_points = ( (.25* $stats_edit_count) + ($stats_opinions_created) + ($stats_opinions_published) + (.25*$comment_count) + (.15*$stats_comment_score_positive_rec) + (.05*$stats_vote_count) + (25*$stats_refferals_completed)  );
		
		$sql = "UPDATE low_priority user_stats set stats_total_points = {$new_total_points} 
			WHERE stats_user_id= {$this->user_id} AND stats_year_id = {$this->year_id}";
		$res = $dbr->query($sql);
		
	}
	
}
?>
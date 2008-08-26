<?php
/*
 * Ajax Functions used by Wikia extensions
 */
 
$wgAjaxExportList [] = 'wfCommentSubmit';
function wfCommentSubmit($page_id, $parent_id, $comment_text, $sid, $mk){
	global $wgRequest, $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 

	require_once ("$wgVoteDirectory/Publish.php");
	require_once ("$wgVoteDirectory/RSS.php");
	$stats = new UserStatsTrack($wgUser->getID(), $wgUser->getName());
	
	if($comment_text!=""){ 
		$Comment = new Comment($page_id);
		$Comment->setCommentText($comment_text);
		$Comment->setCommentParentID($parent_id);
		$Comment->add();
	
		$stats->incStatField("comment");
		
		//score check after comment add
		$Vote = new Vote($page_id);
		$publish = new Publish();
		$publish->PageID = $page_id;
		$publish->VoteCount = $Vote->count(1);
		$publish->CommentCount = $Comment->count();
		$publish->check_score();
	}
	return "ok";
}

$wgAjaxExportList [] = 'wfCommentVote';
function wfCommentVote($comment_id,$vote_value,$mk,$vg,$page_id){
	global $wgRequest, $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 

	require_once ("$wgVoteDirectory/RSS.php");
	require_once ("$wgVoteDirectory/Publish.php");

	$stats = new UserStatsTrack($wgUser->getID(), $wgUser->getName());
	
	if(  is_numeric($comment_id) &&  is_numeric($vote_value) ){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT comment_page_id,comment_user_id, comment_username FROM Comments WHERE CommentID = {$comment_id}";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$PageID = $row->comment_page_id;
			$Comment = new Comment($PageID);
			$Comment->CommentID = $comment_id;
			$Comment->setCommentVote($vote_value);
			$Comment->setVoting($vg);
			$Comment->addVote();
			$out =  $Comment->getCommentScore();
		
			//must update stats for user doing the voting
			if($vote_value==1)$stats->incStatField("comment_give_plus");
			if($vote_value==-1)$stats->incStatField("comment_give_neg");
			
			//also must update the stats for user receiving the vote
			$stats_comment_owner = new UserStatsTrack($row->comment_user_id, $row->comment_username);
			$stats_comment_owner->updateCommentScoreRec($vote_value);
	
			$stats_comment_owner->updateTotalPoints();
			if($vote_value==1){
				$stats_comment_owner->updateWeeklyPoints($stats_comment_owner->point_values["comment_plus"]);
				$stats_comment_owner->updateMonthlyPoints($stats_comment_owner->point_values["comment_plus"]);
			}
			
			return  $out;
		}	 
	}
}

$wgAjaxExportList [] = 'wfCommentList';
function wfCommentList($page_id,$order){
	global $wgRequest, $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 

	$Comment = new Comment($page_id);
	$Comment->setOrderBy($order);
	if($_POST["shwform"] == 1)$output .= $Comment->displayOrderForm();
	$output .= $Comment->display();
	if($_POST["shwform"] == 1)$output .= $Comment->diplayForm();
	return $output;
}

$wgAjaxExportList [] = 'wfCommentLatestID';
function wfCommentLatestID($page_id){
	global $wgRequest, $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 

	$Comment = new Comment($page_id);
	return $Comment->getLatestCommentID();
}

$wgAjaxExportList [] = 'wfCommentBlock';
function wfCommentBlock($comment_id,$user_id,$mk){
	global $wgRequest, $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 
	
	//load user_name and user_id for person we want to block from the comment it originated from
	$dbr =& wfGetDB( DB_MASTER );
	$s = $dbr->selectRow( '`Comments`', array( 'comment_username','comment_user_id' ), array( 'CommentID' => $comment_id ), $fname );
	if ( $s !== false ) {
		$user_id  = $s->comment_user_id;
		$user_name = $s->comment_username;
	}
		
	$Comment = new Comment(0);
	$Comment->block_user($user_id,$user_name);
	
	$stats = new UserStatsTrack($user_id, $user_name);
	$stats->incStatField("comment_ignored");
	return "ok";
}


?>
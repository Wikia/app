<?php

$wgExtensionFunctions[] = 'wfSpecialCommentAction';


function wfSpecialCommentAction(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class CommentAction extends UnlistedSpecialPage {

  function CommentAction(){
    UnlistedSpecialPage::UnlistedSpecialPage("CommentAction");
  }

  function execute(){
    global $wgUser, $wgOut, $wgVoteDirectory, $IP; 

	require_once ('CommentClass.php');
	require_once ("$wgVoteDirectory/VoteClass.php");
	require_once ("$wgVoteDirectory/Publish.php");
	require_once ("$IP/extensions/UserStats/UserStatsClass.php");
	$stats = new UserStatsTrack(1,$wgUser->mId, $wgUser->mName);
			
	// Vote for a Comment
	
	if($_POST["mk"] == md5($_POST["cid"] . 'pants' . $wgUser->mName) ){
		if(is_numeric($_GET["Action"]) && $_GET["Action"] == 1 && is_numeric($_POST["cid"]) ){
			if(is_numeric($_POST["cid"]) &&  is_numeric($_POST["vt"])   ){
				$dbr =& wfGetDB( DB_MASTER );
				$sql = "SELECT comment_page_id,comment_user_id, comment_username FROM Comments WHERE CommentID = " . $_POST["cid"];
				$res = $dbr->query($sql);
				$row = $dbr->fetchObject( $res );
				if($row){
					$PageID = $row->comment_page_id;
					$Comment = new Comment($PageID);
					$Comment->setUser($wgUser->mName,$wgUser->mId);
					$Comment->CommentID = $_POST["cid"];
					$Comment->setCommentVote($_POST["vt"]);
					$Comment->setVoting($_POST["vg"]);
					$Comment->addVote();
					$out =  $Comment->getCommentScore();
				
					//must update stats for user doing the voting
					$stats->incCommentScoreGiven($_POST["vt"]);
					
					//also must update the stats for user receiving the vote
					$stats_comment_owner = new UserStatsTrack(1,$row->comment_user_id, $row->comment_username);
					$stats_comment_owner->updateCommentScoreRec($_POST["vt"]);
					
					echo  $out;
				}
			}
		}
	}
	
	// get new Comment list
	if(is_numeric($_GET["Action"]) && $_GET["Action"] == 2 && is_numeric($_POST["pid"])){
		$Comment = new Comment($_POST["pid"]);
		$Comment->setUser($wgUser->mName,$wgUser->mId);
		$Comment->setOrderBy($_POST["ord"]);
		if($_POST["shwform"] == 1)$output .= $Comment->displayOrderForm();
		$output .= $Comment->display();
		if($_POST["shwform"] == 1)$output .= $Comment->diplayForm();
		echo $output;
	}

	if($_POST['ct']!="" && is_numeric($_GET["Action"]) && $_GET["Action"] == 3){ 
		$input = $_POST['ct'];
		$host  = $_SERVER['SERVER_NAME'];
		$input = str_replace($host,"",$input);
	
		$AddComment = true;
	
		if($AddComment == true){
			$Comment = new Comment($_POST["pid"]);
			$Comment->setUser($wgUser->mName,$wgUser->mId);
			$Comment->setCommentText($_POST['ct']);
			$Comment->setCommentParentID($_POST['par']);
			$Comment->add();
	
			//$stats->incCommentCount();
		
			//score check after comment add
			$Vote = new Vote($_POST["pid"]);
			$publish = new Publish();
			$publish->PageID = $_POST["pid"];
			$publish->VoteCount = $Vote->count(1);
			$publish->CommentCount = $Comment->count();
			$publish->check_score();
		}
	
	}

	if(is_numeric($_GET["Action"]) && $_GET["Action"] == 4 && is_numeric($_GET["pid"])){
		$Comment = new Comment($_GET["pid"]);
		$Comment->setUser($wgUser->mName,$wgUser->mId);
		echo $Comment->getLatestCommentID();
	}
	// This line removes the navigation and everything else from the
 	// page, if you don't set it, you get what looks like a regular wiki
 	// page, with the body you defined above.
 	$wgOut->setArticleBodyOnly(true);
  }

}

 SpecialPage::addPage( new CommentAction );
 global $wgMessageCache,$wgOut;
 //$wgMessageCache->addMessage( 'commenteaction', 'comment action' );
 


}

?>
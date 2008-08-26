<?php
/*
 * Ajax Functions used by Wikia extensions
 */
$wgAjaxExportList [] = 'wfVoteClick';

function wfVoteClick($vote_value,$page_id,$mk){
	global $wgRequest, $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 

	require_once ("$wgVoteDirectory/Publish.php");
	require_once ("$wgVoteDirectory/RSS.php");
	
	if( is_numeric($page_id ) && (is_numeric($vote_value) )){
		$Vote = new Vote($page_id);
		$Vote->insert($vote_value);
		
		$CommentList = new Comment($page_id);

		$publish = new Publish();
		$publish->PageID = $page_id;
		$publish->VoteCount = $Vote->count(1);
		$publish->CommentCount = $CommentList->count();
		$publish->check_score();
		
		return $Vote->count(1);
		
	}else{
		return "error";
	}
}

$wgAjaxExportList [] = 'wfVoteDelete';
function wfVoteDelete($page_id,$mk){
	global $wgRequest, $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 
	
	if( is_numeric($page_id )  ){
		$Vote = new Vote($page_id);
		$Vote->delete();
		
		return $Vote->count(1);
	}else{
		return "error";
	}
}

$wgAjaxExportList [] = 'wfVoteStars';
function wfVoteStars($vote_value,$page_id,$mk){
	global $wgRequest, $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 
	
	$Vote = new VoteStars($page_id);
	if($Vote->UserAlreadyVoted()){
		$Vote->delete();
	}
	$Vote->insert($vote_value);
	
	return $Vote->display($vote_value);
}

					
$wgAjaxExportList [] = 'wfVoteStarsMulti';
function wfVoteStarsMulti($vote_value,$page_id,$mk){
	global $wgRequest, $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 
	
	$Vote = new VoteStars($page_id);
	if($Vote->UserAlreadyVoted()){
		$Vote->delete();
	}
	$Vote->insert($vote_value);
	
	return $Vote->displayScore();
}

$wgAjaxExportList [] = 'wfVoteStarsDelete';
function wfVoteStarsDelete($page_id){
	global $wgRequest, $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 

	$Vote = new VoteStars($page_id);
	$Vote->delete();

	return $Vote->display();
}



?>
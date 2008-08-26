<?php
$wgExtensionFunctions[] = "wfComments";

function wfComments() {
    global $wgParser, $wgOut;
	
    $wgParser->setHook( "comments", "DisplayComments" );
}

function DisplayComments( $input ){
	global $wgUser, $wgTitle, $wgOut, $wgVoteDirectory;
	$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Comments/Comment.js\"></script>\n");
 
	require_once ('CommentClass.php');
	require_once ("$wgVoteDirectory/VoteClass.php");
	
	getValue($scorecard,$input,"Scorecard");
	getValue($allow,$input,"Allow");
	getValue($voting,$input,"Voting");
	getValue($title,$input,"title");
	getValue($userRating,$input,"userrating");
	$Comment = new Comment($wgTitle->mArticleID);
	$Comment->setUser($wgUser->mName,$wgUser->mId);
	$Comment->setAllow($allow);
	$Comment->setVoting($voting);
	$Comment->setTitle($title);
	$Comment->setBool("ShowScorecard",$scorecard);
	$Comment->setBool("ShowUserRating",$userRating);


	 if( ($_POST['commentid']) ){
		$Comment->setCommentID($_POST['commentid']);
		$Comment->delete();
	 }
	$output = $Comment->displayOrderForm();
	
	if($Comment->ShowScoreCard == 1){
	$output .=   "<div id=\"scorecard\"></div>";
	}
	
	$output .=   "<div id=\"allcomments\">" . $Comment->display() . "</div>";
	
	$output .= $Comment->diplayForm();
	
	if($Comment->ShowScoreCard == 1){
	$output .= $Comment->displayCommentScorecard($scorecard);
	}
	return $output; 
}
?>
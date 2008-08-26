<?php

$wgExtensionFunctions[] = 'wfSpecialVoteAction';


function wfSpecialVoteAction(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class VoteAction extends SpecialPage {

  function VoteAction(){
    UnlistedSpecialPage::UnlistedSpecialPage("VoteAction");
  }

  function execute(){
	  global $wgUser, $wgOut, $wgVoteDirectory, $wgCommentsDirectory, $IP; 
    
	require_once("$wgVoteDirectory/VoteClass.php");
	require_once ("$wgVoteDirectory/Publish.php");
	require_once ("$wgVoteDirectory/RSS.php");
	require_once ("$wgCommentsDirectory/CommentClass.php");
	
	if($_POST["mk"] == md5($_POST["pid"] . 'pants' .  $wgUser->getName() ) ){
		require_once ("$IP/extensions/UserStats/UserStatsClass.php");
		$stats = new UserStatsTrack(1,$wgUser->getID(), $wgUser->getName());
		
		if(($_GET["Action"]==1 || $_GET["Action"] == 2) && is_numeric($_POST["pid"]) && (is_numeric($_POST["TheVote"]) || $_GET["Action"] ==2)  ){
			//echo 'test2';
			$Vote = new Vote($_POST["pid"]);
			$Vote->setUser($wgUser->getName(),$wgUser->getID());
	
			if($_GET["Action"] == 1){
				$Vote->insert($_POST["TheVote"]);
				$stats->incVoteCount();
			}else{
				$Vote->delete();
			}

			$CommentList = new Comment($_POST["pid"]);
			
			$publish = new Publish();
			$publish->PageID = $_POST["pid"];
			$publish->VoteCount = $Vote->count(1);
			$publish->CommentCount = $CommentList->count();
			$publish->check_score();
			
			echo $Vote->count(1);
		}
	 
		if($_GET["Action"] == 5){
			$Vote = new VoteStars($_POST["pid"]);
			$Vote->setUser($wgUser->getName(),$wgUser->getID());
			if($Vote->UserAlreadyVoted()){
				$Vote->delete();
			}
			$Vote->insert($_POST["TheVote"]);
			$stats->incVoteCount();
			echo $Vote->displayScore();
		}
		
		if($_GET["Action"] == 6){
			$Vote = new VoteStars($_POST["pid"]);
			$Vote->setUser($wgUser->getName(),$wgUser->getID());
			$Vote->delete();
			echo $Vote->display();
		}
	}
	// This line removes the navigation and everything else from the
 	// page, if you don't set it, you get what looks like a regular wiki
 	// page, with the body you defined above.
 	$wgOut->setArticleBodyOnly(true);
  }

}

 SpecialPage::addPage( new VoteAction );
 global $wgMessageCache,$wgOut;
 $wgMessageCache->addMessage( 'voteaction', 'just a test extension' );
 


}

?>
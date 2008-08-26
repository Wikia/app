<?php

$wgExtensionFunctions[] = 'wfSpecialCommentAction';

function wfSpecialCommentAction(){
	
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");

	class CommentListGet extends UnlistedSpecialPage {
	
		function CommentListGet(){
			UnlistedSpecialPage::UnlistedSpecialPage("CommentListGet");
		}
		
		function execute(){
			global $wgUser, $wgOut, $wgVoteDirectory, $IP; 
		 
			
			require_once ('CommentClass.php');
			
			// get new Comment list
			if(  is_numeric($_GET["pid"]) ){
			$Comment = new Comment($_GET["pid"]);
			$Comment->setUser($wgUser->mName,$wgUser->mId);
			$Comment->setOrderBy($_GET["ord"]);
			if($_POST["shwform"] == 1)$output .= $Comment->displayOrderForm();
			$output .= $Comment->display();
			if($_POST["shwform"] == 1)$output .= $Comment->diplayForm();
			 
			}
			$wgOut->addHTML($output);
			$wgOut->setArticleBodyOnly(true);
		}

	}

	SpecialPage::addPage( new CommentListGet );
}

?>
<?php

$wgHooks['ArticleSaveComplete'][] = 'wfInviteFriendToEdit';
$wgHooks['ArticleInsertComplete'][] = 'wfCreateOpinionCheck';
$wgHooks['OutputPageBeforeHTML'][] = 'wfInviteRedirect';

function wfInviteFriendToEdit(&$article, &$user, &$text, &$summary, &$minoredit, &$watchthis, &$sectionanchor, &$flags){
	global $wgOut, $wgTitle, $wgArticle, $wgUser;
	
	if(!$flags & EDIT_NEW){
		//increment edits for this page by one (for this user's session)
		$edits_views = $_SESSION["edits_views"];
		$page_edits_views = $edits_views[$article->getID()];
		$edits_views[$article->getID()] = ($page_edits_views + 1);
	
		$_SESSION["edits_views"] = $edits_views;
	}
	return true;
}

function wfCreateOpinionCheck(&$article, &$user, &$text, &$summary, &$minoredit, &$watchthis, &$sectionanchor, &$flags){
	global $wgOut, $wgTitle, $wgArticle, $wgUser, $wgRequest, $wgSendNewArticleToFriends;
	
	if($wgSendNewArticleToFriends){
		//If the user has created a new opinion, we want to turn on a session flag
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT cl_to FROM " . $dbr->tableName( 'categorylinks' ) . "  WHERE cl_from=" . $wgTitle->mArticleID;
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			if(   strtoupper($row->cl_to) == "OPINIONS" ) {
				 $_SESSION["new_opinion"] = $wgTitle->getText();
			}
		}
	}
	return true;
}

function wfInviteRedirect(){
	global $wgOut, $wgTitle, $wgArticle, $wgUser, $wgRequest, $wgSendNewArticleToFriends;
	if($wgSendNewArticleToFriends){
		if(isset($_SESSION["new_opinion"])){
			$invite =  Title::makeTitle( NS_SPECIAL  , "EmailNewArticle"  );
			$wgOut->redirect( $invite->getFullURL() . "&page=" . $_SESSION["new_opinion"] );
			unset($_SESSION["new_opinion"]);
		}
	}
}
?>
<?php
$wgExtensionFunctions[] = "wfVote";

function wfVote() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "vote", "RenderVote" );
}

function RenderVote( $input ){
	global $wgUser, $wgTitle, $wgOut;
	$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Vote-Mag/Vote.js\"></script>\n");
	require_once ('VoteClass.php');
	
	getValue($type,$input,"type");
	switch ($type) {
	case 0:
		$Vote = new Vote($wgTitle->mArticleID);
		break;
	case 1:
		$Vote = new VoteStars($wgTitle->mArticleID);
		break;
	default:
		$Vote = new Vote($wgTitle->mArticleID);
	}
	
	$Vote->setUser($wgUser->mName,$wgUser->mId);
	$output = $Vote->display();
	return $output; 
}
?>
<?php
$wgExtensionFunctions[] = "wfVote";
$wgExtensionFunctions[] = 'wfVoteReadLang';

function wfVote() {
    global $wgParser, $wgOut;
    //wfLoadAllExtensions();
    $wgParser->setHook( "vote", "RenderVote" );
}

function RenderVote( $input, $args, &$parser ){
	global $wgUser, $wgTitle, $wgOut, $wgStyleVersion;
	
	wfProfileIn(__METHOD__);
	
	//$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/wikia/Vote/Vote.js?{$wgStyleVersion}\"></script>\n");

	$wgOut->addHTML("<script type=\"text/javascript\">
	var _VOTE_LINK = \"" . wfMsgForContent( 'vote_link' ) . "\"
	var _UNVOTE_LINK = \"" . wfMsgForContent( 'vote_unvote_link' ) . "\"
	</script>
	");
		
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
	$output = $Vote->display();
	wfProfileOut(__METHOD__);
	
	return $output; 
}

//read in localisation messages
function wfVoteReadLang(){
	global $wgMessageCache, $IP, $wgVoteDirectory;
	require_once ( "$wgVoteDirectory/Vote.i18n.php" );
	foreach( efWikiaVote() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}

$wgHooks['UserRename::Local'][] = "VoteUserRenameLocal";

function VoteUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'Vote',
		'userid_column' => 'vote_user_id',
		'username_column' => 'username',
	);
	return true;
}


?>

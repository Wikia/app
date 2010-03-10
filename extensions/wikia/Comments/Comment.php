<?php
$wgComments = true;
$wgCommentsLog = false;
$wgExtensionFunctions[] = "wfComments";
$wgExtensionMessagesFiles['Comment'] = dirname(__FILE__).'/Comments.i18n.php';
$wgExtensionMessagesFiles['CommentLog'] = dirname(__FILE__).'/CommentLog.i18n.php';

function wfComments() {
    global $wgParser, $wgOut, $wgCommentsLog;

	wfLoadExtensionMessages('Comment');

    if( $wgCommentsLog ){
		# Add a new log type
		global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;

		wfLoadExtensionMessages('CommentLog');

		$wgLogTypes[]                      = 'comments';
		$wgLogNames['comments']            = 'commentslogpage';
		$wgLogHeaders['comments']          = 'commentslogpagetext';
		$wgLogActions['comments/comments'] = 'commentslogentry';
    }

    $wgParser->setHook( "comments", "DisplayComments" );
}

function DisplayComments( $input , $args, &$parser ){
	global $wgUser, $wgTitle, $wgOut, $wgVoteDirectory, $wgReadOnly, $wgStyleVersion;

	wfProfileIn(__METHOD__);

	//$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/wikia/Comments/Comment.js?{$wgStyleVersion}\"></script>\n");
	$parser->disableCache();

	$wgOut->addHTML("<script type=\"text/javascript\">
				var _COMMENT_VOTED = \"" . wfMsgForContent( 'comment_voted_label' ) . "\"
				var _COMMENT_LOADING = \"" . wfMsgForContent( 'comment_loading' ) . "\"
				var _COMMENT_PAUSE_REFRESHER = \"" . wfMsgForContent( 'comment_pause_auto_refresher' ) . "\"
				var _COMMENT_ENABLE_REFRESHER = \"" . wfMsgForContent( 'comment_enable_auto_refresher' ) . "\"
				var _COMMENT_REFRESHER = \"" . wfMsgForContent( 'comment_auto_refresher' ) . "\"
				var _COMMENT_CANCEL_REPLY = \"" . wfMsgForContent( 'comment_cancel_reply' ) . "\"
				var _COMMENT_REPLY_TO = \"" . wfMsgForContent( 'comment_reply_to' ) . "\"
				var _COMMENT_BLOCK_WARNING = \"" . wfMsgForContent( 'comment_block_warning' ) . "\"
				var _COMMENT_BLOCK_ANON = \"" . wfMsgForContent( 'comment_block_anon' ) . "\"
				var _COMMENT_BLOCK_USER = \"" . wfMsgForContent( 'comment_block_user' ) . "\"
			</script>
			");

	getValue($allow,$input,"Allow");
	getValue($voting,$input,"Voting");
	getValue($title,$input,"title");

	$Comment = new Comment($wgTitle->mArticleID);
	$Comment->setAllow($allow);
	$Comment->setVoting($voting);
	$Comment->setTitle($title);

	if( !empty($_POST['commentid']) ){
		$Comment->setCommentID($_POST['commentid']);
		$Comment->delete();
	}
	//$output = $Comment->displayOrderForm();

	$output =   "<div id=\"allcomments\">" . $Comment->display() . "</div>";

	if(!$wgReadOnly){
		$output .= $Comment->diplayForm();
	}else{
		$output .= wfMsgForContent( 'comments_db_locked');
	}

	wfProfileOut(__METHOD__);

	return $output;
}

?>

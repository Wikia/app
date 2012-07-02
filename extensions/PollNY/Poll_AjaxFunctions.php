<?php
/**
 * AJAX functions used by PollNY extension.
 */
$wgAjaxExportList[] = 'wfPollTitleExists';
function wfPollTitleExists( $pageName ) {
	// Construct page title object to convert to database key
	$pageTitle = Title::makeTitle( NS_MAIN, urldecode( $pageName ) );
	$dbKey = $pageTitle->getDBKey();

	// Database key would be in page title if the page already exists
	$dbr = wfGetDB( DB_MASTER );
	$s = $dbr->selectRow(
		'page',
		array( 'page_id' ),
		array( 'page_title' => $dbKey, 'page_namespace' => NS_POLL ),
		__METHOD__
	);
	if ( $s !== false ) {
		return 'Page exists';
	} else {
		return 'OK';
	}
}

$wgAjaxExportList[] = 'wfPollVote';
function wfPollVote( $pollID, $choiceID ) {
	global $wgUser;

	$p = new Poll();
	if( !$p->userVoted( $wgUser->getName(), $pollID ) ) {
		$p->addPollVote( $pollID, $choiceID );
	}
	return 'OK';
}

$wgAjaxExportList[] = 'wfGetRandomPoll';
function wfGetRandomPoll() {
	global $wgUser;

	$p = new Poll();

	$pollPage = $p->getRandomPollURL( $wgUser->getName() );
	return $pollPage;
}

$wgAjaxExportList[] = 'wfUpdatePollStatus';
function wfUpdatePollStatus( $pollID, $status ) {
	global $wgUser;

	$p = new Poll();
	if(
		$status == 2 ||
		$p->doesUserOwnPoll( $wgUser->getID(), $pollID ) ||
		$wgUser->isAllowed( 'polladmin' )
	) {
		$p->updatePollStatus( $pollID, $status );
		return 'Status successfully changed';
	} else {
		return 'error';
	}
}

$wgAjaxExportList[] = 'wfDeletePoll';
function wfDeletePoll( $pollID ) {
	global $wgUser;

	if( !$wgUser->isAllowed( 'polladmin' ) ) {
		return '';
	}

	if( $pollID > 0 ) {
		$dbw = wfGetDB( DB_MASTER );
		$s = $dbw->selectRow(
			'poll_question',
			array( 'poll_page_id' ),
			array( 'poll_id' => intval( $pollID ) ),
			__METHOD__
		);

		if( $s !== false ) {
			$dbw->delete(
				'poll_user_vote',
				array( 'pv_poll_id' => intval( $pollID ) ),
				__METHOD__
			);

			$dbw->delete(
				'poll_choice',
				array( 'pc_poll_id' => intval( $pollID ) ),
				__METHOD__
			);

			$dbw->delete(
				'poll_question',
				array( 'poll_page_id' => $s->poll_page_id ),
				__METHOD__
			);

			$pollTitle = Title::newFromId( $s->poll_page_id );
			$article = new Article( $pollTitle );
			$article->doDeleteArticle( 'delete poll' );
		}
	}
	return 'OK';
}

$wgAjaxExportList[] = 'wfGetPollResults';
function wfGetPollResults( $pageID ) {
	global $wgScriptPath;

	$p = new Poll();
	$poll_info = $p->getPoll( $pageID );
	$x = 1;

	$output = '';
	foreach( $poll_info['choices'] as $choice ) {
		//$percent = round( $choice['votes'] / $poll_info['votes'] * 100 );
		if( $poll_info['votes'] > 0 ) {
			$bar_width = floor( 480 * ( $choice['votes'] / $poll_info['votes'] ) );
		}
		$bar_img = "<img src=\"{$wgScriptPath}/extensions/PollNY/images/vote-bar-{$x}.gif\" border=\"0\" class=\"image-choice-{$x}\" style=\"width:{$choice['percent']}%;height:12px;\"/>";

		$output .= "<div class=\"poll-choice\">
		<div class=\"poll-choice-left\">{$choice['choice']} ({$choice['percent']}%)</div>";

		$output .= "<div class=\"poll-choice-right\">{$bar_img} <span class=\"poll-choice-votes\">"
			. wfMsgExt( 'poll-votes', 'parsemag', $choice['votes'] ) .
		'</span></div>';
		$output .= '</div>';

		$x++;
	}
	return $output;
}
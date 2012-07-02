<?php
/**
 * AJAX functions used by Vote extension.
 */
$wgAjaxExportList[] = 'wfVoteClick';

function wfVoteClick( $voteValue, $pageId ) {
	global $wgUser;

	if ( !$wgUser->isAllowed( 'vote' ) ) {
		return '';
	}

	if( is_numeric( $pageId ) && ( is_numeric( $voteValue ) ) ) {
		$vote = new Vote( $pageId );
		$vote->insert( $voteValue );

		return $vote->count( 1 );
	} else {
		return 'error';
	}
}

$wgAjaxExportList[] = 'wfVoteDelete';
function wfVoteDelete( $pageId ) {
	global $wgUser;

	if ( !$wgUser->isAllowed( 'vote' ) ) {
		return '';
	}

	if( is_numeric( $pageId ) ) {
		$vote = new Vote( $pageId );
		$vote->delete();

		return $vote->count( 1 );
	} else {
		return 'error';
	}
}

$wgAjaxExportList[] = 'wfVoteStars';
function wfVoteStars( $voteValue, $pageId ) {
	global $wgUser;

	if ( !$wgUser->isAllowed( 'vote' ) ) {
		return '';
	}

	$vote = new VoteStars( $pageId );
	if( $vote->UserAlreadyVoted() ) {
		$vote->delete();
	}
	$vote->insert( $voteValue );

	return $vote->display( $voteValue );
}

$wgAjaxExportList[] = 'wfVoteStarsMulti';
function wfVoteStarsMulti( $voteValue, $pageId ) {
	global $wgUser;

	if ( !$wgUser->isAllowed( 'vote' ) ) {
		return '';
	}

	$vote = new VoteStars( $pageId );
	if( $vote->UserAlreadyVoted() ) {
		$vote->delete();
	}
	$vote->insert( $voteValue );

	return $vote->displayScore();
}

$wgAjaxExportList[] = 'wfVoteStarsDelete';
function wfVoteStarsDelete( $pageId ) {
	global $wgUser;

	if ( !$wgUser->isAllowed( 'vote' ) ) {
		return '';
	}

	$vote = new VoteStars( $pageId );
	$vote->delete();

	return $vote->display();
}
<?php
/**
 * Comments of the Day parser hook -- shows the five newest comments that have
 * been sent within the last 24 hours.
 *
 * @file
 * @ingroup Extensions
 * @date 5 August 2011
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

$wgHooks['ParserFirstCallInit'][] = 'wfCommentsOfTheDay';

/**
 * Register the new <commentsoftheday /> parser hook with the Parser.
 *
 * @param $parser Parser: instance of Parser (not necessarily $wgParser)
 * @return Boolean: true
 */
function wfCommentsOfTheDay( &$parser ) {
	$parser->setHook( 'commentsoftheday', 'getCommentsOfTheDay' );
	return true;
}

/**
 * Get comments of the day -- five newest comments within the last 24 hours
 *
 * @return String: HTML
 */
function getCommentsOfTheDay( $input, $args, $parser ) {
	global $wgMemc, $wgUploadPath;

	$oneDay = 60 * 60 * 24;

	// Try memcached first
	$key = wfMemcKey( 'comments-of-the-day', 'standalone-hook' );
	$data = $wgMemc->get( $key );

	if( $data ) { // success, got it from memcached!
		$commentsOfTheDay = $data;
	} elseif ( !$data || $args['nocache'] ) { // just query the DB
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			array( 'Comments', 'page' ),
			array(
				'Comment_Username', 'comment_ip', 'comment_text',
				'comment_date', 'Comment_user_id', 'CommentID',
				'IFNULL(Comment_Plus_Count - Comment_Minus_Count,0) AS Comment_Score',
				'Comment_Plus_Count AS CommentVotePlus',
				'Comment_Minus_Count AS CommentVoteMinus',
				'Comment_Parent_ID', 'page_title', 'page_namespace'
			),
			array(
				'comment_page_id = page_id',
				'UNIX_TIMESTAMP(comment_date) > ' . ( time() - ( $oneDay ) )
			),
			__METHOD__,
			array( 'ORDER BY' => '(Comment_Plus_Count) DESC', 'LIMIT' => 5 )
		);

		$commentsOfTheDay = array();
		foreach ( $res as $row ) {
			$commentsOfTheDay[] = array(
				'username' => $row->Comment_Username,
				'userid' => $row->Comment_user_id,
				'score' => $row->CommentVotePlus,
				'text' => $row->comment_text,
				'id' => $row->CommentID,
				'pagens' => $row->page_namespace,
				'pagetitle' => $row->page_title
			);
		}

		$wgMemc->set( $key, $commentsOfTheDay, $oneDay );
	}

	$comments = '';

	foreach ( $commentsOfTheDay as $commentOfTheDay ) {
		$title2 = Title::makeTitle(
			$commentOfTheDay['pagens'],
			$commentOfTheDay['pagetitle']
		);

		if( $commentOfTheDay['userid'] != 0 ) {
			$title = Title::makeTitle( NS_USER, $commentOfTheDay['username'] );
			$commentPoster_Display = $commentOfTheDay['username'];
			$commentPoster = '<a href="' . $title->getFullURL() .
				'" title="' . $title->getText() . '" rel="nofollow">' .
				$commentOfTheDay['username'] . '</a>';
			$avatar = new wAvatar( $commentOfTheDay['userid'], 's' );
			$commentIcon = $avatar->getAvatarImage();
		} else {
			$commentPoster_Display = wfMsg( 'comment-anon-name' );
			$commentPoster = wfMsg( 'comment-anon-name' );
			$commentIcon = 'default_s.gif';
		}

		$comment_text = substr( $commentOfTheDay['text'], 0, 50 - strlen( $commentPoster_Display ) );
		if( $comment_text != $commentOfTheDay['text'] ) {
			$comment_text .= wfMsg( 'ellipsis' );
		}

		$comments .= '<div class="cod">';
		$sign = '';
		if ( $commentOfTheDay['score'] > 0 ) {
			$sign = '+';
		} elseif ( $commentOfTheDay['score'] < 0 ) {
			$sign = '-'; // this *really* shouldn't be happening...
		}
		$comments .= '<span class="cod-score">' . $sign . $commentOfTheDay['score'] .
			'</span> <img src="' . $wgUploadPath . '/avatars/' . $commentIcon .
			'" alt="" align="middle" style="margin-bottom:8px;" border="0"/>
			<span class="cod-poster">' . $commentPoster . '</span>';
		$comments .= '<span class="cod-comment"><a href="' .
			$title2->getFullURL() . '#comment-' . $commentOfTheDay['id'] .
			'" title="' . $title2->getText() . '">' . $comment_text .
			'</a></span>';
		$comments .= '</div>';
	}

	$output = '';
	if ( !empty( $comments ) ) {
		$output .= $comments;
	} else {
		$output .= wfMsg( 'comments-no-comments-of-day' );
	}

	return $output;
}
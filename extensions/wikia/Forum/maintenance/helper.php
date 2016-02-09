<?php

/**
* Maintenance script to collect comment data and insert into comments_index table
* @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
*/

// get parent page
function getParentPage( $articleComment ) {
	$titleText = $articleComment->getTitle()->getDBkey();
	$parts = explode( '/@', $titleText );
	$titleText = $parts[0];
	$namespace = MWNamespace::getSubject( $articleComment->getTitle()->getNamespace() );
	$title = Title::newFromText( $titleText, $namespace );

	if ( $title instanceof Title ) {
		// create message wall if not exist
		if ( !$title->exists() && $namespace == NS_USER_WALL ) {
			$title = WallMessage::addMessageWall( $title );
			echo ".....Wall message NOT found.\n\tAdded wall message '$titleText' (" . $title->getArticleID() . ")";
			return $title->getArticleId();
		}
	}

	return 	$title->getArticleID();
}

// get comment properties
function getCommentProperties( $articleComment ) {
	$properties = array();
	if ( $articleComment->getTitle()->getNamespace() == NS_USER_WALL_MESSAGE
			|| $articleComment->getTitle()->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {
		$wallMessage = WallMessage::newFromArticleComment( $articleComment );
		$properties = array(
			'archived' => intval( $wallMessage->isArchive() ),
			'deleted' => intval( $wallMessage->isAdminDelete() ),
			'removed' => intval( $wallMessage->isRemove() ),
		);
	}

	return $properties;
}

function getLastChildCommentId( $articleComment ) {
	$db = wfGetDB( DB_MASTER );
	$row = $db->selectRow(
		array( 'page', 'page_wikia_props' ),
		array( 'max(page.page_id) last_comment_id' ),
		array(
			'page_wikia_props.page_id is NULL',
			'page.page_namespace' => $articleComment->getTitle()->getNamespace(),
			'page.page_title ' . $db->buildLike( sprintf( "%s/%s", $articleComment->getTitle()->getDBkey(), ARTICLECOMMENT_PREFIX ), $db->anyString() ),
		),
		__METHOD__,
		array(),
		array(
			'page_wikia_props' => array(
				'LEFT JOIN',
				array(
					'page.page_id' => 'page_wikia_props.page_id',
					'page_wikia_props.propname in (' . WPP_WALL_ARCHIVE . ',' . WPP_WALL_REMOVE . ',' . WPP_WALL_ADMINDELETE . ')',
					'page_wikia_props.props' => serialize( 1 )
				)
			)
		)
	);

	$lastCommentId = 0;
	if ( $row ) {
		$lastCommentId = $row->last_comment_id;
	}

	return $lastCommentId;
}

// insert data into commnets_index table
function insertIntoCommentsIndex( $parentPageId, $articleComment, $parentCommentId = 0, $lastChildCommentId = 0 ) {
	global $isDryrun;

	$data = array(
		'parentPageId' => $parentPageId,
		'commentId' => $articleComment->getTitle()->getArticleID(),
		'parentCommentId' => intval( $parentCommentId ),
		'lastChildCommentId' => intval( $lastChildCommentId ),
		'firstRevId' => $articleComment->mFirstRevId,
		'createdAt' => $articleComment->mFirstRevision->getTimestamp(),
		'lastTouched' => $articleComment->mLastRevision->getTimestamp(),
		'lastRevId' => $articleComment->mLastRevId,
	);

	$data = array_merge( $data, getCommentProperties( $articleComment ) );
	$commentsIndex = new CommentsIndex( $data );

	if ( !$isDryrun ) {
		$commentsIndex->addToDatabase();
	}

	return true;
}
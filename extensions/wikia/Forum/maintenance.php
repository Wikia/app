<?php

	/**
	* Maintenance script to collect comment data and insert into comments_index table
	* @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
	*/

	// get parent page
	function getParentPage( $articleComment ) {
		$titleText = $articleComment->getTitle()->getDBkey();
		$parts = explode('/@', $titleText);
		$titleText = $parts[0];
		$namespace = MWNamespace::getSubject( $articleComment->getTitle()->getNamespace() );
		$title = Title::newFromText( $titleText, $namespace );

		$parentPage = null;
		if( $title instanceof Title ) {
			// create message wall if not exist
			if ( !$title->exists() && $namespace == NS_USER_WALL ) {
				$title = WallMessage::addMessageWall( $title );
				echo ".....Wall message NOT found.\n\tAdded wall message '$titleText' (".$title->getArticleID().")";
			}
			$parentPage = ArticleComment::newFromTitle( $title );
		}

		return $parentPage;
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
		$db = F::App()->wf->GetDB( DB_MASTER );
		$row = $db->selectRow(
			array( 'page', 'page_wikia_props' ),
			array( 'max(page.page_id) last_comment_id' ),
			array(
				'page_wikia_props.page_id is NULL',
				'page.page_namespace' => $articleComment->getTitle()->getNamespace(),
				'page.page_title '.$db->buildLike( sprintf( "%s/%s", $articleComment->getTitle()->getDBkey(), ARTICLECOMMENT_PREFIX ), $db->anyString() ),
			),
			__METHOD__,
			array(),
			array(
				'page_wikia_props' => array(
					'LEFT JOIN',
					array(
						'page.page_id' => 'page_wikia_props.page_id',
						'page_wikia_props.propname in ('.WPP_WALL_ARCHIVE.','.WPP_WALL_REMOVE.','.WPP_WALL_ADMINDELETE.')',
						'page_wikia_props.props' => serialize(1)
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

		$data = array_merge($data, getCommentProperties($articleComment) );
		$commentsIndex = F::build( 'CommentsIndex', array($data) );
		$commentsIndex->addToDatabase();

		return true;
	}

	// ------------------------------------------- Main -------------------------------------------------

	ini_set( "include_path", dirname( __FILE__ )."/../../../maintenance/" );

	require_once( "commandLine.inc" );

	$app = F::app();
	if ( empty($app->wg->CityId) ) {
		die( "Error: Invalid wiki id." );
	}

	if ( $app->wf->ReadOnly() ) {
		die( "Error: In read only mode." );
	}

	echo "Wiki $wgCityId:\n";

	// create table or patch table schema
	$commentsIndex = F::build( 'CommentsIndex' );
	$commentsIndex->patchTableCommentsIndexV1();

	echo "Updated database schema for comment_index table.\n";

	$db = $app->wf->GetDB( DB_MASTER );

	// clear data in the table
	$db->delete( 'comments_index', '*' );

	echo "Removed data from comments_index table.\n";

	// get min/max comments
	$row = $db->selectRow(
		array( 'page' ),
		array( 'min(page_id) min_id, max(page_id) max_id' ),
		array(
			'page.page_title '.$db->buildLike( $db->anyString(), sprintf( "/%s", ARTICLECOMMENT_PREFIX ), $db->anyString() ),
			'page_latest > 0'	// BugId:22821
		),
		__METHOD__
	);

	$fromId = 0;
	$maxId = 0;
	if ($row) {
		$fromId = intval( $row->min_id );
		$maxId = intval( $row->max_id );
	}

	if ( $fromId > 0 ) {
		$fromId = $fromId - 1;
	}

	$cnt = 0;
	$failed = 0;
	$range = 1000;
	while( $fromId <= $maxId ) {
		$toId = ( ($fromId + $range) < $maxId ) ? $fromId + $range : $maxId ;
		echo "LOOP: From ID $fromId to ID $toId (Max ID = $maxId).\n";

		// get comment list
		$result = $db->select(
			array( 'page' ),
			array( 'page_id',
				'page_title',
				'page_namespace',
				'page_len',
				'page_is_redirect',
				'page_latest'
			),
			array(
				'page_id > '.$fromId,
				'page_id <= '.$toId,
				'page.page_title '.$db->buildLike( $db->anyString(), sprintf( "/%s", ARTICLECOMMENT_PREFIX ), $db->anyString() ),
				'page_latest > 0'	// BugId:22821
			),
			__METHOD__,
			array( 'ORDER BY' => 'page_id ASC' )
		);

		$commentList = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$commentList[$row->page_id] = $row;
		}
		$db->freeResult( $result );

		// collect and insert data
		foreach ( $commentList as $comment ) {
			$cnt++;
			echo "$cnt [$fromId-$toId]: ID $comment->page_id(NS $comment->page_namespace): $comment->page_title";

			$title = F::build( 'Title' , array( $comment ), 'newFromRow' );
			$articleComment = F::build( 'ArticleComment', array( $title ), 'newFromTitle' );
			$articleComment->load();

			// parent page id
			$parentPage = getParentPage( $articleComment );
			if ( !$parentPage instanceof ArticleComment ) {
				echo ".....Parent page NOT found.\n";
				$failed++;
				continue;
			}
			$parentPageId = $parentPage->getTitle()->getArticleID();

			// get parent comment id
			$parentCommentObj = $articleComment->getTopParentObj();
			if ( $parentCommentObj instanceof ArticleComment ) { // posts/replies
				$parentCommentId = $parentCommentObj->getTitle()->getArticleID();
				$lastChildCommentId = 0;
			} else { // main comments
				$parentCommentId = 0;
				$lastChildCommentId = getLastChildCommentId( $articleComment );
			}

			// insert main comment
			insertIntoCommentsIndex( $parentPageId, $articleComment, $parentCommentId, $lastChildCommentId );
			echo ".....DONE.\n";
		}

		$fromId += $range;
	}

	echo "TOTAL: ".$cnt.", SUCCESS: ".($cnt-$failed).", FAILED: $failed\n\n";
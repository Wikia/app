<?php

class DatabaseForumActivityService implements ForumActivityService {
	const POST_FETCH_COUNT = 5;

	public function getRecentlyUpdatedThreads(): array {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			[
				'page',
				'comments_index',
				'thread_rev' => 'revision',
				'last_comment_page' => 'page',
				'last_comment_rev' => 'revision'
			],
			[
				'page.page_id AS page_id',
				'page.page_namespace AS page_namespace',
				'page.page_title AS page_title',
				'thread_rev.rev_text_id AS thread_text_id',
				'thread_rev.rev_user AS thread_author_id',
				'thread_rev.rev_user_text AS thread_author_name',
				'thread_rev.rev_timestamp AS thread_modified_timestamp',
				'last_comment_rev.rev_user AS last_comment_author_id',
				'last_comment_rev.rev_user_text AS last_comment_author_name',
				'last_comment_rev.rev_timestamp AS last_comment_timestamp'
			],
			[
				'page.page_namespace' => NS_WIKIA_FORUM_BOARD_THREAD,
				'archived' => 0,
				'deleted' => 0,
				'removed' => 0,
				// only fetch threads, not replies
				'parent_comment_id' => 0,
				// check added so that the query planner can use proper index
				'parent_page_id != 0'
			],
			__METHOD__,
			[
				'LIMIT' => static::POST_FETCH_COUNT,
				'ORDER BY' => 'last_touched DESC'
			],
			[
				'comments_index' => [ 'INNER JOIN', 'page.page_id = comment_id' ],
				'last_comment_page' => [ 'INNER JOIN', 'last_comment_page.page_id = last_child_comment_id' ],
				'last_comment_rev' => [ 'INNER JOIN', 'last_comment_rev.rev_id = last_comment_page.page_latest' ],
				'thread_rev' => [ 'INNER JOIN', 'thread_rev.rev_id = page.page_latest' ],
			]
		);

		$postInfo = [];

		foreach ( $res as $row ) {
			$title = Title::newFromRow( $row );

			$threadRevision = new Revision( [
				'text_id' => $row->thread_text_id,
				'user' => $row->thread_author_id,
				'user_text' => $row->thread_author_name,
				'timestamp' => $row->thread_modified_timestamp
			] );
			$updateRevision = new Revision( [
				'user' => $row->last_comment_author_id,
				'user_text' => $row->last_comment_author_name,
				'timestamp' => $row->last_comment_timestamp
			] );

			// set comment text from already available revision
			// this avoids redundant query when fetching Wall meta title
			$articleComment = new ArticleComment( $title );
			$articleComment->setRawText( $threadRevision->getRawText() );

			$wallMessage = WallMessage::newFromArticleComment( $articleComment );

			// SUS-4084: If the thread revision timestamp is higher than that of the last comment,
			// then the thread was edited by the author and we should reflect that
			if ( $threadRevision->getTimestamp() > $updateRevision->getTimestamp() ) {
				$authorId = $threadRevision->getUser();
				$authorName = $threadRevision->getUserText();
				$eventTime = $threadRevision->getTimestamp();
			} else {
				$authorId = $updateRevision->getUser();
				$authorName = $updateRevision->getUserText();
				$eventTime = $updateRevision->getTimestamp();
			}

			if ( $authorId ) {
				$authorLink = Title::makeTitle( NS_USER, $authorName );
			} else {
				$authorLink = SpecialPage::getTitleFor( 'Contributions', $authorName );
			}

			$postInfo[] = [
				'authorId' => $authorId,
				'authorName' => $authorName,
				'authorUrl' => $authorLink->getFullURL(),
				'threadUrl' => $wallMessage->getMessagePageUrl(),
				'threadTitle' => $wallMessage->getMetaTitle(),
				'timestamp' => $eventTime
			];
		}

		return $postInfo;
	}
}

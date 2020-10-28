<?php

/**
 * Handles hooks run on article deletes and undeletes
 *
 * @see SUS-1521
 */
class CommentsIndexHooks {

	/**
	 * Ensure that the comments_index record (if it exists) for an article that we're about to delete is marked with deleted = 1
	 *
	 * This event must be run inside the transaction in WikiPage::doDeleteArticleReal
	 * otherwise the Article referenced will no longer exist and the lookup for it's associated
	 * comments_index row will fail.
	 *
	 * @param WikiPage
	 * @param [not used]
	 * @param Title
	 * @param [not used]
	 * @param [not used]
	 * @return bool true
	 */
	static public function onArticleDoDeleteArticleBeforeLogEntry( WikiPage $page, $logtype, Title $title, $reason, $hookAddedLogEntry ) : bool {

		if ( $title->isTalkPage() && WallHelper::isWallNamespace( $title->getNamespace() ) ) {
			wfDebug(__METHOD__ . "\n\n");

			try {
				// we have either Wall message or Forum post - mark comments_index entry
				$wallMessage = WallMessage::newFromTitle( $title );
				$wallMessage->setInCommentsIndex( WPP_WALL_ADMINDELETE, 1 ); // set deleted = 1

				// invalidate message and thread cache
				$wallMessage->invalidateCache();
			} catch ( CommentsIndexEntryNotFoundException $notFoundException ) {
				// don't fail if comment was invalid
			}
		}

		return true;
	}

	/**
	 * When an article is undeleted, take the page id from before the delete ($oldPageId) and just update comment_id column
	 *
	 * @param Title $title
	 * @param $create
	 * @param $comment
	 * @param $oldPageId
	 */
	public static function onArticleUndelete( Title $title, $create, $comment, int $oldPageId ) : bool {

		if ( $title->isTalkPage() && WallHelper::isWallNamespace( $title->getNamespace() ) ) {
			wfDebug(__METHOD__ . "\n\n");

			// we have either Wall message or Forum post - update comments_index entry
			$wallMessage = WallMessage::newFromTitle( $title );
			$wallMessage->load(true);

			CommentsIndex::getInstance()->doRestore( $oldPageId, $wallMessage->getId() );

			// invalidate message and thread cache
			$wallMessage->invalidateCache();
		}

		return true;
	}

}

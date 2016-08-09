<?php

class QuickToolsHelper extends ContextSource {

	/**
	 * Get all pages that should be rolled back for a given user
	 *
	 * @param  string $user A name to check against rev_user_text
	 * @param  string $time Timestamp to revert since
	 * @return Array  An array of page titles to revert
	 */
	public function getRollbackTitles( $user, $time ) {
		$dbr = wfGetDB( DB_SLAVE );

		$titles = [];
		$where = [
			'rev_page = page_id',
			'page_latest = rev_id',
		];

		if ( IP::isIPAddress( $user ) ) {
			$where['rev_user_text'] = $user;
		} else {
			$where['rev_user'] = User::idFromName( $user );
		}

		if ( $time !== '' ) {
			$time = $dbr->addQuotes( $time );
			$where[] = "rev_timestamp >= {$time}";
		}

		$results = $dbr->select(
			[ 'page', 'revision' ],
			[ 'page_namespace', 'page_title' ],
			$where,
			__METHOD__,
			[
				'LIMIT' => 500,
			]
		);

		foreach ( $results as $row ) {
			$titles[] = Title::makeTitle( $row->page_namespace, $row->page_title );
		}

		return $titles;
	}

	/**
	 * Rollback edits and/or delete page creations by user
	 *
	 * @param  Title   $title The page name to perform reverts on
	 * @param  string  $user Username of user to revert
	 * @param  string  $time Timestamp to revert edits since
	 * @param  string  $summary Edit summary to give for reverts and deletions
	 * @param  boolean $rollback Whether or not to perform rollbacks (default: true)
	 * @param  boolean $delete Whether or not to perform deletions (default: true)
	 * @param  boolean $markBot Whether or not to mark rollbacks as bot edits through
	 *         the bot=1 URL parameter (default: false)
	 * @return boolean True on success, false on failure
	 */
	public function rollbackTitle(
		Title $title, $user, $time, $summary, $rollback = true, $delete = true, $markBot = false
	) {
		// build article object and find article id
		$article = new Article( $title );
		$pageId = $article->getID();

		// check if article exists
		if ( $pageId <= 0 ) {
			return false;
		}

		// find the newest edit done by other user
		$revertRevId = $this->getRevertId( $pageId, $user, $time );

		$result = false;

		if ( $revertRevId && $rollback ) { // found an edit by other user - reverting
			$result = $this->doRollback( $article, $revertRevId, $summary, $markBot );
		} elseif ( !$revertRevId && $delete ) { // no edits by other users - deleting page
			$result = $this->doDelete( $article, $summary );
		}

		return false;
	}

	/**
	 * Rollback a page to the given revision ID.
	 *
	 * @param  Article $article     Article to rollback
	 * @param  int     $revertRevId Revision ID to revert the article to
	 * @param  string  $summary     Edit summary for the revert
	 * @param  boolean $markBot     Whether or not the edit should be flagged as a bot
	 * @return boolean              Result of the rollback
	 */
	private function doRollback( Article $article, $revertRevId, $summary, $markBot = false ) {
		$revision = Revision::newFromId( $revertRevId );
		$text = $revision->getRawText();
		$flags = EDIT_UPDATE|EDIT_MINOR;
		if ( $this->getUser()->isAllowed( 'bot' ) || $markBot ) {
			$flags |= EDIT_FORCE_BOT;
		}
		$status = $article->doEdit( $text, $summary, $flags );

		return $status->isOK();
	}

	/**
	 * Delete an article or file.
	 *
	 * @param  Article $article Article or file page
	 * @param  string  $summary Summary for the deletion
	 * @return boolean          Result of the deletion
	 */
	private function doDelete( Article $article, $summary ) {
		$title = $article->getTitle();
		$file = $title->getNamespace() == NS_FILE ? wfLocalFile( $title ) : false;
		if ( $file ) {
			$oldimage = null; // Must be passed by reference
			$status = FileDeleteForm::doDelete( $title, $file, $oldimage, $summary, false )->isOK();
		} else {
			$status = $article->doDeleteArticle( $summary );
		}

		return $status;
	}

	/**
	 * Get the most recent edit to a page by a different user.
	 *
	 * @param  int         $pageId   ID of the page
	 * @param  string      $userName User who made the most recent edit
	 * @param  string      $time     Optionally a timestamp to get the last
	 *                               revision since
	 * @return int|boolean           The revision ID or false if the given user
	 *                               is the only one to have edited the page
	 */
	private function getRevertId( $pageId, $userName, $time ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'revision',
			[ 'rev_id', 'rev_user_text', 'rev_timestamp' ],
			[
				'rev_page' => $pageId,
			],
			__METHOD__,
			[
				'ORDER BY' => 'rev_id DESC',
			]
		);

		// Find the newest edit done by another user
		$revertRevId = false;

		foreach ( $res as $row ) {
			if ( $row->rev_user_text !== $userName || ( $time !== '' && $row->rev_timestamp < $time ) ) {
				$revertRevId = $row->rev_id;
				break;
			}
		}

		return $revertRevId;
	}
}

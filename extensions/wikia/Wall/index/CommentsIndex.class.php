<?php

/**
 * CommentsIndex Class
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */

class CommentsIndex {
	use \Wikia\Logger\Loggable;

	/** @var CommentsIndex $instance */
	private static $instance = null;

	/** @var CommentsIndexEntry[] $objectCache */
	private $objectCache = [];

	private function __construct() {
	}

	public static function getInstance(): CommentsIndex {
		if ( !( static::$instance instanceof CommentsIndex ) ) {
			static::$instance = new CommentsIndex();
		}

		return static::$instance;
	}

	/**
	 * Given a Comments Index Entry, update the corresponding row in DB.
	 *
	 * @param CommentsIndexEntry $entry
	 * @param DatabaseBase $dbw
	 * @return bool Whether database was successfully updated
	 */
	public function updateEntry( CommentsIndexEntry $entry, DatabaseBase $dbw = null ) {
		$dbw = $dbw ?? wfGetDB( DB_MASTER );

		$entry->setLastTouched( $dbw->timestamp() );

		$updateSuccess = $dbw->update(
			'comments_index',
			$entry->getDatabaseRepresentation(),
			[
				'parent_page_id' => $entry->getParentPageId(),
				'comment_id' => $entry->getCommentId()
			],
			__METHOD__
		);

		// If this update action changes visibility of comment,
		// update last_child_comment_id for parent thread
		if ( $updateSuccess && $this->shouldUpdateParentInfoFor( $entry ) ) {
			$parentId = $entry->getParentCommentId();

			$lastCommentId = $dbw->selectField(
				[ 'comments_index' ],
				'max(comment_id)',
				[
					'parent_comment_id' => $parentId,
					'archived' => 0,
					'removed' => 0,
					'deleted' => 0,
				],
				__METHOD__
			);

			$parentEntry = static::entryFromId( $parentId );
			$parentEntry->setLastChildCommentId( $lastCommentId );
			$updateSuccess &= $this->updateEntry( $parentEntry );
		}

		// store new entry in object cache
		$this->objectCache[$entry->getCommentId()] = $entry;
		return $updateSuccess;
	}

	public function doRestore( int $oldPageId, int $newPageId ): void {
		$entry = $this->entryFromId( $oldPageId );
		$entry->setCommentId( $newPageId );
		$entry->setDeleted( false );

		$dbw = wfGetDB( DB_MASTER );

		$dbw->update(
			'comments_index',
			$entry->getDatabaseRepresentation(),
			[ 'comment_id' => $oldPageId ],
			__METHOD__
		);

		$this->objectCache[$newPageId] = $entry;
	}

	/**
	 * Check if current update action has any changes which require updating child comment data for parent thread.
	 * If message visibility has changed (removal/deletion), we need to update parent thread to exclude it
	 *
	 * @param CommentsIndexEntry $entry new entry being inserted
	 * @return bool
	 */
	private function shouldUpdateParentInfoFor( CommentsIndexEntry $entry ): bool {
		$oldEntry = $this->objectCache[$entry->getCommentId()];
		if ( !( $oldEntry instanceof CommentsIndexEntry ) ) {
			return false;
		}

		return
			$entry->getParentCommentId() > 0 && (
				$entry->isArchived() != $oldEntry->isArchived() ||
				$entry->isDeleted() != $oldEntry->isDeleted()
			)
		;
	}

	/**
	 * Insert a new Comments Index Entry into database
	 * This assumes that wfReadOnly was called before and we're safe to write to master (see DAR-120 for details)
	 * This has to be performed within the same transaction used by MediaWiki to save corresponding article comment to database,
	 * to ensure data integrity.
	 *
	 * If this fails, transaction has to be rollbacked to prevent invalid data from being posted!
	 *
	 * @see https://wikia-inc.atlassian.net/browse/ZZZ-3225
	 * @param CommentsIndexEntry $entry
	 * @param DatabaseBase $db
	 * @return bool whether transaction succeeded
	 */
	public function insertEntry( CommentsIndexEntry $entry, DatabaseBase $db ): bool {
		$timestamp = $db->timestamp();

		if ( empty( $entry->getCreatedAt() ) ) {
			$entry->setCreatedAt( $timestamp );
		}

		if ( empty( $entry->getLastTouched() ) ) {
			$entry->setLastTouched( $timestamp );
		}

		if ( empty( $entry->getLastChildCommentId() ) ) {
			$entry->setLastChildCommentId( $entry->getCommentId() );
		}

		// cache the new instance so we won't have to query the db when we need it again during this request
		$this->objectCache[$entry->getCommentId()] = $entry;

		$status = $db->replace(
			'comments_index',
			null,
			$entry->getDatabaseRepresentation(),
			__METHOD__
		);

		if ( !$status ) {
			$this->error( 'Failed to insert comments index entry', $entry->getDatabaseRepresentation() );
			return false;
		}

		// update last_child_comment_id for parent thread
		if ( !empty( $entry->getParentCommentId() ) ) {
			$parentEntry = static::entryFromId( $entry->getParentCommentId() );
			$parentEntry->setLastChildCommentId( $entry->getCommentId() );
			$this->updateEntry( $parentEntry );
		}

		return true;
	}

	/**
	 * Return a single Comments Index Entry corresponding to the row in comments_index table with matching comment_id
	 *
	 * @param int $commentId
	 * @return CommentsIndexEntry
	 * @throws CommentsIndexEntryNotFoundException
	 */
	public function entryFromId( int $commentId ) {
		if ( isset( $this->objectCache[$commentId] ) ) {
			return $this->objectCache[$commentId];
		}

		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow( 'comments_index', '*', [ 'comment_id' => $commentId ], __METHOD__ );

		if ( !$row ) {
			$this->error( 'SUS-1680 - No match for comment id in comments_index', [
				'commentId' => $commentId
			] );

			throw new CommentsIndexEntryNotFoundException( $commentId );
		}

		$entry = CommentsIndexEntry::newFromRow( $row );
		$this->objectCache[$commentId] = $entry;

		return $entry;
	}

	/**
	 * get CommentsIndexEntry objects for a set of ids in a single database query
	 *
	 * @see SUS-262
	 *
	 * @param int[] $commentIds
	 * @return CommentsIndexEntry[]
	 */
	public function entriesFromIds( array $commentIds ) {

		// a shortcut that prevents "DatabaseBase::makeList: empty input" exception
		if ( count( $commentIds ) == 0 ) {
			return [];
		}

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'comments_index',
			'*',
			[ 'comment_id' => $commentIds ],
			__METHOD__
		);

		$comments = [];

		while ( $row = $res->fetchObject() ) {
			$comments[] = CommentsIndexEntry::newFromRow( $row );
		}

		return $comments;
	}

	/**
	 * Move a given thread to a different Message Wall or Forum Board
	 *
	 * @param int $threadId page id of thread to move
	 * @param int $targetPageId page id of destination page
	 */
	public function moveThread( int $threadId, int $targetPageId ) {
		$db = wfGetDB( DB_MASTER );

		$db->update(
			'comments_index',
			[ 'parent_page_id' => $targetPageId ],
			[ "parent_comment_id = $threadId OR comment_id = $threadId" ],
			__METHOD__
		);

		$db->commit( __METHOD__ );
	}

	/**
	 * Move all threads from a given Message Wall or Forum Board to a different one
	 * Used by Rename Tool and Forum Board renaming
	 *
	 * @param int $sourcePageId page id of source page
	 * @param int $targetPageId page id of destination page
	 */
	public function moveAllThreads( int $sourcePageId, int $targetPageId ) {
		$db = wfGetDB( DB_MASTER );

		$db->update(
			'comments_index',
			[ 'parent_page_id' => $targetPageId ],
			[ 'parent_page_id' => $sourcePageId ],
			__METHOD__
		);

		$db->commit( __METHOD__ );
	}

}

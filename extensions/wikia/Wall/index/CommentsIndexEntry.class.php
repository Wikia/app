<?php

/**
 * Class CommentsIndexEntry represents a single row in comments_index table.
 * Each property corresponds to a column in comments_index table
 *
 * @see CommentsIndexEntry::getDatabaseRepresentation()
 */
class CommentsIndexEntry {
	/** @var int $namespace */
	private $namespace = 0;
	/** @var int $parentPageId */
	private $parentPageId = 0;

	/** @var int $commentId */
	private $commentId = 0;
	/** @var int $parentCommentId */
	private $parentCommentId = 0;

	/** @var int $firstRevId */
	private $firstRevId = 0;
	/** @var int $lastRevId */
	private $lastRevId = 0;

	/** @var int $lastChildCommentId */
	private $lastChildCommentId = 0;

	/** @var bool $archived */
	private $archived = false;
	/** @var bool $deleted */
	private $deleted = false;
	/** @var bool $removed */
	private $removed = false;

	/** @var string $createdAt */
	private $createdAt = "";
	/** @var string $lastTouched */
	private $lastTouched = "";

	/**
	 * Populate and return CommentsIndexEntry instance from a DB result row as provided by Mediawiki.
	 * @param object $row
	 * @return CommentsIndexEntry
	 */
	public static function newFromRow( $row ): CommentsIndexEntry {
		return
			( new CommentsIndexEntry() )
				->setParentPageId( $row->parent_page_id )
				->setCommentId( $row->comment_id )
				->setParentCommentId( $row->parent_comment_id )
				->setLastChildCommentId( $row->last_child_comment_id )
				->setArchived( $row->archived )
				->setDeleted( $row->deleted )
				->setRemoved( $row->removed )
				->setFirstRevId( $row->first_rev_id )
				->setCreatedAt( $row->created_at )
				->setLastRevId( $row->last_rev_id )
				->setLastTouched( $row->last_touched )
		;
	}

	/**
	 * @return int
	 */
	public function getParentPageId(): int {
		return $this->parentPageId;
	}

	/**
	 * @param int $parentPageId
	 * @return CommentsIndexEntry
	 */
	public function setParentPageId( int $parentPageId ): CommentsIndexEntry {
		$this->parentPageId = $parentPageId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getLastChildCommentId(): int {
		return $this->lastChildCommentId;
	}

	/**
	 * @param int $lastChildCommentId
	 * @return CommentsIndexEntry
	 */
	public function setLastChildCommentId( int $lastChildCommentId ): CommentsIndexEntry {
		$this->lastChildCommentId = $lastChildCommentId;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isArchived(): bool {
		return $this->archived;
	}

	/**
	 * @param bool $archived
	 * @return CommentsIndexEntry
	 */
	public function setArchived( bool $archived ): CommentsIndexEntry {
		$this->archived = $archived;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isDeleted(): bool {
		return $this->deleted;
	}

	/**
	 * @param bool $deleted
	 * @return CommentsIndexEntry
	 */
	public function setDeleted( bool $deleted ): CommentsIndexEntry {
		$this->deleted = $deleted;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isRemoved(): bool {
		return $this->removed;
	}

	/**
	 * @param bool $removed
	 * @return CommentsIndexEntry
	 */
	public function setRemoved( bool $removed ): CommentsIndexEntry {
		$this->removed = $removed;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCreatedAt(): string {
		return $this->createdAt;
	}

	/**
	 * @param string $createdAt
	 * @return CommentsIndexEntry
	 */
	public function setCreatedAt( string $createdAt ): CommentsIndexEntry {
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLastTouched(): string {
		return $this->lastTouched;
	}

	/**
	 * @param string $lastTouched
	 * @return CommentsIndexEntry
	 */
	public function setLastTouched( string $lastTouched ): CommentsIndexEntry {
		$this->lastTouched = $lastTouched;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getNamespace(): int {
		return $this->namespace;
	}

	/**
	 * @param int $namespace
	 * @return CommentsIndexEntry
	 */
	public function setNamespace( int $namespace ): CommentsIndexEntry {
		$this->namespace = $namespace;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCommentId(): int {
		return $this->commentId;
	}

	/**
	 * @param int $commentId
	 * @return CommentsIndexEntry
	 */
	public function setCommentId( int $commentId ): CommentsIndexEntry {
		$this->commentId = $commentId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getParentCommentId(): int {
		return $this->parentCommentId;
	}

	/**
	 * @param int $parentCommentId
	 * @return CommentsIndexEntry
	 */
	public function setParentCommentId( int $parentCommentId ): CommentsIndexEntry {
		$this->parentCommentId = $parentCommentId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getFirstRevId(): int {
		return $this->firstRevId;
	}

	/**
	 * @param int $firstRevId
	 * @return CommentsIndexEntry
	 */
	public function setFirstRevId( int $firstRevId ): CommentsIndexEntry {
		$this->firstRevId = $firstRevId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getLastRevId(): int {
		return $this->lastRevId;
	}

	/**
	 * @param int $lastRevId
	 * @return CommentsIndexEntry
	 */
	public function setLastRevId( int $lastRevId ): CommentsIndexEntry {
		$this->lastRevId = $lastRevId;

		return $this;
	}

	/**
	 * Map the properties of this object to columns of comments_index table
	 * Returns associative array which can be passed straight to DB helper functions
	 * @return array
	 */
	public function getDatabaseRepresentation(): array {
		return [
			'parent_page_id' => $this->parentPageId,
			'comment_id' => $this->commentId,
			'parent_comment_id' => $this->parentCommentId,
			'last_child_comment_id' => $this->lastChildCommentId,
			'archived' => $this->archived,
			'deleted' => $this->deleted,
			'removed' => $this->removed,
			'first_rev_id' => $this->firstRevId,
			'created_at' => $this->createdAt,
			'last_rev_id' => $this->lastRevId,
			'last_touched' => $this->lastTouched,
		];
	}
}

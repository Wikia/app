<?php

class CommentsIndexTest extends WikiaBaseTest {
	/** @var int $parentId */
	private $parentId;
	/** @var int $commentId */
	private $commentId;
	/** @var CommentsIndexEntry $parentEntry */
	private $parentEntry;
	/** @var CommentsIndexEntry $entry */
	private $entry;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../Wall.setup.php';
		parent::setUp();

		$this->parentId = 1526;
		$this->commentId = 1686;
		$this->parentEntry = new CommentsIndexEntry();
		$this->parentEntry->setCommentId( $this->parentId );
		$this->entry = new CommentsIndexEntry();
		$this->entry
			->setCommentId( $this->commentId )
			->setParentCommentId( $this->parentId );
	}

	/**
	 * Verify that CommentsIndex populates its in memory cache with queried entry instances
	 */
	public function testCommentsIndexUsesInObjectCacheForEntries() {
		$dbMock = $this->getDatabaseMock( [ 'selectRow' ] );
		$dbMock->expects( $this->once() )
			->method( 'selectRow' )
			->willReturn( (object)( $this->entry->getDatabaseRepresentation() ) );

		$this->mockGlobalFunction( 'wfGetDB', $dbMock );

		$firstCall = CommentsIndex::getInstance()->entryFromId( $this->commentId );
		$secondCall = CommentsIndex::getInstance()->entryFromId( $this->commentId );

		$this->assertEquals( $firstCall->getCommentId(), $secondCall->getCommentId() );
	}

	/**
	 * Verify CommentsIndex updates its cached entry instances when an entry is updated
	 */
	public function testInObjectCacheIsUpdatedOnUpdate() {
		$dbMock = $this->getDatabaseMock( [ 'timestamp', 'update', 'selectField', 'selectRow' ] );
		$dbMock->expects( $this->exactly( 2 ) )
			->method( 'timestamp' )
			->willReturn( 'foo' );

		$dbMock->expects( $this->exactly( 2 ) )
			->method( 'update' )
			->willReturn( true );

		$dbMock->expects( $this->once() )
			->method( 'selectField' )
			->willReturn( 1456 );

		$dbMock->expects( $this->once() )
			->method( 'selectRow' )
			->willReturn( (object)$this->parentEntry->getDatabaseRepresentation() );

		$this->mockGlobalFunction( 'wfGetDB', $dbMock );

		// update and save entry
		$this->entry->setDeleted( true );
		CommentsIndex::getInstance()->updateEntry( $this->entry );

		$updatedEntryFromCache = CommentsIndex::getInstance()->entryFromId( $this->commentId );
		$updatedParentFromCache = CommentsIndex::getInstance()->entryFromId( $this->parentId );

		$this->assertTrue( $updatedEntryFromCache->isDeleted() );
		$this->assertEquals( 1456, $updatedParentFromCache->getLastChildCommentId() );
	}

	/**
	 * Verify CommentsIndex updates its cached entry instances when a new entry is inserted
	 */
	public function testInObjectCacheIsUpdatedOnInsert() {
		/** @var PHPUnit_Framework_MockObject_MockObject|DatabaseBase $dbMock */
		$dbMock = $this->getDatabaseMock( [ 'timestamp', 'replace', 'update' ] );
		$dbMock->expects( $this->exactly( 2 ) )
			->method( 'timestamp' )
			->willReturn( 'foo' );

		$dbMock->expects( $this->once() )
			->method( 'replace' )
			->willReturn( true );

		$dbMock->expects( $this->once() )
			->method( 'update' );

		$this->mockGlobalFunction( 'wfGetDB', $dbMock );

		CommentsIndex::getInstance()->insertEntry( $this->entry, $dbMock );

		$commentEntryFromCache = CommentsIndex::getInstance()->entryFromId( $this->commentId );
		$parentEntryFromCache = CommentsIndex::getInstance()->entryFromId( $this->parentId );

		$this->assertEquals( $this->commentId, $commentEntryFromCache->getCommentId() );
		$this->assertEquals( $this->commentId, $parentEntryFromCache->getLastChildCommentId() );
	}

	public function testEntriesFromIdsCanProcessEmptyInput() {
		$result = CommentsIndex::getInstance()->entriesFromIds( [] );

		$this->assertEmpty( $result );
	}
}

<?php

class CommentsIndexTest extends WikiaBaseTest {

	/*
	 * Create a fake object emulating the comments_index row fetched from db
	 */
	private function getFakeCommentsIndexRow( $v ) {
		$rowMock = new stdClass();
		$rowMock->parent_page_id = $v;
		$rowMock->comment_id = $v;
		$rowMock->parent_comment_id = $v;
		$rowMock->last_child_comment_id = $v;
		$rowMock->archived = $v;
		$rowMock->deleted = $v;
		$rowMock->removed = $v;
		$rowMock->locked = $v;
		$rowMock->protected = $v;
		$rowMock->sticky = $v;
		$rowMock->first_rev_id = $v;
		$rowMock->created_at = $v;
		$rowMock->last_rev_id = $v;
		$rowMock->last_touched = $v;
		return $rowMock;
	}

	/*
	 * Make sure the cache is not used when the CommentsIndex objects are just fetched from the database.
	 */
	public function testCommentsIndexCacheNotUsedForDB() {

		$rowMock = $this->getFakeCommentsIndexRow(1);

		$dbMock = $this->getMock('stdClass', [ 'selectRow' ] );
		$dbMock->expects($this->exactly(2))
			->method( 'selectRow' )
			->will( $this->returnValue( $rowMock ) );

		CommentsIndex::newFromId(1, 0, $dbMock);
		CommentsIndex::newFromId(1, 0, $dbMock);
	}

	/*
	 * The purpose of CommentsIndex cache is avoid database queries for CommentsIndex instances that were created
	 * during the request. So here we simulate inserting the CommentsIndex to the table and then ask for that id and
	 * make sure it's not fetched from the database
	 */
	public function testCommentsIndexCacheIsUsedForNewObjects() {

		$rowMock = $this->getFakeCommentsIndexRow(2);

		$dbMock = $this->getMock('stdClass', [ 'selectRow', 'replace', 'tableExists', 'timestamp' ] );

		$dbMock->expects($this->exactly(0))
			->method( 'selectRow' )
			->will( $this->returnValue( $rowMock ) );

		$dbMock->expects($this->any())
			->method( 'replace' )
			->will( $this->returnValue( true ) );

		$dbMock->expects($this->any())
			->method( 'timestamp' )
			->will( $this->returnValue( '20130102030405' ) );

		$dbMock->expects($this->any())
			->method( 'tableExists' )
			->will( $this->returnValue( true ) );

		$ci = new CommentsIndex( [ 'commentId' => 2, 'parentPageId' => 3, 'parentCommentId' => 4 ], $dbMock );
		$ci->addToDatabase();

		//we pass the same $db connection so it's easier to compare objects
		$ci2 = CommentsIndex::newFromId(2, 0, $dbMock);

		// make sure the cached object has the same properties
		$this->assertEquals($ci, $ci2);

		//make sure we don't inherit the database connection form the original object
		$ci2 = CommentsIndex::newFromId(3);
		$this->assertNotEquals($ci, $ci2);
	}

}

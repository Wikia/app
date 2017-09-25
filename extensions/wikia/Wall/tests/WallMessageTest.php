<?php

class WallMessageTest extends WikiaBaseTest {

	/**
	 * Forum main board title can have a slightly different name that the ac title itself, the article comment parent
	 * title takes precedence over the ac itself
	 */
	public function testGetWallUsesWallMainTitle() {
		$acTitle = Title::newFromText( 'ArticleCommentTitle/@comment/xxx' );
		$wallTitle = Title::newFromText( 'MessageWallTitle' );  // this takes precedence
		$wmMock = $this->getMock( 'WallMessage', [ 'getArticleTitle' ], [ $acTitle ] );
		$wmMock->expects( $this->any() )
			->method( 'getArticleTitle' )
			->will( $this->returnValue( $wallTitle ) );
		$this->assertEquals( $wmMock->getWallOwner()->getName(), 'MessageWallTitle' );
	}

	public function testNewFromIds() {
		$slaveId = 1;
		$onlyMasterId = 2;
		$notExistingId = 3;

		$masterData = [
			$slaveId => $this->getSlaveTitleRow(),
			$onlyMasterId => $this->getMasterTitle(),
			$notExistingId => null
		];

		$commentsIndexMock = $this->getMockBuilder( CommentsIndex::class )
			->disableOriginalConstructor()
			->setMethods( [ 'entriesFromIds' ] )
			->getMock();
		$commentsIndexMock->expects( $this->once() )
			->method( 'entriesFromIds' )
			->with( [ $slaveId ] )
			->willReturn( [] );
		$this->mockStaticMethod( CommentsIndex::class, 'getInstance', $commentsIndexMock );
		$this->mockStaticMethodWithCallBack( 'Title', 'newFromId', function( int $id ) use ( $masterData ) {
			return $masterData[$id] !== null
				? $this->createConfiguredMock( Title::class, [ 'exists' => true ] )
				: null;
		} );

		$mockDb = $this->getDatabaseMock([ 'select' ] );
		$mockDb->expects( $this->exactly( 1 ) )
			->method( 'select' )
			->will( $this->returnValue( [ $this->getSlaveTitleRow() ] ) );

		$this->mockGlobalFunction( 'wfGetDb', $mockDb );

		$ids = [ $slaveId, $onlyMasterId, $notExistingId ];

		$wallMessages = WallMessage::newFromIds( $ids );

		$this->assertEquals( 2, count( $wallMessages ) );
	}

	private function getSlaveTitleRow() {
		return (object)[
			"page_namespace" => NS_USER_WALL_MESSAGE,
			"page_title" => "Slave Title",
			"page_id" => 1,
		];
	}

	private function getMasterTitle() {
		return (object)[
			"page_namespace" => NS_USER_WALL_MESSAGE,
			"page_title" => "Master Title",
			"page_id" => 2,
		];
	}
}

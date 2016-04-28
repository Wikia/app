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

	/**
	 * if article comment/title is not in database yet, we should use the article comment title's text as a fallback
	 * to return wall owner name
	 * @group Integration
	 */
	public function testGetWallOwnerACFallback() {
		$acTitle = Title::newFromText( 'ArticleCommentTitle/@comment/xxx' );
		$wallTitle = Title::newFromText( 'Empty' );  // it means we couldn't fetch the main wall/forum title from db
		$wmMock = $this->getMock( 'WallMessage', [ 'getArticleTitle' ], [ $acTitle ] );
		$wmMock->expects( $this->any() )
			->method( 'getArticleTitle' )
			->will( $this->returnValue( $wallTitle ) );
		$this->assertEquals( $wmMock->getWallOwner()->getName(), 'ArticleCommentTitle' );

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

		$mockDb = $this->getDatabaseMock([ 'select', 'selectRow' ] );
		$mockDb->expects( $this->exactly( 1 ) )
			->method( 'select' )
			->will( $this->returnValue( [ $this->getSlaveTitleRow() ] ) );

		$mockDb->expects( $this->exactly( 2 ) )
			->method( "selectRow" )
			->will( $this->returnCallback(
				function ( $table, $vars, $conds ) use ( $masterData ) {
					return $masterData[ $conds[ 'page_id' ] ];
				} ) );

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

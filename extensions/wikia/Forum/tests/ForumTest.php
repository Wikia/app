<?php

class ForumTest extends WikiaBaseTest {


	/*
	 * https://wikia-inc.atlassian.net/browse/SUS-156
	 * This test check behaviour what happen if wikia props has some leftovers
	 * in case of race condition master->slave
	 */
	public function testGetBoardListShouldReturnBoardsWithoutLeftoversInWikiaProps() {

		$titlesFromNamespace = [ ];
		foreach ( [ 1, 2, 3, 4 ] as $key ) {
			$titlesFromNamespace[ $key ] = $this->getTitleMock( $key );
		}
		$wikiaPropsReturn = [ 1 => 4, 2 => 7, 3 => 6, 5 => 2 ];
		$expectedBoardsTitle = [ 1, 2, 3 ];

		$titleBatchMock = $this->getMock( 'TitleBatch', [ ], [ ], '', false );

		$titleBatchMock->expects( $this->any() )
			->method( 'getById' )
			->will( $this->returnCallback(
				function ( $pageId ) use ( $titlesFromNamespace ) {
					return $titlesFromNamespace[ $pageId ];
				} ) );

		$titleBatchMock->expects( $this->once() )
			->method( 'getWikiaProperties' )
			->willReturn( $wikiaPropsReturn );

		$this->mockStaticMethod( 'TitleBatch', 'newFromConds', $titleBatchMock );

		$this->mockStaticMethodWithCallBack( 'Wall', 'newFromTitle',
			function ( $title ) {
				return $this->getBoardMock();
			}
		);

		$forum = new Forum();
		$boards = $forum->getBoardList();

		foreach ( $boards as $board ) {
			$this->assertContains( $board[ 'id' ], $expectedBoardsTitle );
		}
	}

	private function getTitleMock( $key ) {
		$titleMock = $this->getMock( 'Title', [ 'getArticleID' ] );
		$titleMock->expects( $this->any() )
			->method( 'getArticleID' )
			->willReturn( $key );
		return $titleMock;
	}

	private function getBoardMock() {
		$boardMock = $this->getMock( 'ForumBoard', [ 'getBoardInfo', 'getDescriptionWithoutTemplates', 'getTitle' ] );
		return $boardMock;
	}
}

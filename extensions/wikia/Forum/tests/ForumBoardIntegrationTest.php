<?php

/**
 * @group Integration
 */
class ForumBoardIntegrationTest extends WikiaDatabaseTest {
	private const NOT_FORUM_BOARD_ID = 885;
	private const VALID_FORUM_BOARD_ID = 1204;
	private const VALID_FORUM_BOARD_PAGE = 'ValidForumBoardPage';

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		require_once __DIR__ . '/../../Wall/Wall.setup.php';
		require_once __DIR__ . '/../Forum.setup.php';
	}


	public function testShouldReturnNullWhenPageWithGivenIdDoesNotExist(): void {
		$board = ForumBoard::newFromId( 256 );

		$this->assertNull( $board );
	}

	public function testShouldReturnNullWhenGivenIdDoesNotBelongToForumBoardPage(): void {
		$board = ForumBoard::newFromId( self::NOT_FORUM_BOARD_ID );

		$this->assertNull( $board );
	}

	public function testShouldReturnNullWhenGivenTitleDoesNotBelongToForumBoardPage(): void {
		$title = Title::makeTitle( NS_MAIN, 'NotForumBoardEither');

		$board = ForumBoard::newFromTitle( $title );

		$this->assertNull( $board );
	}

	public function testShouldCreateForumBoardBasedOnIdOfForumBoardPage(): void {
		$board = ForumBoard::newFromId( self::VALID_FORUM_BOARD_ID );

		$this->assertInstanceOf( ForumBoard::class, $board );
		$this->assertEquals( self::VALID_FORUM_BOARD_PAGE, $board->getTitle()->getText() );
	}

	public function testShouldCreateForumBoardBasedOnTitleOfForumBoardPage(): void {
		$title = Title::makeTitle( NS_WIKIA_FORUM_BOARD, self::VALID_FORUM_BOARD_PAGE );

		$board = ForumBoard::newFromTitle( $title );

		$this->assertInstanceOf( ForumBoard::class, $board );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/forum.yaml' );
	}
}

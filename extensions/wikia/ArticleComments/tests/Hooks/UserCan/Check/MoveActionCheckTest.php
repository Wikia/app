<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan\Check;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\DependencyFactory;
use Extensions\Wikia\ArticleComments\Hooks\UserCan\Right;

class MoveActionCheckTest extends \WikiaBaseTest {
	/** @var \Title|\PHPUnit_Framework_MockObject_MockObject $title */
	private $title;

	/** @var \User|\PHPUnit_Framework_MockObject_MockObject $user */
	private $user;

	/** @var MoveActionCheck $moveActionCheck */
	private $moveActionCheck;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->title = $this->createMock( \Title::class );
		$this->user = $this->createMock( \User::class );

		$this->moveActionCheck = new MoveActionCheck( new DependencyFactory() );
	}

	public function testUserWithoutCommentMoveRightIsNotAllowed() {
		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::COMMENT_MOVE )
			->willReturn( false );

		$result = $this->moveActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}


	public function testUserWithCommentMoveRightIsAllowed() {
		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::COMMENT_MOVE )
			->willReturn( true );

		$result = $this->moveActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}
}

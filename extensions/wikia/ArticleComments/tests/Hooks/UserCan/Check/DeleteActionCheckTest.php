<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan\Check;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\DependencyFactory;
use Extensions\Wikia\ArticleComments\Hooks\UserCan\Right;

class DeleteActionCheckTest extends \WikiaBaseTest {
	/** @var \Title|\PHPUnit_Framework_MockObject_MockObject $title */
	private $title;

	/** @var \User|\PHPUnit_Framework_MockObject_MockObject $user */
	private $user;

	/** @var DeleteActionCheck $deleteActionCheck */
	private $deleteActionCheck;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->title = $this->createMock( \Title::class );
		$this->user = $this->createMock( \User::class );

		$this->deleteActionCheck = new DeleteActionCheck( new DependencyFactory() );
	}

	public function testUserWithoutCommentDeleteRightIsNotAllowed() {
		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::COMMENT_DELETE )
			->willReturn( false );

		$result = $this->deleteActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}


	public function testUserWithCommentDeleteRightIsAllowed() {
		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::COMMENT_DELETE )
			->willReturn( true );

		$result = $this->deleteActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}
}

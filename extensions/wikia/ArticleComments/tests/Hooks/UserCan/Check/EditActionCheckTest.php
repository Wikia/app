<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan\Check;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\DependencyFactory;
use Extensions\Wikia\ArticleComments\Hooks\UserCan\Right;

class EditActionCheckTest extends \WikiaBaseTest {
	/** @var DependencyFactory|\PHPUnit_Framework_MockObject_MockObject $dependencyFactory */
	private $dependencyFactory;

	/** @var \Title|\PHPUnit_Framework_MockObject_MockObject $title */
	private $title;

	/** @var \User|\PHPUnit_Framework_MockObject_MockObject $user */
	private $user;

	/** @var EditActionCheck $editActionCheck */
	private $editActionCheck;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->dependencyFactory = $this->createMock( DependencyFactory::class );
		$this->title = $this->createMock( \Title::class );
		$this->user = $this->createMock( \User::class );

		$this->editActionCheck = new EditActionCheck( $this->dependencyFactory );
	}

	public function testUserWithCommentEditRightIsAllowed() {
		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::COMMENT_EDIT )
			->willReturn( true );

		$result = $this->editActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}


	public function testUserWithoutCommentEditRightIsAllowedIfTheyAreTheAuthor() {
		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::COMMENT_EDIT )
			->willReturn( false );

		$articleCommentMock = $this->createMock( \ArticleComment::class );
		$this->dependencyFactory->expects( $this->once() )
			->method( 'newArticleComment' )
			->with( $this->title )
			->willReturn( $articleCommentMock );

		$articleCommentMock->expects( $this->once() )
			->method( 'isAuthor' )
			->with( $this->user )
			->willReturn( true );

		$result = $this->editActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}

	public function testUserWithoutCommentEditRightIsNotAllowedIfTheyAreNotTheAuthor() {
		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::COMMENT_EDIT )
			->willReturn( false );

		$articleCommentMock = $this->createMock( \ArticleComment::class );
		$this->dependencyFactory->expects( $this->once() )
			->method( 'newArticleComment' )
			->with( $this->title )
			->willReturn( $articleCommentMock );

		$articleCommentMock->expects( $this->once() )
			->method( 'isAuthor' )
			->with( $this->user )
			->willReturn( false );

		$result = $this->editActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}
}

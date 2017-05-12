<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan\Check;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\DependencyFactory;
use Extensions\Wikia\ArticleComments\Hooks\UserCan\Right;

class CreateActionCheckTest extends \WikiaBaseTest {
	/** @var \Title|\PHPUnit_Framework_MockObject_MockObject $parentPage */
	private $parentPage;

	/** @var \Title|\PHPUnit_Framework_MockObject_MockObject $title */
	private $title;

	/** @var \User|\PHPUnit_Framework_MockObject_MockObject $user */
	private $user;

	/** @var CreateActionCheck $createActionCheck */
	private $createActionCheck;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->parentPage = $this->createMock( \Title::class );
		$this->title = $this->createMock( \Title::class );
		$this->user = $this->createMock( \User::class );

		$this->title->expects( $this->once() )
			->method( 'getSubjectPage' )
			->willReturn( $this->parentPage );

		$this->createActionCheck = new CreateActionCheck( new DependencyFactory() );
	}

	public function testNonExistingTitleIsNotAllowed() {
		$this->parentPage->expects( $this->once() )
			->method( 'exists' )
			->willReturn( false );

		$result = $this->createActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}

	public function testMainPageIsNotAllowed() {
		$this->parentPage->expects( $this->once() )
			->method( 'exists' )
			->willReturn( true );

		$this->parentPage->expects( $this->once() )
			->method( 'isMainPage' )
			->willReturn( true );

		$result = $this->createActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}

	public function testUserWithoutCommentCreateAndEditOnValidPageIsNotAllowed() {
		$this->parentPage->expects( $this->once() )
			->method( 'exists' )
			->willReturn( true );

		$this->parentPage->expects( $this->once() )
			->method( 'isMainPage' )
			->willReturn( false );

		$this->user->expects( $this->once() )
			->method( 'isAllowedAll' )
			->with( Right::COMMENT_CREATE, Right::EDIT )
			->willReturn( false );

		$result = $this->createActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}

	public function testUserWithCommentCreateAndEditOnValidPageIsAllowed() {
		$this->parentPage->expects( $this->once() )
			->method( 'exists' )
			->willReturn( true );

		$this->parentPage->expects( $this->once() )
			->method( 'isMainPage' )
			->willReturn( false );

		$this->user->expects( $this->once() )
			->method( 'isAllowedAll' )
			->with( Right::COMMENT_CREATE, Right::EDIT )
			->willReturn( true );

		$result = $this->createActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}
}

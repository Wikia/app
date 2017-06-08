<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

use Extensions\Wikia\Blogs\DependencyFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Right;

class BlogArticleProtectActionCheckTest extends \WikiaBaseTest {
	/** @var \Title|\PHPUnit_Framework_MockObject_MockObject $title */
	private $title;

	/** @var \User|\PHPUnit_Framework_MockObject_MockObject $user */
	private $user;

	/** @var BlogArticleProtectActionCheck $blogArticleProtectActionCheck */
	private $blogArticleProtectActionCheck;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->title = $this->createMock( \Title::class );
		$this->user = $this->createMock( \User::class );

		$this->blogArticleProtectActionCheck = new BlogArticleProtectActionCheck( new DependencyFactory() );
	}

	public function testIsAllowedIfUserHasBlogArticleProtect() {
		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::BLOG_ARTICLES_PROTECT )
			->willReturn( true );

		$result = $this->blogArticleProtectActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}

	public function testIsDisallowedIfUserDoesNotHaveBlogArticleProtect() {
		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::BLOG_ARTICLES_PROTECT )
			->willReturn( false );

		$result = $this->blogArticleProtectActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}
}

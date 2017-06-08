<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

use Extensions\Wikia\Blogs\DependencyFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Right;

class BlogArticleEditActionCheckTest extends \WikiaBaseTest {
	/** @var \Title|\PHPUnit_Framework_MockObject_MockObject $title */
	private $title;

	/** @var \User|\PHPUnit_Framework_MockObject_MockObject $user */
	private $user;

	/** @var \BlogArticle|\PHPUnit_Framework_MockObject_MockObject $blogArticle */
	private $blogArticle;

	/** @var DependencyFactory|\PHPUnit_Framework_MockObject_MockObject $dependencyFactory */
	private $dependencyFactory;

	/** @var BlogArticleEditActionCheck $blogArticleEditActionCheck */
	private $blogArticleEditActionCheck;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->title = $this->createMock( \Title::class );
		$this->user = $this->createMock( \User::class );

		$this->blogArticle = $this->createMock( \BlogArticle::class );
		$this->dependencyFactory = $this->createMock( DependencyFactory::class );

		$this->blogArticleEditActionCheck = new BlogArticleEditActionCheck( $this->dependencyFactory );
	}

	public function testIsAllowedIfUserDoesNotHaveBlogArticleEditButIsTheAuthor() {
		$owner = 'Grzegorz Brzęczyszczykiewicz';

		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::BLOG_ARTICLES_EDIT )
			->willReturn( false );

		$this->dependencyFactory->expects( $this->once() )
			->method( 'newBlogArticle' )
			->willReturn( $this->blogArticle );

		$this->blogArticle->expects( $this->once() )
			->method( 'getBlogOwner' )
			->willReturn( $owner );

		$this->user->expects( $this->once() )
			->method( 'getName' )
			->willReturn( $owner );

		$result = $this->blogArticleEditActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}

	public function testIsDisallowedIfUserDoesNotHaveBlogArticleEditAndIsNotTheAuthor() {
		$owner = 'Grzegorz Brzęczyszczykiewicz';
		$user = 'Franciszek Dolas';

		$this->user->expects( $this->once() )
			->method( 'isAllowed' )
			->with( Right::BLOG_ARTICLES_EDIT )
			->willReturn( false );

		$this->dependencyFactory->expects( $this->once() )
			->method( 'newBlogArticle' )
			->willReturn( $this->blogArticle );

		$this->blogArticle->expects( $this->once() )
			->method( 'getBlogOwner' )
			->willReturn( $owner );

		$this->user->expects( $this->once() )
			->method( 'getName' )
			->willReturn( $user );

		$result = $this->blogArticleEditActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}
}

<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

use Extensions\Wikia\Blogs\DependencyFactory;

class BlogArticleCreateActionCheckTest extends \WikiaBaseTest {
	/** @var \Title|\PHPUnit_Framework_MockObject_MockObject $title */
	private $title;

	/** @var \User|\PHPUnit_Framework_MockObject_MockObject $user */
	private $user;

	/** @var \BlogArticle|\PHPUnit_Framework_MockObject_MockObject $blogArticle */
	private $blogArticle;

	/** @var DependencyFactory|\PHPUnit_Framework_MockObject_MockObject $dependencyFactory */
	private $dependencyFactory;

	/** @var BlogArticleCreateActionCheck $blogArticleCreateActionCheck */
	private $blogArticleCreateActionCheck;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->title = $this->createMock( \Title::class );
		$this->user = $this->createMock( \User::class );

		$this->blogArticle = $this->createMock( \BlogArticle::class );
		$this->dependencyFactory = $this->createMock( DependencyFactory::class );

		$this->dependencyFactory->expects( $this->any() )
			->method( 'newBlogArticle' )
			->with( $this->title )
			->willReturn( $this->blogArticle );

		$this->blogArticleCreateActionCheck = new BlogArticleCreateActionCheck( $this->dependencyFactory );
	}

	public function testIsDisallowedIfUserIsNotLoggedInAndIsTheAuthor() {
		$owner = '8.8.8.8';

		$this->title->expects( $this->once() )
			->method( 'isUndeleting' )
			->willReturn( false );

		$this->user->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$this->blogArticle->expects( $this->any() )
			->method( 'getBlogOwner' )
			->willReturn( $owner );

		$this->user->expects( $this->any() )
			->method( 'getName' )
			->willReturn( $owner );

		$result = $this->blogArticleCreateActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}

	public function testIsDisallowedIfUserIsNotLoggedInAndIsNotTheAuthor() {
		$owner = 'Grzegorz Brzęczyszczykiewicz';
		$user = '8.8.8.8';

		$this->title->expects( $this->once() )
			->method( 'isUndeleting' )
			->willReturn( false );

		$this->user->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$this->blogArticle->expects( $this->any() )
			->method( 'getBlogOwner' )
			->willReturn( $owner );

		$this->user->expects( $this->any() )
			->method( 'getName' )
			->willReturn( $user );

		$result = $this->blogArticleCreateActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}

	public function testIsAllowedIfUserIsLoggedInAndIsTheAuthor() {
		$owner = 'Grzegorz Brzęczyszczykiewicz';

		$this->title->expects( $this->once() )
			->method( 'isUndeleting' )
			->willReturn( false );

		$this->user->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->blogArticle->expects( $this->once() )
			->method( 'getBlogOwner' )
			->willReturn( $owner );

		$this->user->expects( $this->once() )
			->method( 'getName' )
			->willReturn( $owner );

		$result = $this->blogArticleCreateActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}

	public function testIsDisallowedIfUserIsLoggedInAndNotTheAuthor() {
		$owner = 'Grzegorz Brzęczyszczykiewicz';
		$user = 'Franciszek Dolas';

		$this->title->expects( $this->once() )
			->method( 'isUndeleting' )
			->willReturn( false );

		$this->user->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->blogArticle->expects( $this->once() )
			->method( 'getBlogOwner' )
			->willReturn( $owner );

		$this->user->expects( $this->once() )
			->method( 'getName' )
			->willReturn( $user );

		$result = $this->blogArticleCreateActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}

	public function testIsAllowedIfThisIsAnUndelete() {
		$owner = 'Grzegorz Brzęczyszczykiewicz';

		$this->title->expects( $this->once() )
			->method( 'isUndeleting' )
			->willReturn( true );

		$this->user->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->blogArticle->expects( $this->any() )
			->method( 'getBlogOwner' )
			->willReturn( $owner );

		$this->user->expects( $this->any() )
			->method( 'getName' )
			->willReturn( $owner );

		$result = $this->blogArticleCreateActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}
}

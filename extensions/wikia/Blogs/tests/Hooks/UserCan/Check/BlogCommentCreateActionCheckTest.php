<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

use Extensions\Wikia\Blogs\DependencyFactory;

class BlogCommentCreateActionCheckTest extends \WikiaBaseTest {
	/** @var \Title|\PHPUnit_Framework_MockObject_MockObject $title */
	private $title;

	/** @var \User|\PHPUnit_Framework_MockObject_MockObject $user */
	private $user;

	/** @var \BlogArticle|\PHPUnit_Framework_MockObject_MockObject $blogArticle */
	private $blogArticle;

	/** @var DependencyFactory|\PHPUnit_Framework_MockObject_MockObject $dependencyFactory */
	private $dependencyFactory;

	/** @var BlogCommentCreateActionCheck $blogCommentCreateActionCheck */
	private $blogCommentCreateActionCheck;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../../src/autoload.php';

		$this->title = $this->createMock( \Title::class );
		$this->user = $this->createMock( \User::class );
		$parentPage = $this->createMock( \Title::class );

		$this->blogArticle = $this->createMock( \BlogArticle::class );
		$this->dependencyFactory = $this->createMock( DependencyFactory::class );

		$articleComment = $this->createMock( \ArticleComment::class );

		$articleComment->expects( $this->once() )
			->method( 'getArticleTitle' )
			->willReturn( $parentPage );

		$this->dependencyFactory->expects( $this->once() )
			->method( 'newArticleComment' )
			->with( $this->title )
			->willReturn( $articleComment );

		$this->dependencyFactory->expects( $this->once() )
			->method( 'newBlogArticle' )
			->with( $parentPage )
			->willReturn( $this->blogArticle );

		$this->blogCommentCreateActionCheck = new BlogCommentCreateActionCheck( $this->dependencyFactory );
	}

	public function testIsAllowedIfBlogArticleCommentingIsEnabled() {
		$this->blogArticle->expects( $this->once() )
			->method( 'getPageProps' )
			->willReturn( [ 'commenting' => 1 ] );

		$result = $this->blogCommentCreateActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}

	public function testIsDisallowedIfBlogArticleCommentingDisabled() {
		$this->blogArticle->expects( $this->once() )
			->method( 'getPageProps' )
			->willReturn( [ 'commenting' => 0 ] );

		$result = $this->blogCommentCreateActionCheck->process( $this->title, $this->user );

		$this->assertFalse( $result );
	}

	public function testIsAllowedIfBlogArticleCommentingIsNotExplicitlySet() {
		$this->blogArticle->expects( $this->once() )
			->method( 'getPageProps' )
			->willReturn( [ 'commenting' => null ] );

		$result = $this->blogCommentCreateActionCheck->process( $this->title, $this->user );

		$this->assertTrue( $result );
	}
}

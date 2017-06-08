<?php
namespace Extensions\Wikia\Blogs;

use Extensions\Wikia\Blogs\Hooks\UserCan\Check\BlogArticleCheckFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Check\BlogCommentCheckFactory;

class DependencyFactoryTest extends \WikiaBaseTest {
	/** @var DependencyFactory $dependencyFactory */
	private $dependencyFactory;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../src/autoload.php';

		$this->dependencyFactory = new DependencyFactory();
	}

	public function testNewBlogArticle() {
		$title = new \Title();

		$blogArticleOne = $this->dependencyFactory->newBlogArticle( $title );
		$blogArticleTwo = $this->dependencyFactory->newBlogArticle( $title );

		$this->assertInstanceOf( \BlogArticle::class, $blogArticleOne );
		$this->assertInstanceOf( \BlogArticle::class, $blogArticleTwo );
		$this->assertNotSame( $blogArticleOne, $blogArticleTwo );
	}

	public function testNewArticleComment() {
		$title = new \Title();

		$articleCommentOne = $this->dependencyFactory->newArticleComment( $title );
		$articleCommentTwo = $this->dependencyFactory->newArticleComment( $title );

		$this->assertInstanceOf( \ArticleComment::class, $articleCommentOne );
		$this->assertInstanceOf( \ArticleComment::class, $articleCommentTwo );
		$this->assertNotSame( $articleCommentOne, $articleCommentTwo);
	}

	public function testNewBlogArticleCheckFactory() {
		$checkFactoryOne = $this->dependencyFactory->newBlogArticleCheckFactory();
		$checkFactoryTwo = $this->dependencyFactory->newBlogArticleCheckFactory();

		$this->assertInstanceOf( BlogArticleCheckFactory::class, $checkFactoryOne );
		$this->assertInstanceOf( BlogArticleCheckFactory::class, $checkFactoryTwo );
		$this->assertNotSame( $checkFactoryOne, $checkFactoryTwo );
	}

	public function testNewBlogCommentCheckFactory() {
		$checkFactoryOne = $this->dependencyFactory->newBlogCommentCheckFactory();
		$checkFactoryTwo = $this->dependencyFactory->newBlogCommentCheckFactory();

		$this->assertInstanceOf( BlogCommentCheckFactory::class, $checkFactoryOne );
		$this->assertInstanceOf( BlogCommentCheckFactory::class, $checkFactoryTwo );
		$this->assertNotSame( $checkFactoryOne, $checkFactoryTwo );
	}
}

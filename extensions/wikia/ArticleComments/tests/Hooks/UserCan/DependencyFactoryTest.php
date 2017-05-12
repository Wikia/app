<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\Check\CheckFactory;

class DependencyFactoryTest extends \WikiaBaseTest {
	/** @var DependencyFactory $dependencyFactory */
	private $dependencyFactory;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../../src/autoload.php';

		$this->dependencyFactory = new DependencyFactory();
	}

	public function testNewCheckFactory() {
		$checkFactoryOne = $this->dependencyFactory->newCheckFactory();
		$checkFactoryTwo = $this->dependencyFactory->newCheckFactory();

		$this->assertInstanceOf( CheckFactory::class, $checkFactoryOne );
		$this->assertInstanceOf( CheckFactory::class, $checkFactoryTwo );
		$this->assertNotSame( $checkFactoryOne, $checkFactoryTwo );
	}

	public function testNewArticleComment() {
		$title = new \Title();

		$articleCommentOne = $this->dependencyFactory->newArticleComment( $title );
		$articleCommentTwo = $this->dependencyFactory->newArticleComment( $title );

		$this->assertInstanceOf( \ArticleComment::class, $articleCommentOne );
		$this->assertInstanceOf( \ArticleComment::class, $articleCommentTwo );
		$this->assertNotSame( $articleCommentOne, $articleCommentTwo );
	}
}

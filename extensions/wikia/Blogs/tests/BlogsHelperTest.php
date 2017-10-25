<?php

class BlogsHelperTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../Blogs.php';
		parent::setUp();
	}

	/**
	 * SUS-1635: Regression test for BlogsHelper::AbortMove hook handler
	 * Verify blog pages and comments can be renamed, pages can be moved into blog namespace and that pages can't be moved
	 * out of blogs namespaces or into comment namespace
	 *
	 * @covers BlogsHelper::onAbortMove()
	 * @dataProvider blogsMoveRestrictionsDataProvider
	 * @param int $sourceNamespace
	 * @param int $targetNamespace
	 * @param bool $shouldAllow
	 */
	public function testBlogsMoveRestrictions( int $sourceNamespace, int $targetNamespace, bool $shouldAllow ) {
		/** @var Title|PHPUnit_Framework_MockObject_MockObject $sourceTitleMock */
		$sourceTitleMock = $this->getMock( Title::class, [ 'getNamespace' ] );
		/** @var Title|PHPUnit_Framework_MockObject_MockObject $targetTitleMock */
		$targetTitleMock = $this->getMock( Title::class, [ 'getNamespace' ] );

		$sourceTitleMock->expects( $this->atLeastOnce() )
			->method( 'getNamespace' )
			->willReturn( $sourceNamespace );

		$targetTitleMock->expects( $this->atLeastOnce() )
			->method( 'getNamespace' )
			->willReturn( $targetNamespace );

		$err = null;
		$res = BlogsHelper::onAbortMove( $sourceTitleMock, $targetTitleMock, new User, $err, '' );

		if ( $shouldAllow ) {
			$this->assertTrue( $res, 'Blogs extension must not prevent page moves between these two namespaces' );
			$this->assertEmpty( $err, 'Error info must be empty if page move is to be allowed' );
		} else {
			$this->assertFalse( $res, 'Blogs extension must prevent page moves between these two namespaces' );
			$this->assertInternalType( 'string', $err, 'Error message must be set if page move is to be prevented' );
		}
	}

	public function blogsMoveRestrictionsDataProvider(): array {
		return [
			'renaming user blog' => [ NS_BLOG_ARTICLE, NS_BLOG_ARTICLE, true ],
			'renaming user blog comment' => [ NS_BLOG_ARTICLE_TALK, NS_BLOG_ARTICLE_TALK, true ],
			'moving page to user blog namespace' => [ NS_MAIN, NS_BLOG_ARTICLE, true ],
			'malformed move to blog comments namespace' => [ NS_MAIN, NS_BLOG_ARTICLE_TALK, false ],
			'malformed move out of blog namespace' => [ NS_BLOG_ARTICLE, NS_MAIN, false ],
			'malformed move out of blog comments namespace' => [ NS_BLOG_ARTICLE_TALK, NS_MAIN, false ],
			'unrelated namespaces' => [ NS_MAIN, NS_PROJECT, true ]
		];
	}
}

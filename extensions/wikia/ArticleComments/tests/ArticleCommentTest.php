<?php

class ArticleCommentTest extends WikiaBaseTest {
	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../classes/ArticleComment.class.php';
	}

	/**
	 * @dataProvider provideCommentTitlesAndExpectedArticleTitles
	 * @param Title $commentTitle
	 * @param Title $expectedArticleTitle
	 */
	public function testGetArticleTitle( Title $commentTitle, Title $expectedArticleTitle ) {
		$articleComment = new ArticleComment( $commentTitle );

		$actualArticleTitle = $articleComment->getArticleTitle();

		$this->assertEquals(
			$expectedArticleTitle->getPrefixedText(),
			$actualArticleTitle->getPrefixedText()
		);
	}

	public function provideCommentTitlesAndExpectedArticleTitles() {
		$map = [
			'Talk:Foo/@comment-TK-test-20170513135129' => 'Foo',
			'Talk:Bar/@comment-TK-test-20140211143144' => 'Bar',
			'Talk:Foo/Bar/@comment-TK-test-20170513135129' => 'Foo/Bar',
			'Talk:Foo/Bar/Baz/@comment-TK-test-20170513135129' => 'Foo/Bar/Baz',
		];

		foreach ( $map as $commentTitleText => $expectedArticleTitleText ) {
			yield [ Title::newFromText( $commentTitleText ), Title::newFromText( $expectedArticleTitleText ) ];
		}
	}
}

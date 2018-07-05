<?php

/**
 * @group Integration
 */
class SpecialForumRedirectControllerTest extends WikiaDatabaseTest {
	const THREAD_ID = 1;
	const REPLY_ID = 2;
	const ARTICLE_ID = 3;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../controllers/SpecialForumRedirectController.class.php';
	}

	protected function getDataSet()	{
		return $this->createYamlDataSet( __DIR__ . '/fixtures/special_forum_redirect_controller.yaml' );
	}

	/**
	 * @dataProvider provideGetRedirectableForumTitleForForumThreadNamespace
	 * @param int $articleId
	 * @param int|null $expectedArticleId
	 */
	public function testGetRedirectableForumTitleForForumThreadNamespace(
		int $articleId, $expectedArticleId
	) {
		$article = Article::newFromID( $articleId );

		$redirectableForumTitle = SpecialForumRedirectController::getRedirectableForumTitle( $article );

		if ( $expectedArticleId !== null ) {
			$this->assertEquals( $expectedArticleId, $redirectableForumTitle->getArticleID() );
		} else {
			$this->assertEquals( null, $redirectableForumTitle );
		}
	}

	public function provideGetRedirectableForumTitleForForumThreadNamespace(): Generator {
		yield [ static::THREAD_ID, static::THREAD_ID ];
		yield [ static::REPLY_ID, static::THREAD_ID ];
		yield [ static::ARTICLE_ID, null ];
	}

	/**
	 * @throws MWException
	 */
	public function testGetRedirectableForumTitleForWallMessageNamespace() {
		$title = Title::newFromText( 'Thread:' . static::THREAD_ID );
		$article = Article::newFromTitle( $title, new RequestContext() );

		$redirectableForumTitle = SpecialForumRedirectController::getRedirectableForumTitle( $article );

		$this->assertEquals( static::THREAD_ID, $redirectableForumTitle->getArticleID() );
	}
}

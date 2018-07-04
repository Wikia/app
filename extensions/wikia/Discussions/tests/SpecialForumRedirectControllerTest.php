<?php

/**
 * @group Integration
 */
class SpecialForumRedirectControllerTest extends WikiaDatabaseTest {
	const THREAD_ID = 1;
	const REPLY_ID = 2;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../controllers/SpecialForumRedirectController.class.php';
	}

	/**
	 * @dataProvider provideGetRedirectableForumTitle
	 * @param int $articleId
	 * @param int $expectedArticleId
	 */
	public function testGetRedirectableForumTitle(
		int $articleId, int $expectedArticleId
	) {
		$article = Article::newFromID( $articleId );
		$redirectableForumTitle = SpecialForumRedirectController::getRedirectableForumTitle( $article );
		var_dump($redirectableForumTitle);

		$this->assertEquals( $expectedArticleId, $redirectableForumTitle->getArticleID() );
	}

	public function provideGetRedirectableForumTitle(): Generator {
		yield [ static::THREAD_ID, static::THREAD_ID ];
		yield [ static::REPLY_ID, static::THREAD_ID ];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/special_forum_redirect_controller.yaml' );
	}
}

<?php

/**
 * @group Integration
 */
class ArticleCommentIntegrationTest extends WikiaDatabaseTest {
	const ANON_COMMENT_ID = 885;
	const EDITED_ANON_COMMENT_ID = 890;

	const ANON_COMMENT = 'Lorem ipsum';
	const EDITED_ANON_COMMENT = 'Abcd';

	const ANON_IP = '188.146.144.183';

	const TEST_USER_ID = 56371;
	const TEST_USER_NAME = 'TestUser';

	const TEST_USER_COMMENT_ID = 1040;
	const TEST_USER_COMMENT = 'UserComment';

	/**
	 * @dataProvider provideCommentInfo
	 *
	 * @param int $articleId
	 * @param string $expectedAuthorName
	 * @param string $expectedCommentText
	 */
	public function testLoad(
		int $articleId, string $expectedAuthorName, string $expectedCommentText
	) {
		$articleComment = ArticleComment::newFromId( $articleId );
		$articleComment->load();

		$this->assertEquals( $expectedAuthorName, $articleComment->mUser->getName() );
		$this->assertEquals( $expectedCommentText, $articleComment->getRawText() );
	}

	public function provideCommentInfo(): Generator {
		yield [ static::ANON_COMMENT_ID, static::ANON_IP, static::ANON_COMMENT ];
		yield [ static::EDITED_ANON_COMMENT_ID, static::ANON_IP, static::EDITED_ANON_COMMENT ];
		yield [ static::TEST_USER_COMMENT_ID, static::TEST_USER_NAME, static::TEST_USER_COMMENT ];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/article_comment_integration.yaml' );
	}
}

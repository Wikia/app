<?php

/**
 * @group Integration
 */
class DatabaseForumActivityServiceIntegrationTest extends WikiaDatabaseTest {
	/** @var ForumActivityService $forumActivityService */
	private $forumActivityService;

	protected function setUp() {
		parent::setUp();
		$this->forumActivityService = new DatabaseForumActivityService();
	}

	protected function extraSchemaFiles() {
		yield __DIR__ . '/fixtures/comments_index.sql';
	}

	public function testGetRecentlyUpdatedThreads() {
		$postInfo = $this->forumActivityService->getRecentlyUpdatedThreads();

		$this->assertCount( 2, $postInfo );

		$this->assertEquals( 0, $postInfo[0]['authorId'] );
		$this->assertEquals( '8.8.8.8', $postInfo[0]['authorName'] );
		$this->assertStringEndsWith(
			'Thread:3',
			$postInfo[0]['threadUrl']
		);
		$this->assertEquals( 'Lorem ipsum', $postInfo[0]['threadTitle'] );
		$this->assertEquals( '20180211093609', $postInfo[0]['timestamp'] );

		$this->assertEquals( 0, $postInfo[1]['authorId'] );
		$this->assertEquals( '8.8.8.8', $postInfo[1]['authorName'] );
		$this->assertStringEndsWith(
			'Thread:2',
			$postInfo[1]['threadUrl']
		);
		$this->assertEquals( 'Foo', $postInfo[1]['threadTitle'] );
		$this->assertEquals( '20180211103609', $postInfo[1]['timestamp'] );

	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/recently_updated_threads.yaml' );
	}
}

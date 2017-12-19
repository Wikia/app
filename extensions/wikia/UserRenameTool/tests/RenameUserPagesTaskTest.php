<?php

use Wikia\Tasks\Tasks\RenameUserPagesTask;

/**
 * @group Integration
 */
class RenameUserPagesTaskTest extends WikiaDatabaseTest {
	const OLD_USER_NAME = 'Old User Nąmę';
	const NEW_USER_NAME = 'New User Name';

	const WIKI_WITH_USER_PAGE = 177;
	const WIKI_WITH_TALK_PAGE = 147;
	const WIKI_WITH_BLOG_PAGE = 1770;
	const WIKI_WITH_MESSAGE_WALL = 1240;

	/** @var RenameUserPagesTask $renameUserPagesTask */
	private $renameUserPagesTask;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		$dbw = wfGetDB( DB_MASTER );
		$dbw->sourceFile( __DIR__ . '/fixtures/dataware-pages.sql' );
	}

	protected function setUp() {
		parent::setUp();
		$this->renameUserPagesTask = new RenameUserPagesTask();

		// unset everyone else's hooks, who knows what they are trying to do here
		$hooks = &Hooks::getHandlersArray();
		$hooks = [];
	}

	public function testFindsWikisWhereUserRelatedPagesExist() {
		$communityIds = RenameUserPagesTask::getTargetCommunities( static::OLD_USER_NAME );

		$this->assertCount( 4, $communityIds );

		$this->assertContains( static::WIKI_WITH_USER_PAGE, $communityIds );
		$this->assertContains( static::WIKI_WITH_TALK_PAGE, $communityIds );
		$this->assertContains( static::WIKI_WITH_BLOG_PAGE, $communityIds );
		$this->assertContains( static::WIKI_WITH_MESSAGE_WALL, $communityIds );
	}

	public function testUserRelatedPagesAreRenamed() {
		$this->renameUserPagesTask->renameLocalPages(
			static::OLD_USER_NAME, static::NEW_USER_NAME
		);

		$queryTable = $this->getConnection()->createQueryTable(
			'page', 'SELECT page_namespace, page_title, page_is_redirect FROM page'
		);
		$expectedTable = $this->createYamlDataSet(
			__DIR__ . '/fixtures/expected_post_rename_state.yaml'
		)->getTable( 'page' );

		$this->assertTablesEqual( $expectedTable, $queryTable );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/user_related_pages.yaml' );
	}
}

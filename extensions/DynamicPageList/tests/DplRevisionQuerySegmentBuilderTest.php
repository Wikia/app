<?php

use PHPUnit\Framework\TestCase;

class DplRevisionQuerySegmentBuilderTest extends TestCase {
	const TEST_USER_ARRAY_WITH_ID = [ 'user_id' => 123 ];
	const TEST_USER_ARRAY_WITH_NAME = [ 'user_text' => 'TestUser' ];

	/** @var DatabaseBase|PHPUnit_Framework_MockObject_MockObject $databaseConnectionMock */
	private $databaseConnectionMock;

	/** @var DplTableSet|PHPUnit_Framework_MockObject_MockObject $dplTableSetMock */
	private $dplTableSetMock;

	/** @var DplRevisionQuerySegmentBuilder $dplRevisionQuerySegmentBuilder */
	private $dplRevisionQuerySegmentBuilder;

	protected function setUp() {
		parent::setUp();

		require_once __DIR__ . '/../DynamicPageList.php';

		$this->databaseConnectionMock = $this->createMock( DatabaseBase::class );
		$this->dplTableSetMock = $this->createMock( DplTableSet::class );

		$this->dplRevisionQuerySegmentBuilder =
			( new DplRevisionQuerySegmentBuilder( $this->databaseConnectionMock ) )
				->tableSet( $this->dplTableSetMock );

		$this->databaseConnectionMock->expects( $this->any() )
			->method( 'tableName' )
			->willReturnArgument( 0 );

		$this->databaseConnectionMock->expects( $this->any() )
			->method( 'addQuotes' )
			->willReturnArgument( 0 );
	}

	public function testNoQuerySegmentIsBuiltForEmptyUserArray() {
		$userArray = [];

		$this->dplTableSetMock->expects( $this->never() )
			->method( 'addTableAlias' );

		$this->assertEmpty(
			$this->dplRevisionQuerySegmentBuilder->buildCreatedByQuerySegment( $userArray )
		);

		$this->assertEmpty(
			$this->dplRevisionQuerySegmentBuilder->buildNotCreatedByQuerySegment( $userArray )
		);


		$this->assertEmpty(
			$this->dplRevisionQuerySegmentBuilder->buildModifiedByQuerySegment( $userArray )
		);


		$this->assertEmpty(
			$this->dplRevisionQuerySegmentBuilder->buildNotModifiedByQuerySegment( $userArray )
		);

		$this->assertEmpty(
			$this->dplRevisionQuerySegmentBuilder->buildLastModifiedByQuerySegment( $userArray )
		);


		$this->assertEmpty(
			$this->dplRevisionQuerySegmentBuilder->buildNotLastModifiedByQuerySegment( $userArray )
		);
	}

	public function testBuildCreatedByQuerySegmentUserId() {
		$this->dplTableSetMock->expects( $this->once() )
			->method( 'addTableAlias' )
			->with( 'revision', 'creation_rev' );

		$sqlQuerySegment =
			$this->dplRevisionQuerySegmentBuilder->buildCreatedByQuerySegment( static::TEST_USER_ARRAY_WITH_ID );

		$this->assertEquals(
			' AND creation_rev.rev_user = 123 AND creation_rev.rev_page = page_id AND creation_rev.rev_parent_id = 0',
			$sqlQuerySegment
		);
	}

	public function testBuildCreatedByQuerySegmentUserName() {
		$this->dplTableSetMock->expects( $this->once() )
			->method( 'addTableAlias' )
			->with( 'revision', 'creation_rev' );

		$sqlQuerySegment =
			$this->dplRevisionQuerySegmentBuilder->buildCreatedByQuerySegment( static::TEST_USER_ARRAY_WITH_NAME );

		$this->assertEquals(
			' AND creation_rev.rev_user_text = TestUser AND creation_rev.rev_page = page_id AND creation_rev.rev_parent_id = 0',
			$sqlQuerySegment
		);
	}

	public function testBuildNotCreatedByQuerySegmentUserId() {
		$this->dplTableSetMock->expects( $this->once() )
			->method( 'addTableAlias' )
			->with( 'revision', 'no_creation_rev' );

		$sqlQuerySegment = $this->dplRevisionQuerySegmentBuilder
			->buildNotCreatedByQuerySegment( static::TEST_USER_ARRAY_WITH_ID );

		$this->assertEquals(
			' AND no_creation_rev.rev_user != 123 AND no_creation_rev.rev_page = page_id AND no_creation_rev.rev_parent_id = 0',
			$sqlQuerySegment
		);
	}

	public function testBuildNotCreatedByQuerySegmentUserName() {
		$this->dplTableSetMock->expects( $this->once() )
			->method( 'addTableAlias' )
			->with( 'revision', 'no_creation_rev' );

		$sqlQuerySegment = $this->dplRevisionQuerySegmentBuilder
			->buildNotCreatedByQuerySegment( static::TEST_USER_ARRAY_WITH_NAME );

		$this->assertEquals(
			' AND no_creation_rev.rev_user_text != TestUser AND no_creation_rev.rev_page = page_id AND no_creation_rev.rev_parent_id = 0',
			$sqlQuerySegment
		);
	}

	public function testBuildModifiedByQuerySegmentUserId() {
		$this->dplTableSetMock->expects( $this->once() )
			->method( 'addTableAlias' )
			->with( 'revision', 'change_rev' );

		$sqlQuerySegment = $this->dplRevisionQuerySegmentBuilder
			->buildModifiedByQuerySegment( static::TEST_USER_ARRAY_WITH_ID );

		$this->assertEquals(
			' AND change_rev.rev_user = 123 AND change_rev.rev_page = page_id',
			$sqlQuerySegment
		);
	}


	public function testBuildModifiedByQuerySegmentUserName() {
		$this->dplTableSetMock->expects( $this->once() )
			->method( 'addTableAlias' )
			->with( 'revision', 'change_rev' );

		$sqlQuerySegment = $this->dplRevisionQuerySegmentBuilder
			->buildModifiedByQuerySegment( static::TEST_USER_ARRAY_WITH_NAME );

		$this->assertEquals(
			' AND change_rev.rev_user_text = TestUser AND change_rev.rev_page = page_id',
			$sqlQuerySegment
		);
	}

	public function testBuildNotModifiedByQuerySegmentUserId() {
		$this->dplTableSetMock->expects( $this->never() )
			->method( 'addTableAlias' );

		$sqlQuerySegment = $this->dplRevisionQuerySegmentBuilder
			->buildNotModifiedByQuerySegment( static::TEST_USER_ARRAY_WITH_ID );

		$this->assertEquals(
			' AND NOT EXISTS (SELECT 1 FROM revision WHERE revision.rev_page=page_id AND revision.rev_user = 123 LIMIT 1)',
			$sqlQuerySegment
		);
	}


	public function testBuildNotModifiedByQuerySegmentUserName() {
		$this->dplTableSetMock->expects( $this->never() )
			->method( 'addTableAlias' );

		$sqlQuerySegment = $this->dplRevisionQuerySegmentBuilder
			->buildNotModifiedByQuerySegment( static::TEST_USER_ARRAY_WITH_NAME );

		$this->assertEquals(
			' AND NOT EXISTS (SELECT 1 FROM revision WHERE revision.rev_page=page_id AND revision.rev_user_text = TestUser LIMIT 1)',
			$sqlQuerySegment
		);
	}

	public function testBuildLastModifiedByQuerySegmentUserId() {
		$this->dplTableSetMock->expects( $this->never() )
			->method( 'addTableAlias' );

		$sqlQuerySegment = $this->dplRevisionQuerySegmentBuilder
			->buildLastModifiedByQuerySegment( static::TEST_USER_ARRAY_WITH_ID );


		$this->assertEquals(
			' AND (SELECT rev_user FROM revision WHERE revision.rev_page=page_id ORDER BY revision.rev_timestamp DESC LIMIT 1) = 123',
			$sqlQuerySegment
		);
	}

	public function testBuildLastModifiedByQuerySegmentUserName() {
		$this->dplTableSetMock->expects( $this->never() )
			->method( 'addTableAlias' );

		$sqlQuerySegment = $this->dplRevisionQuerySegmentBuilder
			->buildLastModifiedByQuerySegment( static::TEST_USER_ARRAY_WITH_NAME );


		$this->assertEquals(
			' AND (SELECT rev_user_text FROM revision WHERE revision.rev_page=page_id ORDER BY revision.rev_timestamp DESC LIMIT 1) = TestUser',
			$sqlQuerySegment
		);
	}

	public function testBuildNotLastModifiedByQuerySegmentUserId() {
		$this->dplTableSetMock->expects( $this->never() )
			->method( 'addTableAlias' );

		$sqlQuerySegment = $this->dplRevisionQuerySegmentBuilder
			->buildNotLastModifiedByQuerySegment( static::TEST_USER_ARRAY_WITH_ID);

		$this->assertEquals(
			' AND (SELECT rev_user FROM revision WHERE revision.rev_page=page_id ORDER BY revision.rev_timestamp DESC LIMIT 1) != 123',
			$sqlQuerySegment
		);
	}

	public function testBuildNotLastModifiedByQuerySegmentUserName() {
		$this->dplTableSetMock->expects( $this->never() )
			->method( 'addTableAlias' );

		$sqlQuerySegment = $this->dplRevisionQuerySegmentBuilder
			->buildNotLastModifiedByQuerySegment( static::TEST_USER_ARRAY_WITH_NAME );

		$this->assertEquals(
			' AND (SELECT rev_user_text FROM revision WHERE revision.rev_page=page_id ORDER BY revision.rev_timestamp DESC LIMIT 1) != TestUser',
			$sqlQuerySegment
		);
	}
}

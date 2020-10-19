<?php
/**
 * @group Integration
 */
class UpdateListUsersTaskIntegrationTest extends WikiaDatabaseTest {
	const TEST_WIKI_ID = 1299;

	const USER_ID_WITH_DATA = 1;
	const USER_ID_WITHOUT_DATA = 2;

	/** @var EditCountService|PHPUnit_Framework_MockObject_MockObject $editCountServiceMock */
	private $editCountServiceMock;

	/** @var UpdateListUsersTask $updateListUsersTask */
	private $updateListUsersTask;

	/** @var DatabaseBase $dbr */
	private $dbr;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../SpecialListusers.php';

		$this->editCountServiceMock = $this->createMock( EditCountService::class );
		$this->updateListUsersTask =
			( new UpdateListUsersTask( $this->editCountServiceMock ) )
				->wikiId( static::TEST_WIKI_ID );

		$this->dbr = wfGetDB( DB_SLAVE );
	}

	protected function extraSchemaFiles() {
		yield __DIR__ . '/fixtures/local_user_groups.sql';
	}

	public function testEditUpdateInsertsNewDataForUser() {
		$this->editCountServiceMock->expects( $this->any() )
			->method( 'getEditCount' )
			->with( static::USER_ID_WITHOUT_DATA )
			->willReturn( 2500 );

		$this->updateListUsersTask->updateEditInformation( [
			'userId' => static::USER_ID_WITHOUT_DATA,
			'userGroups' => [ 'sysop', 'bureaucrat' ],
			'latestRevisionTimestamp' => '20171110000000',
			'latestRevisionId' => 3
		] );

		$row = $this->selectUserRow( static::USER_ID_WITHOUT_DATA );

		$this->assertEquals( 2500, $row->edits );
		$this->assertEquals( '2017-11-10 00:00:00', $row->editdate );
		$this->assertEquals( 3, $row->last_revision );

		$this->assertEquals( [ 'bureaucrat', 'sysop' ], $this->selectUserGroups( self::USER_ID_WITHOUT_DATA ) );
	}

	public function testEditUpdateUpdatesExistingDataForUser() {
		$this->editCountServiceMock->expects( $this->any() )
			->method( 'getEditCount' )
			->with( static::USER_ID_WITH_DATA )
			->willReturn( 1200 );

		$this->updateListUsersTask->updateEditInformation( [
			'userId' => static::USER_ID_WITH_DATA,
			'userGroups' => [ 'rollback' ],
			'latestRevisionTimestamp' => '20100101000000',
			'latestRevisionId' => 2
		] );

		$row = $this->selectUserRow( static::USER_ID_WITH_DATA );

		$this->assertEquals( 1200, $row->edits );
		$this->assertEquals( '2010-01-01 00:00:00', $row->editdate );
		$this->assertEquals( 2, $row->last_revision );

		$this->assertEquals( [ 'rollback' ], $this->selectUserGroups( self::USER_ID_WITH_DATA ) );
	}

	public function testGroupsUpdateInsertsNewDataForUser() {
		$this->editCountServiceMock->expects( $this->any() )
			->method( 'getEditCount' )
			->with( static::USER_ID_WITHOUT_DATA )
			->willReturn( 900 );

		$this->updateListUsersTask->updateUserGroups( [
			'userId' => static::USER_ID_WITHOUT_DATA,
			'userGroups' => [ 'sysop', 'bureaucrat', 'chatmoderator' ],
		] );

		$row = $this->selectUserRow( static::USER_ID_WITHOUT_DATA );

		$this->assertEquals( 900, $row->edits );
		$this->assertEquals( '2011-01-01 00:00:00', $row->editdate );
		$this->assertEquals( 3, $row->last_revision );

		$this->assertEquals(
			[ 'bureaucrat', 'chatmoderator', 'sysop' ],
			$this->selectUserGroups( self::USER_ID_WITHOUT_DATA )
		);
	}

	public function testGroupsUpdateUpdatesExistingDataForUser() {
		$this->markTestSkipped( 'SUS-4625' );

		$this->editCountServiceMock->expects( $this->never() )
			->method( 'getEditCount' );

		$this->updateListUsersTask->updateUserGroups( [
			'userId' => static::USER_ID_WITH_DATA,
			'userGroups' => [ 'chatmoderator' ],
		] );

		$row = $this->selectUserRow( static::USER_ID_WITH_DATA );

		$this->assertEquals( 1, $row->edits );
		$this->assertEquals( '2009-01-01 00:00:00', $row->editdate );
		$this->assertEquals( 1, $row->last_revision );

		$this->assertEquals( [ 'chatmoderator' ], $this->selectUserGroups( self::USER_ID_WITH_DATA ) );
	}

	private function selectUserGroups( int $userId ): array {
		return $this->dbr->selectFieldValues(
			'local_user_groups',
			'group_name',
			[ 'wiki_id' => static::TEST_WIKI_ID, 'user_id' => $userId ]
		);
	}

	private function selectUserRow( int $userId ) {
		return $this->dbr->selectRow( 'events_local_users', '*', [ 'wiki_id' => static::TEST_WIKI_ID, 'user_id' => $userId ] );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/update_task.yaml' );
	}
}

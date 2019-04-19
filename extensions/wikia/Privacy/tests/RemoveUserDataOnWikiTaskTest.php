<?php

/**
 * @group Integration
 */
class RemoveUserDataOnWikiTaskTest extends WikiaDatabaseTest {

	const TEST_USER_ID = 1;
	const TEST_USER = 'Test user';
	const TEST_USER_DB_KEY = 'Test_user';
	const OLD_TEST_USER_ID = 1;
	const OLD_TEST_USER = 'Old test user';
	const OLD_TEST_USER_DB_KEY = 'Old_test_user';
	const OTHER_TEST_USER = 'Other test user';
	const OTHER_TEST_USER_DB_KEY = 'Other_test_user';
	const TEST_AUDIT_ID = 1;

	/**
	 * Returns the test dataset.
	 *
	 * @return \PHPUnit\DbUnit\DataSet\IDataSet
	 */
	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/pii_data.yaml' );
	}

	protected function extraSchemaFiles() {
		return [
			__DIR__ . '/fixtures/audit_log.sql'
		];
	}

	protected function setUp() {
		parent::setUp();
		include __DIR__ . '/../Privacy.setup.php';
	}

	public function testShouldRemoveUserData() {
		(new RemoveUserDataOnWikiTask())->removeUserDataOnCurrentWiki( self::TEST_AUDIT_ID, self::TEST_USER_ID );
		$logPager = new CheckUserLogPager( null, [], null, null );
		$this->assertEquals( 1,  $logPager->getNumRows() );
		foreach ( $logPager->getResult() as $row ) {
			$this->assertNotEquals( self::TEST_USER_ID, $row->cul_target_id );
		}
	}

	public function testShouldRemoveIpsFromRecentChanges() {
		(new RemoveUserDataOnWikiTask())->removeUserDataOnCurrentWiki( self::TEST_AUDIT_ID, self::TEST_USER_ID );
		$dbr = wfGetDB( DB_SLAVE );
		$changes = $dbr->select( 'recentchanges', ['rc_user', 'rc_user_text', 'rc_ip_bin'] );
		foreach ( $changes as $change ) {
			if ( $change->rc_user == self::TEST_USER_ID ) {
				$this->assertTrue( empty( $change->rc_ip_bin ) );
			} else {
				$this->assertFalse( empty( $change->rc_ip_bin ) );
			}
		}
	}

	public function testShouldRemoveAbuseFilterData() {
		(new RemoveUserDataOnWikiTask())->removeUserDataOnCurrentWiki( self::TEST_AUDIT_ID, self::TEST_USER_ID );
		$dbr = wfGetDB( DB_SLAVE );
		// check filter author
		$filters = $dbr->select( 'abuse_filter', ['af_user', 'af_user_text'] );
		foreach ( $filters as $f ) {
			if ( $f->af_user == self::TEST_USER_ID ) {
				$this->assertTrue( empty( $f->af_user_text ) );
			}
		}
		// check author in filter history
		$history = $dbr->select( 'abuse_filter_history', ['afh_user', 'afh_user_text'] );
		foreach ( $history as $h ) {
			if ( $h->afh_user == self::TEST_USER_ID ) {
				$this->assertTrue( empty( $h->afh_user_text ) );
			}
		}
		// check abuse filter log
		$log = $dbr->select( 'abuse_filter_log', ['afl_user'], ['afl_user' => self::TEST_USER_ID] );
		$this->assertEquals( 0, $log->numRows() );
	}

	public function testShouldRemoveUserPageHistoryFromRecentChanges() {
		(new RemoveUserDataOnWikiTask())->removeUserDataOnCurrentWiki( self::TEST_AUDIT_ID, self::TEST_USER_ID );
		$dbr = wfGetDB( DB_SLAVE );
		$changes = $dbr->select( 'recentchanges', ['rc_namespace', 'rc_title'] );
		foreach ( $changes as $change ) {
			$isUserPage = in_array( $change->rc_namespace, RemoveUserDataOnWikiTask::USER_NAMESPACES );
			$startsWithUsername = strpos( $change->rc_title, self::TEST_USER_DB_KEY ) === 0;
			$this->assertFalse( $isUserPage && $startsWithUsername );
		}
	}

	public function testShouldRemoveUserPages() {
		( new RemoveUserDataOnWikiTask() )->removeUserDataOnCurrentWiki( self::TEST_AUDIT_ID, self::TEST_USER_ID, self::OLD_TEST_USER_ID );

		$dbr = wfGetDB( DB_SLAVE );

		$this->assertEquals( 0,
			$dbr->selectField( 'page', 'count(*)', [ 'page_title' => self::TEST_USER_DB_KEY ],
				__METHOD__ ),
			'page table contains data related to user who wants to be forgotten' );

		$this->assertEquals( 0,
			$dbr->selectField( 'page', 'count(*)', [ 'page_title' => self::OLD_TEST_USER_DB_KEY ],
				__METHOD__ ),
			'page table contains data related to renamed user who wants to be forgotten' );

		$this->assertEquals( 1,
			$dbr->selectField( 'page', 'count(*)', [ 'page_title' => self::OTHER_TEST_USER_DB_KEY ],
				__METHOD__ ),
			'page table doesn\'t contain data related to user who hasn\'t been removed' );
	}

	public function testShouldRemoveActionLogs() {
		( new RemoveUserDataOnWikiTask() )->removeUserDataOnCurrentWiki( self::TEST_AUDIT_ID, self::TEST_USER_ID );

		$db = wfGetDB( DB_MASTER );

		$logs = $db->select( 'logging', '*' );

		$this->assertEquals( 1, $logs->numRows(), 'Incorrect number of log records' );
		$this->assertEquals( 'Test_user1', $logs->next()->log_title, 'Incorrect log record' );
	}

	public function testShouldRemoveWatchlist() {
		( new RemoveUserDataOnWikiTask() )->removeUserDataOnCurrentWiki( self::TEST_AUDIT_ID, self::TEST_USER_ID );

		$db = wfGetDB( DB_SLAVE );

		$this->assertEquals( 0,
			$db->selectField( 'watchlist', 'count(*)', ['wl_user' => self::TEST_USER_ID], __METHOD__ ),
			'Watchlist is not empty');
	}

	public function testShouldHaveAuditLog() {
		(new RemoveUserDataOnWikiTask())->removeUserDataOnCurrentWiki( self::TEST_AUDIT_ID, self::TEST_USER_ID );

		$dbr = wfGetDB( DB_SLAVE );

		$this->assertEquals( 1,
			$dbr->selectField( 'rtbf_log_details', 'count(*)', [ 'log_id' => self::TEST_AUDIT_ID, 'was_successful' => 1 ],
				__METHOD__ ), 'No audit log found' );
	}

}

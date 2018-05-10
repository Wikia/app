<?php

/**
 * @group Integration
 */
class RemoveUserDataOnWikiTaskTest extends WikiaDatabaseTest {

	const TEST_USER_ID = 1;

	/**
	 * Returns the test dataset.
	 *
	 * @return \PHPUnit\DbUnit\DataSet\IDataSet
	 */
	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/pii_data.yaml' );
	}

	protected function extraSchemaFiles() {
		return [__DIR__ . '/fixtures/drop_test_tables.sql', __DIR__ . '/../../../AbuseFilter/abusefilter.tables.sqlite.sql', __DIR__ . '/fixtures/check_user.sql'];
	}

	protected function setUp() {
		parent::setUp();
		include __DIR__ . '/../Privacy.setup.php';
		$this->mockGlobalVariable( 'wgEnableAbuseFilterExtension', true );
	}

	public function testShouldRemoveCheckUserData() {
		(new RemoveUserDataOnWikiTask())->removeCheckUserData( self::TEST_USER_ID );
		$logPager = new CheckUserLogPager( null, [], null, null );
		$this->assertEquals( 1,  $logPager->getNumRows() );
		foreach ( $logPager->getResult() as $row ) {
			$this->assertNotEquals( self::TEST_USER_ID, $row->cul_target_id );
		}
	}
	
	public function testShouldRemoveIpsFromRecentChanges() {
		(new RemoveUserDataOnWikiTask())->removeIpFromRecentChanges( self::TEST_USER_ID );
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
		(new RemoveUserDataOnWikiTask())->removeAbuseFilterData( self::TEST_USER_ID );
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
	
}
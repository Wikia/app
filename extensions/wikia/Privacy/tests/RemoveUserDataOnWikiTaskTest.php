<?php

/**
 * @group Integration
 */
class RemoveUserDataOnWikiTaskTest extends WikiaDatabaseTest {

	const REMOVED_USER_ID = 1;
	const OTHER_USER_ID = 2;

	/**
	 * Returns the test dataset.
	 *
	 * @return \PHPUnit\DbUnit\DataSet\IDataSet
	 */
	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/pii_data.yaml' );
	}

	protected function extraSchemaFiles() {
		return [__DIR__ . '/../../../AbuseFilter/abusefilter.tables.sqlite.sql', __DIR__ . '/fixtures/cu_changes.sqllite.sql'];
	}

	protected function setUp() {
		parent::setUp();
		include __DIR__ . '/../Privacy.setup.php';
	}

	public function testShouldRemoveCheckUserData() {
		(new RemoveUserDataOnWikiTask())->removeData( self::REMOVED_USER_ID );
		$logPager = new CheckUserLogPager( null, [], null, null );
		$this->assertEquals( 1,  $logPager->getNumRows() );
		foreach ( $logPager->getResult() as $row ) {
			$this->assertNotEquals( self::REMOVED_USER_ID, $row->cul_target_id );
		}
	}
	
}
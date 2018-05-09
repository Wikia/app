<?php

/**
 * @group Integration
 */
class RemoveGlobalUserDataTaskTest extends WikiaDatabaseTest {

	const REMOVED_USER_ID = 1;
	const OTHER_USER_ID = 2;

	/**
	 * Returns the test dataset.
	 *
	 * @return \PHPUnit\DbUnit\DataSet\IDataSet
	 */
	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/pii_wikicities_data.yaml' );
	}

	protected function setUp() {
		parent::setUp();
		include __DIR__ . '/../Privacy.setup.php';
	}

	public function testShouldRemoveGlobalUserData() {
		//( new RemoveGlobalUserDataTask() )->removeData( self::REMOVED_USER_ID );

// TODO: implement test logic
		$this->assertTrue( true );
	}

}
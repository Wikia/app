<?php

class UserIdsAdapterTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	public function testOnEmptyResult() {
		$result = new stdClass();
		$adapter = new \Wikia\ExactTarget\UserIdsAdapter( [ $result ] );
		$this->assertEquals( [ ], $adapter->getUsersIds() );
	}

	public function testOnNullResult() {
		$adapter = new \Wikia\ExactTarget\UserIdsAdapter( [ null ] );
		$this->assertEquals( [ ], $adapter->getUsersIds() );
	}

	public function testGetEmail() {
		$result = new stdClass();
		$result->Properties->Property->Value = 1;
		$adapter = new \Wikia\ExactTarget\UserIdsAdapter( [ $result ] );
		$this->assertEquals( [ 1 ], $adapter->getUsersIds() );
	}
}

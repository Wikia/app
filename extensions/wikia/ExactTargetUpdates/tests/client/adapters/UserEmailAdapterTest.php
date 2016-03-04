<?php

class UserEmailAdapterTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	public function testGetEmptyEmail() {
		$result = new stdClass();
		$adapter = new \Wikia\ExactTarget\UserEmailAdapter( [ $result ] );
		$this->assertEquals( '', $adapter->getEmail() );
	}

	public function testGetEmail() {
		$result = new stdClass();
		$result->Properties->Property->Value = 'test@wikiatest.com';
		$adapter = new \Wikia\ExactTarget\UserEmailAdapter( [ $result ] );
		$this->assertEquals( 'test@wikiatest.com', $adapter->getEmail() );
	}
}

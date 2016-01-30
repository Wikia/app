<?php

class ExternalStoreDBFetchBlobHookTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../ExternalStoreDBFetchBlobHook.php';
		parent::setUp();
	}

	/**
	 * @group Integration
	 * @slowExecutionTime 0.8222 ms
	 */
	public function testApiCall() {
		$result = false;

		$mockApiURL = "http://community.wikia.com/api.php";
		$this->mockGlobalVariable( "wgFetchBlobApiURL", $mockApiURL);

		$expectedHash = "d41d8cd98f00b204e9800998ecf8427e";

		ExternalStoreDBFetchBlobHook( "archive1", "34", null, $result );
		$resultHash = md5( $result );

		$this->assertEquals( $expectedHash, $resultHash );
	}
}

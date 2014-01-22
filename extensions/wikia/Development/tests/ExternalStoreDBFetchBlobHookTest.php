<?php

class ExternalStoreDBFetchBlobHookTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../ExternalStoreDBFetchBlobHook.php';
		parent::setUp();
	}

	public function testApiCall() {
		$result = false;

		$mockApiURL = "http://community.wikia.com/api.php";
		$this->mockGlobalVariable( "wgFetchBlobApiURL", $mockApiURL);

		$expectedHash = "b5088eed4e6c1a2188fc32213b2715dc";

		ExternalStoreDBFetchBlobHook( "archive1", "34", null, $result );
		$resultHash = md5( $result );

		$this->assertEquals( $expectedHash, $resultHash );
	}
}

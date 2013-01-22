<?php

class ExternalStoreDBFetchBlobHookTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../ExternalStoreDBFetchBlobHook.php';
		parent::setUp();
	}

	public function testApiCall() {
		$result = false;
		ExternalStoreDBFetchBlobHook( "archive1", "34", null, $result );
		print $result;
	}
}

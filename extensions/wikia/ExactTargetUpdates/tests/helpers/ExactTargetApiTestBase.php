<?php

require_once __DIR__ . '/../../lib/exacttarget_soap_client.php';
use Wikia\Logger\WikiaLogger;

class ExactTargetApiTestBase extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../ExactTargetUpdates.setup.php';
		parent::setUp();
		require_once __DIR__ . '/ExactTargetApiWrapper.php';
	}

	protected function getExactTargetSoapClientMock() {
		return $this->getMockBuilder( '\ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Update', 'Delete', 'Create', '__getLastResponse' ] )
			->getMock();
	}

	protected function getWikiaLoggerMock() {
		return $this->getMockBuilder( 'Wikia\Logger\WikiaLogger' )
			->disableOriginalConstructor()
			->setMethods( [ 'info', 'error' ] )
			->getMock();
	}

}

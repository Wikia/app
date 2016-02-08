<?php

require_once __DIR__ . '/helpers/ExactTargetApiTestBase.php';
use Wikia\ExactTarget\ExactTargetApiSubscriber;

class ExactTargetApiSubscriberTest extends ExactTargetApiTestBase {

	const TEST_USER_ID = "1234";
	const TEST_USER_EMAIL = "test@wikia-inc.com";

	protected $taskHelper;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
		require_once __DIR__ . '/helpers/ExactTargetApiWrapper.php';

		$this->taskHelper = new Wikia\ExactTarget\ExactTargetUserTaskHelper();

	}


	public function testCreateRequest() {
		$responseValue = 'response';
		$lastRespose = 'last response';
		$mockLogger = $this->getWikiaLoggerMock();
		$mockSoapClient = $this->getExactTargetSoapClientMock();

		$mockSoapClient
			->expects( $this->once() )
			->method( 'Create' )
			// FIXME: we should be able to test what goes into Create
			->with( $this->anything() )
			->willReturn( $responseValue );

		$mockSoapClient
			->expects( $this->once() )
			->method( '__getLastResponse' )
			->willReturn( $lastRespose );

		$mockLogger
			->expects( $this->once() )
			->method( 'info' )
			->with( $this->matchesRegularExpression( "/.*{$lastRespose}.*/") );

		$subscriber = new ExactTargetApiSubscriber();
		$subscriber->setClient( $mockSoapClient );
		$subscriber->setLogger( $mockLogger );

		$params = $this->taskHelper->prepareSubscriberData( $sUserEmail );
		$this->assertEquals( $responseValue, $subscriber->createRequest( $params ) );
	}

}

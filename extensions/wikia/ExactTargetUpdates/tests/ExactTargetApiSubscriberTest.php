<?php

require_once __DIR__ . '/helpers/ExactTargetApiTestBase.php';
use Wikia\ExactTarget\ExactTargetApiSubscriber;

class ExactTargetApiSubscriberTest extends ExactTargetApiTestBase {

	const TEST_USER_ID = "1234";
	const TEST_USER_EMAIL = "test@wikia-inc.com";

	protected $helper;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
		require_once __DIR__ . '/helpers/ExactTargetApiWrapper.php';

		$this->helper = new Wikia\ExactTarget\ExactTargetApiHelper();
	}

	public function testCreateRequest() {
		$responseValue = 'response';
		$lastRespose = 'last response';
		$mockLogger = $this->getWikiaLoggerMock();
		$mockSoapClient = $this->getExactTargetSoapClientMock();

		$params = $this->createSubscriberParams( self::TEST_USER_EMAIL, false );
		$requestVars = $this->createRequestVars( $params );

		$mockSoapClient
			->expects( $this->once() )
			->method( 'Create' )
			->with( $requestVars )
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

		$this->assertEquals( $responseValue, $subscriber->createRequest( $params ) );
	}


	public function testDeleteRequest() {
		$responseValue = 'delete response';
		$lastRespose = 'last delete response';
		$mockLogger = $this->getWikiaLoggerMock();
		$mockSoapClient = $this->getExactTargetSoapClientMock();

		$params = $this->createSubscriberParams( self::TEST_USER_EMAIL, false );
		$requestVars = $this->deleteRequestVars( $params );

		$mockSoapClient
			->expects( $this->once() )
			->method( 'Delete' )
			->with( $requestVars )
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

		$this->assertEquals( $responseValue, $subscriber->deleteRequest( $params ) );
	}

	protected function createSubscriberParams( $email, $unsubscribed ) {
		return ['Subscriber' => array(array(
			'SubscriberKey' => self::TEST_USER_EMAIL,
			'EmailAddress' => self::TEST_USER_EMAIL,
			))];
	}

	protected function createRequestVars( $params ) {
		$makeCreateRequestParams = $this->helper->prepareSubscriberObjects( $params['Subscriber'] );
		$requestVars = $this->helper->wrapCreateRequest(
			$this->helper->prepareSoapVars( $makeCreateRequestParams, 'Subscriber' )
		);
		return $requestVars;
	}

	protected function deleteRequestVars( $params ) {
		$makeDeleteRequestParams = $this->helper->prepareSubscriberObjects( $params['Subscriber'] );
		$requestVars = $this->helper->wrapDeleteRequest(
			$this->helper->prepareSoapVars( $makeDeleteRequestParams, 'Subscriber' )
		);
		return $requestVars;
	}
}

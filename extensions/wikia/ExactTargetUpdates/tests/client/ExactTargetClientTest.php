<?php

class ExactTargetClientTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	public function testEmailRetrieval() {
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Retrieve' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Retrieve' )
			->will( $this->returnValue(
				$this->getResponse( [ [ 'user_email' => 'test@test.com' ] ], 'OK' )
			) );

		// inject into client wrapper
		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );

		$this->assertEquals( 'test@test.com', $client->retrieveEmailByUserId( 1 ) );
	}

	public function testUserIdsRetrieval() {
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Retrieve' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Retrieve' )
			->will( $this->returnValue(
				$this->getResponse( [ [ 'user_id' => 1 ], [ 'user_id' => 2 ] ], 'OK' )
			) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );

		$this->assertEquals( [ 1, 2 ], $client->retrieveUserIdsByEmail( 'test@test.com' ) );
	}

	public function testConsecutiveRetrieval() {
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Retrieve' ] )
			->getMock();
		$soapClientMock->expects( $this->exactly(3) )
			->method( 'Retrieve' )
			->will( $this->onConsecutiveCalls(
				$this->getResponse( [ [ 'user_id' => 1 ], [ 'user_id' => 2 ] ], 'MoreDataAvailable' ),
				$this->getResponse( [ [ 'user_id' => 3 ], [ 'user_id' => 4 ] ], 'MoreDataAvailable' ),
				$this->getResponse( [ [ 'user_id' => 5 ] ], 'OK' )
			) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );

		$this->assertEquals( [ 1, 2, 3, 4, 5 ], $client->retrieveUserIdsByEmail( 'test@test.com' ) );
	}

	public function testUserEditsRetrieval() {
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Retrieve' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Retrieve' )
			->will( $this->returnValue(
				$this->getResponse( [ [ 'user_id' => 1, 'wiki_id' => 1, 'contributions' => 2 ],
									  [ 'user_id' => 1, 'wiki_id' => 2, 'contributions' => 20 ] ], 'OK' )
			) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );

		$this->assertEquals( [ 1 => [ 1 => 2, 2 => 20 ] ], $client->retrieveUsersEdits( [ 1 ] ) );
	}

	public function testEmptyResult() {
		$this->setExpectedException( 'Wikia\ExactTarget\ExactTargetException', 'Request failed' );
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Create' ] )
			->getMock();

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );
		$client->createSubscriber( 'test@test.com' );
	}

	public function testErrorResponse() {
		$this->setExpectedException( 'Wikia\ExactTarget\ExactTargetException', 'Test error response' );
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Update' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Update' )
			->will( $this->returnValue( $this->getResponse( [ ], 'Error', 'Test error response' ) ) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );
		$client->updateUserProperties( 1, [ ] );
	}

	public function testDefaultErrorResponse() {
		$this->setExpectedException( 'Wikia\ExactTarget\ExactTargetException', \Wikia\ExactTarget\ExactTargetClient::EXACT_TARGET_REQUEST_FAILED );
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Update' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Update' )
			->will( $this->returnValue( $this->getResponse( [ ], 'Error' ) ) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );
		$client->updateUserProperties( 1, [ ] );
	}

	public function testRetryFunctionality() {
		$this->setExpectedException( 'Wikia\ExactTarget\ExactTargetException', 'Request failed' );
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Delete' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Delete' )
			->willThrowException( new \Exception( 'Test external failure' ) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );
		$client->deleteSubscriber( 1 );
	}

	public function testPathOnCorrectDeleteResponse() {
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Delete' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Delete' )
			->will( $this->returnValue( $this->getResponse( [ ], 'OK' ) ) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );
		$this->assertTrue( $client->deleteSubscriber( 'test@test.com' ) );
	}

	public function testPathOnCorrectCreateResponse() {
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Create' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Create' )
			->will( $this->returnValue( $this->getResponse( [ ], 'OK' ) ) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );
		$this->assertTrue( $client->createSubscriber( 'test@test.com' ) );
	}

	public function testCorrectResponseOnUserUpdate() {
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Update' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Update' )
			->will( $this->returnValue( $this->getResponse( [ ], 'OK' ) ) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );
		$this->assertTrue( $client->updateUser( [ 'user_id' => 1, 'user_email' => 'test@test.com' ] ) );
	}

	public function testCorrectResponseOnPropertiesUpdate() {
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Update' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Update' )
			->will( $this->returnValue( $this->getResponse( [ ], 'OK' ) ) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );
		$this->assertTrue( $client->updateUserProperties( 1, [ ] ) );
	}

	public function testDefaultClientConstruction() {
		$getExactTargetClient = new ReflectionMethod( '\Wikia\ExactTarget\ExactTargetClient', 'getExactTargetClient' );
		$getExactTargetClient->setAccessible( true );

		$wsdlPath = __DIR__ . '/../resources/mocked.wsdl';
		$username = 'test_username';
		$password = 'test_password';
		$wrapper = new \Wikia\Util\GlobalStateWrapper( [ 'wgExactTargetApiConfig' => [
			'username' => $username,
			'password' => $password,
			'wsdl' => $wsdlPath
		] ] );

		$expected = new ExactTargetSoapClient( $wsdlPath, [ 'trace' => 1 ] );
		$expected->username = $username;
		$expected->password = $password;

		$soapClient = $wrapper->wrap( function () use ( $getExactTargetClient ) {
			$client = new \Wikia\ExactTarget\ExactTargetClient();
			return $getExactTargetClient->invoke( $client );
		} );

		$this->assertEquals( $expected, $soapClient );
	}

	public function testWikiCategoriesMappingRetrieval() {
		$soapClientMock = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Retrieve' ] )
			->getMock();
		$soapClientMock->expects( $this->any() )
			->method( 'Retrieve' )
			->will( $this->returnValue(
				$this->getResponse( [ [ 'city_id' => 1, 'cat_id' => 2 ] ], 'OK' )
			) );

		$client = new \Wikia\ExactTarget\ExactTargetClient( $soapClientMock );

		$this->assertEquals( [ [ 'city_id' => 1, 'cat_id' => 2 ] ], $client->retrieveWikiCategories( 1 ) );
	}

	private function getResponse( $data, $status, $msg = '' ) {
		$response = new stdClass();
		$response->OverallStatus = $status;
		$response->RequestID = 'ABC-1234-XYZ';
		if ( !empty( $msg ) ) {
			$response->Results = new stdClass();
			$response->Results->StatusMessage = $msg;
		} else {
			$results = [ ];
			foreach ( $data as $item ) {
				$result = new stdClass();
				$result->Properties = new stdClass();
				$properties = [ ];
				foreach ( $item as $name => $value ) {
					$property = new stdClass();
					$property->Name = $name;
					$property->Value = $value;
					$properties[] = $property;
				}
				$result->Properties->Property = count( $properties ) == 1 ? $properties[ 0 ] : $properties;

				$results[] = $result;
			}
			$response->Results = count( $results ) == 1 ? $results[ 0 ] : $results;
		}

		return $response;
	}
}

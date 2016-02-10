<?php

use Wikia\ExactTarget\ExactTargetCreateUserTask;

class ExactTargetCreateUserTaskTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	function testSendNewUserShouldDistributeParams() {
		$createRequestReturn = "created";
		$updateFallbackCreateRequest = (object)array( 'OverallStatus' => 'ok' );
		$taskId = 100;
		/* Params to compare */
		$aUserData = [
			'user_id' => 12345,
			'user_email' => 'email@email.com'
		];
		$aUserProperties = [
			'property_name' => 'property_value'
		];

		$oDeleteUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetDeleteUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'deleteSubscriber', 'taskId' ] )
			->getMock();
		$oDeleteUserTask
			->expects( $this->once() )
			->method( 'deleteSubscriber' )
			->will( $this->returnValue( 8 ) );

		$verificationTask = $this->getMockBuilder( 'ExactTargetUserDataVerificationTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'taskId', 'verifyUsersData', 'verifyUserPropertiesData' ] )
			->getMock();
		$verificationTask->expects( $this->exactly( 2 ) )
			->method( 'taskId' )
			->with( $this->anything() );
		$verificationTask->expects( $this->once() )
			->method( 'verifyUsersData' )
			->with( $this->anything() )
			->will( $this->returnValue( true ) );
		$verificationTask->expects( $this->once() )
			->method( 'verifyUserPropertiesData' )
			->with( $this->anything() )
			->will( $this->returnValue( true ) );


		$taskProvider = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetTaskProvider' )
			->disableOriginalConstructor()
			->setMethods( [ 'getDeleteUserTask', 'getCreateUserTask', 'getRetrieveUserTask', 'getUserDataVerificationTask', 'getRetrieveWikiTask', 'getWikiDataVerificationTask', 'getUpdateWikiHelper', 'getUpdateUserTask' ] )
			->getMock();
		$taskProvider->expects( $this->once() )
			->method( 'getDeleteUserTask' )
			->will( $this->returnValue( $oDeleteUserTask ) );
		$taskProvider->expects( $this->exactly( 2 ) )
			->method( 'getUserDataVerificationTask' )
			->will( $this->returnValue( $verificationTask ) );


		$apiSubscriber = $this->getMockBuilder( 'ExactTargetApiSubscriber' )
			->disableOriginalConstructor()
			->setMethods( [ 'createRequest' ] )
			->getMock();
		$apiSubscriber->expects( $this->once() )
			->method( 'createRequest' )
			->with( $this->anything() ) // FIXME
			->will( $this->returnValue( $createRequestReturn ) );

		$dataExtension = $this->getMockBuilder( 'ExactTargetApiDataExtension' )
			->disableOriginalConstructor()
			->setMethods( [ 'updateFallbackCreateRequest' ] )
			->getMock();
		// FIXME: why is this being called twice? Is it necessary?
		$dataExtension->expects( $this->exactly( 2 ) )
			->method( 'updateFallbackCreateRequest' )
			->with( $this->anything() ) // FIXME
			->will( $this->returnValue( $updateFallbackCreateRequest ) );

		$apiProvider = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetApiProvider' )
			->disableOriginalConstructor()
			->setMethods( [ 'getApiSubscriber', 'getApiDataExtension' ] )
			->getMock();
		$apiProvider->expects( $this->once() )
			->method( 'getApiSubscriber' )
			->will( $this->returnValue( $apiSubscriber ) );
		$apiProvider->expects( $this->exactly( 2 ) )
			->method( 'getApiDataExtension' )
			->will( $this->returnValue( $dataExtension ) );

		$createUserTask = new ExactTargetCreateUserTask();
		$createUserTask->setApiProvider( $apiProvider );
		$createUserTask->setTaskProvider( $taskProvider );

		$this->assertEquals( 'OK', $createUserTask->updateCreateUserData( $aUserData, $aUserProperties ) );
	}

	function testCreateUserPropertiesDataExtensionShouldSendData() {
		/* Params to compare */
		$iUserId = 12345;
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		/* Prepare request object */
		$aApiParams = [ 'DataExtension' => [] ];
		foreach ( $aUserProperties as $sProperty => $sValue ) {
			$aApiParams[ 'DataExtension' ][] = [
				'CustomerKey' => 'user_properties',
				'Properties' => [ 'up_value' => $sValue ],
				'Keys' => [
					'up_user' => $iUserId,
					'up_property' => $sProperty
				]
			];
		}

		/* Mock api class */
		/* @var ExactTargetApiDataExtension $mockCreateUserTask mock of ExactTargetApiDataExtension */
		$mockApiDataExtension = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetApiDataExtension' )
			->disableOriginalConstructor()
			->setMethods( [ 'updateFallbackCreateRequest' ] )
			->getMock();
		$mockApiDataExtension
			->expects( $this->once() )
			->method( 'updateFallbackCreateRequest' )
			->with( $aApiParams );

		/* Mock tested class */
		/* @var ExactTargetCreateUserTask $mockCreateUserTask mock of ExactTargetCreateUserTask */
		$mockCreateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetCreateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getApiDataExtension' ] )
			->getMock();
		$mockCreateUserTask
			->expects( $this->once() )
			->method( 'getApiDataExtension' )
			->will( $this->returnValue( $mockApiDataExtension ) );

		/* Run tested method */
		$mockCreateUserTask->createUserProperties( $iUserId, $aUserProperties );
	}

	function testCreateUserDataExtensionShouldSendData() {
		/* Params to compare */
		$aUserData = [
			'user_id' => 12345,
			'user_email' => 'email@email.com'
		];

		/* Prepare request object */
		$aApiParams = [ 'DataExtension' => [] ];
		$aApiParams[ 'DataExtension' ][] = [
			'CustomerKey' => 'user',
			'Keys' => [ 'user_id' => $aUserData['user_id'] ],
			'Properties' => [ 'user_email' => $aUserData['user_email'] ]
		];

		/* Mock api class */
		/* @var ExactTargetApiDataExtension $mockCreateUserTask mock of ExactTargetApiDataExtension */
		$mockApiDataExtension = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetApiDataExtension' )
			->disableOriginalConstructor()
			->setMethods( [ 'updateFallbackCreateRequest' ] )
			->getMock();
		$mockApiDataExtension
			->expects( $this->once() )
			->method( 'updateFallbackCreateRequest' )
			->with( $aApiParams );

		/* Mock tested class */
		/* @var ExactTargetCreateUserTask $mockCreateUserTask mock of ExactTargetCreateUserTask */
		$mockCreateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetCreateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getApiDataExtension' ] )
			->getMock();
		$mockCreateUserTask
			->expects( $this->once() )
			->method( 'getApiDataExtension' )
			->will( $this->returnValue( $mockApiDataExtension ) );

		/* Run tested method */
		$mockCreateUserTask->createUser( $aUserData );
	}

	function testCreateSubscriberShouldSendData() {
		/* Params to compare */
		$sUserEmail = 'email@email.com';

		$aApiParams = [
			'Subscriber' => [
				[
					'SubscriberKey' => $sUserEmail,
					'EmailAddress' => $sUserEmail,
					'Status' => ExactTarget_SubscriberStatus::Active,
				]
			],
		];

		/* @var ExactTargetApiDataExtension $mockCreateUserTask mock of ExactTargetApiDataExtension */
		$mockApiDataExtension = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetApiSubscriber' )
			->disableOriginalConstructor()
			->setMethods( [ 'createRequest' ] )
			->getMock();
		$mockApiDataExtension
			->expects( $this->once() )
			->method( 'createRequest' )
			->with( $aApiParams );


		/* Mock tested class */
		/* @var ExactTargetCreateUserTask $mockCreateUserTask mock of ExactTargetCreateUserTask */
		$mockCreateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetCreateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getApiSubscriber' ] )
			->getMock();
		$mockCreateUserTask
			->expects( $this->once() )
			->method( 'getApiSubscriber' )
			->will( $this->returnValue( $mockApiDataExtension ) );

		/* Run tested method */
		$mockCreateUserTask->createSubscriber( $sUserEmail );
	}

}

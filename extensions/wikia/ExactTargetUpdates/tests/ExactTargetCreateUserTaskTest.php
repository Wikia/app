<?php

use Wikia\ExactTarget\ExactTargetCreateUserTask;

class ExactTargetCreateUserTaskTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
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
					'EmailAddress' => $sUserEmail
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

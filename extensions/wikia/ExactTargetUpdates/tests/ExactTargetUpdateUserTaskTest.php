<?php

require_once __DIR__ . '/../lib/exacttarget_soap_client.php';

class ExactTargetUpdateUserTaskTest extends WikiaBaseTest {

	function testShouldInvokeUpdateMethodWithProperParam() {
		$sCustomerKey = 'sample_table_name';

		/* Input params */
		$aUserData = [ 'user_id' => 12345 ];
		$aUserProperties = [
			'property_name' => 'property_value'
		];

		/* Expected update params */
		$aApiParams = [
			'DataExtension' => [
				0 => [
					'CustomerKey' => $sCustomerKey,
					'Properties' => [
						'up_value' => 'property_value'
					],
					'Keys' => [
						'up_user' => 12345,
						'up_property' => 'property_name'
					]
				]
			]
		];

		/* @var ExactTargetApiDataExtension $mockApiDataExtension mock of ExactTargetApiDataExtension */
		$mockApiDataExtension = $this->getMockBuilder( 'Wikia\ExactTarget\Api\ExactTargetApiDataExtension' )
			->disableOriginalConstructor()
			->setMethods( [ 'updateRequest' ] )
			->getMock();
		$mockApiDataExtension
			->expects( $this->once() )
			->method( 'updateRequest' )
			->with( $aApiParams );

		/* @var ExactTargetUserTaskHelper $mockApiDataExtension mock of ExactTargetUserTaskHelper */
		$mockUserHelper = $this->getMockBuilder( 'Wikia\ExactTarget\Tasks\ExactTargetUserTaskHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getCustomerKeys' ] )
			->getMock();
		$mockUserHelper
			->expects( $this->once() )
			->method( 'getCustomerKeys' )
			->will( $this->returnValue([ 'user_properties' => $sCustomerKey ]) );

		/* Mock tested class */
		$mockUpdateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\Tasks\ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getApiDataExtension', 'getHelper' ] )
			->getMock();
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getApiDataExtension' )
			->will( $this->returnValue( $mockApiDataExtension ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getHelper' )
			->will( $this->returnValue( $mockUserHelper ) );

		/* @var Wikia\ExactTarget\Tasks\ExactTargetUpdateUserTask $mockUpdateUserTask */
		$mockUpdateUserTask->updateUserPropertiesData( $aUserData, $aUserProperties );
	}

	/**
	 * @dataProvider updateUserEmailProvider
	 */
	function testUpdateUserEmailShouldSendData( $aUserData, $aApiParams, $aMockCustomerKey ) {

		/* @var ExactTargetApiDataExtension $mockApiDataExtension mock of ExactTargetApiDataExtension */
		$mockApiDataExtension = $this->getMockBuilder( 'Wikia\ExactTarget\Api\ExactTargetApiDataExtension' )
			->disableOriginalConstructor()
			->setMethods( [ 'updateRequest' ] )
			->getMock();
		$mockApiDataExtension
			->expects( $this->once() )
			->method( 'updateRequest' )
			->with( $aApiParams );

		/* @var ExactTargetUserTaskHelper $mockApiDataExtension mock of ExactTargetUserTaskHelper */
		$mockUserHelper = $this->getMockBuilder( 'Wikia\ExactTarget\Tasks\ExactTargetUserTaskHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getCustomerKeys' ] )
			->getMock();
		$mockUserHelper
			->expects( $this->once() )
			->method( 'getCustomerKeys' )
			->will( $this->returnValue( $aMockCustomerKey ) );

		/* Mock ExactTargetCreateUserTask */
		$mockCreateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\Tasks\ExactTargetCreateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'createSubscriber' ] )
			->getMock();
		$mockCreateUserTask
			->expects( $this->once() )
			->method( 'createSubscriber' );

		/* Mock tested class */
		/* @var Wikia\ExactTarget\Tasks\ExactTargetUpdateUserTask $mockUpdateUserTask */
		$mockUpdateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\Tasks\ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getApiDataExtension', 'getCreateUserTask', 'getHelper' ] )
			->getMock();
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getApiDataExtension' )
			->will( $this->returnValue( $mockApiDataExtension ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getHelper' )
			->will( $this->returnValue( $mockUserHelper ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getCreateUserTask' )
			->will( $this->returnValue( $mockCreateUserTask ) );

		/* Run tested method */
		$mockUpdateUserTask->updateUserEmail( $aUserData[ 'user_id' ], $aUserData[ 'user_email' ] );
	}


	/**
	 * DATA PROVIDERS
	 */


	function updateUserEmailProvider() {
		$sCustomerKey = 'sample_table_name';

		$aMockCustomerKey = [ 'user' => $sCustomerKey ];

		/* Params to compare */
		$aUserData = [
			'user_id' => 12345,
			'user_email' => 'email@email.com'
		];

		$aApiParams = [
			'DataExtension' => [
				0 => [
					'CustomerKey' => $sCustomerKey,
					'Properties' => [
						'user_email' => $aUserData[ 'user_email']
					],
					'Keys' => [
						'user_id' => $aUserData[ 'user_id'],
					]
				]
			]
		];


		return [
			[ $aUserData, $aApiParams, $aMockCustomerKey ]
		];
	}

}

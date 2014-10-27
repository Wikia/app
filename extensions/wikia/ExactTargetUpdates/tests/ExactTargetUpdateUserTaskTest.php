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
	 * prepareUserPropertiesUpdateParams should set Keys property of ExactTarget_DataExtensionObject
	 * to define API query filter for update
	 */
	function _testShouldSetKeysProperty() {
		$iUserId = 12345;
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2',
		];

		/* Create new DataExtensionObject */
		$aDataExtensionExpected = new ExactTarget_DataExtensionObject();
		$aDataExtensionExpected->CustomerKey = 'user_properties';

		$keys = [];
		$properties = [];

		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'up_user';
		$apiProperty->Value = $iUserId;
		$keys[] = $apiProperty;

		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'up_property';
		$apiProperty->Value = 'property1';// Property name taken from $aUserProperties above
		$keys[] = $apiProperty;


		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'up_value';
		$apiProperty->Value = 'value1';// Value taken from $aUserProperties above
		$properties[] = $apiProperty;

		$aDataExtensionExpected->Keys = $keys;
		$aDataExtensionExpected->Properties = $properties;// Value taken from $aUserProperties above

		/* @var ExactTargetUpdateUserTask $mockUpdateUserTask */
		$mockUpdateUserTask = $this->getMockBuilder( 'ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( NULL )
			->getMock();

		/* Run tested method */
		$aDataExtensionActual = $mockUpdateUserTask->prepareUserPropertiesUpdateParams( $iUserId, $aUserProperties );

		/* Check assertions */
		$this->assertEquals( sizeof( $aDataExtensionActual ), 2 );
		$this->assertEquals( $aDataExtensionActual[ 0 ], $aDataExtensionExpected );
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
	 * @dataProvider updateUserDataProvider
	 */
	function _testShouldPrepareUserDataExtensionObject( $aUserData, $oDEExpected ) {
		$mockUpdateUserTask = $this->getMockBuilder( 'ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( null )
			->getMock();

		$oDEActual = $mockUpdateUserTask->prepareUserDataExtensionObjectsForUpdate( $aUserData );
		$this->assertEquals( $oDEExpected, $oDEActual );
	}


	/**
	 * DATA PROVIDERS
	 */

	function _updateUserDataProvider() {
		$aUserData = [
			'user_id' => 12345,
			'user_editcount' => 10
		];

		$oDE = new ExactTarget_DataExtensionObject();
		$oDE->CustomerKey = 'user';

		/* Prepare properties */
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'user_editcount';
		$apiProperty->Value = $aUserData['user_editcount'];
		$oDE->Properties = [ $apiProperty ];

		/* Prepare keys */
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'user_id';
		$apiProperty->Value = $aUserData['user_id'];
		$oDE->Keys = [ $apiProperty ];

		return [
			[ $aUserData, $oDE ]
		];
	}

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

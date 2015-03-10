<?php

class ExactTargetUpdateUserTaskTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider shouldInvokeUpdateMethodWithProperParamProvider
	 */
	function testShouldInvokeUpdateMethodWithProperParam( $aInvokeParams, $aApiParams, $aCustomerKeys, $sInvokeMethodName ) {

		/* @var ExactTargetApiDataExtension $mockApiDataExtension mock of ExactTargetApiDataExtension */
		$mockApiDataExtension = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetApiDataExtension' )
			->disableOriginalConstructor()
			->setMethods( [ 'updateRequest' ] )
			->getMock();
		$mockApiDataExtension
			->expects( $this->once() )
			->method( 'updateRequest' )
			->with( $aApiParams );

		/* @var ExactTargetUserTaskHelper $mockApiDataExtension mock of ExactTargetUserTaskHelper */
		$mockUserHelper = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetUserTaskHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getCustomerKeys' ] )
			->getMock();
		$mockUserHelper
			->expects( $this->once() )
			->method( 'getCustomerKeys' )
			->will( $this->returnValue( $aCustomerKeys ) );

		/* Mock tested class */
		/* @var Wikia\ExactTarget\ExactTargetUpdateUserTask $mockUpdateUserTask */
		$mockUpdateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getApiDataExtension', 'getUserHelper' ] )
			->getMock();
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getApiDataExtension' )
			->will( $this->returnValue( $mockApiDataExtension ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getUserHelper' )
			->will( $this->returnValue( $mockUserHelper ) );

		call_user_func_array( [ $mockUpdateUserTask, $sInvokeMethodName ], $aInvokeParams );
	}

	/**
	 * @dataProvider updateUserEmailProvider
	 */
	function testUpdateUserEmailShouldSendData( $aUserData, $aApiParams, $aMockCustomerKey ) {

		/* @var ExactTargetApiDataExtension $mockApiDataExtension mock of ExactTargetApiDataExtension */
		$mockApiDataExtension = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetApiDataExtension' )
			->disableOriginalConstructor()
			->setMethods( [ 'updateRequest' ] )
			->getMock();
		$mockApiDataExtension
			->expects( $this->once() )
			->method( 'updateRequest' )
			->with( $aApiParams );

		/* @var ExactTargetUserTaskHelper $mockApiDataExtension mock of ExactTargetUserTaskHelper */
		$mockUserHelper = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetUserTaskHelper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getCustomerKeys' ] )
			->getMock();
		$mockUserHelper
			->expects( $this->once() )
			->method( 'getCustomerKeys' )
			->will( $this->returnValue( $aMockCustomerKey ) );

		/* Mock ExactTargetCreateUserTask */
		$mockCreateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetCreateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'createSubscriber' ] )
			->getMock();
		$mockCreateUserTask
			->expects( $this->once() )
			->method( 'createSubscriber' );

		/* Mock ExactTargetCreateUserTask */
		$mockDeleteUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetDeleteUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'deleteSubscriber' ] )
			->getMock();
		$mockDeleteUserTask
			->expects( $this->once() )
			->method( 'deleteSubscriber' );

		/* Mock tested class */
		/* @var Wikia\ExactTarget\ExactTargetUpdateUserTask $mockUpdateUserTask */
		$mockUpdateUserTask = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getApiDataExtension', 'getCreateUserTask', 'getDeleteUserTask', 'getUserHelper' ] )
			->getMock();
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getApiDataExtension' )
			->will( $this->returnValue( $mockApiDataExtension ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getUserHelper' )
			->will( $this->returnValue( $mockUserHelper ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getCreateUserTask' )
			->will( $this->returnValue( $mockCreateUserTask ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getDeleteUserTask' )
			->will( $this->returnValue( $mockDeleteUserTask ) );

		/* Run tested method */
		$mockUpdateUserTask->updateUserEmail( $aUserData['user_id'], $aUserData['user_email'] );
	}


	/**
	 * DATA PROVIDERS
	 */


	function shouldInvokeUpdateMethodWithProperParamProvider() {
		$sCustomerKey = 'sample_table_name';
		$aCustomerKeys = [
			'user_properties' => $sCustomerKey,
			'user' => $sCustomerKey
		];

		/* User properties update params */
		$sUpdateUserPropertiesMethodName = 'updateUserPropertiesData';
		$aUserData1 = [ 'user_id' => 12345 ];
		$aUserProperties = [
			'property_name' => 'property_value'
		];
		$aInvokeParamsUserProperties = [ $aUserData1, $aUserProperties ];
		$aUserPropertiesApiParams = [
			'DataExtension' => [
				0 => [
					'CustomerKey' => $sCustomerKey,
					'Properties' => [
						'up_value' => $aUserProperties['property_name']
					],
					'Keys' => [
						'up_user' => $aUserData1['user_id'],
						'up_property' => 'property_name'
					]
				]
			]
		];

		/* User update params */
		$sUpdateUserMethodName = 'updateUserData';
		$iUserId = 12345;
		$aUserData2 = [
			'user_field1' => 'value1',
			'user_field2' => 'value2',
		];
		$aInvokeParamsUser = [ array_merge( $aUserData2, [ 'user_id' => $iUserId ] ) ];
		$aUserApiParams = [
			'DataExtension' => [
				[
					'CustomerKey' => $sCustomerKey,
					'Properties' => $aUserData2,
					'Keys' => [ 'user_id' => $iUserId ]
				]
			]
		];

		return [
			[ $aInvokeParamsUserProperties, $aUserPropertiesApiParams, $aCustomerKeys, $sUpdateUserPropertiesMethodName ],
			[ $aInvokeParamsUser, $aUserApiParams, $aCustomerKeys, $sUpdateUserMethodName ],
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
						'user_email' => $aUserData['user_email']
					],
					'Keys' => [
						'user_id' => $aUserData['user_id'],
					]
				]
			]
		];

		return [
			[ $aUserData, $aApiParams, $aMockCustomerKey ]
		];
	}

}

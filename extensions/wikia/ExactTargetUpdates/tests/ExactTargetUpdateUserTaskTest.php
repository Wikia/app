<?php

require_once __DIR__ . '/../lib/exacttarget_soap_client.php';

class ExactTargetUpdateUserTaskTest extends WikiaBaseTest {

	function testShouldInvokeUpdateMethodWithProperParam() {
		/* Params to compare */
		$iUserId = 12345;
		$aUserProperties = [];

		$oRequest = new ExactTarget_CreateRequest();

		$soapClient = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Update' ] )
			->getMock();
		$soapClient
			->expects( $this->once() )
			->method( 'Update' )
			->with( $oRequest );

		/* Mock tested class */
		$mockUpdateUserTask = $this->getMockBuilder( 'ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'wrapUpdateRequest', 'getClient' ] )
			->getMock();
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'wrapUpdateRequest' )
			->will( $this->returnValue( $oRequest ) );

		/* @var ExactTargetUpdateUserTask $mockUpdateUserTask */
		$mockUpdateUserTask->updateUserPropertiesDataExtension( $iUserId, $aUserProperties, $soapClient );
	}

	/**
	 * prepareUserPropertiesDataExtensionObjectsForUpdate should set Keys property of ExactTarget_DataExtensionObject
	 * to define API query filter for update
	 */
	function testShouldSetKeysProperty() {
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
		$aDataExtensionActual = $mockUpdateUserTask->prepareUserPropertiesDataExtensionObjectsForUpdate( $iUserId, $aUserProperties );

		/* Check assertions */
		$this->assertEquals( sizeof( $aDataExtensionActual ), 2 );
		$this->assertEquals( $aDataExtensionActual[ 0 ], $aDataExtensionExpected );
	}

	function testUpdateUserEmailShouldSendData() {
		/* Params to compare */
		$aUserData = [
			'user_id' => 12345,
			'user_email' => 'email@email.com'
		];

		/* Prepare request object */
		$oUpdateRequest = new ExactTarget_UpdateRequest();

		$DE = new ExactTarget_DataExtensionObject();
		$DE->CustomerKey = 'user';

		/* Prepare properties */
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'user_email';
		$apiProperty->Value = $aUserData['user_email'];
		$DE->Properties = [ $apiProperty ];

		/* Prepare keys */
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'user_id';
		$apiProperty->Value = $aUserData['user_id'];
		$DE->Keys = [ $apiProperty ];

		$soapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', 'http://exacttarget.com/wsdl/partnerAPI' );

		/* Prepare update-add options */
		$oUpdateRequest->Options = null;
		$oUpdateRequest->Objects = [ $soapVar ];

		$soapClient = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Update' ] )
			->getMock();
		$soapClient
			->expects( $this->once() )
			->method( 'Update' )
			->with( $oUpdateRequest );

		/* @var ExactTargetAddUserTask $mockAddUserTask mock of ExactTargetAddUserTask */
		$mockAddUserTask = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'createSubscriber' ] )
			->getMock();
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'createSubscriber' );

		/* Mock tested class */
		/* @var ExactTargetUpdateUserTask $mockUpdateUserTask mock of ExactTargetUpdateUserTask */
		$mockUpdateUserTask = $this->getMockBuilder( 'ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getClient', 'getAddUserTaskObject' ] )
			->getMock();
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getAddUserTaskObject' )
			->will( $this->returnValue( $mockAddUserTask ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getClient' )
			->will( $this->returnValue( $soapClient ) );

		/* Run tested method */
		$mockUpdateUserTask->updateUserEmail( $aUserData[ 'user_id' ], $aUserData[ 'user_email' ] );
	}

}

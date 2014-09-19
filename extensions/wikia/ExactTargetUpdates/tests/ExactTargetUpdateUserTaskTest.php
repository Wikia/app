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

}

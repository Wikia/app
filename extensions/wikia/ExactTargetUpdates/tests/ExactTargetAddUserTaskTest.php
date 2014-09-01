<?php

include __DIR__ . '/../lib/exacttarget_soap_client.php';

class ExactTargetAddUserTaskTest extends WikiaBaseTest {


	function testSendNewUserShouldInvokeCreateSubscriber() {
		/* Params to compare */
		$aUserData = [
			'user_id' => '12345',
			'user_email' => 'email@email.com'
		];
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		$addTaskMock = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'createUserPropertiesDataExtension', 'CreateUserDE', 'createSubscriber' ] )
			->getMock();
		$addTaskMock
			->expects( $this->once() )
			->method( 'createSubscriber' )
			->will(  $this->returnValue( NULL ) );

		$addTaskMock->sendNewUserData( $aUserData, $aUserProperties );
	}

	function testSendNewUserShouldInvokeCreateUserDE() {
		/* Params to compare */
		$aUserData = [
			'user_id' => '12345',
			'user_email' => 'email@email.com'
		];

		$addTaskMock = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'createUserPropertiesDataExtension', 'CreateUserDE', 'createSubscriber' ] )
			->getMock();
		$addTaskMock
			->expects( $this->once() )
			->method( 'CreateUserDE' )
			->will(  $this->returnValue( NULL ) );

		$addTaskMock->sendNewUserData( $aUserData );
	}

	function testSendNewUserShouldInvokeCreateUserPropertiesDataExtension() {
		/* Params to compare */
		$aUserData = [
			'user_id' => '12345',
			'user_email' => 'email@email.com'
		];
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		$addTaskMock = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'createUserPropertiesDataExtension', 'CreateUserDE', 'createSubscriber' ] )
			->getMock();
		$addTaskMock
			->expects( $this->once() )
			->method( 'createUserPropertiesDataExtension' )
			->will( $this->returnValue( NULL ) );

		$addTaskMock->sendNewUserData( $aUserData['user_id'], $aUserProperties );
	}

	function testPrepareRequestShouldReturnRequestObject() {
		/* Params to compare */
		$iUserId = 12345;
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		/* prepare request mock */
		$aSoapVars = [];
		foreach ( $aUserProperties as $sProperty => $sValue ) {

			$DE = new ExactTarget_DataExtensionObject();
			$DE->CustomerKey = 'user_properties';

			$apiPropertyUser = new ExactTarget_APIProperty();
			$apiPropertyUser->Name = 'up_user';
			$apiPropertyUser->Value = $iUserId;

			$apiPropertyProperty = new ExactTarget_APIProperty();
			$apiPropertyProperty->Name = 'up_property';
			$apiPropertyProperty->Value = $sProperty;

			$apiPropertyValue = new ExactTarget_APIProperty();
			$apiPropertyValue->Name = 'up_value';
			$apiPropertyValue->Value = $sValue;

			$apiProperties = [ $apiPropertyUser, $apiPropertyProperty, $apiPropertyValue ];

			$DE->Properties = $apiProperties;

			$soapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', 'http://exacttarget.com/wsdl/partnerAPI' );
			$aSoapVars[] = $soapVar;
		}

		$oRequestExpected = new ExactTarget_CreateRequest();

		$oRequestExpected->Options = NULL;
		$oRequestExpected->Objects = $aSoapVars;

		/* Mock tested class */
		$mockAddUserTask = $this->getMock( 'ExactTargetAddUserTask', [ 'getClient' ] );

		/* Run test */
		$oRequestActual = $mockAddUserTask->prepareRequest( $iUserId, $aUserProperties );
		$this->assertEquals( $oRequestExpected, $oRequestActual );
	}

	function testCreateUserPropertiesDataExtensionShouldInvokeCreateMethodOnceWithRequestParam() {
		/* Params to compare */
		$iUserId = 12345;
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		/* Prepare request object */
		$aSoapVars = [];
		foreach ( $aUserProperties as $sProperty => $sValue ) {

			$DE = new ExactTarget_DataExtensionObject();
			$DE->CustomerKey = 'user_properties';

			$apiPropertyUser = new ExactTarget_APIProperty();
			$apiPropertyUser->Name = 'up_user';
			$apiPropertyUser->Value = $iUserId;

			$apiPropertyProperty = new ExactTarget_APIProperty();
			$apiPropertyProperty->Name = 'up_property';
			$apiPropertyProperty->Value = $sProperty;

			$apiPropertyValue = new ExactTarget_APIProperty();
			$apiPropertyValue->Name = 'up_value';
			$apiPropertyValue->Value = $sValue;

			$apiProperties = [ $apiPropertyUser, $apiPropertyProperty, $apiPropertyValue ];

			$DE->Properties = $apiProperties;

			$soapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', 'http://exacttarget.com/wsdl/partnerAPI' );
			$aSoapVars[] = $soapVar;
		}

		$oRequest = new ExactTarget_CreateRequest();

		$oRequest->Options = NULL;
		$oRequest->Objects = $aSoapVars;

		$soapClient = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Create' ] )
			->getMock();
		$soapClient
			->expects( $this->once() )
			->method( 'Create' )
			->with( $oRequest );

		/* Mock tested class */
		$mockAddUserTask = $this->getMock( 'ExactTargetAddUserTask', ['prepareRequest', 'getClient'] );
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'prepareRequest' )
			->will( $this->returnValue( $oRequest ) );
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'getClient' )
			->will( $this->returnValue( $soapClient ) );

		/* Run test */
		$mockAddUserTask->createUserPropertiesDataExtension( $iUserId, $aUserProperties );
	}
}

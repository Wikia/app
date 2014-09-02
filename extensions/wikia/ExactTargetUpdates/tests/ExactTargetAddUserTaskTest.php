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
			->setMethods( [ 'createUserPropertiesDataExtension', 'createUserDataExtension', 'createSubscriber' ] )
			->getMock();
		$addTaskMock
			->expects( $this->once() )
			->method( 'createSubscriber' )
			->will(  $this->returnValue( NULL ) );

		$addTaskMock->sendNewUserData( $aUserData, $aUserProperties );
	}

	function testSendNewUserShouldInvokecreateUserDataExtension() {
		/* Params to compare */
		$aUserData = [
			'user_id' => '12345',
			'user_email' => 'email@email.com'
		];

		$addTaskMock = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'createUserPropertiesDataExtension', 'createUserDataExtension', 'createSubscriber' ] )
			->getMock();
		$addTaskMock
			->expects( $this->once() )
			->method( 'createUserDataExtension' )
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
			->setMethods( [ 'createUserPropertiesDataExtension', 'createUserDataExtension', 'createSubscriber' ] )
			->getMock();
		$addTaskMock
			->expects( $this->once() )
			->method( 'createUserPropertiesDataExtension' )
			->will( $this->returnValue( NULL ) );

		$addTaskMock->sendNewUserData( $aUserData['user_id'], $aUserProperties );
	}

	function testPrepareUserPropertiesSoapVarsShouldReturnSoapVarsArray() {
		/* Params to compare */
		$iUserId = 12345;
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		/* prepare request mock */
		$aSoapVarsExpected = [];
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
			$aSoapVarsExpected[] = $soapVar;
		}

		/* Mock tested class */
		/* @var ExactTargetAddUserTask $mockAddUserTask (mock of ExactTargetAddUserTask) */
		$mockAddUserTask = $this->getMock( 'ExactTargetAddUserTask', [ 'getClient' ] );

		/* Run test */
		$aSoapVarsActual = $mockAddUserTask->prepareUserPropertiesSoapVars( $iUserId, $aUserProperties );
		$this->assertEquals( $aSoapVarsExpected, $aSoapVarsActual );
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
		$mockAddUserTask = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'wrapRequest', 'getClient' ] )
			->getMock();
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'wrapRequest' )
			->will( $this->returnValue( $oRequest ) );
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'getClient' )
			->will( $this->returnValue( $soapClient ) );

		$mockAddUserTask->initClient();
		/* Run test */
		$mockAddUserTask->createUserPropertiesDataExtension( $iUserId, $aUserProperties );
	}

	/**
	 * initClient method should be invoked early as it results in using ExactTargetSoapClient class
	 * which is autoloaded and that runs a chain of including all necessary ExactTarget API classes from lib dir
	 * so it generally means ExactTargetSoapClient class have to be used as first class from ExactTarget API classes
	 */
	public function testConstructorShouldCallInitClientMethod() {
		$mockAddUserTask = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'initClient' ] )
			->getMock();

		$mockAddUserTask
			->expects( $this->once() )
			->method('initClient');

		$reflectedClass = new ReflectionClass( 'ExactTargetAddUserTask' );
		$constructor = $reflectedClass->getConstructor();
		$constructor->invoke( $mockAddUserTask );
	}
}

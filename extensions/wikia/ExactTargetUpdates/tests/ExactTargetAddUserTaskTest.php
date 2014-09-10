<?php

require_once __DIR__ . '/../lib/exacttarget_soap_client.php';

class ExactTargetAddUserTaskTest extends WikiaBaseTest {


	function testSendNewUserShouldInvokeFollowingMethods() {
		/* Params to compare */
		$aUserData = [
			'user_id' => '12345',
			'user_email' => 'email@email.com'
		];
		$aUserProperties = [];

		/* @var ExactTargetAddUserTask $addTaskMock */
		$addTaskMock = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getClient', 'createUserPropertiesDataExtension', 'createUserDataExtension', 'createSubscriber' ] )
			->getMock();

		/* require getClient once */
		$addTaskMock
			->expects( $this->once() )
			->method( 'getClient' );

		/* require getClient once */
		$addTaskMock
			->expects( $this->once() )
			->method( 'createSubscriber' );

		/* require getClient once */
		$addTaskMock
			->expects( $this->once() )
			->method( 'createUserDataExtension' );

		/* require getClient once */
		$addTaskMock
			->expects( $this->once() )
			->method( 'createSubscriber' );

		/* Run tested method */
		$addTaskMock->sendNewUserData( $aUserData, $aUserProperties );
	}

	function testPrepareSoapVarsShouldReturnSoapVarsArray() {
		/* Params to compare */
		$iUserId = 12345;
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		/* prepare DataExtension objects array */
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

			$aDE[] = $DE;
		}

		/* prepare request mock - array of SoapVars */
		$aSoapVarsExpected = [];
		foreach ( $aDE as $DE ) {

			$soapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', 'http://exacttarget.com/wsdl/partnerAPI' );
			$aSoapVarsExpected[] = $soapVar;
		}

		/* Mock tested class */
		/* @var ExactTargetAddUserTask $mockAddUserTask (mock of ExactTargetAddUserTask) */
		$mockAddUserTask = $this->getMock( 'ExactTargetAddUserTask', [ 'getClient' ] );

		/* Run test */
		$aSoapVarsActual = $mockAddUserTask->prepareSoapVars( $aDE, 'DataExtensionObject' );
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
			->setMethods( [ 'wrapCreateRequest', 'getClient' ] )
			->getMock();
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'wrapCreateRequest' )
			->will( $this->returnValue( $oRequest ) );

		/* Run tested method */
		$mockAddUserTask->createUserPropertiesDataExtension( $iUserId, $aUserProperties, $soapClient );
	}

}
